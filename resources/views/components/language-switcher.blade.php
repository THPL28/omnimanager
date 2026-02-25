<div class="fixed bottom-4 right-4 z-50">
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-2 bg-white dark:bg-surface-dark border border-border-light dark:border-border-dark shadow-lg rounded-full px-4 py-2 hover:bg-slate-50 dark:hover:bg-white/5 transition-colors">
            <span class="material-symbols-outlined text-[20px] text-text-secondary dark:text-text-secondary-dark">language</span>
            <span class="text-[13px] font-medium text-text-primary dark:text-white uppercase">{{ app()->getLocale() }}</span>
            <span class="material-symbols-outlined text-[16px] text-slate-400">expand_less</span>
        </button>

        <div x-show="open" 
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="transform opacity-0 scale-95 translation-y-2"
             x-transition:enter-end="transform opacity-100 scale-100 translation-y-0"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="transform opacity-100 scale-100 translation-y-0"
             x-transition:leave-end="transform opacity-0 scale-95 translation-y-2"
             class="absolute bottom-full right-0 mb-2 w-48 bg-white dark:bg-surface-dark border border-border-light dark:border-border-dark rounded-lg shadow-xl overflow-hidden py-1 max-h-64 overflow-y-auto">
            
            @foreach (['pt_BR' => 'Português', 'en' => 'English', 'es' => 'Español', 'fr' => 'Français', 'de' => 'Deutsch', 'it' => 'Italiano', 'zh_CN' => '中文', 'ja' => '日本語', 'ru' => 'Русский'] as $code => $label)
                <a href="{{ route('language.switch', $code) }}" class="flex items-center justify-between px-4 py-2 text-[13px] hover:bg-slate-50 dark:hover:bg-white/5 transition-colors {{ app()->getLocale() === $code ? 'text-primary font-medium bg-slate-50 dark:bg-white/5' : 'text-text-primary dark:text-gray-300' }}">
                    <span>{{ $label }}</span>
                    @if(app()->getLocale() === $code)
                        <span class="material-symbols-outlined text-[16px] text-primary">check</span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</div>
