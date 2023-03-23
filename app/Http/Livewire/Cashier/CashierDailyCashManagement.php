<?php

namespace App\Http\Livewire\Cashier;

use Akaunting\Money\Money;
use App\Actions\ExtractAmountFromDenominationRecord;
use App\Forms\Components\DenominationCounter;
use App\Models\DailyCash;
use App\Models\Dividend;
use App\Models\Release;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;

class CashierDailyCashManagement extends Component implements HasForms
{
    use InteractsWithForms;

    public Release $release;
    public $daily_cash_start_data = [];
    public $daily_cash_end_data = [];
    public $lane = '';

    protected $listeners = ['dailyCash' => '$refresh'];

    protected function getForms(): array
    {
        return [
            'daily_cash_start_form' => $this->makeForm()->schema($this->getDailyCashStartForm())->statePath('daily_cash_start_data'),
            'daily_cash_end_form' => $this->makeForm()->schema($this->getDailyCashEndForm())->statePath('daily_cash_end_data'),
        ];
    }

    public function render()
    {
        $beginning_cash = collect($this->daily_cash_start?->denominations ?? [])->map(fn ($d) => $d['count'] * $d['denomination'])->sum();
        $actual_end_cash = collect($this->daily_cash_end?->denominations ?? [])->map(fn ($d) => $d['count'] * $d['denomination'])->sum();
        $release_amount =  Dividend::whereReleasedBy(auth()->id())->whereReleaseId($this->release->id)->whereDate('released_at', today())->sum('net_amount') / 100;
        $release_count = Dividend::whereReleasedBy(auth()->id())->whereReleaseId($this->release->id)->whereDate('released_at', today())->count();
        $cash_released = $beginning_cash - $actual_end_cash;
        $cash_over_short = $release_amount -  $cash_released;
        return view('livewire.cashier.cashier-daily-cash-management', [
            'beginning_cash' => Money::PHP($beginning_cash, true),
            'actual_end_cash' => Money::PHP($actual_end_cash, true),
            'cash_released' => Money::PHP($cash_released, true),
            'release_count' => $release_count,
            'release_amount' => Money::PHP($release_amount, true),
            'cash_over_short' => Money::PHP($cash_over_short, true),
        ]);
    }

    public function mount()
    {
        $this->lane = $this->daily_cash_start?->lane ?? '';
        $this->daily_cash_start_form->fill([
            'denominations' => $this->daily_cash_start?->denominations ?? DailyCash::DEFAULT_DENOMINATIONS
        ]);
        $this->daily_cash_end_form->fill([
            'denominations' => $this->daily_cash_end?->denominations ?? DailyCash::DEFAULT_DENOMINATIONS
        ]);
    }

    public function createDailyCashStart()
    {
        if ($this->daily_cash_start) {
            notify('Daily beginning cash already exists.', type: 'danger');
            return;
        }
        $this->createDailyCash(DailyCash::TYPE_START);
        $this->emitSelf('dailyCash');
        notify('Daily beginning cash created.');
    }

    private function createDailyCash($type)
    {
        $this->validate([
            'lane' => 'required'
        ]);
        if ($type == DailyCash::TYPE_END) {
            $this->lane = $this->daily_cash_start->lane;
        }
        DailyCash::create([
            'release_id' => $this->release->id,
            'lane' => $this->lane,
            'cashier_id' => auth()->id(),
            'type' => $type,
            'denominations' => DailyCash::DEFAULT_DENOMINATIONS,
            'amount' => 0,
        ]);
    }

    public function createDailyCashEnd()
    {
        if ($this->daily_cash_end) {
            notify('Daily end cash already exists.', type: 'danger');
            return;
        }
        $this->createDailyCash(DailyCash::TYPE_END);
        $this->emitSelf('dailyCash');
        notify('Daily beginning cash created.');
    }

    private function getDailyCashStartForm()
    {
        return [
            DenominationCounter::make('denominations')
                ->label('Denominations')
                ->rules('required', 'array')
                ->disableAddingRows()
                ->label('Cash Beginning')
                ->disableDeletingRows(),
        ];
    }
    private function getDailyCashEndForm()
    {
        return [
            DenominationCounter::make('denominations')
                ->label('Denominations')
                ->rules('required', 'array')
                ->disableAddingRows()
                ->label('Cash End')
                ->disableDeletingRows(),
        ];
    }

    public function saveDailyCash()
    {
        $start_valid_counts = collect($this->daily_cash_start_data['denominations'])->every(fn ($d) => filled($d['count']) && is_numeric($d['count']));
        $end_valid_counts = collect($this->daily_cash_end_data['denominations'])->every(fn ($d) => filled($d['count']) && is_numeric($d['count']));
        if (!$start_valid_counts) {
            notify('Invalid data', 'Beginnining cash form contains invalid count values.', type: 'danger');
            return;
        }
        if (!$end_valid_counts) {
            notify('Invalid data', 'End cash form contains invalid count values.', type: 'danger');
            return;
        }
        $this->daily_cash_start?->update([
            'denominations' => $this->daily_cash_start_data['denominations'],
            'amount' => ExtractAmountFromDenominationRecord::run($this->daily_cash_start_data['denominations']),
        ]);
        $this->daily_cash_end?->update([
            'denominations' => $this->daily_cash_end_data['denominations'],
            'amount' => ExtractAmountFromDenominationRecord::run($this->daily_cash_end_data['denominations'])
        ]);
        notify('Daily cash updated.');
    }

    public function getDailyCashStartProperty()
    {
        return auth()->user()->daily_cash_starts()->today()->forRelease($this->release->id)->first();
    }

    public function getDailyCashEndProperty()
    {
        return auth()->user()->daily_cash_ends()->today()->forRelease($this->release->id)->first();
    }
}
