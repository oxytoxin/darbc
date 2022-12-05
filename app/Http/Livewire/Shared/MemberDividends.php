<?php

namespace App\Http\Livewire\Shared;

use App\Models\Dividend;
use App\Models\MemberInformation;
use Livewire\Component;

class MemberDividends extends Component
{
    public MemberInformation $member;

    public function render()
    {
        return view('livewire.shared.member-dividends', [
            'dividends_amount_to_claim' => Dividend::whereUserId($this->member->user_id)
                ->whereNot('status', Dividend::PENDING)
                ->select(['id', 'gross_amount', 'deductions_amount', 'status'])
                ->get()
                ->sum('net_amount'),
            'lineage_members' => MemberInformation::with('user')->whereLineageIdentifier($this->member->lineage_identifier)->orderBy('succession_number')->get(),
            'dividends_by_year' => Dividend::with('release')->whereUserId($this->member->user_id)->get()->groupBy(fn ($value) => $value->release->created_at->format('Y'))->sortKeysDesc(),
        ]);
    }
}
