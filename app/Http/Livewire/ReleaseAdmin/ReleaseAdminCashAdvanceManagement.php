<?php

namespace App\Http\Livewire\ReleaseAdmin;

use Livewire\Component;
use App\Models\CashAdvance;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\Position;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Database\Eloquent\Relations\Relation;

class ReleaseAdminCashAdvanceManagement extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableQuery(): Builder|Relation
    {
        return CashAdvance::query();
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'date_approved';
    }
    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('user.member_information.darbc_id')
                ->label('DARBC ID')
                ->searchable(),
            TextColumn::make('user.full_name')
                ->label('Name')
                ->searchable(),
            TextColumn::make('purpose')
                ->sortable(),
            TextColumn::make('illness')
                ->sortable(),
            TextColumn::make('requested_amount')
                ->label('Requested Amount')
                ->money('PHP', true)
                ->sortable(),
            TextColumn::make('approved_amount')
                ->label('Approved Amount')
                ->money('PHP', true)
                ->sortable(),
            TextColumn::make('date_received')
                ->label('Date Received')
                ->sortable()
                ->date(),
            TextColumn::make('date_approved')
                ->label('Date Approved')
                ->sortable()
                ->date(),
            TextColumn::make('contact_number')
                ->label('Contact Number')
                ->sortable(),
            TextColumn::make('remarks')
                ->sortable(),
        ];
    }

    protected function getTableActionsPosition(): ?string
    {
        return Position::BeforeColumns;
    }

    protected function getTableActions(): array
    {
        return [
            EditAction::make()->form([
                TextInput::make('purpose')
                    ->label('Purpose')
                    ->required(),
                TextInput::make('illness'),
                Grid::make(2)->schema([
                    TextInput::make('requested_amount')
                        ->label('Requested Amount')
                        ->numeric()
                        ->minValue(0)
                        ->required(),
                    TextInput::make('approved_amount')
                        ->label('Approved Amount')
                        ->numeric()
                        ->minValue(0)
                        ->required(),
                    DatePicker::make('date_received')
                        ->label('Date Received')
                        ->withoutTime()
                        ->required(),
                    DatePicker::make('date_approved')
                        ->label('Date Approved')
                        ->withoutTime()
                        ->required(),
                ]),
                Textarea::make('remarks'),
            ])
                ->button()
                ->outlined()
                ->modalHeading('Edit Cash Advance'),
            DeleteAction::make(),
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New Cash Advance')
                ->form([
                    Select::make('user_id')
                        ->label('Name')
                        ->relationship('user', 'full_name')
                        ->searchable()
                        ->required(),
                    TextInput::make('purpose')
                        ->label('Purpose')
                        ->required(),
                    TextInput::make('illness'),
                    Grid::make(2)->schema([
                        TextInput::make('requested_amount')
                            ->label('Requested Amount')
                            ->numeric()
                            ->minValue(0),
                        TextInput::make('approved_amount')
                            ->label('Approved Amount')
                            ->numeric()
                            ->minValue(0),
                        DatePicker::make('date_received')
                            ->label('Date Received')
                            ->withoutTime(),
                        DatePicker::make('date_approved')
                            ->label('Date Approved')
                            ->withoutTime(),
                        TextInput::make('account_amount')
                            ->label('Account')
                            ->numeric()
                            ->minValue(0),
                    ]),
                    Textarea::make('remarks'),
                ])
                ->action(function ($data) {
                    CashAdvance::create([
                        ...$data,
                        'other_details' => []
                    ]);
                    Notification::make()->title('New cash advance created.')->success()->send();
                })
        ];
    }

    public function render()
    {
        return view('livewire.release-admin.release-admin-cash-advance-management');
    }
}
