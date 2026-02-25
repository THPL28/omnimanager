<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest', ['title' => 'Recuperar Senha'])] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));
            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div>
    <div class="bg-card-dark border border-border-dark rounded-xl shadow-2xl p-6 md:p-8 w-full animate-in fade-in zoom-in duration-300">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-white text-2xl font-bold tracking-tight mb-2">Recuperar Senha</h1>
            <p class="text-text-muted text-sm">Esqueceu sua senha? Sem problemas.</p>
        </div>

        <p class="text-text-muted text-sm mb-6 leading-relaxed">
            Informe seu endereço de e-mail e enviaremos um link para você redefinir sua senha e criar uma nova.
        </p>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-6 rounded-lg bg-green-500/10 border border-green-500/20 px-4 py-3 flex items-start gap-3 w-full">
                <span class="material-symbols-outlined text-green-400 text-sm mt-0.5">check_circle</span>
                <p class="text-sm text-green-200">{{ session('status') }}</p>
            </div>
        @endif

        <form wire:submit="sendPasswordResetLink" class="flex flex-col gap-5">
            <!-- Email Field -->
            <div class="space-y-2">
                <label for="email" class="block text-xs font-medium text-text-muted uppercase tracking-wider pl-1">E-mail</label>
                <div class="relative group">
                    <input 
                        wire:model="email"
                        type="email" 
                        id="email" 
                        name="email" 
                        class="w-full bg-input-bg text-white border border-input-border rounded-lg h-11 px-4 text-sm placeholder:text-gray-600 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-200"
                        placeholder="nome@empresa.com" 
                        required 
                        autofocus
                    />
                    <span class="material-symbols-outlined absolute right-3 top-2.5 text-gray-600 pointer-events-none text-[20px]">mail</span>
                </div>
                 @error('email')
                    <p class="text-red-500 text-xs mt-1 pl-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="pt-2">
                <button 
                    type="submit" 
                    class="group relative flex w-full justify-center items-center rounded-lg bg-primary h-11 px-4 text-sm font-semibold text-white shadow-glow transition-all hover:bg-primary-hover focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary active:scale-[0.98]"
                    wire:loading.attr="disabled"
                >
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 opacity-0 group-[.loading]:opacity-100" wire:loading.class="opacity-100">
                         <!-- Loading Spinner SVG -->
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                    <span wire:loading.remove>Enviar Link de Redefinição</span>
                    <span wire:loading>Enviando...</span>
                </button>
            </div>
        </form>

        <!-- Back to Login -->
        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" wire:navigate class="inline-flex items-center gap-2 text-sm font-medium text-text-muted hover:text-white transition-colors group">
                <span class="material-symbols-outlined text-[18px] transition-transform group-hover:-translate-x-1">arrow_back</span>
                Voltar ao Login
            </a>
        </div>
    </div>
</div>
