<?php

namespace App\Http\Livewire\Cashier;

use Livewire\Component;
use App\Models\Dividend;
use DB;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Intervention\Image\Facades\Image;
use Filament\Notifications\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use PDO;

class CashierReleaseDividendManagement extends Component implements HasForms
{
    use AuthorizesRequests, InteractsWithForms;

    public Dividend $dividend;
    public $proof_of_release;
    public $data;
    public $has_representative;
    public $claimed_by;

    public function getFormSchema()
    {
        $k = 0;
        $fields = collect($this->dividend->release->particulars)->map(function ($value, $key) use ($k) {
            if (!str($value)->contains(['sets', 'set', 'can', 'cans'])) {
                return TextInput::make(str($key)->prepend('data.')->replace(' ', '_'))->prefix($this->dividend->release->control_number_prefix)->label($key);
            }
            return Checkbox::make(str($key)->prepend('data.')->replace(' ', '_'))->label($key);
        });
        return [
            Fieldset::make('representative')->schema([
                Checkbox::make('has_representative')->reactive()->label('Has Representative?'),
                TextInput::make('claimed_by')->label('Representative Name')->visible(fn ($get) => $get('has_representative')),
            ])->label('Claimed By Representative'),
            Grid::make(2)->schema($fields->toArray())
        ];
    }

    public function mount()
    {
        $this->form->fill();
        $this->authorize('release', $this->dividend);
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
        DB::beginTransaction();
        if ($this->proof_of_release) {
            $path = storage_path('app/proof_of_release/' . $this->dividend->id . '-' . now()->timestamp . '-proof.png');
            Image::make($this->proof_of_release)->save($path);
            $this->dividend->addMedia($path)->toMediaCollection('proof_of_release');
        }
        $new_particulars = $this->dividend->particulars;
        foreach ($this->data as $key => $value) {
            $new_particulars[str($key)->replace('_', ' ')->toString()] = $value;
        }
        $this->dividend->update([
            'status' => Dividend::RELEASED,
            'released_by' => auth()->id(),
            'released_at' => now(),
            'particulars' => $new_particulars,
            'claimed_by' => $this->claimed_by,
        ]);

        DB::commit();
        Notification::make()->title('Dividend released successfully.')->success()->send();
        return redirect()->route('cashier.dividends.payslip', ['dividend' => $this->dividend]);
    }
}
