<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Gender;
use Illuminate\Support\Str;
use Illuminate\Console\Command;
use App\Models\MembershipStatus;
use App\Models\MemberInformation;
use Illuminate\Support\Facades\DB;

class SeedOriginalMembers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:original';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeds original members';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $path = storage_path('csv/original-members-csv.csv');
        ini_set('auto_detect_line_endings', TRUE);
        $handle = fopen($path, 'r');
        $row = 1;
        DB::beginTransaction();
        $this->output->progressStart(3700);
        while (($data = fgetcsv($handle)) !== FALSE) {
            if ($row == 1) {
                $row++;
                $this->output->text('Skipping header row');
                continue;
            }
            try {
                [$surname, $first_name] = explode(',', $data[1]);
                $MI = [];
                $surname = trim($surname);
                preg_match('/[a-zA-Z]\./', $first_name, $MI);
                $first_name = trim(preg_replace('/[a-zA-Z]\./', '', $first_name));
                $user = User::make();
                $user->first_name = strtoupper($first_name);
                $user->middle_name = $MI[0] ?? null;
                $user->surname = strtoupper($surname);
                $user->username = Str::random(10);
                $user->password = '$2y$10$cbiy.FzxcGc8gkanmgCVmewoGfH2C0FR35cXxT0dLnWWTThAs5UAG';
                $user->save();
                $member = MemberInformation::make();
                $member->user_id = $user->id;
                $member->lineage_identifier = Str::random(10);
                $member->membership_status_id = MembershipStatus::ORIGINAL;
                $member->darbc_id = $data[17];
                $member->date_of_birth = date_create($data[2]) ? date_create($data[2]) : null;
                $member->place_of_birth = strtoupper(trim($data[4]));
                $member->mother_maiden_name = strtoupper(trim($data[9]));
                $member->blood_type = strtoupper(trim($data[11]));
                $member->religion = strtoupper(trim($data[10]));
                $member->status = MemberInformation::STATUS_ACTIVE;
                $member->sss_number = $data[14];
                $member->philhealth_number = $data[15];
                $member->tin_number = $data[16];
                $member->darbc_id = $data[17];
                $member->contact_number = $data[18];
                if (intval($data[19]))
                    $member->cluster_id = $data[19];
                else
                    $member->cluster_id = null;
                if ($data[20])
                    $member->application_date = date_create($data[20]) ? date_create($data[20]) : now();
                else
                    $member->application_date = now();
                $member->spouse = strtoupper(trim($data[21]));
                $member->children = [];
                if ($data[13]) {
                    switch (trim(strtoupper($data[13]))) {
                        case 'ACTIVE DOLEFIL EMPLOYEE':
                            $member->occupation_id = 1;
                            break;
                        case 'SPECIAL VOLUNTARY RETIREMENT':
                            $member->occupation_id = 2;
                            break;
                        case 'RETIRED':
                            $member->occupation_id = 3;
                            break;
                        default:
                            $member->occupation_id = 4;
                            $member->occupation_details = $data[13];
                            break;
                    }
                } else {
                    $member->occupation_id = 5;
                }
                switch (trim(strtoupper($data[8]))) {
                    case 'MALE':
                        $member->gender_id = Gender::MALE;
                        break;
                    case 'FEMALE':
                        $member->gender_id = Gender::FEMALE;
                        break;
                    default:
                        $member->gender_id = Gender::UNKNOWN;
                        break;
                }
                switch (trim(strtoupper($data[12]))) {
                    case 'SINGLE':
                        $member->civil_status = MemberInformation::CS_SINGLE;
                        break;
                    case 'MARRIED':
                        $member->civil_status = MemberInformation::CS_MARRIED;
                        break;
                    case 'WIDOW':
                        $member->civil_status = MemberInformation::CS_WIDOW;
                        break;
                    case 'LEGALLY SEPARATED':
                        $member->civil_status = MemberInformation::CS_LEGALLY_SEPARATED;
                        break;
                    default:
                        $member->civil_status = MemberInformation::CS_UNKNOWN;
                        break;
                }
                $member->save();
                $this->output->progressAdvance();
            } catch (\Throwable $th) {
                dd($data, $th);
            }
        }
        $this->output->progressFinish();
        DB::commit();
        ini_set('auto_detect_line_endings', FALSE);
        return Command::SUCCESS;
    }
}
