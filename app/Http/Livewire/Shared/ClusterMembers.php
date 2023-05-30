<?php

namespace App\Http\Livewire\Shared;

use App\Models\Cluster;
use Livewire\Component;
use App\Models\MemberInformation;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Database\Eloquent\Relations\Relation;
use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use Filament\Tables\Filters\SelectFilter;

class ClusterMembers extends Component implements HasTable
{
    use InteractsWithTable;

    public Cluster $cluster;

    protected function getTableHeaderActions(): array
    {
        return [
            FilamentExportHeaderAction::make('Export')
                ->fileNamePrefix('Cluster ' . $this->cluster->name . ' - ' . str($this->cluster->address)->replace('/', '-')->replace('\\', '-') . ' Members')
                ->directDownload(),
        ];
    }

    protected function getTableQuery(): Builder|Relation
    {
        return MemberInformation::query();
    }

    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('cluster_id')
                ->default(fn () => $this->cluster->id)
                ->label('')
                ->query(fn (Builder $query, $state) => $query->whereClusterId($state['value']))
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
        return view('livewire.shared.cluster-members');
    }
}
