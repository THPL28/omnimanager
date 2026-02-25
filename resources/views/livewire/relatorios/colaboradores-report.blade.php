<div class="flex-1 flex flex-col h-full min-w-0 overflow-hidden bg-background-light dark:bg-background-dark relative">
    <header class="h-16 flex items-center justify-between px-8 border-b border-gray-200 dark:border-border-dark bg-white dark:bg-surface-dark/80 backdrop-blur-md sticky top-0 z-20">
        <div class="flex items-center gap-3">
            <div class="size-9 rounded-lg bg-primary/10 text-primary flex items-center justify-center shadow-inner">
                <span class="material-symbols-outlined text-xl">analytics</span>
            </div>
            <h2 class="text-lg font-bold tracking-tight text-gray-900 dark:text-white">{{ __('Relatório de Colaboradores') }}</h2>
        </div>
    </header>

    <div class="flex-1 overflow-auto p-8 bg-grid">
        <div class="max-w-7xl mx-auto space-y-6">
            {{-- Premium Filters Card --}}
            <div class="relative group">
                {{-- Glow effect behind card --}}
                <div class="absolute -inset-0.5 bg-gradient-to-r from-primary/20 to-transparent blur-xl opacity-0 group-hover:opacity-100 transition duration-1000"></div>
                
                <div class="relative bg-white/70 dark:bg-surface-dark/40 backdrop-blur-xl rounded-2xl border border-gray-200/50 dark:border-white/10 shadow-2xl overflow-hidden p-6">
                    {{-- Inner glow top border --}}
                    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>

                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
                        <div class="flex items-center gap-2.5">
                            <div class="p-1.5 rounded-md bg-primary/10">
                                <span class="material-symbols-outlined text-primary text-xl">filter_list</span>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-widest">{{ __('Filtros de Busca') }}</h3>
                                <p class="text-[10px] text-gray-500 dark:text-gray-400 uppercase tracking-tighter">{{ __('Refine seus resultados com precisão') }}</p>
                            </div>
                        </div>
                        
                        <button 
                            wire:click="export"
                            class="relative flex items-center gap-2 px-6 py-2.5 bg-primary hover:bg-primary-hover text-white text-xs font-bold uppercase tracking-widest rounded-full shadow-lg shadow-primary/30 transition-all active:scale-95 group/btn overflow-hidden"
                        >
                            <div class="absolute inset-0 bg-gradient-to-r from-white/10 to-transparent opacity-0 group-hover/btn:opacity-100 transition-opacity"></div>
                            <span class="material-symbols-outlined text-lg">download</span>
                            {{ __('Exportar Excel') }}
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                        {{-- Group Filter (Custom) --}}
                        <div class="md:col-span-3 space-y-1.5" x-data="{ open: false }">
                            <label class="block text-[10px] font-bold text-slate-500 dark:text-gray-400 uppercase tracking-[0.2em] ml-1">{{ __('Grupo Econômico') }}</label>
                            <div class="relative">
                                <button 
                                    @click="open = !open"
                                    @click.away="open = false"
                                    type="button"
                                    class="w-full bg-white dark:bg-surface-dark border border-slate-200 dark:border-white/10 text-slate-900 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-primary/50 focus:border-primary flex items-center justify-between p-3 hover:bg-slate-50 dark:hover:bg-white/10 transition-all shadow-sm"
                                >
                                    <span class="truncate">
                                        {{ $grupos->find($grupo_economico_id)?->nome ?? __('Todos os Grupos') }}
                                    </span>
                                    <span class="material-symbols-outlined text-lg text-slate-400 transition-transform duration-300" :class="{ 'rotate-180': open }">expand_more</span>
                                </button>

                                {{-- Custom Options List --}}
                                <div 
                                    x-show="open"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                                    class="absolute z-50 w-full mt-2 bg-white dark:bg-surface-dark border border-slate-200 dark:border-white/10 rounded-2xl shadow-2xl overflow-hidden max-h-60 overflow-y-auto no-scrollbar"
                                    style="display: none;"
                                >
                                    <div class="p-1">
                                        <button 
                                            @click="$wire.set('grupo_economico_id', ''); open = false"
                                            class="w-full text-left px-4 py-2.5 rounded-xl text-sm transition-all flex items-center gap-3 {{ !$grupo_economico_id ? 'bg-primary/10 text-primary font-bold' : 'text-slate-600 dark:text-gray-300 hover:bg-slate-100 dark:hover:bg-white/5' }}"
                                        >
                                            <span class="material-symbols-outlined text-lg {{ !$grupo_economico_id ? 'text-primary' : 'opacity-0' }}">check</span>
                                            {{ __('Todos os Grupos') }}
                                        </button>
                                        @foreach ($grupos as $grupo)
                                            <button 
                                                @click="$wire.set('grupo_economico_id', {{ $grupo->id }}); open = false"
                                                class="w-full text-left px-4 py-2.5 rounded-xl text-sm transition-all flex items-center gap-3 {{ $grupo_economico_id == $grupo->id ? 'bg-primary/10 text-primary font-bold' : 'text-slate-600 dark:text-gray-300 hover:bg-slate-100 dark:hover:bg-white/5' }}"
                                            >
                                                <span class="material-symbols-outlined text-lg {{ $grupo_economico_id == $grupo->id ? 'text-primary' : 'opacity-0' }}">check</span>
                                                {{ $grupo->nome }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Brand Filter (Custom) --}}
                        <div class="md:col-span-3 space-y-1.5" x-data="{ open: false }">
                            <label class="block text-[10px] font-bold text-slate-500 dark:text-gray-400 uppercase tracking-[0.2em] ml-1">{{ __('Bandeira') }}</label>
                            <div class="relative">
                                <button 
                                    @click="open = !open"
                                    @click.away="open = false"
                                    type="button"
                                    class="w-full bg-white dark:bg-surface-dark border border-slate-200 dark:border-white/10 text-slate-900 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-primary/50 focus:border-primary flex items-center justify-between p-3 hover:bg-slate-50 dark:hover:bg-white/10 transition-all disabled:opacity-30 disabled:cursor-not-allowed shadow-sm"
                                    @if ($bandeirasDisponiveis->isEmpty() && $grupo_economico_id) disabled @endif
                                >
                                    <span class="truncate">
                                        {{ $bandeirasDisponiveis->find($bandeira_id)?->nome ?? __('Todas as Bandeiras') }}
                                    </span>
                                    <span class="material-symbols-outlined text-lg text-slate-400 transition-transform duration-300" :class="{ 'rotate-180': open }">expand_more</span>
                                </button>

                                {{-- Custom Options List --}}
                                <div 
                                    x-show="open"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                                    class="absolute z-50 w-full mt-2 bg-white dark:bg-surface-dark border border-slate-200 dark:border-white/10 rounded-2xl shadow-2xl overflow-hidden max-h-60 overflow-y-auto no-scrollbar"
                                    style="display: none;"
                                >
                                    <div class="p-1">
                                        <button 
                                            @click="$wire.set('bandeira_id', ''); open = false"
                                            class="w-full text-left px-4 py-2.5 rounded-xl text-sm transition-all flex items-center gap-3 {{ !$bandeira_id ? 'bg-primary/10 text-primary font-bold' : 'text-slate-600 dark:text-gray-300 hover:bg-slate-100 dark:hover:bg-white/5' }}"
                                        >
                                            <span class="material-symbols-outlined text-lg {{ !$bandeira_id ? 'text-primary' : 'opacity-0' }}">check</span>
                                            {{ __('Todas as Bandeiras') }}
                                        </button>
                                        @foreach ($bandeirasDisponiveis as $bandeira)
                                            <button 
                                                @click="$wire.set('bandeira_id', {{ $bandeira->id }}); open = false"
                                                class="w-full text-left px-4 py-2.5 rounded-xl text-sm transition-all flex items-center gap-3 {{ $bandeira_id == $bandeira->id ? 'bg-primary/10 text-primary font-bold' : 'text-slate-600 dark:text-gray-300 hover:bg-slate-100 dark:hover:bg-white/5' }}"
                                            >
                                                <span class="material-symbols-outlined text-lg {{ $bandeira_id == $bandeira->id ? 'text-primary' : 'opacity-0' }}">check</span>
                                                {{ $bandeira->nome }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Search Input --}}
                        <div class="md:col-span-6 space-y-1.5">
                            <label class="block text-[10px] font-bold text-slate-500 dark:text-gray-400 uppercase tracking-[0.2em] ml-1">{{ __('Busca Inteligente') }}</label>
                            <div class="relative group/search">
                                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-primary/50 group-focus-within/search:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-xl">search</span>
                                </div>
                                <input 
                                    wire:model.live.debounce.300ms="search"
                                    type="text"
                                    placeholder="{{ __('Pesquisar colaboradores...') }}"
                                    class="bg-white dark:bg-surface-dark border border-slate-200 dark:border-white/10 text-slate-900 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-primary/50 focus:border-primary block w-full pl-12 p-3 placeholder-slate-400 dark:placeholder-gray-500 transition-all hover:bg-slate-50 dark:hover:bg-white/10 shadow-sm"
                                />
                            </div>
                        </div>
                    </div>

                    {{-- Summary Metrics & Active Filters --}}
                    <div class="mt-6 pt-6 border-t border-gray-200/50 dark:border-white/5 flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="flex flex-wrap items-center gap-3">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mr-2">{{ __('Ativos') }}:</span>
                            @if($search)
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-white dark:bg-white/5 text-primary border border-primary/20 flex items-center gap-2 group transition-all hover:border-primary">
                                    {{ __('Busca') }}: "{{ $search }}"
                                    <button wire:click="removeFilter('search')" class="text-gray-400 hover:text-red-500 transition-colors">
                                        <span class="material-symbols-outlined text-sm">cancel</span>
                                    </button>
                                </span>
                            @endif

                            @if($grupo_economico_id)
                                @php $gnome = $grupos->firstWhere('id', $grupo_economico_id)->nome ?? ''; @endphp
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-white dark:bg-white/5 text-primary border border-primary/20 flex items-center gap-2 group transition-all hover:border-primary">
                                    {{ __('Grupo') }}: {{ $gnome }}
                                    <button wire:click="removeFilter('grupo')" class="text-gray-400 hover:text-red-500 transition-colors">
                                        <span class="material-symbols-outlined text-sm">cancel</span>
                                    </button>
                                </span>
                            @endif

                            @if($bandeira_id)
                                @php $bnome = $bandeirasDisponiveis->firstWhere('id', $bandeira_id)->nome ?? ''; @endphp
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold bg-white dark:bg-white/5 text-primary border border-primary/20 flex items-center gap-2 group transition-all hover:border-primary">
                                    {{ __('Bandeira') }}: {{ $bnome }}
                                    <button wire:click="removeFilter('bandeira')" class="text-gray-400 hover:text-red-500 transition-colors">
                                        <span class="material-symbols-outlined text-sm">cancel</span>
                                    </button>
                                </span>
                            @endif

                            @if($search || $grupo_economico_id || $bandeira_id)
                                <button wire:click="clearFilters" class="text-[10px] font-bold text-gray-500 hover:text-primary transition-all uppercase tracking-widest hover:translate-x-1">
                                    {{ __('Limpar tudo') }} →
                                </button>
                            @else
                                <span class="text-[10px] text-gray-500 italic lowercase tracking-tight">{{ __('nenhum filtro aplicado no momento') }}</span>
                            @endif
                        </div>

                        <div class="flex items-center gap-4 text-xs">
                            <div class="px-4 py-1.5 rounded-lg bg-gray-50 dark:bg-background-dark/50 border border-gray-200 dark:border-white/5 flex items-center gap-3">
                                <span class="size-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span class="text-gray-400 uppercase tracking-tighter">{{ __('Resultados') }}:</span>
                                <span class="font-bold text-gray-900 dark:text-white tabular-nums">{{ $colaboradores->total() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Standard Table Card (Consistent with Dashboard) --}}
            <div class="relative bg-white dark:bg-surface-dark rounded-2xl border border-slate-200 dark:border-border-dark shadow-sm overflow-hidden min-h-[400px]">
                {{-- Inner glow top border (subtle) --}}
                <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-primary/10 to-transparent"></div>

                {{-- Loading Overlay --}}
                <div wire:loading class="absolute inset-0 z-10 bg-white/60 dark:bg-background-dark/60 backdrop-blur-sm flex items-center justify-center transition-all duration-500">
                    <div class="flex flex-col items-center gap-4">
                        <div class="relative size-16">
                            <div class="absolute inset-0 border-4 border-primary/10 rounded-full"></div>
                            <div class="absolute inset-0 border-4 border-t-primary rounded-full animate-spin shadow-glow"></div>
                        </div>
                        <span class="text-[10px] font-bold text-primary uppercase tracking-[0.3em] animate-pulse">{{ __('Processando...') }}</span>
                    </div>
                </div>

                <div class="overflow-x-auto" wire:loading.class="opacity-40 transition-opacity duration-500">
                    <table class="w-full text-sm text-left border-separate border-spacing-0">
                        <thead class="text-[10px] font-bold text-slate-500 dark:text-gray-500 uppercase tracking-widest bg-slate-50 dark:bg-surface-dark border-b border-slate-200 dark:border-border-dark">
                            <tr>
                                <th class="px-8 py-5 border-b border-slate-100 dark:border-white/5">{{ __('Colaborador') }}</th>
                                <th class="px-8 py-5 border-b border-slate-100 dark:border-white/5">{{ __('Contato') }}</th>
                                <th class="px-8 py-5 border-b border-slate-100 dark:border-white/5">{{ __('Documento') }}</th>
                                <th class="px-8 py-5 border-b border-slate-100 dark:border-white/5">{{ __('Unidade') }}</th>
                                <th class="px-8 py-5 border-b border-slate-100 dark:border-white/5">{{ __('Hierarquia') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                            @forelse ($colaboradores as $colaborador)
                                <tr class="hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-all group cursor-default">
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <div class="relative size-10 rounded-xl bg-gradient-to-br from-primary/20 to-primary/5 flex items-center justify-center text-primary font-bold text-xs shadow-inner overflow-hidden group-hover:scale-110 transition-transform duration-500">
                                                {{ substr($colaborador->nome, 0, 2) }}
                                                <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-slate-900 dark:text-white">{{ $colaborador->nome }}</div>
                                                <div class="text-[10px] text-slate-500 uppercase tracking-tighter">{{ __('ID') }}: #{{ str_pad($colaborador->id, 4, '0', STR_PAD_LEFT) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="flex flex-col">
                                            <span class="text-sm text-slate-600 dark:text-gray-300 group-hover:text-primary transition-colors">{{ $colaborador->email }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <span class="text-xs font-mono text-slate-500 px-2 py-0.5 rounded bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/5 tabular-nums">
                                            {{ $colaborador->cpf }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-slate-700 dark:text-gray-300">{{ $colaborador->unidade->nome_fantasia ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="flex flex-col gap-1">
                                            <div class="flex items-center gap-2">
                                                <span class="size-1.5 rounded-full bg-primary/40"></span>
                                                <span class="text-xs font-bold text-slate-900 dark:text-white">{{ $colaborador->unidade->bandeira->nome ?? 'N/A' }}</span>
                                            </div>
                                            <div class="text-[10px] text-slate-500 uppercase tracking-widest pl-3">{{ $colaborador->unidade->bandeira->grupoEconomico->nome ?? 'N/A' }}</div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-32">
                                        <div class="flex flex-col items-center justify-center text-center max-w-xs mx-auto">
                                            <div class="relative size-20 mb-6 group/empty">
                                                <div class="absolute inset-0 bg-primary/10 rounded-full blur-xl animate-pulse"></div>
                                                <div class="relative bg-white dark:bg-surface-dark border border-slate-200 dark:border-white/10 rounded-full size-20 flex items-center justify-center text-slate-300 dark:text-gray-600 shadow-xl group-hover/empty:scale-110 transition-transform">
                                                    <span class="material-symbols-outlined text-5xl">search_off</span>
                                                </div>
                                            </div>
                                            <h4 class="text-xl font-bold text-slate-900 dark:text-white mb-2 tracking-tight">{{ __('Sem Resultados') }}</h4>
                                            <p class="text-sm text-slate-500 dark:text-gray-400 leading-relaxed">{{ __('Não encontramos nenhum colaborador com os filtros aplicados.') }}</p>
                                            <button wire:click="clearFilters" class="mt-6 text-xs font-bold text-primary uppercase tracking-widest hover:underline">{{ __('Resetar Filtros') }}</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Premium Pagination --}}
                <div class="px-8 py-6 border-t border-slate-200 dark:border-white/5 bg-slate-50 dark:bg-white/[0.02]">
                    {{ $colaboradores->links() }}
                </div>
            </div>
        </div>
    </div>
</div>