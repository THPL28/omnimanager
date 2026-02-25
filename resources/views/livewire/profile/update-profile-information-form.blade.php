<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $phone = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone ?? '';
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section class="flex flex-col gap-6">
    <div class="flex flex-col gap-1">
        <h3 class="text-base font-medium text-text-primary dark:text-white">Informações Pessoais</h3>
        <p class="text-[13px] text-text-secondary dark:text-text-secondary-dark">Gerencie suas informações básicas de identificação.</p>
    </div>

    <form wire:submit="updateProfileInformation" class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
        <div class="col-span-1 md:col-span-2">
            <label for="name" class="block text-[13px] font-medium text-text-primary dark:text-slate-300 mb-1.5">Nome Completo</label>
            <input wire:model="name" id="name" name="name" type="text" class="w-full rounded-md border-border-light dark:border-border-dark bg-white dark:bg-surface-dark text-text-primary dark:text-white focus:border-primary focus:ring-1 focus:ring-primary transition-all text-[14px] px-3 py-2 placeholder:text-slate-400" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="col-span-1">
            <label for="email" class="block text-[13px] font-medium text-text-primary dark:text-slate-300 mb-1.5">Email Corporativo</label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-[18px]">mail</span>
                <input wire:model="email" id="email" name="email" type="email" class="w-full rounded-md border-border-light dark:border-border-dark bg-white dark:bg-surface-dark text-text-primary dark:text-white focus:border-primary focus:ring-1 focus:ring-primary transition-all text-[14px] pl-9 pr-3 py-2" required autocomplete="username" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-text-primary dark:text-white">
                        {{ __('O seu endereço de e-mail não foi verificado.') }}

                        <button wire:click.prevent="sendVerification" class="underline text-sm text-text-secondary dark:text-text-secondary-dark hover:text-text-primary dark:hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Clique aqui para reenviar o e-mail de verificação.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('Um novo link de verificação foi enviado para o seu endereço de e-mail.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="col-span-1">
            <label for="phone" class="block text-[13px] font-medium text-text-primary dark:text-slate-300 mb-1.5">Telefone</label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-[18px]">call</span>
                <input wire:model="phone" id="phone" name="phone" type="tel" class="w-full rounded-md border-border-light dark:border-border-dark bg-white dark:bg-surface-dark text-text-primary dark:text-white focus:border-primary focus:ring-1 focus:ring-primary transition-all text-[14px] pl-9 pr-3 py-2" placeholder="+55 11 99999-8888" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div class="col-span-1 md:col-span-2 flex justify-start border-t border-border-light dark:border-border-dark pt-5">
            <button type="submit" class="bg-primary hover:bg-primary-hover text-white font-medium px-4 py-2 rounded-md text-[13px] shadow-sm transition-all">
                Salvar Alterações
            </button>
            <x-action-message class="me-3 ms-3 self-center" on="profile-updated">
                {{ __('Salvo.') }}
            </x-action-message>
        </div>
    </form>
</section>
