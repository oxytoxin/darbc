<?php

namespace App\Http\Livewire\Cashier;

use Livewire\Component;
use App\Models\Dividend;
use DB;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Intervention\Image\Facades\Image;
use Filament\Notifications\Notification;
use Http;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;

class CashierReleaseDividendManagement extends Component implements HasForms
{
    use AuthorizesRequests, InteractsWithForms;

    public Dividend $dividend;
    public $proof_of_release;
    public $data;
    public $voting_status;
    public $restricted_by_election = true;

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
        $this->authorize('release', $this->dividend);
        $member_id = $this->dividend->user->member_information->id;
        $this->voting_status = Http::get(config('services.election.url') . '/api/member-details/' . $member_id)->json();
        // $this->restricted_by_election = false;
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

        DB::commit();
        Notification::make()->title('Dividend released successfully.')->success()->send();
        return redirect()->route('cashier.dividends.payslip', ['dividend' => $this->dividend]);
    }
}
