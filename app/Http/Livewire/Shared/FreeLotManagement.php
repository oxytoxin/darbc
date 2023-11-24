<?php

namespace App\Http\Livewire\Shared;

use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Models\FreeLot;
use App\Models\MemberInformation;
use App\View\Components\FreeLotStatusColumn;
use Closure;
use DB;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Livewire\Component;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Layout;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class FreeLotManagement extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [5, 10, 25, 50];
    }

    protected function getTableQuery(): Builder|Relation
    {
        return FreeLot::query();
    }

    protected function getTableRecordClassesUsing(): ?Closure
    {
        return fn (Model $record) => match ($record->status) {
            1 => 'bg-green-200 border-b border-gray-700',
            2 => 'bg-yellow-100 border-b border-gray-700',
            3 => 'bg-blue-200 border-b border-gray-700',
            4 => 'bg-purple-200 border-b border-gray-700',
            5 => 'bg-pink-200 border-b border-gray-700',
            default => null,
        };
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('user.member_information.darbc_id')
                ->visible(fn () => $this->tableFilters['darbc_id']['isActive'])
                ->sortable(true, function ($query, $direction) {
                    $query
                        ->leftJoin('users', 'free_lots.user_id', '=', 'users.id')
                        ->leftJoin('member_information', 'users.id', '=', 'member_information.user_id')
                        ->selectRaw('free_lots.*, member_information.darbc_id as member_darbc_id')
                        ->orderBy('member_darbc_id', $direction);
                })
                ->label('DARBC ID'),
            TextColumn::make('user.alt_full_name')
                ->visible(fn () => $this->tableFilters['name']['isActive'])
                ->sortable(['users.first_name', 'users.surname'])
                ->label('Name'),
            TextColumn::make('block')
                ->visible(fn () => $this->tableFilters['block']['isActive'])
                ->sortable(),
            TextColumn::make('lot')
                ->visible(fn () => $this->tableFilters['lot']['isActive'])
                ->sortable(),
            TextColumn::make('area')
                ->visible(fn () => $this->tableFilters['area']['isActive'])
                ->sortable(),
            FreeLotStatusColumn::make('status')
                ->enum([
                    1 => '',
                    2 => 'SOLD',
                    3 => 'RELOCATED',
                    4 => 'SWAPPED',
                    5 => 'DONATED',
                ])
                ->size('sm')
                ->colors([
                    'active' => 1,
                    'sold' => 2,
                    'relocated' => 3,
                    'swapped' => 4,
                    'donated' => 5,
                ])
                ->visible(fn () => $this->tableFilters['status_id']['isActive'])
                ->sortable(),
            TextColumn::make('buyer')
                ->visible(fn () => $this->tableFilters['buyer']['isActive'])
                ->sortable(),
            TextColumn::make('sold_at')
                ->date('M d, Y')
                ->label('Date Sold')
                ->visible(fn () => $this->tableFilters['date_sold']['isActive'])
                ->sortable(),
            TextColumn::make('draw_date')
                ->date('M d, Y')
                ->label('Draw Date')
                ->visible(fn () => $this->tableFilters['draw_date']['isActive'])
                ->sortable(),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            Filter::make('darbc_id')->label('DARBC ID')->default(),
            Filter::make('name')->label('NAME')->default(),
            Filter::make('block')->label('BLOCK')->default(),
            Filter::make('lot')->label('LOT')->default(),
            Filter::make('area')->label('AREA')->default(),
            Filter::make('status_id')->label('STATUS')->default(),
            Filter::make('buyer')->label('BUYER')->default(),
            Filter::make('date_sold')->label('DATE SOLD')->default(),
            Filter::make('draw_date')->label('DRAW DATE')->default(),
            Filter::make('lot_text')
                ->columns(4)
                ->columnSpan(4)->form([
                    TextInput::make('first_name')
                        ->label('First Name'),
                    TextInput::make('last_name')
                        ->label('Last Name'),
                    TextInput::make('block')
                        ->label('Block'),
                    TextInput::make('lot')
                        ->label('Lot'),
                    TextInput::make('area')
                        ->label('Area'),
                    Select::make('member_status')
                        ->label('Member Status')
                        ->options([
                            MemberInformation::STATUS_ACTIVE => 'ACTIVE',
                            MemberInformation::STATUS_DECEASED => 'DECEASED',
                        ])
                        ->default(MemberInformation::STATUS_ACTIVE)
                        ->placeholder('ALL'),
                    Select::make('status')
                        ->label('Lot Status')
                        ->options([
                            1 => 'ACTIVE',
                            2 => 'SOLD',
                            3 => 'RELOCATED',
                            4 => 'SWAPPED',
                            5 => 'DONATED',
                        ])
                        ->placeholder('All'),
                ])->query(function ($query, $data) {
                    $query->when($data['status'], fn ($q) => $q->where('status', $data['status']));
                    $query->when(
                        $data['member_status'],
                        fn ($q) => $data['member_status'] == MemberInformation::STATUS_ACTIVE ?
                            $q :
                            $q->whereRelation('user.member_information', 'status', $data['member_status'])
                    );
                    $query->when($data['first_name'], fn ($q) => $q->whereRelation('user', 'first_name', "LIKE", "{$data['first_name']}%"));
                    $query->when($data['last_name'], fn ($q) =>  $q->whereRelation('user', 'surname', "LIKE", "{$data['last_name']}%"));
                    $query->when($data['block'], fn ($q) => $q->where('block', $data['block']));
                    $query->when($data['lot'], fn ($q) => $q->where('lot', $data['lot']));
                    $query->when($data['area'], fn ($q) => $q->where('area', $data['area']));
                }),

        ];
    }

    protected function getTableFiltersLayout(): ?string
    {
        return Layout::AboveContent;
    }

    protected function getTableActions(): array
    {
        return [
            EditAction::make()
                ->form(function ($record) {
                    return [
                        Grid::make(2)->schema([
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
                                ->label('Draw Date'),

                        ]),
                        Grid::make(2)->schema([
                            TextInput::make('buyer'),
                            DatePicker::make('sold_at')
                                ->label('Date Sold'),
                        ]),
                    ];
                })
                ->button(),
            Action::make('history')
                ->icon('heroicon-o-clock')
                ->outlined()
                ->button()
                ->extraAttributes([
                    'class' => 'bg-white'
                ])
                ->color('secondary')
                ->url(fn (FreeLot $record) => route('release-admin.free-lot-history', ['free_lot' => $record])),
            ActionGroup::make([
                Action::make('swap')
                    ->icon('heroicon-o-refresh')
                    ->outlined()
                    ->button()
                    ->form([
                        Select::make('target_free_lot_id')
                            ->label('Target Free Lot')
                            ->required()
                            ->options(
                                fn ($record) =>
                                FreeLot::query()
                                    ->whereNot('free_lots.id', $record->id)
                                    ->join('users', 'free_lots.user_id', '=', 'users.id')
                                    ->select([
                                        'free_lots.id',
                                        'address', 'users.full_name',
                                        DB::raw("CONCAT(users.full_name, ' - ', address) as owner")
                                    ])
                                    ->pluck('owner', 'free_lots.id')
                            )
                            ->searchable(),
                    ])
                    ->action(function ($data, $record) {
                        $target_free_lot = FreeLot::findOrfail($data['target_free_lot_id']);
                        $origin_free_lot = $record->replicate();
                        DB::beginTransaction();
                        $origin_swapping_history = collect($record->swapping_history ?? []);
                        $origin_swapping_history->push([
                            'date' => today()->format('Y-m-d'),
                            'origin' => [
                                'owner_id' => $record->user_id,
                                'owner' => $record->user->full_name,
                                'cluster_id' => $record->cluster_id,
                                'block' => $record->block ?? null,
                                'lot' => $record->lot ?? null,
                                'area' => $record->area ?? null,
                            ],
                            'target' => [
                                'owner_id' => $target_free_lot->user_id,
                                'owner' => $target_free_lot->user->full_name,
                                'cluster_id' => $target_free_lot->cluster_id,
                                'block' => $target_free_lot->block,
                                'lot' => $target_free_lot->lot,
                                'area' => $target_free_lot->area,
                            ],
                        ]);
                        $record->update([
                            'status' => 4,
                            'block' => $target_free_lot->block,
                            'lot' => $target_free_lot->lot,
                            'area' => $target_free_lot->area,
                            'swapping_history' => $origin_swapping_history->values()->toArray(),
                        ]);
                        $target_swapping_history = collect($target_free_lot->swapping_history ?? []);
                        $target_swapping_history->push([
                            'date' => today()->format('Y-m-d'),
                            'origin' => [
                                'owner_id' => $target_free_lot->user_id,
                                'owner' => $target_free_lot->user->full_name,
                                'cluster_id' => $target_free_lot->cluster_id,
                                'block' => $target_free_lot->block ?? null,
                                'lot' => $target_free_lot->lot ?? null,
                                'area' => $target_free_lot->area ?? null,
                            ],
                            'target' => [
                                'owner_id' => $origin_free_lot->user_id,
                                'owner' => $origin_free_lot->user->full_name,
                                'cluster_id' => $origin_free_lot->cluster_id,
                                'block' => $origin_free_lot->block,
                                'lot' => $origin_free_lot->lot,
                                'area' => $origin_free_lot->area,
                            ],
                        ]);
                        $target_free_lot->update([
                            'status' => 4,
                            'block' => $origin_free_lot->block,
                            'lot' => $origin_free_lot->lot,
                            'area' => $origin_free_lot->area,
                            'swapping_history' => $target_swapping_history->values()->toArray(),
                        ]);
                        DB::commit();
                        Notification::make()->title('Free Lot Swapped')->success()->send();
                    }),
                Action::make('sell')
                    ->icon('heroicon-o-cash')
                    ->outlined()
                    ->button()
                    ->form([
                        TextInput::make('buyer')
                            ->required(),
                        DatePicker::make('sold_at')
                            ->label('Date Sold')
                            ->required(),
                    ])
                    ->action(function ($data, $record) {
                        DB::beginTransaction();
                        $selling_history = collect($record->selling_history ?? []);
                        $selling_history->push([
                            'date' => today()->format('Y-m-d'),
                            'buyer' => $data['buyer'],
                            'sold_at' => $data['sold_at'],
                        ]);
                        $record->update([
                            'status' => 2,
                            'buyer' => $data['buyer'],
                            'sold_at' => $data['sold_at'],
                            'selling_history' => $selling_history->values()->toArray(),
                        ]);
                        DB::commit();
                        Notification::make()->title('Free Lot Sold')->success()->send();
                    })
                    ->mountUsing(function ($form) {
                        $form->fill([
                            'sold_at' => today()->format('Y-m-d'),
                        ]);
                    }),
                Action::make('relocate')
                    ->icon('heroicon-o-location-marker')
                    ->outlined()
                    ->button()
                    ->form([
                        TextInput::make('block')
                            ->required(),
                        TextInput::make('lot')
                            ->required(),
                        TextInput::make('area')
                            ->required(),
                    ])
                    ->action(function ($data, $record) {
                        DB::beginTransaction();
                        $relocation_history = collect($record->relocation_history ?? []);
                        $relocation_history->push([
                            'date' => today()->format('Y-m-d'),
                            'origin' => [
                                'block' => $record->block,
                                'lot' => $record->lot,
                                'area' => $record->area,
                                'cluster_id' => $record->cluster_id,
                            ]
                        ]);
                        $record->update([
                            'status' => 3,
                            'block' => $data['block'],
                            'lot' => $data['lot'],
                            'area' => $data['area'],
                            'relocation_history' => $relocation_history->values()->toArray(),
                        ]);
                        DB::commit();
                        Notification::make()->title('Free Lot Relocated')->success()->send();
                    })
                    ->mountUsing(function ($form, $record) {
                        $form->fill([
                            'block' => $record->block,
                            'lot' => $record->lot,
                            'area' => $record->area,
                        ]);
                    }),
                Action::make('donate')
                    ->icon('heroicon-o-users')
                    ->outlined()
                    ->button()
                    ->action(function ($data, $record) {
                        DB::beginTransaction();
                        $record->update([
                            'status' => 5,
                        ]);
                        DB::commit();
                        Notification::make()->title('Free Lot donated')->success()->send();
                    })
                    ->requiresConfirmation()
            ])
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
            FilamentExportHeaderAction::make('export')
                ->button()
                ->outlined()
                ->fileNamePrefix('Free Lot Export ')
                ->directDownload(),
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
