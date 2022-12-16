<?php

namespace App\Http\Livewire\ReleaseAdmin;

use App\Models\User;
use Livewire\Component;
use App\Models\Dividend;
use Illuminate\Support\HtmlString;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Layout;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Concerns\InteractsWithTable;

class ReleaseAdminTransactionsHistory extends Component implements HasTable
{
    use InteractsWithTable;

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
                ->dateTime('h:i A m/d/Y'),
            TextColumn::make('user.surname')
                ->label('Last Name')
                ->sortable()
                ->searchable(isIndividual: true),
            TextColumn::make('user.first_name')
                ->label('First Name')
                ->searchable(isIndividual: true),
            TextColumn::make('release.name')
                ->label('RELEASE NAME'),
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
                ->sortable(['gross_amount'])
                ->money('PHP', true),
        ];
    }

    protected function getTableActions()
    {
        return [
            Action::make('edit')
                ->action(function ($record, $data) {
                    $record->update($data);
                    Notification::make()->title('Control number updated.')->success()->send();
                })
                ->form([
                    TextInput::make('gift_certificate_control_number')
                        ->prefix(fn ($record) => $record->release->gift_certificate_prefix)
                        ->label('Gift Certificate Control Number')
                        ->maxLength(4)
                ])
                ->mountUsing(fn ($form, $record) => $form->fill([
                    'gift_certificate_control_number' => $record->gift_certificate_control_number,
                ]))
                ->modalWidth('md')
                ->visible(fn ($record) => !$record->voided)
                ->label('GC')
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
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('released_by')
                ->label('Cashier')
                ->placeholder('All')
                ->options(User::whereRelation('roles', 'name', 'cashier')->get()->pluck('full_name', 'id')),
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
