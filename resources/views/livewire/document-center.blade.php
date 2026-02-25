<div class="flex-1 flex flex-col h-full min-w-0 overflow-hidden bg-background-light dark:bg-background-dark relative">
    {{-- Header Section --}}
    <header class="flex flex-col z-10 bg-background-light dark:bg-background-dark border-b border-gray-200 dark:border-white/5">
        {{-- Breadcrumbs --}}
        <div class="px-6 pt-6 pb-2">
            <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-[#92a4c9]">
                <a class="hover:text-primary dark:hover:text-white transition-colors" href="{{ route('dashboard') }}" wire:navigate>{{ __('Início') }}</a>
                <span class="text-xs">/</span>
                <span class="text-slate-900 dark:text-white font-medium">{{ __('Documentos') }}</span>
            </div>
        </div>

        {{-- Page Title & Actions --}}
        <div class="px-6 py-2 flex flex-wrap justify-between items-end gap-4">
            <div class="flex flex-col gap-1">
                <h2 class="text-slate-900 dark:text-white text-2xl font-bold tracking-tight">{{ __('Central de Documentos') }}</h2>
                <p class="text-slate-500 dark:text-[#92a4c9] text-sm">{{ __('Gerencie arquivos, contratos e relatórios de todas as unidades.') }}</p>
            </div>
            <button wire:click="showCreateModal" class="flex items-center gap-2 bg-primary hover:bg-primary-hover text-white px-4 py-2 rounded-lg text-sm font-bold transition-all shadow-lg shadow-primary/20 active:scale-95">
                <span class="material-symbols-outlined text-[20px]">upload_file</span>
                <span>{{ __('Novo Upload') }}</span>
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
                    placeholder="{{ __('Buscar por nome, setor ou descrição...') }}" 
                    type="text"
                    x-on:keydown.window.prevent.cmd.k="document.getElementById('search-input').focus()"
                    x-on:keydown.window.prevent.ctrl.k="document.getElementById('search-input').focus()"
                />
                <div class="absolute right-3 top-1/2 -translate-y-1/2 hidden sm:flex items-center gap-1">
                    <span class="text-[10px] font-mono text-slate-400 dark:text-slate-600 border border-gray-200 dark:border-white/10 rounded px-1.5 py-0.5">⌘K</span>
                </div>
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                {{-- Filter Empresa --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" 
                            class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white dark:bg-surface-dark hover:bg-gray-50 dark:hover:bg-white/5 text-slate-700 dark:text-white text-sm font-medium border {{ $empresa_id ? 'border-primary' : 'border-gray-200 dark:border-transparent' }} transition-colors whitespace-nowrap group shadow-sm">
                        <span class="material-symbols-outlined text-[18px] opacity-60">business</span>
                        <span>{{ __('Empresa') }}: {{ $empresa_id ? ($empresas->find($empresa_id)?->nome ?? __('Selecionada')) : __('Todas') }}</span>
                        <span class="material-symbols-outlined text-[16px] text-slate-400 group-hover:text-slate-600 dark:text-slate-500 dark:group-hover:text-white transition-transform" :class="open ? 'rotate-180' : ''">keyboard_arrow_down</span>
                    </button>
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         @click.away="open = false" 
                         class="absolute right-0 mt-2 w-64 rounded-xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-white/10 shadow-2xl z-50 overflow-hidden ring-1 ring-black/5">
                        <div class="px-3 py-2 border-b border-gray-100 dark:border-white/5 bg-gray-50/50 dark:bg-black/20">
                            <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ __('Filtrar por Empresa') }}</span>
                        </div>
                        <div class="py-1 max-h-60 overflow-y-auto no-scrollbar">
                            <button wire:click="$set('empresa_id', '')" @click="open = false" class="w-full text-left px-4 py-2 text-sm {{ !$empresa_id ? 'text-primary bg-primary/5 font-semibold' : 'text-slate-700 dark:text-gray-300' }} hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">{{ __('Todas') }}</button>
                            @foreach($empresas as $empresa)
                                <button wire:click="$set('empresa_id', {{ $empresa->id }})" @click="open = false" class="w-full text-left px-4 py-2 text-sm {{ $empresa_id == $empresa->id ? 'text-primary bg-primary/5 font-semibold' : 'text-slate-700 dark:text-gray-300' }} hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">{{ $empresa->nome }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Filter Setor --}}
                <div class="relative w-full sm:w-32">
                    <input 
                        wire:model.live.debounce.500ms="filterSetor" 
                        class="w-full bg-white dark:bg-surface-dark border border-gray-200 dark:border-transparent text-slate-900 dark:text-white text-sm rounded-lg px-3 py-1.5 focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all placeholder:text-slate-400 dark:placeholder:text-slate-600 shadow-sm" 
                        placeholder="{{ __('Setor...') }}" 
                        type="text"
                    />
                </div>
            </div>
        </div>
    </header>

    {{-- Data Table --}}
    <div class="flex-1 overflow-auto p-6 pt-2 no-scrollbar">
        @if (session()->has('message'))
            <div class="mb-4 p-3 bg-emerald-500/10 border border-emerald-500/20 rounded-xl flex items-center gap-3 text-emerald-600 dark:text-emerald-400 text-sm animate-in fade-in slide-in-from-top-2">
                <span class="material-symbols-outlined text-[20px]">check_circle</span>
                {{ session('message') }}
            </div>
        @endif

        <div class="border border-gray-200 dark:border-white/5 rounded-xl overflow-hidden bg-white dark:bg-surface-dark shadow-sm">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-white/5">
                <thead class="bg-gray-50/50 dark:bg-surface-dark">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest" scope="col">{{ __('Documento') }}</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest hidden md:table-cell" scope="col">{{ __('Versão') }}</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest hidden lg:table-cell" scope="col">{{ __('Empresa / Setor') }}</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest hidden xl:table-cell" scope="col">{{ __('Tamanho') }}</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest" scope="col">{{ __('Atualizado em') }}</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest" scope="col">{{ __('Ações') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-white/5 bg-white dark:bg-background-dark">
                    @forelse ($documents as $doc)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="size-10 rounded-lg flex items-center justify-center bg-primary/10 text-primary border border-primary/20 shrink-0">
                                        @php
                                            $ext = pathinfo($doc->current_path, PATHINFO_EXTENSION);
                                            $icon = match(strtolower($ext)) {
                                                'pdf' => 'picture_as_pdf',
                                                'doc', 'docx' => 'description',
                                                'xls', 'xlsx' => 'table_chart',
                                                'jpg', 'jpeg', 'png' => 'image',
                                                default => 'draft'
                                            };
                                        @endphp
                                        <span class="material-symbols-outlined text-[24px]">{{ $icon }}</span>
                                    </div>
                                    <div class="flex flex-col min-w-0">
                                        <span class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors truncate">{{ basename($doc->current_path ?? '') ?: __('Documento') . ' #' . $doc->id }}</span>
                                        <span class="text-[11px] text-slate-500 dark:text-[#92a4c9] font-medium truncate">{{ $doc->descricao ?: __('Sem descrição') }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-primary/10 text-primary border border-primary/20 uppercase tracking-wide">
                                    v{{ $doc->versions->max('version') ?: '1.0' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 hidden lg:table-cell">
                                <div class="flex flex-col">
                                    <span class="text-xs font-bold text-slate-700 dark:text-gray-300">{{ $doc->grupo->nome ?? 'Alpha Matriz' }}</span>
                                    <span class="text-[11px] text-slate-500 dark:text-slate-400 font-medium">{{ $doc->setor ?: __('Geral') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 hidden xl:table-cell text-xs font-mono text-slate-500 dark:text-slate-400">
                                {{ $doc->size ? number_format($doc->size/1024, 2) . ' KB' : '--' }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-xs font-medium text-slate-600 dark:text-slate-300">{{ $doc->created_at?->format('d/m/Y') }}</span>
                                    <span class="text-[10px] text-slate-400 dark:text-slate-500 font-mono">{{ $doc->created_at?->format('H:i') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    @if($doc->current_path)
                                        <a href="{{ route('documentos.download', ['document' => $doc->id]) }}" target="_blank" class="p-1.5 rounded-lg text-slate-400 hover:text-emerald-500 hover:bg-emerald-500/10 transition-all" title="{{ __('Download') }}">
                                            <span class="material-symbols-outlined text-[20px]">download</span>
                                        </a>
                                    @endif
                                    <button wire:click="startVersion({{ $doc->id }})" class="p-1.5 rounded-lg text-slate-400 hover:text-primary hover:bg-primary/10 transition-all" title="{{ __('Nova Versão') }}">
                                        <span class="material-symbols-outlined text-[20px]">history</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @if($uploadingVersionFor === $doc->id)
                            <tr class="bg-primary/5 animate-pulse-once">
                                <td colspan="6" class="px-6 py-4 border-l-2 border-primary">
                                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                                        <div class="flex flex-col gap-1">
                                            <span class="text-xs font-bold text-primary uppercase tracking-widest">{{ __('Enviar nova versão para este documento') }}</span>
                                            <p class="text-[11px] text-slate-500 dark:text-slate-400">{{ __('O arquivo anterior será mantido no histórico.') }}</p>
                                        </div>
                                        <div class="flex items-center gap-3 w-full sm:w-auto">
                                            <input type="file" wire:model="versionFile" class="flex-1 bg-white dark:bg-black/20 border border-primary/20 rounded-lg px-3 py-1.5 text-xs text-slate-600 dark:text-slate-300 outline-none focus:ring-1 focus:ring-primary">
                                            <div class="flex items-center gap-2">
                                                <button wire:click.prevent="uploadVersion({{ $doc->id }})" class="px-4 py-1.5 bg-primary text-white text-xs font-bold rounded-lg hover:bg-primary-hover shadow-lg shadow-primary/20 transition-all">{{ __('Upload') }}</button>
                                                <button wire:click.prevent="cancelVersion" class="px-4 py-1.5 bg-white dark:bg-white/5 text-slate-500 text-xs font-bold rounded-lg hover:bg-gray-100 transition-all">{{ __('Cancelar') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                    @error('versionFile') <p class="text-rose-500 text-[10px] font-bold mt-2 ml-1 italic">{{ $message }}</p> @enderror
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center gap-3 opacity-30">
                                    <span class="material-symbols-outlined text-[48px]">folder_off</span>
                                    <p class="text-sm font-bold uppercase tracking-widest text-slate-500">{{ __('Nenhum documento encontrado') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $documents->links() }}
        </div>

        {{-- Dropzone Decoration --}}
        <div class="mt-8 border-2 border-dashed border-gray-200 dark:border-white/5 rounded-2xl p-10 flex flex-col items-center justify-center text-center group cursor-pointer hover:border-primary/50 hover:bg-primary/5 transition-all" wire:click="showCreateModal">
            <div class="size-14 rounded-full bg-gray-100 dark:bg-white/5 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:bg-primary/10 transition-all">
                <span class="material-symbols-outlined text-slate-400 dark:text-slate-500 group-hover:text-primary transition-colors text-[32px]">cloud_upload</span>
            </div>
            <h4 class="text-sm font-bold text-slate-900 dark:text-white">{{ __('Arraste arquivos aqui para fazer upload') }}</h4>
            <p class="text-xs text-slate-500 dark:text-[#92a4c9] mt-1 max-w-xs">{{ __('Ou clique para selecionar manualmente. Suporta PDF, Word, Excel e Imagens até 10MB.') }}</p>
        </div>
    </div>

    {{-- Modal Novo Upload --}}
    @if ($showingUploadModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm animate-in fade-in duration-200">
        <div class="bg-white dark:bg-surface-dark rounded-2xl shadow-2xl w-full max-w-lg border border-gray-200 dark:border-white/10 animate-in zoom-in-95 duration-200">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-white/5 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <div class="size-8 rounded-lg bg-primary/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-[20px]">upload_file</span>
                    </div>
                    {{ __('Novo Documento') }}
                </h3>
                <button wire:click="$set('showingUploadModal', false)" class="size-8 flex items-center justify-center rounded-lg hover:bg-gray-100 dark:hover:bg-white/5 text-slate-400 hover:text-slate-500 transition-colors">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>
            
            <form wire:submit.prevent="upload">
                <div class="p-6 space-y-5">
                    {{-- Empresa Selector --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">{{ __('Empresa / Grupo Relacionado') }}</label>
                        <select wire:model="empresa_id" class="w-full bg-gray-50 dark:bg-background-dark border border-gray-200 dark:border-white/5 text-slate-900 dark:text-white text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all shadow-inner font-medium">
                            <option value="">{{ __('Geral (Sem empresa específica)') }}</option>
                            @foreach($empresas as $e)
                                <option value="{{ $e->id }}">{{ $e->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Setor --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">{{ __('Setor Responsável') }}</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-slate-400 group-focus-within:text-primary transition-colors">hub</span>
                            <input type="text" wire:model.live="setor" class="w-full bg-gray-50 dark:bg-background-dark border border-gray-200 dark:border-white/5 text-slate-900 dark:text-white text-sm rounded-xl pl-10 pr-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder:text-slate-400 shadow-inner" placeholder="{{ __('Ex: Financeiro, Jurídico, RH') }}">
                        </div>
                    </div>

                    {{-- Arquivo --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">{{ __('Selecionar Arquivo') }}</label>
                        <div class="flex items-center justify-center w-full">
                            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-200 dark:border-white/10 rounded-xl cursor-pointer bg-gray-50 dark:bg-background-dark hover:bg-gray-100 dark:hover:bg-white/[0.02] transition-colors relative group overflow-hidden">
                                @if($file)
                                    <div class="flex flex-col items-center gap-2 animate-in zoom-in-95">
                                        <span class="material-symbols-outlined text-emerald-500 text-[40px]">check_circle</span>
                                        <span class="text-xs font-bold text-slate-900 dark:text-white px-4 text-center truncate w-full">{{ $file->getClientOriginalName() }}</span>
                                        <button type="button" wire:click.stop="$set('file', null)" class="text-[10px] font-bold text-rose-500 uppercase hover:underline">{{ __('Remover') }}</button>
                                    </div>
                                @else
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <span class="material-symbols-outlined text-slate-400 dark:text-slate-500 group-hover:text-primary transition-colors text-[32px] mb-2">attachment</span>
                                        <p class="mb-2 text-sm text-slate-500 dark:text-slate-400 font-medium">{{ __('Clique para fazer upload') }}</p>
                                        <p class="text-xs text-slate-400 dark:text-slate-500 italic">{{ __('PDF, Word, Excel, JPG ou PNG (Max. 10MB)') }}</p>
                                    </div>
                                @endif
                                <input type="file" wire:model="file" class="hidden" />
                                
                                {{-- Loading Overlay --}}
                                <div wire:loading wire:target="file" class="absolute inset-0 bg-white/80 dark:bg-surface-dark/80 backdrop-blur-sm flex items-center justify-center">
                                    <div class="flex flex-col items-center gap-2">
                                        <div class="size-6 border-2 border-primary border-t-transparent rounded-full animate-spin"></div>
                                        <span class="text-[10px] font-bold text-primary uppercase tracking-widest">{{ __('Enviando...') }}</span>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('file') <span class="text-red-500 text-[11px] font-semibold mt-1 block pl-1 italic">{{ $message }}</span> @enderror
                    </div>

                    {{-- Descrição --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">{{ __('Informações Adicionais') }}</label>
                        <textarea wire:model="descricao" rows="3" class="w-full bg-gray-50 dark:bg-background-dark border border-gray-200 dark:border-white/5 text-slate-900 dark:text-white text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder:text-slate-400 shadow-inner resize-none" placeholder="{{ __('O que este documento contém?') }}"></textarea>
                    </div>
                </div>

                <div class="p-6 pt-2 bg-gray-50/50 dark:bg-black/10 border-t border-gray-200 dark:border-white/5 flex justify-end gap-3 rounded-b-2xl">
                    <button type="button" wire:click="$set('showingUploadModal', false)" class="px-5 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-white/5 rounded-xl transition-all">
                        {{ __('Cancelar') }}
                    </button>
                    <button type="submit" wire:loading.attr="disabled" class="px-6 py-2.5 text-sm font-bold text-white bg-primary hover:bg-primary-hover rounded-xl shadow-lg shadow-primary/20 active:scale-95 transition-all flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="upload">{{ __('Iniciar Upload') }}</span>
                        <span wire:loading wire:target="upload" class="size-4 border-2 border-white/30 border-t-white rounded-full animate-spin"></span>
                        <span wire:loading wire:target="upload">{{ __('Processando...') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
