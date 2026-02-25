<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ 
          theme: localStorage.getItem('theme') || 'dark',
          init() {
              if (this.theme === 'dark' || (this.theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                  document.documentElement.classList.add('dark');
              } else {
                  document.documentElement.classList.remove('dark');
              }
          }
      }"
      x-init="init()">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? __('Acesso') }} | OmniManager</title>
        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml"/>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

        <!-- Scripts e Estilos -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        {{-- Livewire Styles --}}
        @livewireStyles
        @stack('styles')
    </head>
    <body class="font-display bg-background-light dark:bg-background-dark text-slate-900 dark:text-white antialiased min-h-screen flex flex-col items-center justify-center relative overflow-hidden selection:bg-primary selection:text-white">
        
        <!-- Background Decoration (Subtle Gradients) -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[800px] h-[500px] bg-primary/20 rounded-full blur-[120px] -z-10 opacity-30 pointer-events-none"></div>
        
        <div class="w-full max-w-md px-6 py-8 md:px-8">
            <!-- Logo Header -->
            <div class="flex flex-col items-center justify-center mb-8">
                <a href="/" wire:navigate class="group flex items-center gap-3 focus:outline-none">
                    <div class="w-12 h-12 text-primary">
                        <x-application-logo class="w-full h-full" />
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                        Omni<span class="text-primary">Manager</span>
                    </span>
                </a>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400 text-center">{{ __('Gestão de Grupos Econômicos') }}</p>
            </div>
            
            {{ $slot }}
        <x-language-switcher />
            
            <!-- Extra Footer Links -->
            <div class="mt-8 flex justify-center gap-6 text-xs text-slate-400 dark:text-slate-600">
                <a href="#" class="hover:text-text-muted transition-colors">{{ __('Privacidade') }}</a>
                <a href="#" class="hover:text-text-muted transition-colors">{{ __('Termos') }}</a>
                <a href="#" class="hover:text-text-muted transition-colors">{{ __('Ajuda') }}</a>
            </div>
        </div>
        
        {{-- Livewire Scripts --}}
        @livewireScripts
    </body>
</html>
