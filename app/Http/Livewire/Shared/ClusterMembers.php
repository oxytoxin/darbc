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
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Layout;
use Filament\Tables\Filters\SelectFilter;
use Spatie\SimpleExcel\SimpleExcelWriter;

class ClusterMembers extends Component implements HasTable
{
    use InteractsWithTable;

    public Cluster $cluster;

    protected function getTableHeaderActions(): array
    {
        return [
            Action::make('export')
                ->action(function () {
                    $file_name = 'Cluster ' . $this->cluster->name . ' - ' . str($this->cluster->address)->replace('/', '-')->replace('\\', '-') . ' Members.xlsx';
                    $file_name = preg_replace('/[^a-zA-Z0-9.]+/', '-', $file_name);
                    $writer = SimpleExcelWriter::create(storage_path("app/livewire-tmp/" . $file_name));
                    $writer->addHeader([
                        'DARBC ID',
                        'Member Name',
                        'Succession Number',
                    ]);
                    $this->getFilteredTableQuery()->with('user')->orderBy('darbc_id')->each(function ($member) use ($writer) {
                        $writer->addRow([
                            $member->darbc_id,
                            $member->user->alt_full_name,
                            $member->succession_number == 0 ? 'Original' : ordinal($member->succession_number) . ' Successor'
                        ]);
                    });
                    $writer->close();
                    return response()->download($writer->getPath());
                }),
        ];
    }

    protected function getTableQuery(): Builder|Relation
    {
        return MemberInformation::query();
    }

    protected function getTableFiltersLayout(): ?string
    {
        return Layout::AboveContent;
    }

    protected function getTableFilters(): array
    {
        return [
            Filter::make('filter')
                ->form([
                    Select::make('status')
                        ->label('Member Status')
                        ->options([
                            MemberInformation::STATUS_ACTIVE => 'ACTIVE',
                            MemberInformation::STATUS_INACTIVE => 'INACTIVE',
                            MemberInformation::STATUS_DECEASED => 'DECEASED',
                        ])
                        ->default(MemberInformation::STATUS_ACTIVE)
                        ->placeholder('ALL'),
                    Select::make('cluster_id')
                        ->label('Cluster')
                        ->disabled()
                        ->default($this->cluster->id)
                        ->disablePlaceholderSelection()
                        ->options([
                            $this->cluster->id => 'Cluster ' . $this->cluster->name
                        ]),
                ])
                ->query(function ($query, $data) {
                    $query->when($data['status'], fn ($q) => $q->where('status', $data['status']));
                    $query->when($data['cluster_id'], fn ($q) => $q->where('cluster_id', $data['cluster_id']));
                })
                ->columnSpan(2)
                ->columns(2)
        ];
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('darbc_id')
                ->label('DARBC ID'),
            TextColumn::make('user.alt_full_name')
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
