<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-br from-blue-200 via-white to-green-200 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="w-full max-w-md p-8 bg-white dark:bg-gray-800 rounded-xl shadow-2xl border border-blue-100 dark:border-gray-700">
        <div class="flex flex-col items-center mb-6">
            <img src="/favicon.ico" alt="Island Tours Logo" class="w-16 h-16 mb-2">
            <h1 class="text-2xl font-bold text-blue-700 dark:text-blue-300 mb-1">Island Tours</h1>
            <span class="text-gray-500 dark:text-gray-300">Sign in to your account</span>
        </div>
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <form wire:submit="login" class="space-y-5">
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                <input wire:model="form.email" id="email" type="email" name="email" required autofocus autocomplete="username"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white" />
                <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Password</label>
                <input wire:model="form.password" id="password" type="password" name="password" required autocomplete="current-password"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white" />
                <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
            </div>
            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input wire:model="form.remember" type="checkbox" name="remember" class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:ring-blue-500 dark:bg-gray-700">
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-300">Remember me</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline dark:text-blue-400" wire:navigate>Forgot password?</a>
                @endif
            </div>
            <button type="submit" class="w-full py-2 px-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50 transition">Log in</button>
        </form>
        <div class="mt-6 text-center text-sm text-gray-500 dark:text-gray-400">
            &copy; {{ date('Y') }} TIEZA Island Tours. All rights reserved.
        </div>
    </div>
</div>
