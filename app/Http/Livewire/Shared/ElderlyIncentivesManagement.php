<?php

namespace App\Http\Livewire\Shared;

use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Models\ElderlyIncentive;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Layout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Livewire\Component;

class ElderlyIncentivesManagement extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableQuery(): Builder|Relation
    {
        return ElderlyIncentive::query();
    }

    protected function getTableHeaderActions(): array
    {
        return [
            FilamentExportHeaderAction::make('export')
                ->directDownload()
                ->fileNamePrefix('Elderly Incentives Awarded')
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('user.alt_full_name')
                ->searchable()
                ->label('Member Name'),
            TextColumn::make('amount')
                ->money('PHP', true)
                ->sortable(),
            TextColumn::make('created_at')
                ->date()
                ->sortable()
                ->label('Date Awarded')
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            Filter::make('date')
                ->columns(2)
                ->columnSpan(2)
                ->form([
                    DatePicker::make('date_from'),
                    DatePicker::make('date_to'),
                ])
                ->query(function (Builder $query, $data) {
                    $query
                        ->when($data['date_from'], fn ($query, $value) => $query->whereDate('created_at', '>=', $value))
                        ->when($data['date_to'], fn ($query, $value) => $query->whereDate('created_at', '<=', $value));
                })
        ];
    }

    protected function getTableFiltersLayout(): ?string
    {
        return Layout::AboveContent;
    }

    protected function getTableActions(): array
    {
        return [
            DeleteAction::make()
        ];
    }

    public function render()
    {
        return view('livewire.shared.elderly-incentives-management');
    }
}
