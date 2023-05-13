<?php

namespace App\Http\Livewire\Shared;

use App\Models\User;
use App\Models\Cluster;
use Livewire\Component;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;

class ClusterManagement extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableQuery()
    {
        return Cluster::query()->orderByName();
    }

    protected function getTableColumns()
    {
        return [
            TextColumn::make('name'),
            TextColumn::make('address'),
            TextColumn::make('members_count')
                ->counts('members'),
            TextColumn::make('leader.full_name'),

        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
            Action::make('clusterless')
                ->label('Unassigned Members')
                ->button()
                ->outlined()
                ->url(fn () => route('clusterless-members')),
            CreateAction::make('create')
                ->form([
                    TextInput::make('name')->required(),
                    TextInput::make('address')->required(),
                    Select::make('leader_id')
                        ->searchable()
                        ->debounce(2000)
                        ->options(fn () => User::has('member_information')->pluck('full_name', 'id'))
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
                    TextInput::make('name')->required(),
                    TextInput::make('address')->required(),
                    Select::make('leader_id')
                        ->debounce(2000)
                        ->searchable()
                        ->options(fn () => User::has('member_information')->pluck('full_name', 'id'))
                        ->label('Leader'),
                ])
                ->modalWidth('md')
                ->color('success')
                ->button(),
            Action::make('members')
                ->color('primary')
                ->outlined()
                ->url(fn ($record) => route('cluster-members', ['cluster' => $record]))
                ->icon('heroicon-o-user-group')
                ->button(),
        ];
    }

    public function render()
    {
        return view('livewire.shared.cluster-management');
    }
}
