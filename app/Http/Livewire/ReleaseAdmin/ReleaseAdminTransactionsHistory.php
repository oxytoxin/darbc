<?php

namespace App\Http\Livewire\ReleaseAdmin;

use AlperenErsoy\FilamentExport\Actions\FilamentExportHeaderAction;
use App\Models\User;
use App\Models\Release;
use Livewire\Component;
use App\Models\Dividend;
use Filament\Forms\Components\Actions\Modal\Actions\Action as ModalAction;
use Illuminate\Support\HtmlString;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\Layout;
use Filament\Forms\Components\Radio;
use Filament\Tables\Actions\Position;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Concerns\HasRecords;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Database\Eloquent\Collection;
use Spatie\SimpleExcel\SimpleExcelWriter;

class ReleaseAdminTransactionsHistory extends Component implements HasTable
{
    use InteractsWithTable;

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [5, 10, 25, 50];
    }

    protected function getTableQuery()
    {
        return Dividend::whereClaimed(true);
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'released_at';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }

    protected function getTableColumns()
    {
        return [
            TextColumn::make('released_at')
                ->label('DATE')
                ->sortable()
                ->wrap()
                ->size('sm')
                ->dateTime('h:i A m/d/Y'),
            TextColumn::make('gift_certificate_control_number')
                ->label('GC')
                ->searchable()
                ->size('sm')
                ->prefix(fn ($record) => $record->release->gift_certificate_prefix),
            TextColumn::make('user.surname')
                ->label('Last Name')
                ->sortable()
                ->searchable(isIndividual: true),
            TextColumn::make('user.first_name')
                ->label('First Name')
                ->searchable(isIndividual: true),
            TextColumn::make('release.name')
                ->label('RELEASE NAME')
                ->wrap()
                ->size('sm'),
            TextColumn::make('cashier.full_name')
                ->label('CASHIER')
                ->sortable(['cashier.surname']),
            BadgeColumn::make('status')
                ->label('STATUS')
                ->enum([
                    Dividend::RELEASED => 'released',
                ])
                ->colors([
                    'success',
                ]),
            TextColumn::make('net_amount')
                ->label('AMOUNT')
                ->sortable()
                ->money('PHP', true),
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
            FilamentExportHeaderAction::make('Export')
                ->fileNamePrefix('Transactions History')
                ->directDownload(),
            Action::make('Export')
                ->icon('heroicon-s-download')
                ->button()
                ->outlined()
                ->action(function () {
                    $date = now()->format('h:i:s a F d, Y');
                    $writer = SimpleExcelWriter::create(storage_path("app/livewire-tmp/Transactions History {$date}.xlsx"))
                        ->addHeader([
                            'DARBC ID',
                            'Member Name',
                            'Shares',
                            'Amount',
                            'Released At',
                        ]);
                    $this->getFilteredTableQuery()->orderByDesc('released_at')
                        ->chunk(200, function (Collection $dividends) use ($writer) {
                            $dividends->each(function ($record) use ($writer) {
                                $writer->addRow([
                                    'DARBC ID' => $record->user->member_information->darbc_id,
                                    'Member Name' => $record->user->alt_full_name,
                                    'Shares' => $record->release->name,
                                    'Amount' => $record->net_amount,
                                    'Released At' => date_create($record->released_at)->format('h:i a m/d/Y'),
                                ]);
                            });
                        });
                    return response()->download($writer->getPath());
                })
        ];
    }

    protected function getTableActionsPosition(): ?string
    {
        return Position::BeforeCells;
    }

    protected function getTableActions()
    {
        return [
            ActionGroup::make([
                ViewAction::make('proof_of_release')
                    ->label('Proof of Release')
                    ->icon('heroicon-o-photograph')
                    ->modalContent(fn ($record) => view('livewire.cashier.components.proof_of_release', ['dividend' => $record]))
                    ->modalHeading('Proof of Release'),
                ViewAction::make('payslip')
                    ->label('Payslip')
                    ->icon('heroicon-o-document')
                    ->modalContent(fn ($record) => view('livewire.cashier.components.payslip', ['dividend' => $record]))
                    ->modalHeading('Payslip'),
            ]),
            Action::make('edit')
                ->action(function ($record, $data) {
                    $record->update($data);
                    Notification::make()->title('Dividend updated.')->success()->send();
                })
                ->form(fn ($record) => [
                    TextInput::make('gift_certificate_control_number')
                        ->prefix(fn ($record) => $record->release->gift_certificate_prefix)
                        ->label('Gift Certificate Control Number')
                        ->maxLength(4),
                    Radio::make('claim_type')->options([
                        1 => 'Member',
                        2 => 'SPA',
                        3 => 'Authorized Representative',
                    ])->disableLabel()
                        ->default(1)
                        ->afterStateUpdated(function ($set, $state) use ($record) {
                            if ($state == 2) {
                                $set('claimed_by', collect($record->user->member_information->spa)->first());
                            } else {
                                $set('claimed_by', null);
                            }
                        })
                        ->reactive(),
                    TextInput::make('claimed_by')->label(fn ($get) => match (intval($get('claim_type'))) {
                        2 => 'SPA Name',
                        3 => 'Representative Name',
                        default => 'Member Name',
                    })->validationAttribute('name')->required()->visible(fn ($get) => $get('claim_type') != 1),

                ])
                ->mountUsing(fn ($form, $record) => $form->fill([
                    'gift_certificate_control_number' => $record->gift_certificate_control_number,
                    'claim_type' => $record->claim_type,
                    'claimed_by' => $record->claimed_by,
                ]))
                ->modalWidth('md')
                ->label('Edit')
                ->outlined()
                ->button(),
            Action::make('void')
                ->action(fn ($record, $data) => $record->update([
                    'remarks' => $data['remarks'],
                    'voided' => true,
                ]))
                ->form([
                    Textarea::make('remarks')
                        ->label('Remarks')
                        ->required(),
                ])
                ->modalWidth('md')
                ->visible(fn ($record) => !$record->voided)
                ->label('Void')
                ->button(),
            ViewAction::make('remarks')
                ->label('Remarks')
                ->icon(null)
                ->button()
                ->visible(fn ($record) => $record->remarks && $record->voided)
                ->modalContent(fn ($record) => new HtmlString('<div class="p-4 whitespace-pre">' . $record->remarks . '</div>'))
                ->modalHeading('Payslip'),

        ];
    }

    protected function getTableFilters(): array
    {
        return [

            Filter::make('released_at')
                ->form([
                    DatePicker::make('released_from'),
                    DatePicker::make('released_until'),
                ])
                ->columns(2)
                ->columnSpan(2)
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['released_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('released_at', '>=', $date),
                        )
                        ->when(
                            $data['released_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('released_at', '<=', $date),
                        );
                }),
            SelectFilter::make('released_by')
                ->label('Cashier')
                ->placeholder('All')
                ->options(User::whereRelation('roles', 'name', 'cashier')->get()->pluck('full_name', 'id')),
            SelectFilter::make('release_id')
                ->label('Release')
                ->placeholder('All')
                ->options(Release::latest()->pluck('name', 'id')),
        ];
    }

    protected function getTableFiltersLayout(): ?string
    {
        return Layout::AboveContent;
    }

    public function render()
    {
        return view('livewire.release-admin.release-admin-transactions-history');
    }
}
