<?php

namespace App\Http\Livewire\Cashier;

use App\Models\User;
use App\Models\Release;
use Livewire\Component;
use App\Models\MemberInformation;
use Illuminate\Database\Eloquent\Builder;

class CashierDashboard extends Component
{
    public function render()
    {
        return view('livewire.cashier.cashier-dashboard', [
            'total_members_count' => MemberInformation::darbcMember()->count(),
            'deceased_members_count' => MemberInformation::deceased()->count(),
            'original_members_count' => MemberInformation::original()->count(),
            'replacement_members_count' => MemberInformation::replacement()->count(),
            'members_on_hold_count' => User::onHold()->count(),
            'latest_release' => Release::whereDisbursed(true)->latest()
                ->withCount(['dividends', 'released_dividends' => function (Builder $query) {
                    $query->where('released_by', auth()->id());
                }])
                ->withSum(['released_dividends as released_dividends_gross' => function (Builder $query) {
                    $query->where('released_by', auth()->id());
                }], 'gross_amount')
                ->withSum(['released_dividends as released_dividends_deductions' => function (Builder $query) {
                    $query->where('released_by', auth()->id());
                }], 'deductions_amount')
                ->first(),
            'latest_releases' => Release::take(5)
                ->withSum('released_dividends as gross', 'gross_amount')
                ->withSum('released_dividends as deductions', 'deductions_amount')
                ->latest()->get(),
        ]);
    }
}
