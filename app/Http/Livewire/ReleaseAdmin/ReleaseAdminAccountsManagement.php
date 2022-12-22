<?php

namespace App\Http\Livewire\ReleaseAdmin;

use App\Models\Role;
use App\Models\User;
use Closure;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Contracts\Support\Htmlable;

class ReleaseAdminAccountsManagement extends Component implements HasTable
{
    use InteractsWithTable;

    public $office_data;

    protected function getUserRole()
    {
        return Role::RELEASE_ADMIN;
    }

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
            $query->where('role_id', $this->getUserRole());
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
                TextInput::make('password')
                    ->label('Password')
                    ->password(),
            ])
                ->modalHeading('Edit Office Staff')
                ->modalWidth('md')
                ->action(function ($record, $data) {
                    if ($data["password"]) {
                        $data["password"] = Hash::make($data["password"]);
                    } else {
                        unset($data["password"]);
                    }
                    $record->update($data);
                    Notification::make()->title('Saved!')->success()->send();
                })
                ->button(),
            DeleteAction::make()->action(function ($record) {
                $record->roles()->detach($this->getUserRole());
                Notification::make()->title('Deleted!')->success()->send();
            })->requiresConfirmation(),
        ];
    }

    public function addAccount()
    {
        $this->office_data = $this->mountedTableActionData["office_data"];
        $this->form->validate();
        if ($this->office_data['user'] == 0) {
            $user = User::find($this->office_data['user_id']);
            if (!$user) {
                Notification::make()->title('User not found.')->warning()->send();
                return;
            } else {
                $user->roles()->attach($this->getUserRole());
                Notification::make()->title($this->getUserRoleName() . ' created.')->success()->send();
            }
        } else {
            unset($this->office_data['password_confirmation']);
            unset($this->office_data['user']);
            unset($this->office_data['user_id']);
            $this->office_data['password'] = Hash::make($this->office_data['password']);
            DB::beginTransaction();
            $user = User::create($this->office_data);
            $user->roles()->attach($this->getUserRole());
            DB::commit();
            Notification::make()->title($this->getUserRoleName() . ' created.')->success()->send();
        }
    }

    protected function getTableHeading(): string|Htmlable|Closure|null
    {
        return $this->getUserRoleName();
    }

    protected function getUserRoleName()
    {
        return 'Release Admin';
    }

    protected function getTableHeaderActions(): array
    {
        return [
            CreateAction::make('create')
                ->form([
                    Radio::make('office_data.user')
                        ->label('User')
                        ->options([
                            1 => 'New',
                            0 => 'Existing',
                        ])
                        ->default(1)
                        ->reactive()
                        ->required(),
                    Select::make('office_data.user_id')
                        ->label('User')
                        ->options(fn () => User::doesntHave('member_information')->pluck('full_name', 'id'))
                        ->required()
                        ->searchable()
                        ->visible(fn ($get) => !$get('office_data.user')),
                    Grid::make(2)->schema([
                        TextInput::make('office_data.first_name')
                            ->label('First Name')
                            ->required(),
                        TextInput::make('office_data.middle_name')
                            ->label('Middle Name (Optional)'),
                        TextInput::make('office_data.surname')
                            ->label('Surname')
                            ->required(),
                        TextInput::make('office_data.suffix')
                            ->label('Suffix (Optional)'),
                        TextInput::make('office_data.username')
                            ->label('Username')
                            ->unique('users', 'username')
                            ->columnSpanFull()
                            ->required(),
                        TextInput::make('office_data.password')
                            ->label('Password')
                            ->password()
                            ->required(),
                        TextInput::make('office_data.password_confirmation')
                            ->label('Confirm Password')
                            ->password()
                            ->required()
                            ->validationAttribute('password confirmation')
                            ->same('office_data.password'),
                    ])->visible(fn ($get) => $get('office_data.user')),

                ])
                ->modalHeading('Create ' . $this->getUserRoleName())
                ->label('Add ' . $this->getUserRoleName())
                ->action('addAccount')
                ->disableCreateAnother(),
        ];
    }

    public function mount()
    {
        $this->form->fill();
    }


    public function render()
    {
        return view('livewire.release-admin.release-admin-accounts-management');
    }
}
