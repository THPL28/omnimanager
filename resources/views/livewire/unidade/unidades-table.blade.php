<div>
    {{-- Header Section --}}
    <header class="flex flex-col border-b border-gray-200 dark:border-white/5 bg-white dark:bg-background-dark z-10">
        {{-- Breadcrumbs --}}
        <div class="px-8 pt-6 pb-2">
            <div class="flex items-center gap-2 text-xs font-medium text-slate-500 dark:text-slate-400">
                <a href="#" class="hover:text-primary transition-colors">{{ __('Gestão') }}</a>
                <span class="material-symbols-outlined text-[14px] opacity-40">chevron_right</span>
                <a href="#" class="hover:text-primary transition-colors">{{ __('Cadastros') }}</a>
                <span class="material-symbols-outlined text-[14px] opacity-40">chevron_right</span>
                <span class="text-slate-900 dark:text-white">{{ __('Unidades') }}</span>
            </div>
        </div>

        {{-- Title & Description --}}
        <div class="px-8 pb-6 flex flex-wrap items-end justify-between gap-4">
            <div class="max-w-2xl">
                <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white mb-2">{{ __('Unidades') }}</h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">
                    {{ __('Gerencie todas as unidades de negócio, bandeiras e status de operação em um único lugar.') }}
                </p>
            </div>
            <div class="flex items-center gap-3">
                <button wire:click="showCreateModal" class="h-10 px-4 flex items-center gap-2 bg-primary hover:bg-primary-hover text-white text-sm font-bold rounded-xl shadow-lg shadow-primary/20 transition-all active:scale-95">
                    <span class="material-symbols-outlined text-[20px]">add_circle</span>
                    {{ __('Nova Unidade') }}
                </button>
            </div>
        </div>

        {{-- Toolbar / Filters --}}
        <div class="px-8 py-3 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-gray-50/50 dark:bg-white/[0.02] border-t border-gray-100 dark:border-white/5">
            <div class="flex flex-wrap items-center gap-3 flex-1">
                {{-- Search --}}
                <div class="relative group w-full max-w-md">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 group-focus-within:text-primary transition-colors text-[20px]">search</span>
                    <input 
                        wire:model.live.debounce.500ms="search" 
                        id="search-input"
                        class="w-full bg-white dark:bg-surface-dark border border-gray-200 dark:border-white/10 text-slate-900 dark:text-white text-sm rounded-lg pl-10 pr-4 py-2 focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600 shadow-sm" 
                        placeholder="{{ __('Buscar por unidade, CNPJ ou razão social...') }}" 
                        type="text"
                        x-on:keydown.window.prevent.cmd.k="document.getElementById('search-input').focus()"
                        x-on:keydown.window.prevent.ctrl.k="document.getElementById('search-input').focus()"
                    />
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 hidden sm:flex items-center gap-1">
                        <span class="text-[10px] font-mono text-slate-400 dark:text-slate-600 border border-gray-200 dark:border-white/10 rounded px-1.5 py-0.5">⌘K</span>
                    </div>
                </div>

                <div class="h-6 w-px bg-gray-200 dark:bg-white/10 mx-1 hidden md:block"></div>

                {{-- Action: Clear Filters --}}
                @if($selectedBandeira !== 'Todos' || $selectedStatus !== 'Todos' || $search !== '')
                    <button wire:click="$set('selectedBandeira', 'Todos'); $set('selectedStatus', 'Todos'); $set('search', '')" class="text-xs font-semibold text-primary hover:text-primary-hover transition-colors px-2 py-1 underline-offset-4 hover:underline">
                        {{ __('Limpar Filtros') }}
                    </button>
                @endif

                {{-- Filter Bandeira --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" 
                            class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white dark:bg-surface-dark hover:bg-gray-50 dark:hover:bg-white/5 text-slate-700 dark:text-white text-sm font-medium border {{ $selectedBandeira !== 'Todos' ? 'border-primary text-primary' : 'border-gray-200 dark:border-white/10' }} transition-all whitespace-nowrap group shadow-sm">
                        <span class="material-symbols-outlined text-[18px] opacity-60">flag</span>
                        <span>{{ __('Bandeira') }}: {{ $selectedBandeira === 'Todos' ? __('Todos') : $selectedBandeira }}</span>
                        <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-slate-600 dark:text-slate-500 dark:group-hover:text-white transition-transform" :class="open ? 'rotate-180' : ''">keyboard_arrow_down</span>
                    </button>
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         @click.away="open = false" 
                         class="absolute right-0 mt-2 w-56 rounded-xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-white/10 shadow-2xl z-50 overflow-hidden ring-1 ring-black/5">
                        <div class="px-3 py-2 border-b border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-black/20">
                            <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __('Filtrar por Bandeira') }}</span>
                        </div>
                        <div class="py-1 max-h-60 overflow-y-auto no-scrollbar">
                            <button wire:click="setFilterBandeira('Todos')" @click="open = false" class="w-full text-left px-4 py-2 text-sm {{ $selectedBandeira === 'Todos' ? 'text-primary bg-primary/5 font-semibold' : 'text-slate-700 dark:text-gray-300' }} hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">{{ __('Todas as Bandeiras') }}</button>
                            @foreach($bandeiras as $bandeira)
                                <button wire:click="setFilterBandeira('{{ $bandeira->nome }}')" @click="open = false" class="w-full text-left px-4 py-2 text-sm {{ $selectedBandeira === $bandeira->nome ? 'text-primary bg-primary/5 font-semibold' : 'text-slate-700 dark:text-gray-300' }} hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">{{ $bandeira->nome }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Filter Status --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" 
                            class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white dark:bg-surface-dark hover:bg-gray-50 dark:hover:bg-white/5 text-slate-700 dark:text-white text-sm font-medium border {{ $selectedStatus !== 'Todos' ? 'border-primary text-primary' : 'border-gray-200 dark:border-white/10' }} transition-all whitespace-nowrap group shadow-sm">
                        <span class="material-symbols-outlined text-[18px] opacity-60">check_circle</span>
                        <span>{{ __('Status') }}: {{ $selectedStatus === 'Todos' ? __('Todos') : __($selectedStatus) }}</span>
                        <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-slate-600 dark:text-slate-500 dark:group-hover:text-white transition-transform" :class="open ? 'rotate-180' : ''">keyboard_arrow_down</span>
                    </button>
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         @click.away="open = false" 
                         class="absolute right-0 mt-2 w-48 rounded-xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-white/10 shadow-2xl z-50 overflow-hidden ring-1 ring-black/5">
                        <div class="px-3 py-2 border-b border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-black/20">
                            <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __('Estado de Operação') }}</span>
                        </div>
                        <div class="py-1">
                            <button wire:click="setFilterStatus('Todos')" @click="open = false" class="w-full text-left px-4 py-2 text-sm {{ $selectedStatus === 'Todos' ? 'text-primary bg-primary/5 font-semibold' : 'text-slate-700 dark:text-gray-300' }} hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">{{ __('Todos') }}</button>
                            <button wire:click="setFilterStatus('Ativo')" @click="open = false" class="w-full text-left px-4 py-2 text-sm {{ $selectedStatus === 'Ativo' ? 'text-primary bg-primary/5 font-semibold' : 'text-slate-700 dark:text-gray-300' }} hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">{{ __('Ativo') }}</button>
                            <button wire:click="setFilterStatus('Pendente')" @click="open = false" class="w-full text-left px-4 py-2 text-sm {{ $selectedStatus === 'Pendente' ? 'text-primary bg-primary/5 font-semibold' : 'text-slate-700 dark:text-gray-300' }} hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">{{ __('Pendente') }}</button>
                            <button wire:click="setFilterStatus('Inativo')" @click="open = false" class="w-full text-left px-4 py-2 text-sm {{ $selectedStatus === 'Inativo' ? 'text-primary bg-primary/5 font-semibold' : 'text-slate-700 dark:text-gray-300' }} hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">{{ __('Inativo') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- Content Area --}}
    <div class="flex-1 overflow-auto p-8 no-scrollbar bg-gray-50/30 dark:bg-transparent">
        <div class="max-w-[1600px] mx-auto">
            {{-- Table --}}
            <div class="bg-white dark:bg-[#111622] rounded-2xl border border-gray-200 dark:border-white/5 shadow-sm overflow-hidden transition-all">
                <div class="overflow-x-auto no-scrollbar">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-black/20">
                                <th class="w-10 px-6 py-4">
                                    <input type="checkbox" wire:model.live="selectAll" class="rounded border-gray-300 dark:border-white/10 bg-white dark:bg-white/5 text-primary focus:ring-primary/20">
                                </th>
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">{{ __('Unidade') }}</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">{{ __('Bandeira') }}</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">{{ __('Grupo Econômico') }}</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">{{ __('CNPJ / Razão Social') }}</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">{{ __('Status') }}</th>
                                <th class="px-6 py-4 text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest text-right">{{ __('Ações') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                            @forelse ($unidades as $unidade)
                                <tr class="group hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-all cursor-default">
                                    <td class="px-6 py-4">
                                        <input type="checkbox" value="{{ $unidade->id }}" wire:model.live="selectedUnidades" class="rounded border-gray-300 dark:border-white/10 bg-white dark:bg-white/5 text-primary focus:ring-primary/20">
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors">{{ $unidade->nome_fantasia }}</span>
                                            <span class="text-[11px] text-slate-500 dark:text-slate-500 font-medium">#{!! str_pad($unidade->id, 4, '0', STR_PAD_LEFT) !!}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md border border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-white/5 shadow-sm">
                                            <div class="size-2 rounded-full bg-primary/60"></div>
                                            <span class="text-xs font-semibold text-slate-700 dark:text-gray-300">{{ $unidade->bandeira->nome ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400 font-medium">
                                        {{ $unidade->bandeira->grupoEconomico->nome ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-mono text-slate-700 dark:text-slate-300">{{ $unidade->cnpj }}</span>
                                            <span class="text-[11px] text-slate-500 dark:text-slate-500 truncate max-w-[150px]" title="{{ $unidade->razao_social }}">{{ $unidade->razao_social }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="size-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.4)]"></div>
                                            <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 capitalize">{{ __('Ativo') }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-1">
                                            <button wire:click="showEditModal({{ $unidade->id }})" class="p-1.5 rounded-lg text-slate-400 hover:text-primary hover:bg-primary/10 transition-all" title="Editar">
                                                <span class="material-symbols-outlined text-[20px]">edit</span>
                                            </button>
                                            <button wire:click="deleteUnidade({{ $unidade->id }})" wire:confirm="{{ __('Excluir esta unidade? Esta ação é irreversível.') }}" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-500/10 transition-all" title="{{ __('Excluir') }}">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center gap-2 opacity-30">
                                            <span class="material-symbols-outlined text-[48px]">storefront_off</span>
                                            <p class="text-sm font-semibold uppercase tracking-widest text-slate-500">{{ __('Nenhuma unidade encontrada') }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-6 py-4 bg-gray-50/50 dark:bg-black/20 border-t border-gray-100 dark:border-white/5">
                    {{ $unidades->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal --}}
    @if ($showingModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm animate-in fade-in duration-200">
        <div class="bg-white dark:bg-surface-dark rounded-2xl shadow-2xl w-full max-w-lg border border-gray-200 dark:border-white/10 animate-in zoom-in-95 duration-200">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-white/5 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <div class="size-8 rounded-lg bg-primary/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-[20px]">{{ $unidadeId ? 'edit' : 'add_circle' }}</span>
                    </div>
                    {{ $unidadeId ? __('Editar Unidade') : __('Nova Unidade') }}
                </h3>
                <button wire:click="$set('showingModal', false)" class="size-8 flex items-center justify-center rounded-lg hover:bg-gray-100 dark:hover:bg-white/5 text-slate-400 hover:text-slate-500 transition-colors">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>
            
            <form wire:submit.prevent="saveUnidade">
                <div class="p-6 space-y-5">
                    {{-- Campo Bandeira --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">{{ __('Bandeira Pertencente') }}</label>
                        <div x-data="{ 
                            open: false, 
                            search: '',
                            selectedId: @entangle('bandeira_id'),
                            selectedNome: '{{ $bandeira_id ? $bandeiras->find($bandeira_id)?->nome : __('Selecione uma Bandeira') }}',
                            get filteredBandeiras() {
                                if (!this.search) return @js($bandeiras);
                                return @js($bandeiras).filter(b => b.nome.toLowerCase().includes(this.search.toLowerCase()));
                            },
                            init() {
                                this.$watch('selectedId', (val) => {
                                    if (!val) {
                                        this.selectedNome = '{{ __('Selecione uma Bandeira') }}';
                                        return;
                                    }
                                    const bandeiras = @js($bandeiras);
                                    const found = bandeiras.find(b => b.id == val);
                                    if (found) this.selectedNome = found.nome;
                                });
                            },
                            select(id, nome) {
                                this.selectedId = id;
                                this.selectedNome = nome;
                                this.open = false;
                                this.search = '';
                            }
                        }" class="relative">
                            <button type="button" @click="open = !open" 
                                    class="w-full flex items-center justify-between gap-3 px-4 py-3 rounded-xl border border-gray-200 dark:border-white/5 bg-gray-50 dark:bg-background-dark text-slate-900 dark:text-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all text-sm group shadow-inner">
                                <div class="flex items-center gap-2 overflow-hidden">
                                    <span class="material-symbols-outlined text-[20px] text-slate-400 group-hover:text-primary transition-colors shrink-0">flag</span>
                                    <span x-text="selectedNome" class="truncate font-medium" :class="selectedId ? 'text-slate-900 dark:text-white' : 'text-slate-400 dark:text-slate-500'"></span>
                                </div>
                                <span class="material-symbols-outlined text-[22px] text-slate-400 transition-transform shrink-0" :class="open ? 'rotate-180' : ''">keyboard_arrow_down</span>
                            </button>

                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="transform opacity-0 -translate-y-2 scale-[0.98]"
                                 x-transition:enter-end="transform opacity-100 translate-y-0 scale-100"
                                 @click.away="open = false" 
                                 class="absolute left-0 mt-2 w-full rounded-2xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-white/10 shadow-[0_20px_50px_rgba(0,0,0,0.3)] z-[70] overflow-hidden ring-1 ring-black/5">
                                
                                <div class="p-3 border-b border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-black/20">
                                    <div class="relative">
                                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[18px] text-slate-400">search</span>
                                        <input type="text" x-model="search" placeholder="{{ __('Buscar bandeira...') }}" 
                                               class="w-full bg-white dark:bg-background-dark border border-gray-200 dark:border-white/10 text-xs rounded-lg pl-9 pr-3 py-2 focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all placeholder:text-slate-500">
                                    </div>
                                </div>

                                <div class="py-1.5 max-h-60 overflow-y-auto no-scrollbar">
                                    <template x-if="filteredBandeiras.length === 0">
                                        <div class="px-4 py-6 text-sm text-slate-500 text-center italic flex flex-col items-center gap-2">
                                            <span class="material-symbols-outlined text-slate-300 text-[32px]">search_off</span>
                                            {{ __('Nenhuma bandeira encontrada') }}
                                        </div>
                                    </template>
                                    <template x-for="bandeira in filteredBandeiras" :key="bandeira.id">
                                        <button type="button" @click="select(bandeira.id, bandeira.nome)" 
                                                class="w-full text-left px-4 py-2.5 text-sm transition-all flex items-center justify-between group/item mx-1 rounded-lg w-[calc(100%-8px)]"
                                                :class="selectedId == bandeira.id ? 'text-primary bg-primary/5 font-bold' : 'text-slate-700 dark:text-gray-300 hover:bg-slate-100 dark:hover:bg-white/5'">
                                            <div class="flex items-center gap-3">
                                                <div class="size-2 rounded-full transition-all shadow-[0_0_8px_currentColor]" :class="selectedId == bandeira.id ? 'bg-primary scale-110' : 'bg-slate-200 dark:bg-white/10 group-hover/item:bg-slate-300 dark:group-hover/item:bg-white/20'"></div>
                                                <span x-text="bandeira.nome"></span>
                                            </div>
                                            <span x-show="selectedId == bandeira.id" class="material-symbols-outlined text-[18px]">check_circle</span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>
                        @error('bandeira_id') <span class="text-red-500 text-[11px] font-semibold mt-1 block pl-1 italic">{{ $message }}</span> @enderror
                    </div>

                    {{-- Nome Fantasia --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">{{ __('Nome Fantasia') }}</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-slate-400 group-focus-within:text-primary transition-colors">storefront</span>
                            <input type="text" wire:model.live="nome_fantasia" 
                                class="w-full bg-gray-50 dark:bg-background-dark border border-gray-200 dark:border-white/5 text-slate-900 dark:text-white text-sm rounded-xl pl-10 pr-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600 shadow-inner" 
                                placeholder="{{ __('Ex: Unidade Centro') }}">
                        </div>
                        @error('nome_fantasia') <span class="text-red-500 text-[11px] font-semibold mt-1 block pl-1 italic">{{ $message }}</span> @enderror
                    </div>

                    {{-- Razão Social --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">{{ __('Razão Social') }}</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-slate-400 group-focus-within:text-primary transition-colors">business</span>
                            <input type="text" wire:model.live="razao_social" 
                                class="w-full bg-gray-50 dark:bg-background-dark border border-gray-200 dark:border-white/5 text-slate-900 dark:text-white text-sm rounded-xl pl-10 pr-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600 shadow-inner" 
                                placeholder="{{ __('Ex: Bio Ritmo Academia S/A') }}">
                        </div>
                        @error('razao_social') <span class="text-red-500 text-[11px] font-semibold mt-1 block pl-1 italic">{{ $message }}</span> @enderror
                    </div>

                    {{-- CNPJ --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">{{ __('CNPJ (apenas números)') }}</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-slate-400 group-focus-within:text-primary transition-colors">fingerprint</span>
                            <input type="text" wire:model.live="cnpj" maxlength="14"
                                class="w-full bg-gray-50 dark:bg-background-dark border border-gray-200 dark:border-white/5 text-slate-900 dark:text-white text-sm font-mono rounded-xl pl-10 pr-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600 shadow-inner" 
                                placeholder="00000000000000">
                        </div>
                        @error('cnpj') <span class="text-red-500 text-[11px] font-semibold mt-1 block pl-1 italic">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="p-6 pt-2 bg-gray-50/50 dark:bg-black/10 border-t border-gray-200 dark:border-white/5 flex justify-end gap-3 rounded-b-2xl">
                    <button type="button" wire:click="$set('showingModal', false)" 
                            class="px-5 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-white/5 rounded-xl transition-all">
                        {{ __('Cancelar') }}
                    </button>
                    <button type="submit" 
                            class="px-6 py-2.5 text-sm font-bold text-white bg-primary hover:bg-primary-hover rounded-xl shadow-[0_8px_20px_-4px_rgba(var(--primary-rgb),0.5)] active:scale-95 transition-all">
                        {{ $unidadeId ? __('Salvar Alterações') : __('Criar Unidade') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>