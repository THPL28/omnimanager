<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>OmniManager</title>
        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml"/>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        @livewireStyles 
    </head>
    <body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-gray-200 font-display h-screen overflow-hidden antialiased selection:bg-primary/30 selection:text-white"
          x-data="{ 
              theme: localStorage.getItem('theme') || 'dark',
              toggleTheme() {
                  this.theme = this.theme === 'light' ? 'dark' : 'light';
                  localStorage.setItem('theme', this.theme);
                  this.applyTheme();
              },
              applyTheme() {
                  document.documentElement.setAttribute('data-theme', this.theme);
                  if (this.theme === 'dark') {
                      document.documentElement.classList.add('dark');
                  } else {
                      document.documentElement.classList.remove('dark');
                  }
              }
          }"
          x-init="applyTheme()">
        
        <div class="flex h-screen overflow-hidden">
            {{-- Navegação Lateral --}}
            <livewire:layout.navigation />

            {{-- Main Content --}}
            <main class="flex-1 flex flex-col h-full min-w-0 overflow-hidden bg-background-light dark:bg-background-dark relative">
                {{ $slot }}
            </main>
        </div>
        
        <x-language-switcher />

        @livewireScripts
    </body>
</html>