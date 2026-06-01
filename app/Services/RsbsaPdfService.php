<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\RsbsaRecord;
use App\Models\MemberInformation;
use setasign\Fpdi\Fpdi;

/**
 * Generates a filled RSBSA Enrollment Form by overlaying record data onto the
 * official template PDF. Field positions live in config/rsbsa.php.
 */
class RsbsaPdfService
{
    private Fpdi $pdf;
    private int $pageCount = 0;
    private bool $debugGrid = false;

    /** Enable a measurement grid overlay (development/coordinate tuning only). */
    public function withGrid(bool $on = true): self
    {
        $this->debugGrid = $on;
        return $this;
    }

    /** Path to the live coordinate overrides written by the visual tuner. */
    public static function overridesPath(): string
    {
        return storage_path('app/rsbsa-overrides.json');
    }

    /**
     * Effective field map: config defaults merged with any live overrides
     * (x / y / gap) saved by the tuner. Read at request time, so saved
     * positions take effect immediately without clearing config cache.
     */
    public static function fields(): array
    {
        $fields = config('rsbsa.fields');

        if (is_file(self::overridesPath())) {
            $overrides = json_decode((string) file_get_contents(self::overridesPath()), true) ?: [];
            foreach ($overrides as $key => $pos) {
                if (! isset($fields[$key])) {
                    continue;
                }
                foreach (['x', 'y', 'gap'] as $prop) {
                    if (isset($pos[$prop]) && is_numeric($pos[$prop])) {
                        $fields[$key][$prop] = $pos[$prop] + 0;
                    }
                }
            }
        }

        return $fields;
    }

    /** Expose the flat mapped data for a record (used by the visual tuner). */
    public function mappedData(RsbsaRecord $record): array
    {
        return $this->mapRecord($record);
    }

    public function __construct()
    {
        $this->pdf = new Fpdi('P', 'pt', 'Letter');
        $this->pdf->SetAutoPageBreak(false);
        $this->pdf->SetTextColor(0, 0, 0);
        $this->pdf->SetFont(config('rsbsa.font.family'), '', config('rsbsa.font.size'));
    }

    /**
     * Build the filled PDF for a record and return the FPDI instance.
     */
    public function fill(RsbsaRecord $record): Fpdi
    {
        $data = $this->mapRecord($record);
        $fields = self::fields();

        $path = storage_path('app/' . config('rsbsa.template'));
        $this->pageCount = $this->pdf->setSourceFile($path);

        // FPDF cannot revisit a page, so each page's fields are stamped while
        // that page is the current one.
        for ($n = 1; $n <= $this->pageCount; $n++) {
            $this->pdf->AddPage();
            $tpl = $this->pdf->importPage($n);
            $this->pdf->useTemplate($tpl, 0, 0, config('rsbsa.page.w'), config('rsbsa.page.h'));

            if ($this->debugGrid) {
                $this->drawGrid();
            }

            foreach ($data as $key => $value) {
                if ($value === null || $value === '' || ! isset($fields[$key])) {
                    continue;
                }

                $f = $fields[$key];
                if (($f['page'] ?? 1) !== $n) {
                    continue;
                }

                if (isset($f['size'])) {
                    $this->pdf->SetFont(config('rsbsa.font.family'), '', $f['size']);
                }

                match ($f['type']) {
                    'text'  => $this->writeText($f['x'], $f['y'], (string) $value),
                    'boxed' => $this->writeBoxedChars($f['x'], $f['y'], (string) $value, $f['gap']),
                    'check' => $this->checkBox($f['x'], $f['y']),
                    'image' => $this->putImage($f['x'], $f['y'], $f['w'] ?? 100, $f['h'] ?? 100, (string) $value),
                };

                if (isset($f['size'])) {
                    $this->pdf->SetFont(config('rsbsa.font.family'), '', config('rsbsa.font.size'));
                }
            }
        }

        return $this->pdf;
    }

    private function writeText(float $x, float $y, string $text): void
    {
        $this->pdf->Text($x, $y, $this->latin($text));
    }

    private function writeBoxedChars(float $x, float $y, string $text, float $gap): void
    {
        foreach (str_split($this->latin($text)) as $i => $char) {
            $w = $this->pdf->GetStringWidth($char);
            $cx = $x + ($i * $gap) + (($gap - $w) / 2);
            $this->pdf->Text($cx, $y, $char);
        }
    }

    private function checkBox(float $x, float $y): void
    {
        $this->pdf->SetFont(config('rsbsa.font.family'), 'B', config('rsbsa.font.size'));
        $this->pdf->Text($x, $y, 'X');
        $this->pdf->SetFont(config('rsbsa.font.family'), '', config('rsbsa.font.size'));
    }

    /** Place an image (e.g. the 2x2 photo). (x, y) is the top-left corner. */
    private function putImage(float $x, float $y, float $w, float $h, string $path): void
    {
        if (is_file($path)) {
            $this->pdf->Image($path, $x, $y, $w, $h);
        }
    }

    /**
     * Mobile digits to print, with the form's pre-printed "09" removed so we
     * only stamp the trailing 9 digits.
     */
    private function mobileDigits(?string $raw): ?string
    {
        if (! $raw) {
            return null;
        }
        $d = preg_replace('/\D/', '', $raw);
        if ($d === '') {
            return null;
        }
        if (strlen($d) === 10 && $d[0] === '9') {
            $d = '0' . $d; // 9XXXXXXXXX -> 09XXXXXXXXX
        }
        if (str_starts_with($d, '09')) {
            $d = substr($d, 2); // drop the pre-printed "09"
        }
        return $d;
    }

    /** Draw a 10pt/50pt measurement grid on the current page (debug only). */
    private function drawGrid(): void
    {
        $w = config('rsbsa.page.w');
        $h = config('rsbsa.page.h');
        for ($x = 0; $x <= $w; $x += 10) {
            $x % 50 === 0 ? $this->pdf->SetDrawColor(255, 150, 150) : $this->pdf->SetDrawColor(205, 225, 255);
            $this->pdf->Line($x, 0, $x, $h);
        }
        for ($y = 0; $y <= $h; $y += 10) {
            $y % 50 === 0 ? $this->pdf->SetDrawColor(255, 150, 150) : $this->pdf->SetDrawColor(205, 225, 255);
            $this->pdf->Line(0, $y, $w, $y);
        }
        $this->pdf->SetTextColor(230, 0, 0);
        $this->pdf->SetFont(config('rsbsa.font.family'), 'B', 6);
        for ($x = 0; $x <= $w; $x += 50) {
            $this->pdf->Text($x + 1, 10, (string) $x);
        }
        for ($y = 0; $y <= $h; $y += 50) {
            $this->pdf->Text(1, $y - 1, (string) $y);
        }
        $this->pdf->SetTextColor(0, 0, 0);
        $this->pdf->SetFont(config('rsbsa.font.family'), '', config('rsbsa.font.size'));
    }

    /** FPDF core fonts are Latin-1; convert UTF-8 so accents render. */
    private function latin(string $s): string
    {
        return mb_convert_encoding($s, 'Windows-1252', 'UTF-8');
    }

    /**
     * Translate an RsbsaRecord into the flat keys used by the coordinate map.
     */
    private function mapRecord(RsbsaRecord $r): array
    {
        $digits = fn ($v) => $v ? preg_replace('/\D/', '', $v) : null;

        $data = [
            'trn' => $r->transaction_reference_number ? $digits($r->transaction_reference_number) : null,

            'surname'        => $r->surname,
            'first_name'     => $r->first_name,
            'middle_name'    => $r->middle_name,
            'extension_name' => $r->extension_name,

            'perm_house'     => $r->house_lot_bldg_purok,
            'perm_street'    => $r->street_sitio_subdv,
            'perm_barangay'  => $r->barangay,
            'perm_city'      => $r->city_municipality,
            'perm_province'  => $r->province,
            'perm_region'    => $r->region,

            'place_birth_city'     => $r->place_of_birth_municipality,
            'place_birth_province' => $r->place_of_birth_province,

            'mobile' => $this->mobileDigits($r->contact_number),
            'photo'  => $r->getFirstMediaPath('two_by_two') ?: null,

            'mother_maiden_name' => $r->mother_maiden_name,
            'spouse'             => $r->name_of_spouse,

            'id_type'   => $r->id_type,
            'id_number' => $r->id_number,

            'rsbsa_number' => $r->reference_number ? $digits($r->reference_number) : null,

            // Provincial address (NCR)
            'prov_house'    => $r->provincial_house_lot_bldg_purok,
            'prov_street'   => $r->provincial_street_sitio_subdv,
            'prov_barangay' => $r->provincial_barangay,
            'prov_city'     => $r->provincial_city_municipality,
            'prov_province' => $r->provincial_province,
            'prov_region'   => $r->provincial_region,

            // Mobile owner / ICC / FCA
            'mobile_owner_name'         => $r->mobile_owner_name,
            'mobile_owner_relationship' => $r->mobile_owner_relationship,
            'icc_name' => $r->indigenous_group_name,
            'fca_1'    => $r->farmers_association_name,
            'fca_2'    => $r->farmers_association_name_2,
            'fca_3'    => $r->farmers_association_name_3,
        ];

        if ($r->date_of_birth) {
            $dob = Carbon::parse($r->date_of_birth);
            $data['dob_mm'] = $dob->format('m');
            $data['dob_dd'] = $dob->format('d');
            $data['dob_yyyy'] = $dob->format('Y');
        }

        // PhilSys PCN: 16 digits split into 4 groups of 4 (to clear the separators)
        $pcn = $r->philsys_card_number ? $digits($r->philsys_card_number) : null;
        if ($pcn) {
            $data['pcn_1'] = substr($pcn, 0, 4);
            $data['pcn_2'] = substr($pcn, 4, 4);
            $data['pcn_3'] = substr($pcn, 8, 4);
            $data['pcn_4'] = substr($pcn, 12, 4);
        }

        $this->mapSex($r, $data);
        $this->mapCivilStatus($r, $data);
        $this->mapReligion($r, $data);
        $this->mapEducation($r, $data);

        $this->mapYesNo($data, 'owns_mobile', $r->owns_mobile_number);
        $this->mapYesNo($data, 'icc', $r->is_indigenous_group_member);
        $this->mapYesNo($data, 'pwd', $r->is_pwd);
        $this->mapYesNo($data, 'fourps', $r->is_4ps_beneficiary);

        $this->mapLivelihood($r, $data);
        $this->mapFarmParcels($r, $data);

        return $data;
    }

    /** Set a "<prefix>_yes" or "<prefix>_no" checkbox from a boolean (null = neither). */
    private function mapYesNo(array &$data, string $prefix, $value): void
    {
        if ($value === null) {
            return;
        }
        $data[$value ? "{$prefix}_yes" : "{$prefix}_no"] = true;
    }

    private function mapLivelihood(RsbsaRecord $r, array &$data): void
    {
        $liv = $r->main_livelihood ?? [];
        if (in_array('Farmer', $liv)) $data['liv_farmer'] = true;
        if (in_array('Farmworker/Laborer', $liv)) $data['liv_worker'] = true;
        if (in_array('Fisherfolk', $liv)) $data['liv_fisher'] = true;
        if (in_array('Agri Youth', $liv)) $data['liv_youth'] = true;
    }

    /** Map the first farm parcel (and its first two commodity rows) to Page 2. */
    private function mapFarmParcels(RsbsaRecord $r, array &$data): void
    {
        $parcel = $r->farmParcels()->with('commodities')->orderBy('parcel_number')->first();
        if (! $parcel) {
            return;
        }

        $data['p1_barangay']    = $parcel->farm_location_barangay;
        $data['p1_city']        = $parcel->farm_location_city_municipality;
        $data['p1_area']        = $parcel->total_parcel_area;
        $data['p1_land_owner']  = $parcel->land_owner_name;
        $data['p1_tiller_name'] = $parcel->rotational_tiller_name;
        $data['p1_remarks']     = $parcel->remarks;

        $this->mapYesNo($data, 'p1_ad', $parcel->within_ancestral_domain);
        $this->mapYesNo($data, 'p1_arb', $parcel->agrarian_reform_beneficiary);

        $ownMap = [
            'Registered Owner' => 'p1_own_registered',
            'Tenant'           => 'p1_own_tenant',
            'Lessee'           => 'p1_own_lessee',
            'Others'           => 'p1_own_others',
        ];
        if (isset($ownMap[$parcel->ownership_type])) {
            $data[$ownMap[$parcel->ownership_type]] = true;
        }

        $commodities = $parcel->commodities->values();
        foreach ([0, 1] as $j) {
            $c = $commodities[$j] ?? null;
            if (! $c) {
                continue;
            }
            $n = $j + 1;
            $data["p1_c{$n}_schedule"]  = $c->cropping_schedule;
            $data["p1_c{$n}_commodity"] = $c->commodity;
            $data["p1_c{$n}_size"]      = $c->size;
            $data["p1_c{$n}_heads"]     = $c->no_of_heads;
        }
    }

    private function mapSex(RsbsaRecord $r, array &$data): void
    {
        $sex = strtolower((string) ($r->sex ?: optional($r->gender)->name));
        if (str_starts_with($sex, 'm')) {
            $data['sex_male'] = true;
        } elseif (str_starts_with($sex, 'f')) {
            $data['sex_female'] = true;
        }
    }

    private function mapCivilStatus(RsbsaRecord $r, array &$data): void
    {
        $map = [
            MemberInformation::CS_SINGLE => 'civil_single',
            MemberInformation::CS_MARRIED => 'civil_married',
            MemberInformation::CS_WIDOW => 'civil_widow',
            MemberInformation::CS_LEGALLY_SEPARATED => 'civil_legally',
        ];
        if (isset($map[$r->civil_status])) {
            $data[$map[$r->civil_status]] = true;
        }
    }

    private function mapReligion(RsbsaRecord $r, array &$data): void
    {
        $religion = strtolower(trim((string) $r->religion));
        if ($religion === '') {
            return;
        }
        if (str_contains($religion, 'islam') || str_contains($religion, 'muslim')) {
            $data['religion_islam'] = true;
        } elseif (in_array($religion, ['none', 'wala'])) {
            $data['religion_none'] = true;
        } elseif (str_contains($religion, 'catholic') || str_contains($religion, 'christ') || str_contains($religion, 'iglesia') || str_contains($religion, 'protestant') || str_contains($religion, 'baptist')) {
            $data['religion_christianity'] = true;
        } else {
            $data['religion_others'] = true;
        }
    }

    private function mapEducation(RsbsaRecord $r, array &$data): void
    {
        $map = [
            'Pre-school' => 'edu_preschool',
            'Elementary' => 'edu_elementary',
            'High School (non K-12)' => 'edu_highschool_nonk12',
            'Junior High School (K-12)' => 'edu_juniorhigh',
            'Senior High School (K-12)' => 'edu_seniorhigh',
            'College' => 'edu_college',
            'Vocational' => 'edu_vocational',
            'Post-graduate' => 'edu_postgrad',
            'None' => 'edu_none',
        ];
        if (isset($map[$r->highest_formal_education])) {
            $data[$map[$r->highest_formal_education]] = true;
        }
    }
}
