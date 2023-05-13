<?php

namespace App\Http\Livewire\Shared;

use App\Models\Cluster;
use Livewire\Component;
use App\Models\MemberInformation;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Database\Eloquent\Relations\Relation;

class ClusterlessMembers extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableQuery(): Builder|Relation
    {
        return MemberInformation::query()->whereNull('cluster_id');
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('assign')
                ->button()
                ->outlined()
                ->form([
                    Select::make('cluster_id')
                        ->label('Cluster')
                        ->options(Cluster::orderByName()->selectRaw("id, concat(name, ' - ', address) as name")->pluck('name', 'id'))
                ])
                ->action(fn ($data, $record) => $record->update(['cluster_id' => $data['cluster_id']]))
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('darbc_id')
                ->label('DARBC ID'),
            TextColumn::make('user.full_name')
                ->label('Name'),
            BadgeColumn::make('succession_number')
                ->colors([
                    'success'
                ])
                ->sortable()
                ->formatStateUsing(fn ($state) => $state == 0 ? 'Original' : ordinal($state) . ' Successor')
                ->label('Ownership'),
        ];
    }

    public function render()
    {
        return view('livewire.shared.clusterless-members');
    }
}
