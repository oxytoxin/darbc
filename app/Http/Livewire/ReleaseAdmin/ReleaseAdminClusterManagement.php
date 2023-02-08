<?php

namespace App\Http\Livewire\ReleaseAdmin;

use App\Models\User;
use App\Models\Cluster;
use App\Models\MemberInformation;
use Livewire\Component;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Concerns\InteractsWithTable;

class ReleaseAdminClusterManagement extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableQuery()
    {
        return Cluster::query();
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
            CreateAction::make('create')
                ->form([
                    TextInput::make('name')->required(),
                    TextInput::make('address')->required(),
                    Select::make('leader_id')
                        ->searchable()
                        ->options(fn () => MemberInformation::with('user')->get()->pluck('user.full_name', 'user_id'))
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
                        ->searchable()
                        ->options(fn () => MemberInformation::with('user')->get()->pluck('user.full_name', 'user_id'))
                        ->label('Leader'),
                ])
                ->modalWidth('md')
                ->color('success')
                ->button(),
        ];
    }


    public function render()
    {
        return view('livewire.release-admin.release-admin-cluster-management');
    }
}
