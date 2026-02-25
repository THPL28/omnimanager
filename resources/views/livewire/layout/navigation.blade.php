<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
};
?>

<aside class="w-[280px] border-r border-gray-200 dark:border-white/5 flex flex-col bg-surface-light dark:bg-[#0e121b] shrink-0 z-20 transition-all duration-300">
    <div class="flex flex-col h-full p-6 justify-between">
        <div class="flex flex-col gap-8">
            {{-- Logo Section --}}
            <div class="flex gap-3 px-2 items-center">
                <div class="size-10 flex-shrink-0 text-primary">
                    <x-application-logo class="w-full h-full" />
                </div>
                <div class="flex flex-col overflow-hidden">
                    <h1 class="text-slate-900 dark:text-white text-base font-bold leading-tight truncate">OmniManager</h1>
                    <p class="text-slate-500 dark:text-gray-500 text-xs font-medium truncate">{{ __('Enterprise Admin') }}</p>
                </div>
            </div>

            {{-- Navigation Groups --}}
            <nav class="flex flex-col gap-6">
                {{-- PAINEL --}}
                <div class="flex flex-col gap-1">
                    <p class="px-3 text-[10px] font-bold text-slate-400 dark:text-gray-600 uppercase tracking-[0.1em] mb-2">{{ __('Painel') }}</p>
                    <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all group {{ request()->routeIs('dashboard') ? 'bg-primary/10 text-primary' : 'text-slate-700 dark:text-[#92a4c9] hover:bg-slate-100 dark:hover:bg-white/5' }}">
                        <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('dashboard') ? 'fill-current' : 'group-hover:text-primary transition-colors' }}">analytics</span>
                        <p class="text-sm font-medium">{{ __('Visão Geral') }}</p>
                    </a>
                </div>

                {{-- OPERACIONAL --}}
                <div class="flex flex-col gap-1">
                    <p class="px-3 text-[10px] font-bold text-slate-400 dark:text-gray-600 uppercase tracking-[0.1em] mb-2">{{ __('Operacional') }}</p>
                    
                    <a href="{{ route('grupos.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all group {{ request()->routeIs('grupos.*') ? 'bg-primary/10 text-primary' : 'text-slate-700 dark:text-[#92a4c9] hover:bg-slate-100 dark:hover:bg-white/5' }}">
                        <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('grupos.*') ? 'fill-current' : 'group-hover:text-primary transition-colors' }}">domain</span>
                        <p class="text-sm font-medium">{{ __('Grupos Econômicos') }}</p>
                    </a>

                    <a href="{{ route('bandeiras.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all group {{ request()->routeIs('bandeiras.*') ? 'bg-primary/10 text-primary' : 'text-slate-700 dark:text-[#92a4c9] hover:bg-slate-100 dark:hover:bg-white/5' }}">
                        <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('bandeiras.*') ? 'fill-current' : 'group-hover:text-primary transition-colors' }}">flag</span>
                        <p class="text-sm font-medium">{{ __('Bandeiras') }}</p>
                    </a>

                    <a href="{{ route('unidades.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all group {{ request()->routeIs('unidades.*') ? 'bg-primary/10 text-primary' : 'text-slate-700 dark:text-[#92a4c9] hover:bg-slate-100 dark:hover:bg-white/5' }}">
                        <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('unidades.*') ? 'fill-current' : 'group-hover:text-primary transition-colors' }}">storefront</span>
                        <p class="text-sm font-medium">{{ __('Unidades') }}</p>
                    </a>

                    <a href="{{ route('colaboradores.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all group {{ request()->routeIs('colaboradores.*') ? 'bg-primary/10 text-primary' : 'text-slate-700 dark:text-[#92a4c9] hover:bg-slate-100 dark:hover:bg-white/5' }}">
                        <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('colaboradores.*') ? 'fill-current' : 'group-hover:text-primary transition-colors' }}">group</span>
                        <p class="text-sm font-medium">{{ __('Colaboradores') }}</p>
                    </a>

                    <a href="{{ route('relatorios.colaboradores') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all group {{ request()->routeIs('relatorios.*') ? 'bg-primary/10 text-primary' : 'text-slate-700 dark:text-[#92a4c9] hover:bg-slate-100 dark:hover:bg-white/5' }}">
                        <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('relatorios.*') ? 'fill-current' : 'group-hover:text-primary transition-colors' }}">bar_chart</span>
                        <p class="text-sm font-medium">{{ __('Relatórios') }}</p>
                    </a>
                </div>

                {{-- GOVERNANÇA --}}
                <div class="flex flex-col gap-1">
                    <p class="px-3 text-[10px] font-bold text-slate-400 dark:text-gray-600 uppercase tracking-[0.1em] mb-2">{{ __('Governança') }}</p>
                    
                    <a href="{{ route('documentos.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all group {{ request()->routeIs('documentos.*') ? 'bg-primary/10 text-primary' : 'text-slate-700 dark:text-[#92a4c9] hover:bg-slate-100 dark:hover:bg-white/5' }}">
                        <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('documentos.*') ? 'fill-current' : 'group-hover:text-primary transition-colors' }}">description</span>
                        <p class="text-sm font-medium">{{ __('Documentos') }}</p>
                    </a>
                    
                    <a href="{{ route('auditoria.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all group {{ request()->routeIs('auditoria.*') ? 'bg-primary/10 text-primary' : 'text-slate-700 dark:text-[#92a4c9] hover:bg-slate-100 dark:hover:bg-white/5' }}">
                        <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('auditoria.*') ? 'fill-current' : 'group-hover:text-primary transition-colors' }}">fact_check</span>
                        <p class="text-sm font-medium">{{ __('Auditoria') }}</p>
                    </a>

                    <a href="{{ route('usuarios.index') }}" wire:navigate class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all group {{ request()->routeIs('usuarios.*') ? 'bg-primary/10 text-primary' : 'text-slate-700 dark:text-[#92a4c9] hover:bg-slate-100 dark:hover:bg-white/5' }}">
                        <span class="material-symbols-outlined text-[20px] {{ request()->routeIs('usuarios.*') ? 'fill-current' : 'group-hover:text-primary transition-colors' }}">manage_accounts</span>
                        <p class="text-sm font-medium">{{ __('Usuários e Perfis') }}</p>
                    </a>
                </div>
            </nav>
        </div>

        {{-- Footer User Section --}}
        <div class="flex flex-col gap-4">
            <div class="h-px bg-gray-200 dark:bg-white/5 w-full"></div>
            
            <div class="flex items-center gap-3 px-1 py-2 rounded-lg group">
                <div class="size-10 rounded-full bg-slate-100 dark:bg-white/10 flex items-center justify-center text-slate-500 dark:text-gray-400 shadow-inner overflow-hidden">
                    <span class="material-symbols-outlined text-[24px]">person</span>
                </div>
                <div class="flex flex-col min-w-0 flex-1">
                    <p class="text-sm font-bold text-slate-900 dark:text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500 dark:text-gray-500 truncate">{{ auth()->user()->email }}</p>
                </div>
                <a href="{{ route('profile') }}" wire:navigate class="p-1.5 text-slate-400 hover:text-primary transition-colors rounded-lg hover:bg-slate-100 dark:hover:bg-white/5">
                    <span class="material-symbols-outlined text-[20px]">settings</span>
                </a>
            </div>

            {{-- Logout Button (Subtle) --}}
            <button wire:click="logout" class="flex items-center gap-2 px-3 py-1.5 text-xs font-semibold text-slate-400 hover:text-red-500 transition-colors w-full">
                <span class="material-symbols-outlined text-[16px]">logout</span>
                {{ __('Sair do sistema') }}
            </button>
        </div>
    </div>
</aside>
