<x-app-layout>
    {{-- Glass Header --}}
    <header class="glass-header z-10 sticky top-0 flex items-center justify-between border-b border-border-light dark:border-border-dark px-6 py-3 h-14">
        <div class="flex items-center gap-2 text-text-secondary dark:text-text-secondary-dark text-[13px]">
            <span class="hidden md:inline hover:text-text-primary dark:hover:text-white cursor-pointer transition-colors">Dashboard</span>
            <span class="material-symbols-outlined text-[14px] text-slate-400">chevron_right</span>
            <span class="hover:text-text-primary dark:hover:text-white cursor-pointer transition-colors">Configurações</span>
            <span class="material-symbols-outlined text-[14px] text-slate-400">chevron_right</span>
            <span class="text-text-primary dark:text-white font-medium">Perfil</span>
        </div>
        <div class="flex items-center gap-3">
            <div class="hidden md:flex items-center relative group">
                <span class="material-symbols-outlined absolute left-2.5 text-slate-400 text-[18px] pointer-events-none group-focus-within:text-primary transition-colors">search</span>
                <input class="pl-9 pr-4 py-1.5 w-56 bg-white dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-md text-[13px] text-text-primary dark:text-white focus:ring-1 focus:ring-primary focus:border-primary transition-all placeholder:text-slate-400" placeholder="Buscar (Cmd+K)" type="text"/>
            </div>
            <div class="w-px h-5 bg-border-light dark:bg-border-dark mx-1 hidden md:block"></div>
            <button class="p-1.5 text-text-secondary dark:text-text-secondary-dark hover:bg-slate-100 dark:hover:bg-surface-dark rounded-md transition-colors relative">
                <span class="material-symbols-outlined text-[20px]">notifications</span>
                <span class="absolute top-1.5 right-1.5 w-1.5 h-1.5 bg-red-500 rounded-full border border-white dark:border-background-dark"></span>
            </button>
            <button class="md:hidden p-1.5 text-text-secondary dark:text-white">
                <span class="material-symbols-outlined">menu</span>
            </button>
        </div>
    </header>

    <div class="flex-1 overflow-y-auto bg-white dark:bg-background-dark">
        <div class="mx-auto max-w-3xl w-full p-8 pb-32 flex flex-col gap-10">
            {{-- Profile Summary Header (Livewire Component) --}}
            <livewire:profile.header />

            {{-- Forms --}}
            <livewire:profile.update-profile-information-form />
            
            <livewire:profile.update-password-form />
            
            <livewire:profile.delete-user-form />
        </div>
    </div>
</x-app-layout>
