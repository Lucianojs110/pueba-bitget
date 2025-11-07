<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component {
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


<div class="w-full max-w-md  p-8 rounded-lg ">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-6">
        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Correo electrónico')" />
            <div class="mt-1">
                <input wire:model="form.email" id="email" type="email" name="email" required autofocus
                    class="w-full h-12 px-4 border border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500 shadow-sm" />
            </div>
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Contraseña')" />
            <div class="mt-1 relative">
                <input wire:model="form.password" id="password" type="password" name="password" required
                    class="w-full h-12 px-4 border border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500 shadow-sm pr-10" />

                <!-- Ícono ojo -->
                <button type="button"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700"
                    onclick="let pass=document.getElementById('password'); pass.type = pass.type === 'password' ? 'text' : 'password'">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember -->
        <div class="flex items-center">
            <input wire:model="form.remember" id="remember" type="checkbox"
                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
            <label for="remember" class="ml-2 text-sm text-gray-600">Mantener sesión activa</label>
        </div>

        <!-- Botones -->
        <div class="flex flex-col gap-3">
            <x-primary-button class="w-full h-12 justify-center bg-indigo-600 hover:bg-indigo-700">
                {{ __('Iniciar sesión') }}
            </x-primary-button>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" wire:navigate
                    class="text-sm text-center text-gray-600 hover:text-indigo-600">
                    ¿Olvidó su contraseña?
                </a>
            @endif

            @if (Route::has('register'))
                <a href="{{ route('register') }}" wire:navigate
                    class="text-sm text-center font-semibold text-indigo-600 hover:text-indigo-800">
                    ¿No tenés cuenta? Registrate
                </a>
            @endif
        </div>
    </form>
</div>
