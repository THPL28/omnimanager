<div class="flex-1 flex flex-col h-full min-w-0 overflow-hidden bg-background-light dark:bg-background-dark relative">
    {{-- Header Section --}}
    <header class="flex flex-col z-10 bg-background-light dark:bg-background-dark border-b border-gray-200 dark:border-white/5">
        {{-- Breadcrumbs --}}
        <div class="px-6 pt-6 pb-2">
            <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-[#92a4c9]">
                <a class="hover:text-primary dark:hover:text-white transition-colors" href="{{ route('dashboard') }}" wire:navigate>{{ __('Início') }}</a>
                <span class="text-xs">/</span>
                <span class="text-slate-900 dark:text-white font-medium">{{ __('Colaboradores') }}</span>
            </div>
        </div>

        {{-- Page Title & Actions --}}
        <div class="px-6 py-2 flex flex-wrap justify-between items-end gap-4">
            <div class="flex flex-col gap-1">
                <h2 class="text-slate-900 dark:text-white text-2xl font-bold tracking-tight">{{ __('Colaboradores') }}</h2>
                <p class="text-slate-500 dark:text-[#92a4c9] text-sm">{{ __('Gerencie o acesso e dados de todos os funcionários da corporação.') }}</p>
            </div>
            <button wire:click="showCreateModal" class="flex items-center gap-2 bg-primary hover:bg-primary-hover text-white px-4 py-2 rounded-lg text-sm font-bold transition-all shadow-lg shadow-primary/20 active:scale-95">
                <span class="material-symbols-outlined text-[20px]">person_add</span>
                <span>{{ __('Adicionar Colaborador') }}</span>
            </button>
        </div>

        {{-- Toolbar / Filters --}}
        <div class="px-6 py-4 flex flex-col sm:flex-row gap-3 items-center justify-between">
            <div class="relative w-full sm:max-w-md group">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 group-focus-within:text-primary transition-colors text-[20px]">search</span>
                <input 
                    wire:model.live.debounce.500ms="search" 
                    id="search-input"
                    class="w-full bg-white dark:bg-surface-dark border border-gray-200 dark:border-white/10 text-slate-900 dark:text-white text-sm rounded-lg pl-10 pr-4 py-2 focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600 shadow-sm" 
                    placeholder="{{ __('Buscar por nome, email ou CPF...') }}" 
                    type="text"
                    x-on:keydown.window.prevent.cmd.k="document.getElementById('search-input').focus()"
                    x-on:keydown.window.prevent.ctrl.k="document.getElementById('search-input').focus()"
                />
                <div class="absolute right-3 top-1/2 -translate-y-1/2 hidden sm:flex items-center gap-1">
                    <span class="text-[10px] font-mono text-slate-400 dark:text-slate-600 border border-gray-200 dark:border-white/10 rounded px-1.5 py-0.5">⌘K</span>
                </div>
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                @if($selectedUnidade !== 'Todos' || $selectedStatus !== 'Todos' || $search !== '')
                    <button wire:click="$set('selectedUnidade', 'Todos'); $set('selectedStatus', 'Todos'); $set('search', '')" class="text-xs font-semibold text-primary hover:text-primary-hover transition-colors px-2 py-1 underline-offset-4 hover:underline mr-2">
                        {{ __('Limpar Filtros') }}
                    </button>
                @endif

                {{-- Filter Unidade --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" 
                            class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white dark:bg-surface-dark hover:bg-gray-50 dark:hover:bg-white/5 text-slate-700 dark:text-white text-sm font-medium border {{ $selectedUnidade !== 'Todos' ? 'border-primary' : 'border-gray-200 dark:border-transparent' }} transition-colors whitespace-nowrap group shadow-sm">
                        <span class="material-symbols-outlined text-[18px] opacity-60">storefront</span>
                        <span>{{ __('Unidade') }}: {{ $selectedUnidade === 'Todos' ? __('Todos') : $selectedUnidade }}</span>
                        <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-slate-600 dark:text-slate-500 dark:group-hover:text-white transition-transform" :class="open ? 'rotate-180' : ''">keyboard_arrow_down</span>
                    </button>
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         @click.away="open = false" 
                         class="absolute right-0 mt-2 w-56 rounded-xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-white/10 shadow-2xl z-50 overflow-hidden ring-1 ring-black/5">
                        <div class="px-3 py-2 border-b border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-black/20">
                            <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __('Filtrar por Unidade') }}</span>
                        </div>
                        <div class="py-1 max-h-60 overflow-y-auto no-scrollbar">
                            <button wire:click="setFilterUnidade('Todos')" @click="open = false" class="w-full text-left px-4 py-2 text-sm {{ $selectedUnidade === 'Todos' ? 'text-primary bg-primary/5 font-semibold' : 'text-slate-700 dark:text-gray-300' }} hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">{{ __('Todas as Unidades') }}</button>
                            @foreach($unidades as $unidade)
                                <button wire:click="setFilterUnidade('{{ $unidade->nome_fantasia }}')" @click="open = false" class="w-full text-left px-4 py-2 text-sm {{ $selectedUnidade === $unidade->nome_fantasia ? 'text-primary bg-primary/5 font-semibold' : 'text-slate-700 dark:text-gray-300' }} hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">{{ $unidade->nome_fantasia }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Filter Status --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" 
                            class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white dark:bg-surface-dark hover:bg-gray-50 dark:hover:bg-white/5 text-slate-700 dark:text-white text-sm font-medium border {{ $selectedStatus !== 'Todos' ? 'border-primary' : 'border-gray-200 dark:border-transparent' }} transition-colors whitespace-nowrap group shadow-sm">
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
                            <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __('Estado') }}</span>
                        </div>
                        <div class="py-1">
                            <button wire:click="setFilterStatus('Todos')" @click="open = false" class="w-full text-left px-4 py-2 text-sm {{ $selectedStatus === 'Todos' ? 'text-primary bg-primary/5 font-semibold' : 'text-slate-700 dark:text-gray-300' }} hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">{{ __('Todos') }}</button>
                            <button wire:click="setFilterStatus('Ativo')" @click="open = false" class="w-full text-left px-4 py-2 text-sm {{ $selectedStatus === 'Ativo' ? 'text-primary bg-primary/5 font-semibold' : 'text-slate-700 dark:text-gray-300' }} hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">{{ __('Ativo') }}</button>
                            <button wire:click="setFilterStatus('Desligado')" @click="open = false" class="w-full text-left px-4 py-2 text-sm {{ $selectedStatus === 'Desligado' ? 'text-primary bg-primary/5 font-semibold' : 'text-slate-700 dark:text-gray-300' }} hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">{{ __('Desligado') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- Data Table --}}
    <div class="flex-1 overflow-auto p-6 pt-2 no-scrollbar">
        @if (session()->has('success'))
            <div class="mb-4 p-3 bg-emerald-500/10 border border-emerald-500/20 rounded-xl flex items-center gap-3 text-emerald-600 dark:text-emerald-400 text-sm animate-in fade-in slide-in-from-top-2">
                <span class="material-symbols-outlined text-[20px]">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        <div class="border border-gray-200 dark:border-white/5 rounded-xl overflow-hidden bg-white dark:bg-surface-dark shadow-sm">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-white/5">
                <thead class="bg-gray-50/50 dark:bg-surface-dark">
                    <tr>
                        <th class="px-6 py-4 text-left w-12" scope="col">
                            <input wire:model.live="selectAll" class="rounded border-gray-300 dark:border-white/20 bg-white dark:bg-white/5 text-primary focus:ring-0 size-4 cursor-pointer" type="checkbox"/>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest" scope="col">{{ __('Colaborador') }}</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest hidden md:table-cell" scope="col">{{ __('Cargo & Documentação') }}</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest hidden lg:table-cell" scope="col">{{ __('Unidade / Bandeira') }}</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest hidden xl:table-cell" scope="col">{{ __('Grupo') }}</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest" scope="col">{{ __('Status') }}</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest" scope="col">{{ __('Ações') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-white/5 bg-white dark:bg-background-dark">
                    @forelse ($colaboradores as $colaborador)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors group">
                            <td class="px-6 py-4">
                                <input value="{{ $colaborador->id }}" wire:model.live="selectedColaboradores" class="rounded border-gray-300 dark:border-white/20 bg-white dark:bg-white/5 text-primary focus:ring-0 size-4 cursor-pointer" type="checkbox"/>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="size-10 rounded-full bg-primary/10 text-primary border border-primary/20 flex items-center justify-center text-sm font-bold shrink-0 shadow-inner">
                                        {{ strtoupper(substr($colaborador->nome, 0, 2)) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors">{{ $colaborador->nome }}</span>
                                        <span class="text-[11px] text-slate-500 dark:text-[#92a4c9] font-medium">{{ $colaborador->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-slate-700 dark:text-gray-200">{{ $colaborador->cargo ?: __('Cargo não definido') }}</span>
                                    <span class="text-[10px] font-mono text-slate-500 dark:text-slate-500 uppercase tracking-tighter">{{ $colaborador->cpf }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 hidden lg:table-cell">
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-slate-700 dark:text-gray-300">{{ $colaborador->unidade->nome_fantasia ?? 'N/A' }}</span>
                                    <div class="flex items-center gap-1.5 mt-1">
                                        <div class="size-1.5 rounded-full bg-primary/60"></div>
                                        <span class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">{{ $colaborador->unidade->bandeira->nome ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 hidden xl:table-cell">
                                <span class="inline-flex items-center rounded-md bg-gray-100 dark:bg-white/5 px-2 py-1 text-[10px] font-bold text-slate-500 dark:text-slate-400 border border-gray-200 dark:border-white/5">
                                    {{ $colaborador->unidade->bandeira->grupoEconomico->nome ?? __('Global') }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div x-data="{ open: false }" class="relative inline-block text-left">
                                    <button @click="open = !open" class="flex items-center gap-1.5 hover:bg-gray-100 dark:hover:bg-white/5 px-2 py-1 rounded-lg transition-all group">
                                        @if($colaborador->status === 'Ativo')
                                            <div class="size-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.4)]"></div>
                                            <span class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">{{ __('Ativo') }}</span>
                                        @elseif($colaborador->status === 'Férias')
                                            <div class="size-1.5 rounded-full bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.4)]"></div>
                                            <span class="text-[11px] font-bold text-amber-600 dark:text-amber-400 uppercase tracking-widest">{{ __('Férias') }}</span>
                                        @else
                                            <div class="size-1.5 rounded-full bg-slate-400 shadow-[0_0_8px_rgba(148,163,184,0.4)]"></div>
                                            <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">{{ __('Desligado') }}</span>
                                        @endif
                                        <span class="material-symbols-outlined text-[14px] text-slate-400 group-hover:text-primary transition-colors">expand_more</span>
                                    </button>

                                    {{-- Status Action Menu --}}
                                    <div x-show="open" 
                                         x-transition:enter="transition ease-out duration-100"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         @click.away="open = false" 
                                         class="absolute left-0 mt-2 w-40 rounded-xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-white/10 shadow-2xl z-50 overflow-hidden ring-1 ring-black/5">
                                        <div class="px-3 py-2 border-b border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-black/20">
                                            <span class="text-[9px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __('Alterar Status') }}</span>
                                        </div>
                                        <div class="py-1">
                                            <button wire:click="updateColaboradorStatus({{ $colaborador->id }}, 'Ativo')" @click="open = false" class="w-full text-left px-4 py-2 text-xs font-semibold text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-500/10 transition-colors flex items-center gap-2">
                                                <div class="size-1.5 rounded-full bg-emerald-500"></div> {{ __('Ativo') }}
                                            </button>
                                            <button wire:click="updateColaboradorStatus({{ $colaborador->id }}, 'Férias')" @click="open = false" class="w-full text-left px-4 py-2 text-xs font-semibold text-amber-600 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-500/10 transition-colors flex items-center gap-2">
                                                <div class="size-1.5 rounded-full bg-amber-500"></div> {{ __('Férias') }}
                                            </button>
                                            <button wire:click="updateColaboradorStatus({{ $colaborador->id }}, 'Desligado')" @click="open = false" class="w-full text-left px-4 py-2 text-xs font-semibold text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-500/10 transition-colors flex items-center gap-2">
                                                <div class="size-1.5 rounded-full bg-slate-400"></div> {{ __('Desligado') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button wire:click="showEditModal({{ $colaborador->id }})" class="p-1.5 rounded-lg text-slate-400 hover:text-primary hover:bg-primary/10 transition-all">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </button>
                                    <button wire:click="deleteColaborador({{ $colaborador->id }})" wire:confirm="{{ __('Excluir este colaborador?') }}" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-500/10 transition-all">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center gap-3 opacity-30">
                                    <span class="material-symbols-outlined text-[48px]">group_off</span>
                                    <p class="text-sm font-bold uppercase tracking-widest text-slate-500">{{ __('Nenhum colaborador encontrado') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $colaboradores->links() }}
        </div>
    </div>

    {{-- Modal --}}
    @if ($showingModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm animate-in fade-in duration-200">
        <div class="bg-white dark:bg-surface-dark rounded-2xl shadow-2xl w-full max-w-lg border border-gray-200 dark:border-white/10 animate-in zoom-in-95 duration-200">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-white/5 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <div class="size-8 rounded-lg bg-primary/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-[20px]">{{ $colaboradorId ? 'edit' : 'person_add' }}</span>
                    </div>
                    {{ $colaboradorId ? __('Editar Colaborador') : __('Novo Colaborador') }}
                </h3>
                <button wire:click="$set('showingModal', false)" class="size-8 flex items-center justify-center rounded-lg hover:bg-gray-100 dark:hover:bg-white/5 text-slate-400 hover:text-slate-500 transition-colors">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>
            
            <form wire:submit.prevent="saveColaborador">
                <div class="p-6 space-y-5">
                    {{-- Unidade Selector --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">{{ __('Unidade de Alocação') }}</label>
                        <select wire:model="unidade_id" class="w-full bg-gray-50 dark:bg-background-dark border border-gray-200 dark:border-white/5 text-slate-900 dark:text-white text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all shadow-inner font-medium">
                            <option value="">{{ __('Selecione uma Unidade') }}</option>
                            @foreach($unidades as $un)
                                <option value="{{ $un->id }}">{{ $un->nome_fantasia }}</option>
                            @endforeach
                        </select>
                        @error('unidade_id') <span class="text-red-500 text-[11px] font-semibold mt-1 block pl-1 italic">{{ $message }}</span> @enderror
                    </div>

                    {{-- Nome --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">{{ __('Nome Completo') }}</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-slate-400 group-focus-within:text-primary transition-colors">person</span>
                            <input type="text" wire:model.live="nome" class="w-full bg-gray-50 dark:bg-background-dark border border-gray-200 dark:border-white/5 text-slate-900 dark:text-white text-sm rounded-xl pl-10 pr-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder:text-slate-400 shadow-inner" placeholder="{{ __('Ex: Ana Silva') }}">
                        </div>
                        @error('nome') <span class="text-red-500 text-[11px] font-semibold mt-1 block pl-1 italic">{{ $message }}</span> @enderror
                    </div>

                    {{-- Cargo --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">{{ __('Cargo / Função') }}</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-slate-400 group-focus-within:text-primary transition-colors">work</span>
                            <input type="text" wire:model.live="cargo" class="w-full bg-gray-50 dark:bg-background-dark border border-gray-200 dark:border-white/5 text-slate-900 dark:text-white text-sm rounded-xl pl-10 pr-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder:text-slate-400 shadow-inner" placeholder="{{ __('Ex: Gerente de Operações') }}">
                        </div>
                        @error('cargo') <span class="text-red-500 text-[11px] font-semibold mt-1 block pl-1 italic">{{ $message }}</span> @enderror
                    </div>

                    {{-- Email --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">{{ __('E-mail Corporativo') }}</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-slate-400 group-focus-within:text-primary transition-colors">mail</span>
                            <input type="email" wire:model.live="email" class="w-full bg-gray-50 dark:bg-background-dark border border-gray-200 dark:border-white/5 text-slate-900 dark:text-white text-sm rounded-xl pl-10 pr-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder:text-slate-400 shadow-inner" placeholder="{{ __('ana@gestao.corp') }}">
                        </div>
                        @error('email') <span class="text-red-500 text-[11px] font-semibold mt-1 block pl-1 italic">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        {{-- CPF --}}
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">CPF</label>
                            <div class="relative group">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-slate-400 group-focus-within:text-primary transition-colors">fingerprint</span>
                                <input type="text" wire:model.live="cpf" maxlength="11" class="w-full bg-gray-50 dark:bg-background-dark border border-gray-200 dark:border-white/5 text-slate-900 dark:text-white text-sm font-mono rounded-xl pl-10 pr-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder:text-slate-400 shadow-inner" placeholder="00000000000">
                            </div>
                            @error('cpf') <span class="text-red-500 text-[11px] font-semibold mt-1 block pl-1 italic">{{ $message }}</span> @enderror
                        </div>

                        {{-- Status --}}
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">{{ __('Status Atual') }}</label>
                            <select wire:model="status" class="w-full bg-gray-50 dark:bg-background-dark border border-gray-200 dark:border-white/5 text-slate-900 dark:text-white text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all shadow-inner font-bold uppercase tracking-wider">
                                <option value="Ativo">{{ __('Ativo') }}</option>
                                <option value="Férias">{{ __('Férias') }}</option>
                                <option value="Desligado">{{ __('Desligado') }}</option>
                            </select>
                            @error('status') <span class="text-red-500 text-[11px] font-semibold mt-1 block pl-1 italic">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="p-6 pt-2 bg-gray-50/50 dark:bg-black/10 border-t border-gray-200 dark:border-white/5 flex justify-end gap-3 rounded-b-2xl">
                    <button type="button" wire:click="$set('showingModal', false)" class="px-5 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-white/5 rounded-xl transition-all">
                        {{ __('Cancelar') }}
                    </button>
                    <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-primary hover:bg-primary-hover rounded-xl shadow-lg shadow-primary/20 active:scale-95 transition-all">
                        {{ $colaboradorId ? __('Salvar Alterações') : __('Criar Colaborador') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>