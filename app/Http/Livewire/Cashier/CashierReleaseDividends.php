<?php

namespace App\Http\Livewire\Cashier;

use App\Models\Release;
use Livewire\Component;
use App\Models\Dividend;
use App\Models\MemberInformation;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Layout;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Concerns\InteractsWithTable;

class CashierReleaseDividends extends Component implements HasTable
{
    use InteractsWithTable;

    public Release $release;

    protected function getTableQuery()
    {
        return Dividend::whereReleaseId($this->release->id);
    }

    protected function getTableColumns()
    {
        return [
            TextColumn::make('user.member_information.darbc_id')
                ->label('DARBC ID')
                ->searchable(),
            TextColumn::make('user.surname')
                ->label('Last Name')
                ->searchable(isIndividual: true),
            TextColumn::make('user.first_name')
                ->label('First Name')
                ->searchable(isIndividual: true),
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


    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('status')
                ->label('Status')
                ->placeholder('All')
                ->options([
                    Dividend::FOR_RELEASE => 'for release',
                    Dividend::ON_HOLD => 'on hold',
                    Dividend::RELEASED => 'released',
                ]),
        ];
    }

    protected function getTableFiltersLayout(): ?string
    {
        return Layout::AboveContent;
    }

    protected function getTableActions()
    {
        return [
            Action::make('release')
                ->button()
                ->label('Release Now')
                ->color('success')
                ->visible(fn ($record) => $record->status === Dividend::FOR_RELEASE && !$record->claimed)
                ->url(fn ($record) => route('cashier.dividends.manage', ['dividend' => $record])),
        ];
    }

    public function render()
    {
        return view('livewire.cashier.cashier-release-dividends');
    }
}
