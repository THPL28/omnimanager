<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="flex flex-col gap-6">
    <div class="flex flex-col gap-1">
        <h3 class="text-base font-medium text-red-600 dark:text-red-400">Configurações da Conta</h3>
        <p class="text-[13px] text-text-secondary dark:text-text-secondary-dark">{{ __('Ações irreversíveis relacionadas à existência da sua conta.') }}</p>
    </div>

    <div class="border border-red-100 dark:border-red-900/20 bg-red-50/50 dark:bg-red-900/5 rounded-lg p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex flex-col gap-1">
            <span class="text-[13px] font-semibold text-text-primary dark:text-white">{{ __('Excluir Conta') }}</span>
            <p class="text-[13px] text-text-secondary dark:text-text-secondary-dark max-w-md">
                {{ __('Sua conta será desativada permanentemente. Todos os dados associados serão removidos.') }}
            </p>
        </div>
        
        <button 
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="shrink-0 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/20 border border-red-100 dark:border-red-900/30 font-medium px-4 py-2 rounded-md text-[13px] transition-colors"
        >
            {{ __('Excluir minha conta') }}
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-6 bg-base-100 text-base-content">

            <h2 class="text-lg font-medium text-base-content">
                {{ __('Tem certeza que deseja excluir sua conta?') }}
            </h2>

            <p class="mt-1 text-sm text-base-content/70">
                {{ __('Uma vez excluída, todos os recursos e dados serão permanentemente removidos. Por favor, digite sua senha para confirmar a exclusão permanente da sua conta.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Senha') }}" class="sr-only" />

                <x-text-input
                    wire:model="password"
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Senha') }}"
                />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Excluir Conta') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
