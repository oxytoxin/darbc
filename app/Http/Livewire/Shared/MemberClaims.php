<?php

namespace App\Http\Livewire\Shared;

use Livewire\Component;
use App\Models\Dividend;
use App\Models\MemberInformation;
use Spatie\SimpleExcel\SimpleExcelWriter;

class MemberClaims extends Component
{
    public MemberInformation $member;

    public function getDividendsByYearProperty()
    {
        return Dividend::with('release')->whereUserId($this->member->user_id)->get()->groupBy(fn ($value) => $value->release->created_at->format('Y'))->sortKeysDesc();
    }

    public function render()
    {
        return view('livewire.shared.member-claims', [
            'dividends_amount_to_claim' => Dividend::whereUserId($this->member->user_id)
                ->where('status', Dividend::FOR_RELEASE)
                ->select(['id', 'net_amount', 'status'])
                ->get()
                ->sum('net_amount'),
            'dividends_by_year' => $this->dividends_by_year,
        ]);
    }

    public function export()
    {
        $writer = SimpleExcelWriter::create(storage_path("app/livewire-tmp/{$this->member->user->full_name} Claims.xlsx"))
            ->addHeader([
                'Release Name',
                'Amount',
                'Date of Release',
                'Status',
            ]);

        foreach ($this->dividends_by_year as $year => $dividends) {
            foreach ($dividends as $dividend) {
                $writer->addRow([
                    'Release Name' => $dividend->release->name,
                    'Amount' => $dividend->net_amount,
                    'Date of Release' => $dividend->released_at?->format('F d, Y') ?? '',
                    'Status' => match ($dividend->status) {
                        Dividend::PENDING => 'Pending',
                        Dividend::FOR_RELEASE => 'For Release',
                        Dividend::ON_HOLD => 'On Hold',
                        Dividend::RELEASED => 'Released',
                    },
                ]);
            }
        }

        return response()->download($writer->getPath());
    }
}
