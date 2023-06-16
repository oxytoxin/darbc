<?php

namespace App\Http\Livewire\Shared;

use App\Models\MemberInformation;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Livewire\Component;

class ElderlyIncentivesDashboard extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableQuery(): Builder|Relation
    {
        return MemberInformation::query()->whereIn('age', [79, 89, 99])->whereStatus(MemberInformation::STATUS_ACTIVE);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('darbc_id')
                ->label('DARBC ID'),
            TextColumn::make('user.alt_full_name')
                ->label('Member'),
            TextColumn::make('age')
                ->sortable(),
            TextColumn::make('date_of_birth')
                ->date('F d, Y')

        ];
    }

    public function render()
    {
        return view('livewire.shared.elderly-incentives-dashboard');
    }
}
