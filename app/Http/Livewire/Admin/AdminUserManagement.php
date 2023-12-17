<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use DB;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Concerns\InteractsWithTable;

class AdminUserManagement extends Component implements HasTable
{

    use InteractsWithTable;

    protected function getTableQuery()
    {
        return User::query()->doesntHave('member_information');
    }

    protected function getTableColumns()
    {
        return [
            TextColumn::make('full_name')
                ->label('Name')
                ->searchable(),
            TagsColumn::make('roles.name'),
            IconColumn::make('active')
                ->label('Status')
                ->boolean(),
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
            Action::make('activate cashiers')
                ->label('Activate Cashiers')
                ->action(function () {
                    User::whereHas('roles', function ($query) {
                        $query->where('name', 'Cashier');
                    })->update(['active' => true]);
                    Notification::make()->title('Cashiers activated.')->success()->send();
                })->outlined()->button()->color('success'),
            Action::make('deactivate cashiers')
                ->label('Deactivate Cashiers')
                ->action(function () {
                    User::whereDoesntHave('roles', function ($query) {
                        $query->where('name', 'Release Admin');
                    })->whereHas('roles', function ($query) {
                        $query->where('name', 'Cashier');
                    })->update(['active' => false]);
                    Notification::make()->title('Cashiers deactivated.')->success()->send();
                })->outlined()->button()->color('danger'),
            Action::make('activate staffs')
                ->label('Activate Staffs')
                ->action(function () {
                    User::whereHas('roles', function ($query) {
                        $query->where('name', 'Office Staff');
                    })->update(['active' => true]);
                    Notification::make()->title('Staffs activated.')->success()->send();
                })->outlined()->button()->color('success'),
            Action::make('deactivate staffs')
                ->label('Deactivate Staffs')
                ->action(function () {
                    User::whereDoesntHave('roles', function ($query) {
                        $query->where('name', 'Release Admin');
                    })->whereHas('roles', function ($query) {
                        $query->where('name', 'Office Staff');
                    })->update(['active' => false]);
                    Notification::make()->title('Staffs deactivated.')->success()->send();
                })->outlined()->button()->color('danger'),
            CreateAction::make()
                ->form($this->getFormFields()),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            EditAction::make()
                ->button()
                ->outlined()
                ->action(function ($record, $data) {
                    if (filled($data['password'])) {
                        $data['password'] = Hash::make($data['password']);
                    } else {
                        unset($data['password']);
                    }
                    $record->update($data);
                    Notification::make()->title('User updated.')->success()->send();
                })
                ->form(fn ($record) => $this->getFormFields($record)),
            DeleteAction::make()
                ->action(function ($record) {
                    DB::beginTransaction();
                    try {
                        $record->roles()->detach();
                        $record->delete();
                    } catch (\Throwable $th) {
                        notify('Delete Failed.', 'User has linked records.', 'danger');
                        DB::rollBack();
                        return;
                    }
                    Notification::make()->title('User deleted.')->success()->send();
                }),
            Action::make('Active')
                ->label(fn ($record) => $record->active ? 'Deactivate' : 'Activate')
                ->icon(fn ($record) => $record->active ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                ->color(fn ($record) => $record->active ? 'danger' : 'success')
                ->action(function ($record) {
                    $record->update(['active' => !$record->active]);
                    $record->active ? Notification::make()->title('User activated.')->success()->send() : Notification::make()->title('User deactivated.')->success()->send();
                }),
        ];
    }

    protected function getFormFields($record = null)
    {
        return [
            Fieldset::make('User Information')
                ->schema([
                    TextInput::make('first_name')
                        ->label('First Name')
                        ->required(),
                    TextInput::make('surname')
                        ->label('Last Name')
                        ->required(),
                    TextInput::make('middle_name')
                        ->label('Middle Name'),
                    TextInput::make('suffix')
                        ->label('Suffix'),
                    TextInput::make('username')
                        ->label('Username')
                        ->unique('users', 'username', $record)
                        ->required(),
                    TextInput::make('ip_address')
                        ->label('IP Address'),
                    TextInput::make('password')
                        ->label('Password')
                        ->password(),
                    Select::make('roles')
                        ->relationship('roles', 'name')
                        ->multiple()
                        ->preload()
                        ->required()
                ]),
        ];
    }

    public function render()
    {
        return view('livewire.release-admin.release-admin-user-management');
    }
}
