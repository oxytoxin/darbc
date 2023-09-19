<?php

namespace App\Http\Livewire\Shared;

use DB;
use Closure;
use Livewire\Component;
use App\Models\ElderlyIncentive;
use App\Models\MembershipStatus;
use App\Models\MemberInformation;
use Filament\Tables\Actions\Action;
use App\Models\ElderlyIncentiveType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Filters\Layout;
use Illuminate\Database\Eloquent\Relations\Relation;

class ElderlyIncentivesDashboard extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableQuery(): Builder|Relation
    {
        return MemberInformation::query()
            ->where('age', '>=', 80);
    }

    protected function getTableHeaderActions(): array
    {
        return [
            Action::make('incentives_awarded')
                ->label('View Awarded Incentives')
                ->button()
                ->url($this->getIncentivesAwardedRoute())
                ->color('primary')
                ->icon('heroicon-o-cash')
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('membership_status_id')
                ->label('Membership')
                ->placeholder('All')
                ->options([
                    'active' => 'ACTIVE',
                    'original' => 'ORIGINAL',
                    'replacement' => 'REPLACEMENT',
                    'deceased' => 'DECEASED',
                ])
                ->default('active')
                ->query(function ($query, $data) {
                    switch ($data['value']) {
                        case 'active':
                            $query->whereStatus(MemberInformation::STATUS_ACTIVE);
                            break;
                        case 'original':
                            $query->whereMembershipStatusId(MembershipStatus::ORIGINAL);
                            break;
                        case 'replacement':
                            $query->whereMembershipStatusId(MembershipStatus::REPLACEMENT);
                            break;
                        case 'deceased':
                            $query->whereStatus(MemberInformation::STATUS_DECEASED);
                            break;
                        default:
                            break;
                    }
                }),
        ];
    }

    protected function getTableFiltersLayout(): ?string
    {
        return Layout::AboveContent;
    }

    protected function getIncentivesAwardedRoute(): string
    {
        return '#';
    }

    protected function getTableEmptyStateHeading(): ?string
    {
        return 'No eligible members found.';
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('darbc_id')
                ->sortable()
                ->searchable()
                ->label('DARBC ID'),
            TextColumn::make('user.alt_full_name')
                ->sortable()
                ->searchable()
                ->label('Member'),
            TextColumn::make('age')
                ->sortable(),
            TextColumn::make('date_of_birth')
                ->date('F d, Y')
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('manage')
                ->icon('heroicon-s-currency-dollar')
                ->button()
                ->color('success')
                ->form(function ($record) {
                    return [
                        Placeholder::make('elderly_incentives_awarded')
                            ->content(
                                fn ($record) => view('forms.components.elderly.elderly-incentives', [
                                    'incentives' => $record->user->elderly_incentives
                                ])
                            ),
                        Select::make('elderly_incentive_type_id')
                            ->options(
                                ElderlyIncentiveType::where('minimum_age', '<=', $record->age ?? 0)
                                    ->whereDoesntHave('elderly_incentives', function ($query) use ($record) {
                                        $query->where('lineage_identifier', $record->lineage_identifier);
                                    })
                                    ->pluck('name', 'id')
                            )
                            ->required()
                            ->label('Incentive Type'),
                        DatePicker::make('created_at')
                            ->default(today())
                            ->required()
                            ->label('Date Awarded')
                    ];
                })
                ->action(function ($record, $data) {
                    $existing = ElderlyIncentive::query()
                        ->where('lineage_identifier', $record->lineage_identifier)
                        ->where('elderly_incentive_type_id', $data['elderly_incentive_type_id'])
                        ->exists();
                    if ($existing) {
                        return notify("Member's lineage has already claimed this incentive.", type: 'warning');
                    }
                    DB::beginTransaction();
                    $incentive = ElderlyIncentiveType::find($data['elderly_incentive_type_id']);
                    ElderlyIncentive::firstOrCreate([
                        'lineage_identifier' => $record->lineage_identifier,
                        'elderly_incentive_type_id' => $incentive->id,
                    ], [
                        'user_id' => $record->user_id,
                        'amount' => $incentive->amount,
                        'created_at' => $data['created_at']
                    ]);
                    DB::commit();
                    notify('Incentive awarded.');
                })
        ];
    }

    protected function getTableHeading(): string|Htmlable|Closure|null
    {
        return "Eligible Members";
    }

    public function render()
    {
        return view('livewire.shared.elderly-incentives-dashboard');
    }
}
