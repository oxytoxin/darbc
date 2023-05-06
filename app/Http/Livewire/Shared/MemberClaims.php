<?php

namespace App\Http\Livewire\Shared;

use Livewire\Component;
use App\Models\Dividend;
use App\Models\MemberInformation;

class MemberClaims extends Component
{
    public MemberInformation $member;

    public function render()
    {
        return view('livewire.shared.member-claims', [
            'dividends_amount_to_claim' => Dividend::whereUserId($this->member->user_id)
                ->where('status', Dividend::FOR_RELEASE)
                ->select(['id', 'net_amount', 'status'])
                ->get()
                ->sum('net_amount'),
            'dividends_by_year' => Dividend::with('release')->whereUserId($this->member->user_id)->get()->groupBy(fn ($value) => $value->release->created_at->format('Y'))->sortKeysDesc(),
        ]);
    }
}
