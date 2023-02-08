<?php

namespace App\Http\Livewire\Shared;

use App\Models\FreeLot;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Livewire\Component;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Relations\Relation;

class FreeLotManagement extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableQuery(): Builder|Relation
    {
        return FreeLot::query();
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'draw_date';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('user.full_name')
                ->searchable()
                ->sortable(['users.first_name', 'users.surname'])
                ->label('Member'),
            TextColumn::make('cluster.name')
                ->sortable(),
            TextColumn::make('block')
                ->sortable(),
            TextColumn::make('lot')
                ->sortable(),
            TextColumn::make('area')
                ->sortable(),
            TextColumn::make('draw_date')
                ->date('M d, Y')
                ->label('Draw Date')
                ->sortable(),

            BadgeColumn::make('status')
                ->enum([
                    1 => 'ACTIVE',
                    2 => 'SOLD',
                    3 => 'RELOCATED',
                    4 => 'SWAPPED',
                ])
                ->size('sm')
                ->color('success')
                ->sortable(),
            TextColumn::make('buyer')
                ->sortable(),
            TextColumn::make('sold_at')
                ->date('M d, Y')
                ->label('Date Sold')
                ->sortable(),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('status')
                ->options([
                    1 => 'ACTIVE',
                    2 => 'SOLD',
                    3 => 'RELOCATED',
                    4 => 'SWAPPED',
                ])
                ->placeholder('All'),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            EditAction::make()
                ->form(function ($record) {
                    return [
                        Grid::make(2)->schema([
                            Select::make('cluster_id')
                                ->relationship('cluster', 'name')
                                ->required(),
                            Select::make('user_id')
                                ->relationship('user', 'full_name')
                                ->label('Member')
                                ->required()
                                ->searchable(),
                            TextInput::make('block')
                                ->required(),
                            TextInput::make('lot')
                                ->required(),
                            TextInput::make('area')
                                ->required(),
                            Select::make('status')
                                ->options([
                                    1 => 'ACTIVE',
                                    2 => 'SOLD',
                                    3 => 'RELOCATED',
                                    4 => 'SWAPPED',
                                ])
                                ->required(),
                            DatePicker::make('draw_date')
                                ->label('Draw Date')
                                ->required(),

                        ]),
                        Grid::make(2)->schema([
                            TextInput::make('buyer'),
                            DatePicker::make('sold_at')
                                ->label('Date Sold'),
                        ]),
                    ];
                })
                ->button(),
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->form(function () {
                    return [
                        Grid::make(2)->schema([
                            Select::make('cluster_id')
                                ->relationship('cluster', 'name')
                                ->required(),
                            Select::make('user_id')
                                ->relationship('user', 'full_name')
                                ->label('Member')
                                ->required()
                                ->searchable(),
                            TextInput::make('block')
                                ->required(),
                            TextInput::make('lot')
                                ->required(),
                            TextInput::make('area')
                                ->required(),
                            Select::make('status')
                                ->options([
                                    1 => 'ACTIVE',
                                    2 => 'SOLD',
                                    3 => 'RELOCATED',
                                    4 => 'SWAPPED',
                                ])
                                ->default(1)
                                ->required(),
                            DatePicker::make('draw_date')
                                ->label('Draw Date')
                                ->required(),

                        ]),
                        Grid::make(2)->schema([
                            TextInput::make('buyer'),
                            DatePicker::make('sold_at')
                                ->label('Date Sold'),
                        ]),
                    ];
                })->label('New Free Lot Distribution'),
        ];
    }

    public function render()
    {
        return view('livewire.shared.free-lot-management');
    }
}
