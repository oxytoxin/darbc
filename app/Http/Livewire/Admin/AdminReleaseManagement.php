<?php

namespace App\Http\Livewire\Admin;

use App\Models\Release;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\KeyValue;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Concerns\InteractsWithTable;

class AdminReleaseManagement extends Component implements HasTable
{
    use InteractsWithTable;

    public $data;

    protected function getFormStatePath(): string
    {
        return 'data';
    }

    protected function getTableColumns()
    {
        return [
            TextColumn::make('created_at')
                ->label('Date Released')
                ->date('F d, Y'),
            TextColumn::make('name'),
            TextColumn::make('total_amount')
                ->label('Total Amount')
                ->money('PHP', true),
            TagsColumn::make('particulars')
                ->getStateUsing(fn ($record) => collect($record->particulars)->map(fn ($value, $key) => $key)->toArray()),
            IconColumn::make('disbursed')
                ->alignCenter()
                ->extraAttributes(['class' => 'flex justify-center'])
                ->boolean(),
            ToggleColumn::make('voting_restriction')
                ->label('Verify Voting Status')
        ];
    }

    protected function getTableQuery()
    {
        return Release::latest();
    }

    protected function getTableActions()
    {
        return [
            EditAction::make()->form(fn ($record) => [
                TextInput::make('name')
                    ->required(),
                TextInput::make('share_description')
                    ->hint('share description to be displayed in payslip.')
                    ->placeholder('Profit Share')
                    ->required(),
                TextInput::make('total_amount')
                    ->numeric()
                    ->minValue(1)
                    ->label('Total Amount'),
                TextInput::make('gift_certificate_prefix'),
                TextInput::make('gift_certificate_amount')->numeric()->minValue(0),
                KeyValue::make('particulars'),
            ])
                ->modalHeading('Edit Release')
                ->modalWidth('md')
                ->action(function ($record, $data) {
                    $record->update($data);
                    Notification::make()->title('Saved!')->success()->send();
                })
                ->visible(fn ($record) => $record->disbursed == false)
                ->button(),
            DeleteAction::make()->action(function ($record) {
                $record->dividends()->delete();
                $record->delete();
                Notification::make()->title('Deleted!')->success()->send();
            })->visible(fn ($record) => $record->disbursed == false)->button(),
            ViewAction::make('view')
                ->button()
                ->color('success')
                ->visible(fn ($record) => $record->disbursed)
                ->url(fn ($record) => route('release-admin.releases.dividends', ['release' => $record])),
        ];
    }

    protected function getFormSchema()
    {
        return [
            TextInput::make('name')
                ->required(),
            TextInput::make('share_description')
                ->hint('share description to be displayed in payslip.')
                ->placeholder('Profit Share')
                ->required(),
            TextInput::make('total_amount')
                ->numeric()
                ->minValue(1)
                ->label('Total Amount'),
            TextInput::make('gift_certificate_prefix')
                ->label('Gift Certificate Control Number Prefix')
                ->nullable(),
            TextInput::make('gift_certificate_amount')
                ->label('Gift Certificate Amount')
                ->default(0)
                ->numeric()->minValue(0),
            KeyValue::make('particulars')
                ->default([
                    'Giveaways' => '1 set',
                ]),
        ];
    }

    public function mount()
    {
        $this->form->fill();
    }

    public function render()
    {
        return view('livewire.release-admin.release-admin-release-management');
    }

    public function createRelease()
    {
        $this->form->validate();
        DB::beginTransaction();
        Release::create([
            'name' => $this->data['name'],
            'gift_certificate_prefix' => $this->data['gift_certificate_prefix'],
            'gift_certificate_amount' => $this->data['gift_certificate_amount'],
            'total_amount' => $this->data['total_amount'],
            'particulars' => $this->data['particulars'],
        ]);
        DB::commit();
        Notification::make()->title('New release created.')->success()->send();
        $this->emitSelf('closeModal');
    }
}
