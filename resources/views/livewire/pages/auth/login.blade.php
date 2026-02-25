<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest', ['title' => 'Login'])] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        // Validar o formulário
        $this->form->validate();

        try {
            // Tentar autenticar
            $this->form->authenticate();

            // Regenerar sessão após login bem-sucedido
            Session::regenerate();

            // Redirecionar para o dashboard
            $this->redirect(route('dashboard', absolute: false), navigate: true);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Re-lançar exceção de validação para exibir erros
            throw $e;
        } catch (\Exception $e) {
            // Capturar qualquer outro erro e exibir mensagem genérica
            throw \Illuminate\Validation\ValidationException::withMessages([
                'form.email' => 'Erro ao fazer login. Tente novamente.',
            ]);
        }
    }
}; ?>

<!-- Main Card -->
<div class="bg-white dark:bg-card-dark rounded-2xl shadow-2xl ring-1 ring-black/5 dark:ring-border-dark/50 overflow-hidden relative">
    <!-- Loading Overlay (Hidden by default, structure for Livewire) -->
    <div wire:loading wire:target="login" class="absolute inset-0 bg-white/80 dark:bg-card-dark/80 backdrop-blur-sm z-50 flex items-center justify-center">
        <span class="material-symbols-outlined animate-spin text-primary text-4xl">progress_activity</span>
    </div>

    <div class="p-8">
        <!-- Session Status / Alert -->
        <!-- Example of visible status -->
        @if (session('status'))
            <div class="mb-6 rounded-lg bg-emerald-500/10 border border-emerald-500/20 px-4 py-3 flex items-start gap-3">
                <span class="material-symbols-outlined text-emerald-400 text-sm mt-0.5">check_circle</span>
                <p class="text-sm text-emerald-200">{{ session('status') }}</p>
            </div>
        @endif

        <form wire:submit="login" method="POST" class="space-y-6">
            @csrf
            <!-- Email Field -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300" for="email">{{ __('Email') }}</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-text-muted text-xl">mail</span>
                    </div>
                    <input 
                        wire:model="form.email"
                        autocomplete="username" 
                        autofocus="" 
                        class="block w-full rounded-lg border-gray-300 dark:border-border-dark bg-gray-50 dark:bg-input-dark py-3 pl-10 pr-3 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-text-muted/50 focus:border-primary focus:ring-1 focus:ring-primary sm:text-sm transition-colors duration-200" 
                        id="email" 
                        name="email" 
                        placeholder="nome@empresa.com" 
                        required="" 
                        type="email" 
                    />
                </div>
                @error('form.email')
                    <p class="text-sm text-red-400 mt-1 flex items-center gap-1"><span class="material-symbols-outlined text-sm">error</span> {{ $message }}</p>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300" for="password">{{ __('Senha') }}</label>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-text-muted text-xl">lock</span>
                    </div>
                    <input 
                        wire:model="form.password"
                        autocomplete="current-password" 
                        class="block w-full rounded-lg border-gray-300 dark:border-border-dark bg-gray-50 dark:bg-input-dark py-3 pl-10 pr-3 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-text-muted/50 focus:border-primary focus:ring-1 focus:ring-primary sm:text-sm transition-colors duration-200" 
                        id="password" 
                        name="password" 
                        placeholder="••••••••" 
                        required="" 
                        type="password"
                    />
                </div>
                @error('form.password')
                    <p class="text-sm text-red-400 mt-1 flex items-center gap-1"><span class="material-symbols-outlined text-sm">error</span> {{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <div class="flex items-center" style="--checkbox-tick-svg: url('data:image/svg+xml,%3csvg viewBox=%270 0 16 16%27 fill=%27rgb(255,255,255)%27 xmlns=%27http://www.w3.org/2000/svg%27%3e%3cpath d=%27M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z%27/%3e%3c/svg%3e');">
                    <input 
                        wire:model="form.remember"
                        class="h-4 w-4 rounded border-gray-300 dark:border-border-dark bg-gray-50 dark:bg-input-dark text-primary focus:ring-offset-white dark:focus:ring-offset-card-dark focus:ring-primary checked:bg-[image:--checkbox-tick-svg] cursor-pointer" 
                        id="remember-me" 
                        name="remember-me" 
                        type="checkbox"
                    />
                    <label class="ml-2 block text-sm text-slate-600 dark:text-slate-300 select-none cursor-pointer" for="remember-me">{{ __('Lembrar-me') }}</label>
                </div>
                <div class="text-sm">
                    @if (Route::has('password.request'))
                        <a class="font-medium text-primary hover:text-violet-400 transition-colors" href="{{ route('password.request') }}" wire:navigate>{{ __('Esqueceu sua senha?') }}</a>
                    @endif
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button class="group relative flex w-full justify-center rounded-lg bg-primary px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-primary/25 hover:bg-primary-hover hover:shadow-primary/40 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary transition-all duration-200 disabled:opacity-70 disabled:cursor-not-allowed" type="submit" wire:loading.attr="disabled" wire:target="login">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <span class="material-symbols-outlined h-5 w-5 text-indigo-300 group-hover:text-indigo-200 transition-colors">login</span>
                    </span>
                    <span wire:loading.remove wire:target="login">{{ __('Entrar') }}</span>
                    <span wire:loading wire:target="login">{{ __('Entrando...') }}</span>
                </button>
            </div>
        </form>
    </div>
    
    <!-- Footer Area inside card -->
    <div class="bg-gray-50/50 dark:bg-black/20 px-8 py-4 border-t border-gray-100 dark:border-border-dark/50 text-center">
        @if (Route::has('register'))
            <p class="text-sm text-text-muted">
                {{ __('Não tem uma conta?') }} 
                <a class="font-medium text-slate-900 dark:text-white hover:text-primary transition-colors ml-1 underline decoration-transparent hover:decoration-primary underline-offset-4" href="{{ route('register') }}" wire:navigate>{{ __('Criar uma nova conta') }}</a>
            </p>
        @endif
    </div>
</div>
