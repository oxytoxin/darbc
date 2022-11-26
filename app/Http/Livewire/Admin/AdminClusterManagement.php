<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use App\Models\Cluster;
use Livewire\Component;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Concerns\InteractsWithTable;

class AdminClusterManagement extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableQuery()
    {
        return Cluster::query();
    }

    protected function getTableColumns()
    {
        return [
            TextColumn::make('name')
                ->extraAttributes(['class' => 'font-semibold text-sm']),
            TextColumn::make('members_count')
                ->counts('members')
                ->extraAttributes(['class' => 'font-semibold text-sm']),
            TextColumn::make('leader.full_name')
                ->extraAttributes(['class' => 'font-semibold text-sm']),

        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
            CreateAction::make('create')
                ->form([
                    TextInput::make('name'),
                    Select::make('leader_id')
                        ->searchable()
                        ->options(fn () => User::all()->pluck('full_name', 'id'))
                        ->label('Leader'),
                ])
                ->icon('heroicon-o-plus')
                ->modalWidth('md'),
        ];
    }

    protected function getTableActions()
    {
        return [
            EditAction::make('edit')
                ->form([
                    TextInput::make('name'),
                    Select::make('leader_id')
                        ->searchable()
                        ->options(fn () => User::all()->pluck('full_name', 'id'))
                        ->label('Leader'),
                ])
                ->modalWidth('md')
                ->color('success')
                ->button(),
        ];
    }


    public function render()
    {
        return view('livewire.admin.admin-cluster-management');
    }
}
