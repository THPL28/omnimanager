<div class="max-w-[1400px] w-full flex flex-col gap-6">
    <!-- Page Header & Main Actions -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div class="flex flex-col gap-1">
            <h2 class="text-slate-900 dark:text-white text-3xl font-bold tracking-tight">{{ __('Grupos Econômicos') }}</h2>
            <p class="text-slate-500 dark:text-text-secondary text-base max-w-2xl">{{ __('Gerencie a estrutura corporativa, holdings e vinculações de empresas.') }}</p>
        </div>
        <div class="flex items-center gap-3">
            <button wire:click="exportCsv" class="hidden sm:flex h-9 items-center justify-center gap-2 px-3 rounded-lg border border-gray-200 dark:border-border-dark bg-white dark:bg-surface-dark text-slate-700 dark:text-slate-300 text-sm font-medium hover:bg-slate-50 dark:hover:bg-white/5 transition-colors shadow-sm">
                <span class="material-symbols-outlined text-[18px]">download</span>
                {{ __('Exportar') }}
            </button>
            <button wire:click="showCreateModal" class="flex h-9 items-center justify-center gap-2 px-4 rounded-lg bg-primary hover:bg-primary-hover text-white text-sm font-medium shadow-lg shadow-blue-500/20 transition-all active:scale-95">
                <span class="material-symbols-outlined text-[20px]">add</span>
                {{ __('Criar Grupo') }}
            </button>
        </div>
    </div>

    <!-- Filters & Controls Toolbar -->
    <div class="flex flex-col lg:flex-row gap-4 justify-between items-start lg:items-center bg-white dark:bg-surface-dark p-1 rounded-xl border border-gray-200 dark:border-border-dark shadow-sm">
        <!-- Left Side: Search & Chips -->
        <div class="flex flex-col sm:flex-row items-center gap-2 w-full lg:w-auto p-1">
            <!-- Local Search -->
            <div class="relative w-full sm:w-64">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">filter_list</span>
                <input wire:model.live.debounce.300ms="search" class="w-full bg-slate-50 dark:bg-background-dark border border-gray-200 dark:border-border-dark rounded-lg pl-10 pr-3 py-2 text-sm text-slate-900 dark:text-white placeholder:text-slate-500 focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary transition-all" placeholder="{{ __('Filtrar por nome, CNPJ...') }}"/>
            </div>
            <div class="h-6 w-px bg-gray-200 dark:bg-border-dark hidden sm:block mx-1"></div>
            <!-- Chips -->
            <div class="flex items-center gap-1 w-full sm:w-auto overflow-x-auto no-scrollbar pb-1 sm:pb-0">
                <button wire:click="setStatusFilter('')" class="px-3 py-1.5 rounded-md text-xs font-medium whitespace-nowrap border transition-colors {{ $status === '' ? 'bg-slate-100 dark:bg-white/10 text-slate-900 dark:text-white border-transparent' : 'bg-transparent text-slate-600 dark:text-slate-400 border-transparent hover:bg-slate-50 dark:hover:bg-white/5' }}">
                    {{ __('Todos') }}
                </button>
                <button wire:click="setStatusFilter('ativo')" class="px-3 py-1.5 rounded-md text-xs font-medium whitespace-nowrap transition-colors flex items-center gap-1.5 border {{ $status === 'ativo' ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-500/20' : 'bg-transparent text-slate-600 dark:text-slate-400 border-transparent hover:bg-slate-50 dark:hover:bg-white/5' }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> {{ __('Ativos') }}
                </button>
                <button wire:click="setStatusFilter('pendente')" class="px-3 py-1.5 rounded-md text-xs font-medium whitespace-nowrap transition-colors flex items-center gap-1.5 border {{ $status === 'pendente' ? 'bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border-amber-200 dark:border-amber-500/20' : 'bg-transparent text-slate-600 dark:text-slate-400 border-transparent hover:bg-slate-50 dark:hover:bg-white/5' }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> {{ __('Pendentes') }}
                </button>
                <button wire:click="setStatusFilter('arquivado')" class="px-3 py-1.5 rounded-md text-xs font-medium whitespace-nowrap transition-colors flex items-center gap-1.5 border {{ $status === 'arquivado' ? 'bg-slate-100 dark:bg-white/10 text-slate-700 dark:text-slate-300 border-slate-200 dark:border-white/10' : 'bg-transparent text-slate-600 dark:text-slate-400 border-transparent hover:bg-slate-50 dark:hover:bg-white/5' }}">
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-500"></span> {{ __('Arquivados') }}
                </button>
            </div>
        </div>
        <!-- Right Side: View Options -->
        <div class="flex items-center gap-2 px-2 w-full lg:w-auto justify-end">
            @if(count($selected) > 0)
                <button wire:click="deleteSelected" wire:confirm="{{ __('Excluir :count grupos selecionados?', ['count' => count($selected)]) }}" class="mr-2 flex items-center gap-2 text-xs font-semibold text-red-600 bg-red-50 dark:bg-red-500/10 dark:text-red-400 px-3 py-1.5 rounded-lg border border-red-200 dark:border-red-500/20 hover:bg-red-100 transition-colors">
                    <span class="material-symbols-outlined text-[16px]">delete</span>
                    {{ __('Excluir') }} ({{ count($selected) }})
                </button>
            @endif

            <span class="text-xs text-slate-400 hidden sm:inline-block mr-2">{{ __('Mostrando') }} {{ $grupos->firstItem() ?? 0 }}-{{ $grupos->lastItem() ?? 0 }} {{ __('de') }} {{ $grupos->total() }}</span>
            <div class="flex bg-slate-100 dark:bg-background-dark rounded-lg p-0.5 border border-gray-200 dark:border-border-dark">
                <button wire:click="setViewMode('table')" class="p-1.5 rounded transition-colors {{ $viewMode === 'table' ? 'bg-white dark:bg-surface-dark shadow-sm text-slate-900 dark:text-white' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
                    <span class="material-symbols-outlined text-[18px] block">table_rows</span>
                </button>
                <button wire:click="setViewMode('grid')" class="p-1.5 rounded transition-colors {{ $viewMode === 'grid' ? 'bg-white dark:bg-surface-dark shadow-sm text-slate-900 dark:text-white' : 'text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
                    <span class="material-symbols-outlined text-[18px] block">grid_view</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Data Display -->
    @if($viewMode === 'table')
        <!-- Table View -->
        <div class="w-full overflow-hidden rounded-xl border border-gray-200 dark:border-border-dark bg-white dark:bg-surface-dark shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-border-dark bg-slate-50/50 dark:bg-white/[0.02]">
                            <th class="py-3 px-4 w-10">
                                <input wire:model.live="selectAll" class="rounded border-gray-300 dark:border-slate-600 bg-white dark:bg-surface-dark text-primary focus:ring-offset-0 focus:ring-primary/20 cursor-pointer" type="checkbox"/>
                            </th>
                            <th wire:click="sortBy('nome')" class="py-3 px-4 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-text-secondary cursor-pointer hover:text-slate-700 dark:hover:text-white group select-none">
                                <div class="flex items-center gap-1">
                                    {{ __('Grupo Econômico') }}
                                    @if($sortField === 'nome')
                                        <span class="material-symbols-outlined text-[14px] {{ $sortDirection === 'asc' ? 'rotate-180' : '' }} transition-transform">arrow_downward</span>
                                    @else
                                        <span class="material-symbols-outlined text-[14px] opacity-0 group-hover:opacity-100 transition-opacity">arrow_downward</span>
                                    @endif
                                </div>
                            </th>
                            <th class="py-3 px-4 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-text-secondary">{{ __('CNPJ Master') }}</th>
                            <th class="py-3 px-4 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-text-secondary">{{ __('Vinculações') }}</th>
                            <th class="py-3 px-4 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-text-secondary">{{ __('Responsável') }}</th>
                            <th class="py-3 px-4 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-text-secondary">{{ __('Status') }}</th>
                            <th class="py-3 px-4 text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-text-secondary text-right">{{ __('Ações') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/[0.04]">
                        @forelse($grupos as $grupo)
                        {{-- Row --}}
                        <tr class="group hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors cursor-pointer {{ $grupo->status === 'arquivado' ? 'opacity-70 bg-slate-50/50 dark:bg-surface-dark/50' : '' }} {{ in_array($grupo->id, $selected) ? 'bg-primary/5 dark:bg-primary/10' : '' }}">
                            <td class="py-3 px-4">
                                <input wire:model.live="selected" value="{{ $grupo->id }}" class="rounded border-gray-300 dark:border-slate-600 bg-transparent text-primary focus:ring-offset-0 focus:ring-primary/20 cursor-pointer" type="checkbox"/>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="size-8 rounded {{ $grupo->status === 'arquivado' ? 'bg-slate-500/10 text-slate-500 dark:text-slate-400' : 'bg-indigo-500/10 text-indigo-600 dark:text-indigo-400' }} flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-[18px]">{{ $grupo->status === 'arquivado' ? 'archive' : 'business' }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium {{ $grupo->status === 'arquivado' ? 'text-slate-500 dark:text-slate-400 line-through' : 'text-slate-900 dark:text-white group-hover:text-primary' }} transition-colors">{{ $grupo->nome }}</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-500 mt-0.5">{{ __('Atualizado há') }} {{ rand(1, 24) }}h</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="font-mono text-sm {{ $grupo->status === 'arquivado' ? 'text-slate-400 dark:text-slate-600 line-through' : 'text-slate-600 dark:text-slate-400' }}">
                                    {{ $grupo->cnpj ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="inline-flex items-center px-2 py-1 rounded-md bg-slate-100 dark:bg-white/5 border border-transparent dark:border-white/5">
                                    <span class="material-symbols-outlined text-[14px] text-slate-500 mr-1.5">domain_add</span>
                                    <span class="text-xs font-medium text-slate-700 dark:text-slate-300">{{ rand(1, 15) }} {{ __('Empresas') }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2">
                                    <div class="size-6 rounded-full bg-cover bg-center border border-white dark:border-surface-dark shadow-sm bg-indigo-500 text-white text-[10px] font-bold flex items-center justify-center">
                                        {{ substr($grupo->responsavel ?? ($grupo->nome ?? 'A'), 0, 2) }}
                                    </div>
                                    <span class="text-sm text-slate-700 dark:text-slate-300">{{ $grupo->responsavel ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                @if($grupo->status === 'ativo')
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full border border-emerald-200 dark:border-emerald-500/20 bg-emerald-50 dark:bg-emerald-500/10">
                                        <span class="relative flex h-2 w-2">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                                        </span>
                                        <span class="text-xs font-medium text-emerald-700 dark:text-emerald-400">{{ __('Ativo') }}</span>
                                    </div>
                                @elseif($grupo->status === 'pendente')
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full border border-amber-200 dark:border-amber-500/20 bg-amber-50 dark:bg-amber-500/10">
                                        <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                                        <span class="text-xs font-medium text-amber-700 dark:text-amber-400">{{ __('Pendente') }}</span>
                                    </div>
                                @else
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800">
                                        <span class="h-2 w-2 rounded-full bg-slate-400"></span>
                                        <span class="text-xs font-medium text-slate-500 dark:text-slate-400">{{ __('Arquivado') }}</span>
                                    </div>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right">
                                 <div class="flex items-center justify-end gap-2">
                                     <button wire:click="showEditModal({{ $grupo->id }})" class="text-slate-400 hover:text-slate-900 dark:hover:text-white p-1 rounded hover:bg-slate-200 dark:hover:bg-white/10 transition-colors">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </button>
                                    <button wire:click="deleteGrupo({{ $grupo->id }})" wire:confirm="{{ __('Tem certeza que deseja excluir?') }}" class="text-slate-400 hover:text-red-600 dark:hover:text-red-400 p-1 rounded hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                 </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-500 dark:text-gray-400">
                                <div class="flex flex-col items-center">
                                    <span class="material-symbols-outlined text-4xl mb-2 text-slate-300 dark:text-slate-600">search_off</span>
                                    <p>{{ __('Nenhum grupo encontrado com os filtros atuais.') }}</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <!-- Grid View -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($grupos as $grupo)
            <div class="bg-white dark:bg-surface-dark rounded-xl border border-gray-200 dark:border-border-dark p-6 shadow-sm hover:shadow-md transition-shadow group relative {{ in_array($grupo->id, $selected) ? 'ring-2 ring-primary bg-primary/5' : '' }}">
                <div class="absolute top-4 right-4">
                    <input wire:model.live="selected" value="{{ $grupo->id }}" type="checkbox" class="rounded border-gray-300 dark:border-slate-600 text-primary focus:ring-primary/20 bg-transparent">
                </div>

                <div class="flex items-center gap-4 mb-4">
                   <div class="size-12 rounded-lg {{ $grupo->status === 'arquivado' ? 'bg-slate-500/10 text-slate-500' : 'bg-indigo-500/10 text-indigo-600 dark:text-indigo-400' }} flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[24px]">{{ $grupo->status === 'arquivado' ? 'archive' : 'business' }}</span>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-slate-900 dark:text-white line-clamp-1">{{ $grupo->nome }}</h3>
                        <p class="text-xs font-mono text-slate-500 dark:text-slate-400">{{ $grupo->cnpj ?? 'N/A' }}</p>
                    </div>
                </div>
                
                <div class="space-y-3 mb-6">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-500 dark:text-slate-400">{{ __('Vinculações') }}</span>
                        <div class="flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px] text-slate-400">domain</span>
                            <span class="font-medium text-slate-700 dark:text-slate-300">{{ rand(1, 15) }} {{ __('Empresas') }}</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-500 dark:text-slate-400">{{ __('Responsável') }}</span>
                         <div class="flex items-center gap-2">
                            <div class="size-5 rounded-full bg-indigo-500 text-white text-[9px] font-bold flex items-center justify-center">
                                {{ substr($grupo->responsavel ?? ($grupo->nome ?? 'A'), 0, 2) }}
                            </div>
                            <span class="font-medium text-slate-700 dark:text-slate-300 truncate max-w-[100px]">{{ $grupo->responsavel ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-500 dark:text-slate-400">{{ __('Status') }}</span>
                         @if($grupo->status === 'ativo')
                            <span class="inline-flex items-center gap-1 text-xs font-medium text-emerald-700 dark:text-emerald-400">
                                <span class="size-1.5 rounded-full bg-emerald-500"></span> {{ __('Ativo') }}
                            </span>
                        @elseif($grupo->status === 'pendente')
                            <span class="inline-flex items-center gap-1 text-xs font-medium text-amber-700 dark:text-amber-400">
                                <span class="size-1.5 rounded-full bg-amber-500"></span> {{ __('Pendente') }}
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-xs font-medium text-slate-500 dark:text-slate-400">
                                <span class="size-1.5 rounded-full bg-slate-400"></span> {{ __('Arquivado') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-4 border-t border-slate-100 dark:border-white/5">
                    <button wire:click="showEditModal({{ $grupo->id }})" class="flex-1 flex items-center justify-center gap-2 py-2 rounded-lg bg-slate-50 dark:bg-white/5 text-slate-600 dark:text-slate-300 text-sm font-medium hover:bg-slate-100 dark:hover:bg-white/10 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">edit</span> {{ __('Editar') }}
                    </button>
                     <button wire:click="deleteGrupo({{ $grupo->id }})" wire:confirm="{{ __('Tem certeza?') }}" class="p-2 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors">
                        <span class="material-symbols-outlined text-[20px]">delete</span>
                    </button>
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 flex flex-col items-center justify-center text-slate-500 dark:text-gray-400">
                <span class="material-symbols-outlined text-4xl mb-2 text-slate-300 dark:text-slate-600">search_off</span>
                <p>{{ __('Nenhum grupo encontrado.') }}</p>
            </div>
            @endforelse
        </div>
    @endif     <!-- Pagination Footer -->
        <div class="border-t border-gray-200 dark:border-border-dark px-4 py-3">
             {{ $grupos->links() }}
        </div>
    </div>
    
    {{-- Modal (Previous logic retained or adapted to new UI?) 
         The snippet didn't include a modal, so I'll keep the existing modal logic hidden or append it below if the user wants full CRUD.
         I'll append the modal code at the bottom, styled minimally to correctly overlay.
    --}}
    
    @if($showingModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div class="bg-white dark:bg-[#16181d] rounded-xl shadow-xl w-full max-w-md border border-slate-200 dark:border-[rgba(255,255,255,0.08)] overflow-hidden"
             @click.away="$wire.set('showingModal', false)">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-[rgba(255,255,255,0.08)] flex justify-between items-center">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">
                    {{ $grupoId ? __('Editar Grupo') : __('Novo Grupo') }}
                </h3>
                <button wire:click="$set('showingModal', false)" class="text-slate-400 hover:text-slate-500 dark:hover:text-gray-300">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-gray-300 mb-1">{{ __('Nome do Grupo') }}</label>
                    <input type="text" wire:model="nome" class="w-full rounded-lg border-slate-300 dark:border-[rgba(255,255,255,0.08)] bg-white dark:bg-[#1c1f26] text-slate-900 dark:text-white focus:ring-primary focus:border-primary">
                    @error('nome') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-gray-300 mb-1">{{ __('CNPJ') }}</label>
                        <input type="text" wire:model="cnpj" placeholder="00.000.000/0000-00" class="w-full rounded-lg border-slate-300 dark:border-[rgba(255,255,255,0.08)] bg-white dark:bg-[#1c1f26] text-slate-900 dark:text-white focus:ring-primary focus:border-primary">
                        @error('cnpj') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-gray-300 mb-1">{{ __('Responsável') }}</label>
                        <input type="text" wire:model="responsavel" class="w-full rounded-lg border-slate-300 dark:border-[rgba(255,255,255,0.08)] bg-white dark:bg-[#1c1f26] text-slate-900 dark:text-white focus:ring-primary focus:border-primary">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 dark:text-gray-300 mb-1">{{ __('Status') }}</label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" value="ativo" wire:model="formStatus" class="text-primary focus:ring-primary bg-transparent border-slate-300 dark:border-slate-600">
                            <span class="text-sm text-slate-700 dark:text-gray-300">{{ __('Ativo') }}</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" value="pendente" wire:model="formStatus" class="text-amber-500 focus:ring-amber-500 bg-transparent border-slate-300 dark:border-slate-600">
                            <span class="text-sm text-slate-700 dark:text-gray-300">{{ __('Pendente') }}</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" value="arquivado" wire:model="formStatus" class="text-slate-500 focus:ring-slate-500 bg-transparent border-slate-300 dark:border-slate-600">
                            <span class="text-sm text-slate-700 dark:text-gray-300">{{ __('Arquivado') }}</span>
                        </label>
                    </div>
                    @error('formStatus') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
            
            <div class="px-6 py-4 bg-slate-50 dark:bg-[#0e1015]/50 border-t border-slate-200 dark:border-[rgba(255,255,255,0.08)] flex justify-end gap-3">
                <button wire:click="$set('showingModal', false)" class="px-4 py-2 text-sm font-medium text-slate-700 dark:text-gray-300 hover:bg-slate-100 dark:hover:bg-white/5 rounded-lg transition-colors">
                    {{ __('Cancelar') }}
                </button>
                <button wire:click="saveGrupo" class="px-4 py-2 text-sm font-medium text-white bg-primary hover:bg-primary-hover rounded-lg shadow-sm shadow-primary/30 transition-all">
                    {{ __('Salvar') }}
                </button>
            </div>
        </div>
    </div>
    @endif

</div>