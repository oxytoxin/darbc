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
use Filament\Tables\Concerns\InteractsWithTable;
use PDO;

class ReleaseAdminCashierManagement extends Component implements HasTable
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
            $query->where('role_id', Role::CASHIER);
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
                ->modalHeading('Edit Cashier')
                ->modalWidth('md')
                ->action(function ($record, $data) {
                    $record->update($data);
                    Notification::make()->title('Saved!')->success()->send();
                })
                ->button(),
            DeleteAction::make()->action(function ($record) {
                $record->roles()->detach(Role::CASHIER);
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
        return view('livewire.release-admin.release-admin-cashier-management', [
            'cashiers' => User::whereHas('roles', function ($query) {
                $query->where('role_id', Role::CASHIER);
            })->with('member_information')->paginate(),
        ]);
    }

    public function addCashier()
    {
        $this->form->validate();
        unset($this->data['password_confirmation']);
        $this->data['password'] = Hash::make($this->data['password']);
        DB::beginTransaction();
        $user = User::create($this->data);
        $user->roles()->attach(Role::CASHIER);
        DB::commit();
        $this->reset('data');
        Notification::make()->title('Office Staff created.')->success()->send();
        $this->emitSelf('closeModal');
    }
}
