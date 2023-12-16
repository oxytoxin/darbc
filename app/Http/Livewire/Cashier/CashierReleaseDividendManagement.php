<?php

namespace App\Http\Livewire\Cashier;

use DB;
use Http;
use Livewire\Component;
use App\Models\Dividend;
use Akaunting\Money\Money;
use Mike42\Escpos\Printer;
use Illuminate\Validation\Rule;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Intervention\Image\Facades\Image;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Concerns\InteractsWithForms;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CashierReleaseDividendManagement extends Component implements HasForms
{
    use AuthorizesRequests, InteractsWithForms;

    public Dividend $dividend;
    public $proof_of_release;
    public $data;
    public $voting_status;
    public $restricted_by_election = true;
    public $printer_ip = '1.0.0.73';

    public function getFormSchema()
    {
        $faker = \Faker\Factory::create();
        $fields = collect($this->dividend->particulars)->map(function ($value, $key) {
            return Checkbox::make('data.particulars.' . $key)->default(true)->label($value['name'])->visible(!$value['claimed']);
        });
        return [
            Grid::make(2)->schema([
                Checkbox::make('data.claimed')->default(true)->label('Claim Dividend?')->inline(false),
                TextInput::make('data.gift_certificate_control_number')
                    ->prefix($this->dividend->release->gift_certificate_prefix)
                    ->maxLength(6)
                    ->required()
                    ->default(fn () => $this->dividend->release->gift_certificate_prefix ? strtoupper($faker->bothify('???###')) : null)
                    ->rule(Rule::unique('dividends', 'gift_certificate_control_number')->where('release_id', $this->dividend->release_id))
                    ->visible(!$this->dividend->user->member_information->split_claim && ($this->dividend->release->gift_certificate_amount > 0 || $this->dividend->release->gift_certificate_prefix))
                    ->hidden($this->dividend->gift_certificate_control_number != null),
            ]),
            Fieldset::make('Particulars')->schema(collect($this->dividend->particulars)->contains('claimed', false) ? $fields->toArray() : [
                Placeholder::make('claimed_particulars')->content('No items to claim.')->disableLabel()
            ]),
            Fieldset::make('Claimed By')->schema([
                Radio::make('data.claim_type')->options([
                    1 => 'Member',
                    2 => 'SPA',
                    3 => 'Authorized Representative',
                ])->disableLabel()
                    ->default(1)
                    ->afterStateUpdated(function ($set, $state) {
                        if ($state == 2) {
                            $set('data.claimed_by', collect($this->dividend->user->member_information->spa)->first());
                        } else {
                            $set('data.claimed_by', null);
                        }
                    })
                    ->reactive(),
                TextInput::make('data.claimed_by')->label(fn ($get) => match (intval($get('data.claim_type'))) {
                    2 => 'SPA Name',
                    3 => 'Representative Name',
                    default => 'Member Name',
                })->validationAttribute('name')->required()->visible(fn ($get) => $get('data.claim_type') != 1),
            ]),
        ];
    }

    public function mount()
    {
        $this->form->fill();
        $this->restricted_by_election = $this->dividend->release->voting_restriction;
        $this->authorize('release', $this->dividend);
        $darbc_id = $this->dividend->user->member_information->darbc_id;
        try {
            $this->voting_status = Http::get(config('services.election.url') . '/api/member-details-darbc-id/' . $darbc_id)->json();
        } catch (\Throwable $th) {
        }
        if (!$this->voting_status) {
            notify('Election API cannot be reached.', type: 'danger');
            $this->restricted_by_election = false;
        }
    }

    public function render()
    {
        return view('livewire.cashier.cashier-release-dividend-management');
    }

    public function captureProofOfRelease($data)
    {
        $this->proof_of_release = $data;
        Notification::make()->title('Proof of Release Captured')->success()->send();
        $this->emitSelf('closeModal');
    }

    public function printPayslipMember($dividend)
    {
        if ($dividend->claimed) {
            $net_amount = 'Php' . number_format($dividend->net_amount, 2);
        } else {
            $net_amount = 'UNCLAIMED';
        }

        $claim_type_name = match ($dividend->claim_type) {
            1 => 'MEMBER',
            2 => 'SPA',
            3 => 'REPRESENTATIVE',
            default => 'MEMBER',
        };
        $printerIp = $this->printer_ip;
        $printerPort = 9100;
        $connector = new NetworkPrintConnector($printerIp, $printerPort, 10);
        $printer = new Printer($connector);
        try {
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->text("Dolefil Agrarian Reform\n");
            $printer->text("Beneficiaries Cooperative\n");
            $printer->text("(DARBC)\n");
            $printer->feed(2);
            $printer->text("MEMBERS COPY\n");
            $printer->feed(2);
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("Name: " . $dividend->user->full_name);
            $printer->feed(1);
            $printer->text("Member No. : " . $dividend->user->member_information->darbc_id);
            $printer->feed(1);
            $printer->setEmphasis(false);
            $printer->text("Date : " .  $dividend->released_at->format('m/d/Y'));
            $printer->feed(1);
            $printer->text("Time : " .  $dividend->released_at->format('h:i A'));
            $printer->feed(2);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->text($dividend->release->name . "\n");
            $printer->setEmphasis(false);
            $printer->feed(1);
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text($dividend->release->share_description . ":  " . $net_amount);
            $printer->feed(1);
            if (!$dividend->user->member_information->split_claim && ($dividend->release->gift_certificate_prefix || $dividend->release->gift_certificate_amount > 0)) {
                $gift_certificate_number = $dividend->gift_certificate_control_number ? $dividend->release->gift_certificate_prefix . $dividend->gift_certificate_control_number : 'UNCLAIMED';
                $printer->text("Gift Certificate (worth " . 'Php' . number_format($dividend->release->gift_certificate_amount, 2) . ") :\n");
                $printer->text($gift_certificate_number);
                $printer->feed(2);
            }
            foreach ($dividend->particulars as $key => $value) {
                $printer->text($value['name']);
                $printer->feed(1);
                if ($value['claimed']) {
                    $printer->text($dividend->release->particulars[$value['name']] ?? "");
                } else {
                    $printer->text('UNCLAIMED');
                }
            }
            $printer->feed(2);
            $printer->text("TELLER NAME:  " . $dividend->cashier->first_name . ' ' . $dividend->cashier->surname . "\n");
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->feed(4);
            $printer->text($claim_type_name . "'S SIGNATURE:   ");
            $printer->setEmphasis(true);
            // $printer -> text($member_name."\n");
            if ($dividend->claimed_by) {
                $printer->text(strtoupper($dividend->claimed_by));
            } else {
                $printer->text(strtoupper($dividend->user->full_name));
            }
            $printer->setEmphasis(false);
            $printer->feed(2);
            $printer->cut();
            $printer->close();
        } finally {
            $printer->close();
        }
    }

    public function printPayslipDARBC($dividend)
    {
        if ($dividend->claimed) {
            $net_amount = 'Php' . number_format($dividend->net_amount, 2);
        } else {
            $net_amount = 'UNCLAIMED';
        }

        $claim_type_name = match ($dividend->claim_type) {
            1 => 'MEMBER',
            2 => 'SPA',
            3 => 'REPRESENTATIVE',
            default => 'MEMBER',
        };
        $printerIp = $this->printer_ip;
        $printerPort = 9100;
        $connector = new NetworkPrintConnector($printerIp, $printerPort, 10);
        $printer = new Printer($connector);
        try {
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->text("Dolefil Agrarian Reform\n");
            $printer->text("Beneficiaries Cooperative\n");
            $printer->text("(DARBC)\n");
            $printer->feed(2);
            $printer->text("DARBC COPY\n");
            $printer->feed(2);
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text("Name: " . $dividend->user->full_name);
            $printer->feed(1);
            $printer->text("Member No. : " . $dividend->user->member_information->darbc_id);
            $printer->feed(1);
            $printer->setEmphasis(false);
            $printer->text("Date : " .  $dividend->released_at->format('m/d/Y'));
            $printer->feed(1);
            $printer->text("Time : " .  $dividend->released_at->format('h:i A'));
            $printer->feed(2);
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->text($dividend->release->name . "\n");
            $printer->setEmphasis(false);
            $printer->feed(1);
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $printer->text($dividend->release->share_description . ":  " . $net_amount);
            $printer->feed(1);
            if (!$dividend->user->member_information->split_claim && ($dividend->release->gift_certificate_prefix || $dividend->release->gift_certificate_amount > 0)) {
                $gift_certificate_number = $dividend->gift_certificate_control_number ? $dividend->release->gift_certificate_prefix . $dividend->gift_certificate_control_number : 'UNCLAIMED';
                $printer->text("Gift Certificate (worth " . 'Php' . number_format($dividend->release->gift_certificate_amount, 2) . ") :\n");
                $printer->text($gift_certificate_number);
                $printer->feed(2);
            }
            foreach ($dividend->particulars as $key => $value) {
                $printer->text($value['name']);
                $printer->feed(1);
                if ($value['claimed']) {
                    $printer->text($dividend->release->particulars[$value['name']] ?? "");
                } else {
                    $printer->text('UNCLAIMED');
                }
            }
            $printer->feed(2);
            $printer->text("TELLER NAME:  " . $dividend->cashier->first_name . ' ' . $dividend->cashier->surname . "\n");
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->feed(4);
            $printer->text($claim_type_name . "'S SIGNATURE:   ");
            $printer->setEmphasis(true);
            // $printer -> text($member_name."\n");
            if ($dividend->claimed_by) {
                $printer->text(strtoupper($dividend->claimed_by));
            } else {
                $printer->text(strtoupper($dividend->user->full_name));
            }
            $printer->setEmphasis(false);
            $printer->feed(2);
            $printer->cut();
            $printer->close();
        } finally {
            $printer->close();
        }
    }

    public function release()
    {
        $this->form->validate();

        DB::beginTransaction();
        if ($this->proof_of_release) {
            $path = storage_path('app/proof_of_release/' . $this->dividend->id . '-' . now()->timestamp . '-proof.png');
            Image::make($this->proof_of_release)->save($path);
            $this->dividend->addMedia($path)->toMediaCollection('proof_of_release');
        }
        $new_particulars = $this->dividend->particulars;
        foreach ($this->data['particulars'] ?? [] as $key => $value) {
            if (!$new_particulars[$key]['claimed'])
                $new_particulars[$key]['claimed'] = $value;
        }

        $this->dividend->update([
            'status' => $this->data['claimed'] ? Dividend::RELEASED : Dividend::FOR_RELEASE,
            'claimed' => $this->data['claimed'],
            'released_by' => auth()->id(),
            'released_at' => now(),
            'gift_certificate_control_number' => $this->dividend->gift_certificate_control_number ?? $this->data['gift_certificate_control_number'],
            'particulars' => $new_particulars,
            'claim_type' => $this->data['claim_type'],
            'claimed_by' => $this->data['claim_type'] != 1 && $this->data['claimed'] ? $this->data['claimed_by'] : null,
        ]);
        try {
            $this->printPayslipMember($this->dividend);
            sleep(1);
            $this->printPayslipDARBC($this->dividend);
        } catch (\Throwable $e) {
            Notification::make()->title('Failed to connect to printer. Check if IP is correct.')->danger()->send();
            DB::rollBack();
            return;
        }
        DB::commit();

        Notification::make()->title('Dividend released successfully.')->success()->send();
        return redirect()->route('cashier.releases.dividends', ['release' => $this->dividend->release]);
    }
}
