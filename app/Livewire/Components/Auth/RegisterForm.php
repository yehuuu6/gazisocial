<?php

namespace App\Livewire\Components\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Models\Activity;

class RegisterForm extends Component
{
    public $name;
    public $username;
    public $email;
    public $password;
    public $password_confirmation;

    public function register()
    {

        $attributes = $this->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $attributes['avatar'] = 'https://ui-avatars.com/api/?name=' . $attributes['name'] . '&color=7F9CF5&background=random';

        $user = User::create($attributes);

        Auth::login($user);

        event(new Registered($user));

        Activity::create([
            'user_id' => $user->id,
            'content' => "Gazi Social'a katıldı!",
        ]);

        return redirect(route(('verification.notice')));
    }

    public function render()
    {
        return view('livewire.components.auth.register-form');
    }
}
