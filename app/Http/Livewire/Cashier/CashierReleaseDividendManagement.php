<?php

namespace App\Http\Livewire\Cashier;

use Livewire\Component;
use App\Models\Dividend;
use DB;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Intervention\Image\Facades\Image;
use Filament\Notifications\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CashierReleaseDividendManagement extends Component implements HasForms
{
    use AuthorizesRequests, InteractsWithForms;

    public Dividend $dividend;
    public $proof_of_release;
    public $particulars = [];

    public function getFormSchema()
    {
        return [
            KeyValue::make('particulars')
                ->default($this->dividend->particulars)
                ->disableAddingRows()
                ->disableDeletingRows()
                ->disableEditingKeys()
                ->keyLabel('Particulars')
                ->valueLabel('Control Number (Claimed/Unclaimed)'),
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
        $path = storage_path('app/proof_of_release/' . $this->dividend->id . '-' . now()->timestamp . '-proof.png');
        Image::make($this->proof_of_release)->save($path);

        $this->dividend->addMedia($path)->toMediaCollection('proof_of_release');
        $new_particulars = collect();

        foreach ($this->particulars as $key => $value) {
            $new_particulars->push([
                $key => filled($value) ? $value : 'UNCLAIMED',
            ]);
        }
        $this->dividend->update([
            'status' => Dividend::RELEASED,
            'released_by' => auth()->id(),
            'released_at' => now(),
            'particulars' => $new_particulars->mapWithKeys(fn ($v) => $v)->toArray(),
        ]);

        DB::commit();
        Notification::make()->title('Dividend released successfully.')->success()->send();
        return redirect()->route('cashier.dividends.payslip', ['dividend' => $this->dividend]);
    }
}
