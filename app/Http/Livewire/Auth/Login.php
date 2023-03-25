<?php

namespace App\Http\Livewire\Auth;

use App\Models\Role;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Login extends Component
{
    /** @var string */
    public $username = '';

    /** @var string */
    public $password = '';

    protected $rules = [
        'username' => ['required'],
        'password' => ['required'],
    ];

    public function authenticate()
    {
        $this->validate();
        if (!Auth::attempt(['username' => $this->username, 'password' => $this->password])) {
            Notification::make()->title('Invalid credentials.')->body('Please check your password/username.')->danger()->send();
            return;
        }
        if (!auth()->user()->active && !auth()->user()->roles()->whereRoleId(Role::RELEASE_ADMIN)->exists()) {
            Notification::make()->title('Account is not active.')->body('Please contact your administrator.')->danger()->send();
            Auth::logout();
            return;
        }
        return redirect()->intended('/');
    }

    public function render()
    {
        return view('livewire.auth.login')->extends('layouts.auth');
    }
}
