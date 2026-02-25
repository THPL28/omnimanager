<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section class="flex flex-col gap-6">
    <div class="flex flex-col gap-1">
        <h3 class="text-base font-medium text-text-primary dark:text-white">Segurança</h3>
        <p class="text-[13px] text-text-secondary dark:text-text-secondary-dark">{{ __('Atualize sua senha para manter sua conta segura.') }}</p>
    </div>

    <form wire:submit="updatePassword" class="rounded-lg border border-border-light dark:border-border-dark p-6 flex flex-col gap-5 bg-slate-50/50 dark:bg-surface-dark/30">
        <div>
            <label for="update_password_current_password" class="block text-[13px] font-medium text-text-primary dark:text-slate-300 mb-1.5">{{ __('Senha Atual') }}</label>
            <input wire:model="current_password" id="update_password_current_password" name="current_password" type="password" class="w-full max-w-md rounded-md border-border-light dark:border-border-dark bg-white dark:bg-surface-dark text-text-primary dark:text-white focus:border-primary focus:ring-1 focus:ring-primary transition-all text-[14px] px-3 py-2" autocomplete="current-password" />
            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="update_password_password" class="block text-[13px] font-medium text-text-primary dark:text-slate-300 mb-1.5">{{ __('Nova Senha') }}</label>
                <input wire:model="password" id="update_password_password" name="password" type="password" class="w-full rounded-md border-border-light dark:border-border-dark bg-white dark:bg-surface-dark text-text-primary dark:text-white focus:border-primary focus:ring-1 focus:ring-primary transition-all text-[14px] px-3 py-2" autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <label for="update_password_password_confirmation" class="block text-[13px] font-medium text-text-primary dark:text-slate-300 mb-1.5">{{ __('Confirmar Nova Senha') }}</label>
                <input wire:model="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full rounded-md border-border-light dark:border-border-dark bg-white dark:bg-surface-dark text-text-primary dark:text-white focus:border-primary focus:ring-1 focus:ring-primary transition-all text-[14px] px-3 py-2" autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="pt-2 flex items-center gap-4">
            <button type="submit" class="text-text-primary dark:text-white border border-border-light dark:border-border-dark bg-white dark:bg-surface-dark hover:bg-slate-50 dark:hover:bg-white/5 font-medium px-4 py-2 rounded-md text-[13px] transition-colors shadow-sm">
                {{ __('Atualizar Senha') }}
            </button>

            <x-action-message class="me-3" on="password-updated">
                {{ __('Salvo.') }}
            </x-action-message>
        </div>
    </form>
</section>
