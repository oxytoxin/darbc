<?php

namespace App\Http\Livewire\ReleaseAdmin;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class ReleaseAdminOfficeStaffManagement extends Component implements HasTable
{
    use InteractsWithTable;

    public $office_data;

    protected function getFormStatePath(): string
    {
        return 'office_data';
    }

    protected function getTableColumns()
    {
        return [
            TextColumn::make('full_name')
                ->extraAttributes(['class' => 'font-semibold text-sm'])
                ->label('Name'),
            TextColumn::make('created_at')
                ->extraAttributes(['class' => 'font-semibold text-sm'])
                ->label('Date Added')
                ->since(),
        ];
    }

    protected function getTableQuery()
    {
        return User::whereHas('roles', function ($query) {
            $query->where('role_id', Role::OFFICE_STAFF);
        })->with('member_information');
    }

    protected function getTableActions()
    {
        return [
            EditAction::make()->form(fn ($record) => [
                TextInput::make('first_name')
                    ->label('First Name')
                    ->required(),
                TextInput::make('middle_name')
                    ->label('Middle Name (Optional)'),
                TextInput::make('surname')
                    ->label('Surname')
                    ->required(),
                TextInput::make('username')
                    ->label('Username')
                    ->unique('users', 'username', $record)
                    ->required(),
            ])
                ->modalHeading('Edit Office Staff')
                ->modalWidth('md')
                ->action(function ($record, $data) {
                    $record->update($data);
                    Notification::make()->title('Saved!')->success()->send();
                })
                ->button(),
            DeleteAction::make()->action(function ($record) {
                $record->roles()->detach(Role::OFFICE_STAFF);
                Notification::make()->title('Deleted!')->success()->send();
            })->requiresConfirmation(),
        ];
    }

    protected function getFormSchema()
    {
        return [
            TextInput::make('first_name')
                ->label('First Name')
                ->required(),
            TextInput::make('middle_name')
                ->label('Middle Name (Optional)'),
            TextInput::make('surname')
                ->label('Surname')
                ->required(),
            TextInput::make('username')
                ->label('Username')
                ->unique('users', 'username')
                ->required(),
            TextInput::make('password')
                ->label('Password')
                ->password()
                ->required(),
            TextInput::make('password_confirmation')
                ->label('Confirm Password')
                ->password()
                ->required()
                ->validationAttribute('password confirmation')
                ->same('password'),
        ];
    }

    public function render()
    {
        return view('livewire.release-admin.release-admin-office-staff-management');
    }

    public function addOfficeStaff()
    {
        $this->form->validate();
        unset($this->office_data['password_confirmation']);
        $this->office_data['password'] = Hash::make($this->office_data['password']);
        DB::beginTransaction();
        $user = User::create($this->office_data);
        $user->roles()->attach(Role::OFFICE_STAFF);
        DB::commit();
        Notification::make()->title('Office staff created.')->success()->send();
        $this->reset('office_data');
        $this->emitSelf('closeModal');
    }
}
