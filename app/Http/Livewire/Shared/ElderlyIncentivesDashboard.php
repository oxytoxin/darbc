<?php

namespace App\Http\Livewire\Shared;

use App\Models\ElderlyIncentive;
use App\Models\ElderlyIncentiveType;
use App\Models\MemberInformation;
use Closure;
use DB;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Livewire\Component;

class ElderlyIncentivesDashboard extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableQuery(): Builder|Relation
    {
        return MemberInformation::query()
            ->whereStatus(MemberInformation::STATUS_ACTIVE)
            ->where('age', '>=', 80)
            // ->orderByRaw('FIELD(age, 80, 90, 100) DESC')
            ->orderByDesc('age');
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
                ->label('DARBC ID'),
            TextColumn::make('user.alt_full_name')
                ->searchable()
                ->label('Member'),
            TextColumn::make('age'),
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
                            ->label('Incentive Type')
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
                        'amount' => $incentive->amount
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
