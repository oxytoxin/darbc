<?php

namespace App\Http\Livewire\OfficeStaff;

use App\Models\Release;
use Livewire\Component;
use App\Models\Dividend;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Concerns\InteractsWithTable;

class OfficeStaffReleaseDetailsManagement extends Component implements HasTable
{
    use InteractsWithTable;

    public Release $release;

    protected function getTableQuery()
    {
        return Dividend::whereReleaseId($this->release->id);
    }

    protected function getTableColumns()
    {
        return [
            TextColumn::make('user.surname')
                ->label('Last Name')
                ->sortable()
                ->searchable(isIndividual: true),
            TextColumn::make('user.first_name')
                ->label('First Name')
                ->searchable(isIndividual: true),
            TextColumn::make('gross_amount')
                ->sortable()
                ->label('Gross')
                ->money('PHP', true),
            TextColumn::make('deductions_amount')
                ->sortable()
                ->label('Deductions')
                ->money('PHP', true),
            TextColumn::make('net_amount')
                ->sortable(['gross_amount', 'deductions_amount'])
                ->label('Net')
                ->money('PHP', true),
            TagsColumn::make('restriction_entries')
                ->sortable()
                ->label('Restrictions'),
            BadgeColumn::make('status')
                ->label('Status')
                ->colors([
                    'primary',
                    'success' => Dividend::FOR_RELEASE,
                    'danger' => Dividend::ON_HOLD,
                ])
                ->enum([
                    Dividend::FOR_RELEASE => 'for release',
                    Dividend::ON_HOLD => 'on hold',
                    Dividend::RELEASED => 'released',
                ])
                ->alignCenter(),
        ];
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'user.surname';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'asc';
    }

    protected function getTableActions()
    {
        return [
            EditAction::make('edit')
                ->action(function ($record, $data) {
                    $record->update($data);
                    Notification::make()->title('Dividend updated!')->success()->send();
                })
                ->form([
                    TextInput::make('gross_amount')
                        ->numeric()
                        ->required()
                        ->minValue(0),
                    TextInput::make('deductions_amount')
                        ->numeric()
                        ->required()
                        ->minValue(0)
                        ->lte('gross_amount'),
                    TagsInput::make('restriction_entries')
                        ->label('Restrictions (Press Enter for each entry)')
                        ->placeholder('Enter a restriction')
                ])
                ->modalWidth('md')
                ->button()
                ->outlined(),
            Action::make('for_release')->action(function ($record) {
                $record->update([
                    'status' => Dividend::FOR_RELEASE,
                ]);
                Notification::make()->title('Dividend set for release.')->success()->send();
            })->visible(fn ($record) => $record->status == Dividend::ON_HOLD && $record->status != Dividend::RELEASED)
                ->label('for release')
                ->button()
                ->color('success')
                ->extraAttributes(['class' => 'w-24'])
                ->requiresConfirmation(),
            Action::make('on_hold')->action(function ($record) {
                $record->update([
                    'status' => Dividend::ON_HOLD,
                ]);
                Notification::make()->title('Dividend set on hold.')->success()->send();
            })->visible(fn ($record) => $record->status == Dividend::FOR_RELEASE && $record->status != Dividend::RELEASED)
                ->label('on hold')
                ->button()
                ->color('danger')
                ->extraAttributes(['class' => 'w-24'])
                ->requiresConfirmation(),
        ];
    }

    public function render()
    {
        return view('livewire.office-staff.office-staff-release-details-management', [
            'dividends_net_amount' => ($this->release->dividends()->sum('gross_amount') / 100) - $this->release->dividends()->sum('deductions_amount') / 100,
        ]);
    }
}
