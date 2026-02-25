<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest', ['title' => 'Criar Conta'])] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>


    <!-- Auth Card -->
    <div class="bg-card-dark border border-border-dark rounded-xl shadow-2xl p-6 md:p-8 w-full animate-in fade-in zoom-in duration-300">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-white text-2xl font-bold tracking-tight mb-2">Crie sua conta</h1>
            <p class="text-text-muted text-sm">Junte-se ao sistema de gestão corporativa</p>
        </div>

        <!-- Form -->
        <form wire:submit="register" class="flex flex-col gap-5">
            @csrf
            <!-- Name Field -->
            <div class="space-y-2">
                <label for="name" class="block text-xs font-medium text-text-muted uppercase tracking-wider pl-1">Nome</label>
                <div class="relative group">
                    <input 
                        wire:model="name"
                        type="text" 
                        id="name" 
                        name="name" 
                        class="w-full bg-input-bg text-white border border-input-border rounded-lg h-11 px-4 text-sm placeholder:text-gray-600 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-200"
                        placeholder="Ex: João Silva" 
                        required 
                        autofocus
                        autocomplete="name"
                    />
                </div>
                 @error('name')
                    <p class="text-red-500 text-xs mt-1 pl-1">{{ $message }}</p>
                @enderror
            </div>

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
                        autocomplete="username"
                    />
                    <span class="material-symbols-outlined absolute right-3 top-2.5 text-gray-600 pointer-events-none text-[20px]">mail</span>
                </div>
                 @error('email')
                    <p class="text-red-500 text-xs mt-1 pl-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="space-y-2" x-data="{ 
                show: false, 
                password: '',
                get strength() {
                    let s = 0;
                    if (this.password.length > 5) s++;
                    if (this.password.length > 9) s++;
                    if (/[A-Z]/.test(this.password)) s++;
                    if (/[0-9]/.test(this.password)) s++;
                    return s;
                }
            }">
                <label for="password" class="block text-xs font-medium text-text-muted uppercase tracking-wider pl-1">Senha</label>
                <div class="relative group">
                    <input 
                        wire:model="password"
                        x-model="password"
                        :type="show ? 'text' : 'password'"
                        id="password" 
                        name="password" 
                        class="w-full bg-input-bg text-white border border-input-border rounded-lg h-11 pl-4 pr-10 text-sm placeholder:text-gray-600 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-200"
                        placeholder="••••••••" 
                        required
                        autocomplete="new-password"
                    />
                    <button type="button" @click="show = !show" class="absolute right-3 top-2.5 text-text-muted hover:text-white transition-colors cursor-pointer flex items-center justify-center focus:outline-none">
                        <span class="material-symbols-outlined text-[20px]" x-text="show ? 'visibility_off' : 'visibility'">visibility</span>
                    </button>
                </div>
                <!-- Password Strength Meter -->
                <div class="flex gap-1.5 mt-2 px-1 transition-all duration-300">
                    <div class="h-1 flex-1 rounded-full transition-all duration-500" :class="strength >= 1 ? 'bg-primary' : 'bg-input-border'"></div> <!-- Weak -->
                    <div class="h-1 flex-1 rounded-full transition-all duration-500" :class="strength >= 2 ? 'bg-primary' : 'bg-input-border'"></div> <!-- Fair -->
                    <div class="h-1 flex-1 rounded-full transition-all duration-500" :class="strength >= 3 ? 'bg-primary' : 'bg-input-border'"></div> <!-- Good -->
                    <div class="h-1 flex-1 rounded-full transition-all duration-500" :class="strength >= 4 ? 'bg-primary' : 'bg-input-border'"></div> <!-- Strong -->
                </div>
                <p class="text-[11px] text-text-muted pl-1 transition-all" x-show="password.length > 0">
                    <span x-show="strength <= 1" class="text-primary/70">Fraca</span>
                    <span x-show="strength == 2" class="text-primary/80">Média</span>
                    <span x-show="strength == 3" class="text-primary/90">Boa</span>
                    <span x-show="strength >= 4" class="text-primary">Forte</span>
                </p>
                @error('password')
                    <p class="text-red-500 text-xs mt-1 pl-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password Field -->
            <div class="space-y-2">
                <label for="password_confirmation" class="block text-xs font-medium text-text-muted uppercase tracking-wider pl-1">Confirmar Senha</label>
                <div class="relative group">
                    <input 
                        wire:model="password_confirmation"
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        class="w-full bg-input-bg text-white border border-input-border rounded-lg h-11 pl-4 pr-10 text-sm placeholder:text-gray-600 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all duration-200"
                        placeholder="••••••••" 
                        required
                        autocomplete="new-password"
                    />
                </div>
                 @error('password_confirmation')
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
                    <span wire:loading.remove>Registrar</span>
                    <span wire:loading>Registrando...</span>
                </button>
            </div>
        </form>

        <!-- Footer Link -->
        <div class="mt-6 text-center">
            <p class="text-sm text-text-muted">
                Já tem uma conta? 
                <a href="{{ route('login') }}" wire:navigate class="font-medium text-white hover:text-primary transition-colors underline decoration-border-dark underline-offset-4 hover:decoration-primary">
                    Entrar
                </a>
            </p>
        </div>
    </div>

</div>
