<?php

namespace App\Http\Livewire;

use App\Models\MemberInformation;
use Livewire\Component;
use Spatie\SimpleExcel\SimpleExcelWriter;

class TestComponent extends Component
{
    public function render()
    {
        return view('livewire.test-component');
    }

    public function mount()
    {
        // $writer = SimpleExcelWriter::create(storage_path('csv/members.xlsx'));
        // $writer->addHeader([
        //     'DARBC ID',
        //     'NAME',
        // ]);
        // $members = MemberInformation::query()->with('user')->whereStatus(MemberInformation::STATUS_ACTIVE)->orderBy('darbc_id');
        // $members->each(function ($member) use ($writer) {
        //     $writer->addRow([
        //         $member->darbc_id,
        //         $member->user->alt_full_name,
        //     ]);
        // });
    }
}
