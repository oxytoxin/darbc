<?php

namespace App\Http\Livewire\Auth;

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
        if (!Auth::attempt(['username' => $this->username, 'password' => $this->password, 'active' => true])) {
            Notification::make()->title('Invalid credentials.')->body('Account may be inactive. Please contact your administrator.')->danger()->send();
            return;
        }

        return redirect()->intended('/');
    }

    public function render()
    {
        return view('livewire.auth.login')->extends('layouts.auth');
    }
}
