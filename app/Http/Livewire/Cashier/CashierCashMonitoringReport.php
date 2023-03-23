<?php

namespace App\Http\Livewire\Cashier;

use App\Models\Release;
use Livewire\Component;

class CashierCashMonitoringReport extends Component
{
    public Release $release;
    public $from;
    public $to;

    public function render()
    {
        $daily_cash_starts_by_date = $this->release->daily_cash_starts()
            ->selectRaw('sum(amount) as total, date(created_at) start_date')
            ->orderBy('start_date')
            ->groupBy('start_date')
            ->when($this->from, fn ($q) => $q->whereDate('created_at', '>=', $this->from))
            ->when($this->to, fn ($q) => $q->whereDate('created_at', '<=', $this->to))
            ->get()
            ->map(fn ($dcs) => [
                'date' => date_format(date_create($dcs->start_date), 'm/d/Y'),
                'total' => $dcs->total / 100
            ])
            ->values();
        $releases_total_by_date = $this->release
            ->released_dividends()
            ->selectRaw('sum(net_amount) as total, date(released_at) release_date')
            ->orderBy('release_date')
            ->groupBy('release_date')
            ->when($this->from, fn ($q) => $q->whereDate('released_at', '>=', $this->from))
            ->when($this->to, fn ($q) => $q->whereDate('released_at', '<=', $this->to))
            ->get()
            ->map(fn ($r) => [
                'date' => date_format(date_create($r->release_date), 'm/d/Y'),
                'total' => $r->total / 100
            ])
            ->values();
        $daily_cash_ends_denominations = $this->release
            ->daily_cash_ends()
            ->when($this->from, fn ($q) => $q->whereDate('created_at', '>=', $this->from))
            ->when($this->to, fn ($q) => $q->whereDate('created_at', '<=', $this->to))
            ->get()
            ->map(fn ($dce) => $dce->denominations)
            ->reduce(fn ($carry, $denom) => ($carry ?? collect())->merge($denom))
            ?->groupBy('denomination')
            ->map(fn ($denom) => $denom->sum('count'));
        $daily_cash_ends_total = $daily_cash_ends_denominations?->map(fn ($count, $denom) => $count * $denom)->sum() ?? 0;
        return view('livewire.cashier.cashier-cash-monitoring-report', [
            'daily_cash_end_denominations' => $daily_cash_ends_denominations,
            'releases_total_by_date' => $releases_total_by_date,
            'daily_cash_starts_by_date' => $daily_cash_starts_by_date,
            'daily_cash_ends_total' => $daily_cash_ends_total
        ]);
    }
}
