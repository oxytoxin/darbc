<?php

namespace App\Http\Livewire\OfficeStaff;

use App\Models\Release;
use Livewire\Component;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;

class OfficeStaffReleasesIndex extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableQuery()
    {
        return Release::query();
    }

    protected function getTableColumns()
    {
        return [
            TextColumn::make('created_at')
                ->label('Date Released')
                ->date('F d, Y'),
            TextColumn::make('name'),
            TextColumn::make('total_amount')
                ->label('Total Amount')
                ->money('PHP', true),
            TagsColumn::make('particulars')
                ->getStateUsing(fn ($record) => collect($record->particulars)->map(fn ($value, $key) => $key)->toArray()),
            IconColumn::make('disbursed')
                ->alignCenter()
                ->extraAttributes(['class' => 'flex justify-center'])
                ->boolean(),
        ];
    }

    protected function getTableActions()
    {
        return [
            ViewAction::make('dividends')
                ->label('Dividends')
                ->button()
                ->extraAttributes(['class' => 'w-full'])
                ->icon('heroicon-o-cash')
                ->color('success')
                ->visible(fn ($record) => !$record->disbursed)
                ->url(fn ($record) => route('office-staff.ledger.release-dividends', ['release' => $record])),
            ViewAction::make('details')
                ->label('View Details')
                ->button()
                ->color('primary')
                ->visible(fn ($record) => $record->disbursed)
                ->url(fn ($record) => route('office-staff.ledger.release-details', ['release' => $record])),
        ];
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'created_at';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }
    public function render()
    {
        return view('livewire.office-staff.office-staff-releases-index');
    }
}
