<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} | OmniManager</title>
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml"/>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet" />

    {{-- Tailwind CDN (Fallback/Force for Design Fidelity) --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "primary": "#3b19e6","primary-hover": "#2d14b3",
              "background-light": "#f4f5f8",
              "background-dark": "#0e1015","surface-light": "#ffffff",
              "surface-dark": "#16181d","border-dark": "rgba(255, 255, 255, 0.08)",},
            fontFamily: {
              "display": ["Inter", "sans-serif"]
            },
            borderRadius: {"DEFAULT": "0.25rem", "lg": "0.5rem", "xl": "0.75rem", "full": "9999px"},
            boxShadow: {
                "glow": "0 0 20px -5px rgba(59, 25, 230, 0.3)"
            }
          },
        },
      }
    </script>
    
    {{-- Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
        .dark ::-webkit-scrollbar-thumb { background: #2d303a; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'OPSZ' 24; }
        .icon-fill { font-variation-settings: 'FILL' 1; }
        
        /* Force Dark Mode defaults to match user snippet exactly */
        .dark body { background-color: #0e1015; color: #f3f4f6; }
        .dark aside { border-right-color: rgba(255, 255, 255, 0.08); }
    </style>

    @livewireStyles
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-gray-100 font-display transition-colors duration-200 antialiased overflow-hidden selection:bg-primary/30 selection:text-primary-100"
      x-data="{ 
          darkMode: localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
          toggleTheme() {
              this.darkMode = !this.darkMode;
              localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
              if (this.darkMode) {
                  document.documentElement.classList.add('dark');
              } else {
                  document.documentElement.classList.remove('dark');
              }
          }
      }"
      x-init="$watch('darkMode', val => val ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark')); if(darkMode) document.documentElement.classList.add('dark');"
>
    <div class="flex h-screen w-full">
        <livewire:layout.navigation />
        
        <main class="flex-1 flex flex-col h-full overflow-hidden relative">
            <header class="h-16 flex items-center justify-between px-6 border-b border-slate-200 dark:border-border-dark bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md z-10">
                <div class="flex items-center gap-2 text-sm">
                    <a class="text-slate-500 dark:text-gray-500 hover:text-primary dark:hover:text-primary transition-colors font-medium border-b border-transparent hover:border-primary" href="{{ route('dashboard') }}" wire:navigate>{{ __('Home') }}</a>
                    <span class="text-slate-400 dark:text-gray-700">/</span>
                    <span class="text-slate-900 dark:text-gray-200 font-medium">{{ __('Dashboard Executivo') }}</span>
                </div>
                
                <div class="max-w-md w-full mx-4 hidden md:block">
                    <form action="{{ route('dashboard') }}" method="GET" class="w-full">
                        <label class="relative flex items-center w-full group">
                            <span class="absolute left-3 text-slate-400 dark:text-gray-500 material-symbols-outlined text-[20px] group-focus-within:text-primary transition-colors">search</span>
                            <input name="search" value="{{ request('search') }}" class="w-full bg-white dark:bg-[#1c1f26] border border-gray-200 dark:border-transparent rounded-lg py-2 pl-10 pr-12 text-sm text-slate-900 dark:text-white placeholder:text-slate-400 dark:placeholder:text-gray-600 focus:ring-1 focus:ring-primary dark:focus:ring-primary focus:border-primary dark:focus:border-transparent transition-all shadow-sm" placeholder="{{ __('Buscar unidades, pessoas ou comandos...') }}" type="text"/>
                            <div class="absolute right-3 flex items-center gap-1">
                                <span class="text-[10px] font-mono font-medium text-slate-400 bg-white dark:bg-white/5 px-1.5 py-0.5 rounded border border-slate-200 dark:border-white/10 dark:text-gray-400">⌘K</span>
                            </div>
                        </label>
                    </form>
                </div>
                
                <div class="flex items-center gap-4">
                     {{-- Theme Toggle --}}
                     <button @click="toggleTheme()" class="text-slate-500 dark:text-gray-400 hover:text-slate-900 dark:hover:text-white transition-colors">
                        <span class="material-symbols-outlined" x-show="!darkMode">dark_mode</span>
                        <span class="material-symbols-outlined" x-show="darkMode" style="display: none;">light_mode</span>
                    </button>
                    
                    <button class="relative text-slate-500 dark:text-gray-400 hover:text-slate-900 dark:hover:text-white transition-colors">
                        <span class="material-symbols-outlined">notifications</span>
                        <span class="absolute top-0 right-0 size-2 bg-red-500 rounded-full border-2 border-background-light dark:border-background-dark"></span>
                    </button>
                </div>
            </header>
            
            <div class="flex-1 overflow-y-auto p-6 scroll-smooth bg-background-light dark:bg-background-dark">
                {{ $slot }}
        <x-language-switcher />
            </div>
        </main>
    </div>
    
    @livewireScripts
</body>
</html>
