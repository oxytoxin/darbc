<?php

namespace App\Http\Livewire\Cashier;

use Livewire\Component;
use App\Models\Dividend;
use DB;
use Intervention\Image\Facades\Image;
use Filament\Notifications\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CashierReleaseDividendManagement extends Component
{
    use AuthorizesRequests;

    public Dividend $dividend;
    public $proof_of_release;

    public function mount()
    {
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
        $this->dividend->update([
            'status' => Dividend::RELEASED,
            'released_by' => auth()->id(),
            'released_at' => now(),
        ]);

        DB::commit();
        Notification::make()->title('Dividend released successfully.')->success()->send();
        return redirect()->route('cashier.dividends.payslip', ['dividend' => $this->dividend]);
    }
}
