<?php

namespace App\Http\Livewire\Cashier;

use App\Models\Release;
use Livewire\Component;
use App\Models\Dividend;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Concerns\InteractsWithTable;

class CashierReleaseDividends extends Component implements HasTable
{
    use InteractsWithTable;

    public Release $release;

    protected function getTableQuery()
    {
        return Dividend::whereReleaseId($this->release->id)->whereStatus(Dividend::FOR_RELEASE);
    }

    protected function getTableColumns()
    {
        return [
            TextColumn::make('user.member_information.darbc_id')
                ->label('DARBC ID')
                ->searchable(),
            TextColumn::make('user.full_name')
                ->label('Name')
                ->searchable(query: fn ($query, $search) => $query->orWhereRelation('user', 'surname', 'like',  "$search%"))
                ->sortable(['surname']),
            TextColumn::make('gross_amount')
                ->sortable()
                ->label('Gross')
                ->money('PHP', true),
            TextColumn::make('deductions_amount')
                ->sortable()
                ->label('Deductions')
                ->money('PHP', true),
            TextColumn::make('net_amount')
                ->label('Net')
                ->money('PHP', true),
            TagsColumn::make('restriction_entries')
                ->sortable()
                ->label('Restrictions'),
            BadgeColumn::make('status')
                ->label('Status')
                ->colors([
                    'primary',
                    'success' => Dividend::FOR_RELEASE,
                    'danger' => Dividend::ON_HOLD,
                ])
                ->enum([
                    Dividend::FOR_RELEASE => 'for release',
                    Dividend::ON_HOLD => 'on hold',
                    Dividend::RELEASED => 'released',
                ])
                ->alignCenter(),
        ];
    }

    protected function getTableActions()
    {
        return [
            Action::make('view')
                ->button()
                ->label('Release Now')
                ->color('success')
                ->url(fn ($record) => route('cashier.dividends.manage', ['dividend' => $record])),
        ];
    }

    public function render()
    {
        return view('livewire.cashier.cashier-release-dividends');
    }
}
