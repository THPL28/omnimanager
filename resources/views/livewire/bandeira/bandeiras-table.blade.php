<div class="flex-1 flex flex-col h-full min-w-0 overflow-hidden bg-background-light dark:bg-background-dark relative">
    {{-- Header --}}
    <header class="flex flex-col z-10 bg-background-light dark:bg-background-dark border-b border-gray-200 dark:border-white/5">
        <div class="px-6 pt-6 pb-2">
            <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-[#92a4c9]">
                <a class="hover:text-primary dark:hover:text-white transition-colors" href="{{ route('dashboard') }}" wire:navigate>{{ __('Início') }}</a>
                <span class="text-xs">/</span>
                <span class="text-slate-900 dark:text-white font-medium">{{ __('Bandeiras') }}</span>
            </div>
        </div>

        <div class="px-6 py-2 flex flex-wrap justify-between items-end gap-4">
            <div class="flex flex-col gap-1">
                <h2 class="text-slate-900 dark:text-white text-2xl font-bold tracking-tight">{{ __('Bandeiras') }}</h2>
                <p class="text-slate-500 dark:text-[#92a4c9] text-sm">{{ __('Gerencie as marcas comerciais e suas vinculações aos grupos econômicos.') }}</p>
            </div>
            <button wire:click="showCreateModal" class="flex items-center gap-2 bg-primary hover:bg-primary-hover text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors shadow-lg shadow-primary/20 border border-white/5">
                <span class="material-symbols-outlined text-[20px]">add</span>
                <span>{{ __('Criar Bandeira') }}</span>
            </button>
        </div>

        <div class="px-6 py-4 flex flex-col lg:flex-row gap-4 items-start lg:items-center justify-between">
            <div class="relative w-full lg:max-w-md group">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 group-focus-within:text-primary transition-colors text-[20px]">search</span>
                <input 
                    wire:model.live.debounce.500ms="search" 
                    id="search-input"
                    class="w-full bg-white dark:bg-surface-dark border border-gray-200 dark:border-white/10 text-slate-900 dark:text-white text-sm rounded-lg pl-10 pr-4 py-2 focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600 shadow-sm" 
                    placeholder="{{ __('Buscar por nome, grupo ou código...') }}" 
                    type="text"
                    x-on:keydown.window.prevent.cmd.k="document.getElementById('search-input').focus()"
                    x-on:keydown.window.prevent.ctrl.k="document.getElementById('search-input').focus()"
                />
                <div class="absolute right-3 top-1/2 -translate-y-1/2 hidden sm:flex items-center gap-1">
                    <span class="text-[10px] font-mono text-slate-400 dark:text-slate-600 border border-gray-200 dark:border-white/10 rounded px-1.5 py-0.5">⌘K</span>
                </div>
            </div>
            
            <div class="flex items-center flex-wrap gap-2">
                @if($selectedGrupo !== 'Todos' || $selectedStatus !== 'Todos' || $search !== '')
                    <button wire:click="$set('selectedGrupo', 'Todos'); $set('selectedStatus', 'Todos'); $set('search', '')" class="text-xs font-semibold text-primary hover:text-primary-hover transition-colors px-2 py-1 underline-offset-4 hover:underline mr-2">
                        {{ __('Limpar Filtros') }}
                    </button>
                @endif

                <div class="h-4 w-px bg-gray-300 dark:bg-white/10 mx-1 hidden sm:block"></div>
                
                {{-- Dropdown Grupo --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" 
                            class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white dark:bg-surface-dark hover:bg-gray-50 dark:hover:bg-white/5 text-slate-700 dark:text-white text-sm font-medium border {{ $selectedGrupo !== 'Todos' ? 'border-primary text-primary' : 'border-gray-200 dark:border-white/10' }} transition-all whitespace-nowrap group">
                        <span class="material-symbols-outlined text-[18px] opacity-60">domain</span>
                        <span>{{ __('Grupo') }}: {{ $selectedGrupo === 'Todos' ? __('Todos') : $selectedGrupo }}</span>
                        <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-slate-600 dark:text-slate-500 dark:group-hover:text-white transition-transform" :class="open ? 'rotate-180' : ''">keyboard_arrow_down</span>
                    </button>
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         @click.away="open = false" 
                         class="absolute right-0 mt-2 w-56 rounded-xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-white/10 shadow-2xl z-50 overflow-hidden ring-1 ring-black/5">
                        <div class="px-3 py-2 border-b border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-black/20">
                            <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __('Filtrar por Grupo') }}</span>
                        </div>
                        <div class="py-1 max-h-60 overflow-y-auto no-scrollbar">
                            <button wire:click="setFilterGrupo('Todos')" @click="open = false" class="w-full text-left px-4 py-2 text-sm {{ $selectedGrupo === 'Todos' ? 'text-primary bg-primary/5' : 'text-slate-700 dark:text-gray-300' }} hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">{{ __('Todos os Grupos') }}</button>
                            @foreach($grupos as $grupo)
                                <button wire:click="setFilterGrupo('{{ $grupo->nome }}')" @click="open = false" class="w-full text-left px-4 py-2 text-sm {{ $selectedGrupo === $grupo->nome ? 'text-primary bg-primary/5' : 'text-slate-700 dark:text-gray-300' }} hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">{{ $grupo->nome }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Dropdown Status --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" 
                            class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white dark:bg-surface-dark hover:bg-gray-50 dark:hover:bg-white/5 text-slate-700 dark:text-white text-sm font-medium border {{ $selectedStatus !== 'Todos' ? 'border-primary text-primary' : 'border-gray-200 dark:border-white/10' }} transition-all whitespace-nowrap group">
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
                            <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __('Estado da Bandeira') }}</span>
                        </div>
                        <div class="py-1">
                            <button wire:click="setFilterStatus('Todos')" @click="open = false" class="w-full text-left px-4 py-2 text-sm {{ $selectedStatus === 'Todos' ? 'text-primary bg-primary/5' : 'text-slate-700 dark:text-gray-300' }} hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">{{ __('Todos') }}</button>
                            <button wire:click="setFilterStatus('Ativo')" @click="open = false" class="w-full text-left px-4 py-2 text-sm {{ $selectedStatus === 'Ativo' ? 'text-primary bg-primary/5' : 'text-slate-700 dark:text-gray-300' }} hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">{{ __('Ativo') }}</button>
                            <button wire:click="setFilterStatus('Inativo')" @click="open = false" class="w-full text-left px-4 py-2 text-sm {{ $selectedStatus === 'Inativo' ? 'text-primary bg-primary/5' : 'text-slate-700 dark:text-gray-300' }} hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">{{ __('Inativo') }}</button>
                        </div>
                    </div>
                </div>

                @if (session()->has('success'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 text-sm animate-in fade-in slide-in-from-right-4">
                        <span class="material-symbols-outlined text-[18px]">check_circle</span>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
            </div>
        </div>
    </header>

    {{-- Content --}}
    <div class="flex-1 overflow-auto p-6 pt-2">
        <div class="min-w-full inline-block align-middle">
            <div class="border border-gray-200 dark:border-white/10 rounded-lg overflow-hidden bg-white dark:bg-surface-dark">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-white/5">
                    <thead class="bg-gray-50 dark:bg-surface-dark">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider w-[60px]" scope="col">
                                <div class="flex items-center">
                                    <input wire:model.live="selectAll" class="rounded border-gray-300 dark:border-white/20 bg-white dark:bg-white/5 text-primary focus:ring-0 focus:ring-offset-0 size-4 cursor-pointer" type="checkbox"/>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider cursor-pointer hover:text-primary dark:hover:text-white transition-colors group" scope="col">
                                <div class="flex items-center gap-1">
                                    {{ __('Bandeira') }}
                                    <span class="material-symbols-outlined text-[14px] opacity-0 group-hover:opacity-100 transition-opacity">arrow_downward</span>
                                </div>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider hidden md:table-cell" scope="col">{{ __('Grupo Econômico') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider hidden lg:table-cell" scope="col">{{ __('Código') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider hidden xl:table-cell" scope="col">{{ __('Unidades') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider" scope="col">{{ __('Status') }}</th>
                            <th class="relative px-6 py-3 text-right" scope="col">
                                <span class="sr-only">{{ __('Ações') }}</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-white/5 bg-white dark:bg-[#12161f]">
                        @forelse ($bandeiras as $bandeira)
                            <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02] transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input wire:model.live="selectedBandeiras" value="{{ $bandeira->id }}" class="rounded border-gray-300 dark:border-white/20 bg-white dark:bg-white/5 text-primary focus:ring-0 focus:ring-offset-0 size-4 opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer" type="checkbox"/>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="size-8 rounded-lg bg-primary/10 dark:bg-primary/20 border border-primary/20 flex items-center justify-center text-primary shrink-0">
                                            <span class="material-symbols-outlined text-[18px]">flag</span>
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-slate-900 dark:text-white">{{ $bandeira->nome }}</span>
                                            <span class="text-xs text-slate-500">ID: {{ $bandeira->id }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap hidden md:table-cell">
                                    <div class="flex items-center gap-2">
                                        <div class="size-2 rounded-full bg-primary"></div>
                                        <span class="text-sm text-slate-600 dark:text-slate-300">{{ $bandeira->grupoEconomico->nome ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap hidden lg:table-cell">
                                    <span class="font-mono text-xs text-slate-500 dark:text-slate-500 bg-slate-100 dark:bg-white/5 px-1.5 py-0.5 rounded border border-slate-200 dark:border-white/10">BAN-{{ str_pad($bandeira->id, 3, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap hidden xl:table-cell">
                                    <span class="text-sm text-slate-600 dark:text-slate-300">{{ $bandeira->unidades_count }} {{ __('Unidades') }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-2 py-1 text-xs font-medium text-emerald-700 bg-emerald-50 dark:text-emerald-400 dark:bg-emerald-500/10 border border-emerald-200 dark:border-emerald-500/20">
                                        <span class="size-1.5 rounded-full bg-emerald-500 dark:bg-emerald-400"></span>
                                        {{ __('Ativo') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-2">
                                        <button wire:click="showEditModal({{ $bandeira->id }})" class="text-slate-400 hover:text-primary transition-colors p-1 rounded-md hover:bg-gray-100 dark:hover:bg-white/10" title="{{ __('Editar') }}">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </button>
                                        <button wire:click="deleteBandeira({{ $bandeira->id }})" wire:confirm="{{ __('Tem certeza que deseja excluir esta bandeira?') }}" class="text-slate-400 hover:text-red-500 transition-colors p-1 rounded-md hover:bg-gray-100 dark:hover:bg-white/10" title="{{ __('Excluir') }}">
                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center gap-2 text-slate-500">
                                        <span class="material-symbols-outlined text-[48px] opacity-20">flag_circle</span>
                                        <p class="text-sm">{{ __('Nenhuma bandeira encontrada.') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $bandeiras->links() }}
            </div>
        </div>
    </div>

    {{-- Modal --}}
    @if ($showingModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm animate-in fade-in duration-200">
        <div class="bg-white dark:bg-surface-dark rounded-xl shadow-2xl w-full max-w-lg border border-gray-200 dark:border-white/10 animate-in zoom-in-95 duration-200">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-white/5 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <div class="size-8 rounded-lg bg-primary/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-[20px]">{{ $bandeiraId ? 'edit' : 'add_circle' }}</span>
                    </div>
                    {{ $bandeiraId ? __('Editar Bandeira') : __('Nova Bandeira') }}
                </h3>
                <button wire:click="$set('showingModal', false)" class="size-8 flex items-center justify-center rounded-lg hover:bg-gray-100 dark:hover:bg-white/5 text-slate-400 hover:text-slate-500 transition-colors">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>
            
            <form wire:submit.prevent="saveBandeira">
                <div class="p-6 space-y-5">
                    {{-- Nome da Bandeira --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">{{ __('Nome da Bandeira') }}</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-slate-400 group-focus-within:text-primary transition-colors">flag</span>
                            <input type="text" wire:model.live="nome" 
                                class="w-full bg-gray-50 dark:bg-background-dark border border-gray-200 dark:border-white/5 text-slate-900 dark:text-white text-sm rounded-xl pl-10 pr-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600 shadow-inner" 
                                placeholder="{{ __('Ex: Farmácia Popular') }}">
                        </div>
                        @error('nome') <span class="text-red-500 text-[11px] font-semibold mt-1 block pl-1 italic"> {{ $message }}</span> @enderror
                    </div>

                    {{-- Grupo Econômico --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">{{ __('Grupo Econômico') }}</label>
                        <div x-data="{ 
                            open: false, 
                            search: '',
                            selectedId: @entangle('grupo_economico_id'),
                            selectedNome: '{{ $grupo_economico_id ? $grupos->find($grupo_economico_id)?->nome : __('Selecione um Grupo') }}',
                            get filteredGrupos() {
                                if (!this.search) return @js($grupos);
                                return @js($grupos).filter(g => g.nome.toLowerCase().includes(this.search.toLowerCase()));
                            },
                            init() {
                                this.$watch('selectedId', (val) => {
                                    if (!val) {
                                        this.selectedNome = '{{ __('Selecione um Grupo') }}';
                                        return;
                                    }
                                    const grupos = @js($grupos);
                                    const found = grupos.find(g => g.id == val);
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
                                    <span class="material-symbols-outlined text-[20px] text-slate-400 group-hover:text-primary transition-colors shrink-0">domain</span>
                                    <span x-text="selectedNome" class="truncate font-medium" :class="selectedId ? 'text-slate-900 dark:text-white' : 'text-slate-400 dark:text-slate-500'"></span>
                                </div>
                                <span class="material-symbols-outlined text-[22px] text-slate-400 transition-transform shrink-0" :class="open ? 'rotate-180' : ''">keyboard_arrow_down</span>
                            </button>

                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="transform opacity-0 -translate-y-2 scale-[0.98]"
                                 x-transition:enter-end="transform opacity-100 translate-y-0 scale-100"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="transform opacity-100 translate-y-0 scale-100"
                                 x-transition:leave-end="transform opacity-0 -translate-y-2 scale-[0.98]"
                                 @click.away="open = false" 
                                 class="absolute left-0 mt-2 w-full rounded-2xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-white/10 shadow-[0_20px_50px_rgba(0,0,0,0.3)] z-[70] overflow-hidden ring-1 ring-black/5">
                                
                                <div class="p-3 border-b border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-black/20">
                                    <div class="relative">
                                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[18px] text-slate-400">search</span>
                                        <input type="text" x-model="search" placeholder="{{ __('Buscar grupo...') }}" 
                                               class="w-full bg-white dark:bg-background-dark border border-gray-200 dark:border-white/10 text-xs rounded-lg pl-9 pr-3 py-2 focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all placeholder:text-slate-500">
                                    </div>
                                </div>

                                <div class="py-1.5 max-h-60 overflow-y-auto no-scrollbar">
                                    <div class="px-4 py-2 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __('Lista de Grupos') }}</div>
                                    <template x-if="filteredGrupos.length === 0">
                                        <div class="px-4 py-6 text-sm text-slate-500 text-center italic flex flex-col items-center gap-2">
                                            <span class="material-symbols-outlined text-slate-300 text-[32px]">search_off</span>
                                            {{ __('Nenhum grupo encontrado') }}
                                        </div>
                                    </template>
                                    <template x-for="grupo in filteredGrupos" :key="grupo.id">
                                        <button type="button" @click="select(grupo.id, grupo.nome)" 
                                                class="w-full text-left px-4 py-2.5 text-sm transition-all flex items-center justify-between group/item mx-1 rounded-lg w-[calc(100%-8px)]"
                                                :class="selectedId == grupo.id ? 'text-primary bg-primary/5 font-bold' : 'text-slate-700 dark:text-gray-300 hover:bg-slate-100 dark:hover:bg-white/5'">
                                            <div class="flex items-center gap-3">
                                                <div class="size-2 rounded-full transition-all shadow-[0_0_8px_currentColor]" :class="selectedId == grupo.id ? 'bg-primary scale-110' : 'bg-slate-200 dark:bg-white/10 group-hover/item:bg-slate-300 dark:group-hover/item:bg-white/20'"></div>
                                                <span x-text="grupo.nome"></span>
                                            </div>
                                            <span x-show="selectedId == grupo.id" class="material-symbols-outlined text-[18px] animate-in zoom-in-50 duration-200">check_circle</span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>
                        @error('grupo_economico_id') <span class="text-red-500 text-[11px] font-semibold mt-1 block pl-1 italic">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="p-6 pt-2 bg-gray-50/50 dark:bg-black/10 border-t border-gray-200 dark:border-white/5 flex justify-end gap-3 rounded-b-xl">
                    <button type="button" wire:click="$set('showingModal', false)" 
                            class="px-5 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-white/5 rounded-xl transition-all">
                        {{ __('Cancelar') }}
                    </button>
                    <button type="submit" 
                            class="px-6 py-2.5 text-sm font-bold text-white bg-primary hover:bg-primary-hover rounded-xl shadow-[0_8px_20px_-4px_rgba(var(--primary-rgb),0.5)] active:scale-95 transition-all">
                        {{ $bandeiraId ? __('Salvar Alterações') : __('Criar Bandeira') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>