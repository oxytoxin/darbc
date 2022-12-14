<?php

namespace App\Http\Livewire\ReleaseAdmin;

use App\Models\Release;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TagsInput;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;

class ReleaseAdminReleaseManagement extends Component implements HasTable
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
                ->extraAttributes(['class' => 'font-semibold text-sm'])
                ->label('Date Released')
                ->date(),
            TextColumn::make('name')
                ->extraAttributes(['class' => 'font-semibold text-sm']),
            TextColumn::make('total_amount')
                ->label('Total Amount')
                ->money('PHP', true)
                ->extraAttributes(['class' => 'font-semibold text-sm']),
            TagsColumn::make('particulars')
                ->getStateUsing(fn ($record) => collect($record->particulars)->map(fn ($value, $key) => $key)->toArray()),
            IconColumn::make('disbursed')
                ->alignCenter()
                ->extraAttributes(['class' => 'flex justify-center'])
                ->boolean(),
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
                TextInput::make('total_amount')
                    ->numeric()
                    ->minValue(1)
                    ->label('Total Amount'),
                TextInput::make('control_number_prefix'),
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
        ];
    }

    protected function getFormSchema()
    {
        return [
            TextInput::make('name')
                ->required(),
            TextInput::make('total_amount')
                ->numeric()
                ->minValue(1)
                ->label('Total Amount'),
            TextInput::make('control_number_prefix')
                ->default('PS2023'),
            KeyValue::make('particulars')
                ->default([
                    'DARBC Gift Certificate' => 'worth 1000',
                    'Calendar' => '1 set',
                    'Pineapple Products' => '2 cans'
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
            'control_number_prefix' => $this->data['control_number_prefix'],
            'total_amount' => $this->data['total_amount'],
            'particulars' => $this->data['particulars'],
        ]);
        DB::commit();
        Notification::make()->title('New release created.')->success()->send();
        $this->emitSelf('closeModal');
    }
}
