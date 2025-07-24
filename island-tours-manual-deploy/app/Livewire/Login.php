<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $email = '';
    public $password = '';

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            session()->regenerate();
            // Always redirect to intended URL (where user was headed before login)
            return redirect()->intended('/');
        } else {
            $this->addError('email', 'Invalid credentials.');
        }
    }

    public function render()
    {
        // Changed from admin layout to guest layout
        return view('livewire.login')->layout('layouts.guest');
    }
}
