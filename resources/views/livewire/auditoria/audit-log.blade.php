<div class="flex-1 flex flex-col h-full min-w-0 overflow-hidden bg-background-light dark:bg-background-dark relative">
    {{-- Header Section --}}
    <header class="flex-shrink-0 z-10 bg-background-light dark:bg-background-dark/80 backdrop-blur-md border-b border-gray-200 dark:border-white/5">
        <div class="px-6 py-4 flex flex-col gap-4">
            {{-- Breadcrumbs --}}
            <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-[#92a4c9]">
                <a class="hover:text-primary dark:hover:text-white transition-colors" href="{{ route('dashboard') }}" wire:navigate>{{ __('Home') }}</a>
                <span class="text-xs text-slate-300 dark:text-slate-600">/</span>
                <span class="hover:text-primary dark:hover:text-white transition-colors cursor-pointer">{{ __('Segurança') }}</span>
                <span class="text-xs text-slate-300 dark:text-slate-600">/</span>
                <span class="text-slate-900 dark:text-white font-medium bg-slate-100 dark:bg-surface-dark px-2 py-0.5 rounded-md">{{ __('Logs de Auditoria') }}</span>
            </div>

            {{-- Page Title & Actions --}}
            <div class="flex flex-wrap justify-between items-end gap-4">
                <div class="flex flex-col gap-1">
                    <h2 class="text-slate-900 dark:text-white text-3xl font-bold tracking-tight">{{ __('Logs de Auditoria') }}</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-sm">{{ __('Rastreabilidade completa de ações para conformidade e segurança.') }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <button class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-surface-dark border border-gray-200 dark:border-white/10 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-200 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-[18px]">download</span>
                        {{ __('Exportar CSV') }}
                    </button>
                    <button class="flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primary-hover text-white rounded-lg text-sm font-bold transition-all shadow-lg shadow-primary/20">
                        <span class="material-symbols-outlined text-[18px]">add_alert</span>
                        {{ __('Criar Regra de Alerta') }}
                    </button>
                </div>
            </div>
        </div>

        {{-- Toolbar / Filters --}}
        <div class="px-6 pb-4 flex flex-wrap items-center gap-3">
            {{-- Search --}}
            <div class="relative group min-w-[320px]">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 dark:text-slate-500 group-focus-within:text-primary transition-colors text-[20px]">search</span>
                <input 
                    wire:model.live.debounce.500ms="search" 
                    id="search-input"
                    class="w-full bg-white dark:bg-surface-dark border border-gray-200 dark:border-white/10 text-slate-900 dark:text-white text-sm rounded-lg pl-10 pr-16 py-2 focus:ring-1 focus:ring-primary focus:border-primary outline-none transition-all placeholder:text-slate-400 dark:placeholder:text-slate-500 shadow-sm" 
                    placeholder="{{ __('Buscar por ID, Recurso, Usuário ou IP (Cmd+K)') }}" 
                    type="text"
                    x-on:keydown.window.prevent.cmd.k="document.getElementById('search-input').focus()"
                    x-on:keydown.window.prevent.ctrl.k="document.getElementById('search-input').focus()"
                />
                <div class="absolute right-3 top-1/2 -translate-y-1/2 hidden sm:flex items-center">
                    <kbd class="px-1.5 py-0.5 text-[10px] font-mono text-slate-400 dark:text-slate-500 bg-gray-100 dark:bg-surface-dark rounded border border-gray-200 dark:border-white/10">⌘K</kbd>
                </div>
            </div>

            <div class="h-6 w-px bg-gray-200 dark:bg-white/10 mx-2"></div>

            {{-- Filter Chips --}}
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar">
                {{-- Data Filter --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-2 px-3 py-1.5 rounded-md bg-white dark:bg-surface-dark hover:bg-gray-50 dark:hover:bg-white/5 border border-gray-200 dark:border-transparent hover:border-gray-300 dark:hover:border-slate-600 transition-all group shadow-sm">
                        <span class="text-slate-500 dark:text-slate-300 text-xs font-medium group-hover:text-slate-700 dark:group-hover:text-white">{{ __('Data') }}: <span class="text-slate-900 dark:text-white font-semibold">{{ __('Últimos 30 dias') }}</span></span>
                        <span class="material-symbols-outlined text-slate-400 text-[16px] group-hover:text-slate-600 dark:group-hover:text-white">arrow_drop_down</span>
                    </button>
                </div>

                {{-- User Filter --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-2 px-3 py-1.5 rounded-md bg-white dark:bg-surface-dark hover:bg-gray-50 dark:hover:bg-white/5 border border-gray-200 dark:border-transparent hover:border-gray-300 dark:hover:border-slate-600 transition-all group shadow-sm">
                        <span class="text-slate-500 dark:text-slate-300 text-xs font-medium group-hover:text-slate-700 dark:group-hover:text-white">{{ __('Usuário') }}: <span class="text-slate-900 dark:text-white font-semibold">{{ __('Todos') }}</span></span>
                        <span class="material-symbols-outlined text-slate-400 text-[16px] group-hover:text-slate-600 dark:group-hover:text-white">arrow_drop_down</span>
                    </button>
                </div>

                {{-- Action Filter --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-2 px-3 py-1.5 rounded-md bg-white dark:bg-surface-dark hover:bg-gray-50 dark:hover:bg-white/5 border {{ $event ? 'border-primary' : 'border-gray-200 dark:border-transparent' }} hover:border-gray-300 dark:hover:border-slate-600 transition-all group shadow-sm">
                        <span class="text-slate-500 dark:text-slate-300 text-xs font-medium group-hover:text-slate-700 dark:group-hover:text-white">{{ __('Ação') }}: <span class="text-slate-900 dark:text-white font-semibold">{{ $event ? __($event) : __('Todas') }}</span></span>
                        <span class="material-symbols-outlined text-slate-400 text-[16px] group-hover:text-slate-600 dark:group-hover:text-white">arrow_drop_down</span>
                    </button>
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         @click.away="open = false" 
                         class="absolute left-0 mt-2 w-40 rounded-xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-white/10 shadow-2xl z-50 overflow-hidden">
                        <div class="py-1">
                            <button wire:click="$set('event', '')" @click="open = false" class="w-full text-left px-4 py-2 text-sm {{ !$event ? 'text-primary bg-primary/5 font-semibold' : 'text-slate-700 dark:text-gray-300' }} hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">{{ __('Todas') }}</button>
                            @foreach($events as $e)
                                <button wire:click="$set('event', '{{ $e }}')" @click="open = false" class="w-full text-left px-4 py-2 text-sm flex items-center gap-2 {{ $event === $e ? 'text-primary bg-primary/5 font-semibold' : 'text-slate-700 dark:text-gray-300' }} hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">
                                    <span class="size-1.5 rounded-full {{ $e === 'created' ? 'bg-emerald-500' : ($e === 'updated' ? 'bg-amber-500' : 'bg-rose-500') }}"></span>
                                    {{ __($e) }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Entity Filter --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-2 px-3 py-1.5 rounded-md bg-white dark:bg-surface-dark hover:bg-gray-50 dark:hover:bg-white/5 border {{ $model ? 'border-primary' : 'border-gray-200 dark:border-transparent' }} hover:border-gray-300 dark:hover:border-slate-600 transition-all group shadow-sm">
                        <span class="text-slate-500 dark:text-slate-300 text-xs font-medium group-hover:text-slate-700 dark:group-hover:text-white">{{ __('Entidade') }}: <span class="text-slate-900 dark:text-white font-semibold">{{ $model ? __($model) : __('Todas') }}</span></span>
                        <span class="material-symbols-outlined text-slate-400 text-[16px] group-hover:text-slate-600 dark:group-hover:text-white">arrow_drop_down</span>
                    </button>
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         @click.away="open = false" 
                         class="absolute left-0 mt-2 w-44 rounded-xl bg-white dark:bg-surface-dark border border-gray-200 dark:border-white/10 shadow-2xl z-50 overflow-hidden">
                        <div class="py-1">
                            <button wire:click="$set('model', '')" @click="open = false" class="w-full text-left px-4 py-2 text-sm {{ !$model ? 'text-primary bg-primary/5 font-semibold' : 'text-slate-700 dark:text-gray-300' }} hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">{{ __('Todas') }}</button>
                            @foreach($models as $m)
                                <button wire:click="$set('model', '{{ $m }}')" @click="open = false" class="w-full text-left px-4 py-2 text-sm {{ $model === $m ? 'text-primary bg-primary/5 font-semibold' : 'text-slate-700 dark:text-gray-300' }} hover:bg-slate-100 dark:hover:bg-white/5 transition-colors">{{ __($m) }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- Content Area: Split View --}}
    <div class="flex flex-1 overflow-hidden" x-data="{ selectedAudit: null }">
        {{-- Table Section --}}
        <div class="flex-1 overflow-y-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead class="bg-gray-50 dark:bg-surface-dark sticky top-0 z-10 shadow-sm border-b border-gray-200 dark:border-white/10 text-xs uppercase text-slate-500 dark:text-slate-400 font-semibold tracking-wider">
                    <tr>
                        <th class="px-6 py-3 font-medium">{{ __('Timestamp') }}</th>
                        <th class="px-6 py-3 font-medium">{{ __('Usuário') }}</th>
                        <th class="px-6 py-3 font-medium">{{ __('Ação') }}</th>
                        <th class="px-6 py-3 font-medium">{{ __('Recurso') }}</th>
                        <th class="px-6 py-3 font-medium hidden lg:table-cell">{{ __('IP') }}</th>
                        <th class="px-6 py-3 font-medium text-right">{{ __('Detalhes') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/5 text-slate-600 dark:text-slate-300">
                    @forelse ($audits as $index => $audit)
                        <tr 
                            class="group hover:bg-gray-50 dark:hover:bg-surface-dark/50 transition-colors cursor-pointer border-l-2"
                            :class="selectedAudit === {{ $index }} ? 'bg-gray-50 dark:bg-surface-dark/80 border-l-primary' : 'border-l-transparent'"
                            @click="selectedAudit = selectedAudit === {{ $index }} ? null : {{ $index }}"
                        >
                            <td class="px-6 py-3 whitespace-nowrap font-mono text-slate-400 dark:text-slate-500 text-xs">
                                {{ $audit->created_at->format('d M H:i') }}
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    @php
                                        $colors = ['indigo', 'pink', 'emerald', 'amber', 'cyan'];
                                        $color = $colors[$audit->user_id % count($colors)] ?? 'indigo';
                                    @endphp
                                    <div class="size-6 rounded-full bg-{{ $color }}-500/20 text-{{ $color }}-400 flex items-center justify-center text-[10px] font-bold ring-1 ring-{{ $color }}-500/50 uppercase">
                                        {{ $audit->user ? substr($audit->user->name, 0, 2) : 'SY' }}
                                    </div>
                                    <span class="text-slate-900 dark:text-white font-medium text-sm">{{ $audit->user->name ?? __('Sistema') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap">
                                @php
                                    $eventConfig = [
                                        'created' => ['bg' => 'bg-emerald-500/10', 'text' => 'text-emerald-400', 'border' => 'border-emerald-500/20', 'dot' => 'bg-emerald-400', 'label' => __('CREATE')],
                                        'updated' => ['bg' => 'bg-amber-500/10', 'text' => 'text-amber-400', 'border' => 'border-amber-500/20', 'dot' => 'bg-amber-400', 'label' => __('UPDATE')],
                                        'deleted' => ['bg' => 'bg-rose-500/10', 'text' => 'text-rose-400', 'border' => 'border-rose-500/20', 'dot' => 'bg-rose-400', 'label' => __('DELETE')],
                                    ];
                                    $config = $eventConfig[$audit->event] ?? ['bg' => 'bg-blue-500/10', 'text' => 'text-blue-400', 'border' => 'border-blue-500/20', 'dot' => 'bg-blue-400', 'label' => strtoupper(__($audit->event))];
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded text-[10px] font-medium uppercase tracking-wide {{ $config['bg'] }} {{ $config['text'] }} border {{ $config['border'] }}">
                                    <span class="size-1.5 rounded-full {{ $config['dot'] }}"></span>
                                    {{ $config['label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="text-slate-900 dark:text-white text-sm">{{ __(class_basename($audit->auditable_type)) }}</span>
                                    <span class="text-[10px] text-slate-400 dark:text-slate-500 font-mono">ID: {{ $audit->auditable_id }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-3 whitespace-nowrap font-mono text-[11px] text-slate-400 dark:text-slate-500 hidden lg:table-cell">
                                {{ $audit->ip_address ?? '127.0.0.1' }}
                            </td>
                            <td class="px-6 py-3 text-right">
                                <span class="text-[11px] text-slate-400 group-hover:text-primary transition-colors flex items-center justify-end gap-1">
                                    {{ __('Ver alterações') }} <span class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center gap-3 opacity-30">
                                    <span class="material-symbols-outlined text-[48px]">shield_lock</span>
                                    <p class="text-sm font-bold uppercase tracking-widest text-slate-500">{{ __('Nenhum log de auditoria encontrado') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination Footer --}}
            <div class="border-t border-gray-200 dark:border-white/10 px-6 py-4 flex items-center justify-between bg-gray-50/50 dark:bg-surface-dark">
                <p class="text-sm text-slate-500 dark:text-slate-400">
                    {{ __('Mostrando') }} <span class="font-medium text-slate-900 dark:text-white">{{ $audits->firstItem() ?? 0 }}</span> {{ __('a') }} <span class="font-medium text-slate-900 dark:text-white">{{ $audits->lastItem() ?? 0 }}</span> {{ __('de') }} <span class="font-medium text-slate-900 dark:text-white">{{ $audits->total() }}</span> {{ __('registros') }}
                </p>
                <div class="flex gap-1">
                    {{ $audits->links() }}
                </div>
            </div>
        </div>

        {{-- Detail Panel / Side Drawer --}}
        @if($audits->count() > 0)
        <aside 
            x-show="selectedAudit !== null" 
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="translate-x-full opacity-0"
            x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="translate-x-full opacity-0"
            class="w-[480px] border-l border-gray-200 dark:border-white/10 bg-white dark:bg-surface-dark flex flex-col shadow-xl z-20 shrink-0"
        >
            @foreach($audits as $index => $audit)
            <template x-if="selectedAudit === {{ $index }}">
                <div class="flex flex-col h-full">
                    {{-- Panel Header --}}
                    <div class="px-6 py-5 border-b border-gray-200 dark:border-white/10 flex justify-between items-start shrink-0">
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-[10px] font-mono text-slate-400 dark:text-slate-500">#LOG-{{ str_pad($audit->id, 5, '0', STR_PAD_LEFT) }}</span>
                                @php $config = $eventConfig[$audit->event] ?? $config; @endphp
                                <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded text-[9px] font-bold uppercase tracking-wider {{ $config['bg'] }} {{ $config['text'] }} border {{ $config['border'] }}">{{ $config['label'] }}</span>
                            </div>
                            <h3 class="text-slate-900 dark:text-white text-lg font-bold">{{ __(class_basename($audit->auditable_type)) }}</h3>
                            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">{{ __('Registro ID') }}: {{ $audit->auditable_id }}</p>
                        </div>
                        <button @click="selectedAudit = null" class="text-slate-400 hover:text-slate-600 dark:hover:text-white transition-colors rounded hover:bg-gray-100 dark:hover:bg-white/5 p-1">
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>

                    {{-- Panel Content --}}
                    <div class="flex-1 overflow-y-auto p-6 space-y-6 no-scrollbar">
                        {{-- Meta Data Grid --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex flex-col gap-1">
                                <span class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-wider font-semibold">{{ __('Executado por') }}</span>
                                <div class="flex items-center gap-2 mt-1">
                                    <div class="size-5 rounded-full bg-primary/20 text-primary flex items-center justify-center text-[9px] font-bold ring-1 ring-primary/50 uppercase">
                                        {{ $audit->user ? substr($audit->user->name, 0, 2) : 'SY' }}
                                    </div>
                                    <span class="text-sm text-slate-900 dark:text-white">{{ $audit->user->name ?? __('Sistema') }}</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-wider font-semibold">{{ __('Data e Hora') }}</span>
                                <span class="text-sm text-slate-900 dark:text-white font-mono">{{ $audit->created_at->format('d M Y - H:i:s') }}</span>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-wider font-semibold">{{ __('Endereço IP') }}</span>
                                <span class="text-sm text-slate-900 dark:text-white font-mono">{{ $audit->ip_address ?? '127.0.0.1' }}</span>
                            </div>
                            <div class="flex flex-col gap-1">
                                <span class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-wider font-semibold">User Agent</span>
                                <span class="text-sm text-slate-900 dark:text-white truncate" title="{{ $audit->user_agent ?? 'N/A' }}">{{ Str::limit($audit->user_agent ?? 'N/A', 20) }}</span>
                            </div>
                        </div>

                        <hr class="border-gray-200 dark:border-white/10"/>

                        {{-- Diff Viewer --}}
                        <div>
                            <h4 class="text-slate-900 dark:text-white text-sm font-semibold mb-3 flex items-center gap-2">
                                <span class="material-symbols-outlined text-slate-400 text-lg">code_blocks</span>
                                {{ __('Alterações de Dados (Diff)') }}
                            </h4>
                            <div class="bg-gray-50 dark:bg-background-dark rounded-lg border border-gray-200 dark:border-white/10 overflow-hidden font-mono text-[11px]">
                                <div class="grid grid-cols-2 border-b border-gray-200 dark:border-white/10 bg-gray-100 dark:bg-surface-dark">
                                    <div class="px-3 py-2 text-slate-500 dark:text-slate-400 font-semibold border-r border-gray-200 dark:border-white/10">{{ __('Anterior') }}</div>
                                    <div class="px-3 py-2 text-slate-500 dark:text-slate-400 font-semibold">{{ __('Novo') }}</div>
                                </div>
                                @php
                                    $oldValues = $audit->old_values ?? [];
                                    $newValues = $audit->new_values ?? [];
                                    $allKeys = array_unique(array_merge(array_keys($oldValues), array_keys($newValues)));
                                @endphp
                                @foreach($allKeys as $key)
                                    @php
                                        $oldVal = $oldValues[$key] ?? null;
                                        $newVal = $newValues[$key] ?? null;
                                        $changed = $oldVal !== $newVal;
                                    @endphp
                                    <div class="grid grid-cols-2 group hover:bg-gray-100/50 dark:hover:bg-slate-800/50 {{ !$changed ? 'opacity-40' : '' }}">
                                        <div class="px-3 py-1.5 border-r border-gray-100 dark:border-white/5 {{ $changed && $oldVal !== null ? 'text-rose-600 dark:text-rose-300 bg-rose-50 dark:bg-rose-900/10' : 'text-slate-500 dark:text-slate-400' }} break-all">
                                            "{{ $key }}": {{ json_encode($oldVal) }}
                                        </div>
                                        <div class="px-3 py-1.5 {{ $changed && $newVal !== null ? 'text-emerald-600 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-900/10' : 'text-slate-500 dark:text-slate-400' }} break-all">
                                            "{{ $key }}": {{ json_encode($newVal) }}
                                        </div>
                                    </div>
                                @endforeach
                                @if(empty($allKeys))
                                    <div class="px-3 py-4 text-center text-slate-400 dark:text-slate-500 italic">{{ __('Sem alterações registradas') }}</div>
                                @endif
                            </div>
                            <p class="text-[10px] text-slate-400 dark:text-slate-500 mt-2 text-right">{{ __('Mostrando campos modificados') }}</p>
                        </div>

                        {{-- System Note --}}
                        <div class="rounded-lg bg-blue-50 dark:bg-blue-500/10 p-3 border border-blue-200 dark:border-blue-500/20">
                            <div class="flex gap-2">
                                <span class="material-symbols-outlined text-blue-500 dark:text-blue-400 shrink-0">info</span>
                                <div class="flex flex-col gap-1">
                                    <p class="text-sm text-blue-700 dark:text-blue-200 font-medium">{{ __('Nota de Sistema') }}</p>
                                    <p class="text-xs text-blue-600 dark:text-blue-300/80 leading-relaxed">
                                        {{ __('Esta ação foi registrada automaticamente pelo módulo de auditoria para fins de conformidade e rastreabilidade.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Panel Footer --}}
                    <div class="p-4 border-t border-gray-200 dark:border-white/10 bg-gray-50 dark:bg-surface-dark flex gap-3 justify-end shrink-0">
                        <button 
                            @click="navigator.clipboard.writeText(JSON.stringify({{ json_encode(['old' => $audit->old_values, 'new' => $audit->new_values]) }}))"
                            class="px-4 py-2 rounded-lg border border-gray-200 dark:border-white/10 text-slate-600 dark:text-slate-300 text-sm font-medium hover:bg-gray-100 dark:hover:bg-white/5 transition-colors"
                        >
                            {{ __('Copiar JSON') }}
                        </button>
                        <button class="px-4 py-2 rounded-lg bg-white dark:bg-surface-dark hover:bg-gray-50 dark:hover:bg-white/5 text-slate-700 dark:text-white text-sm font-medium transition-colors border border-gray-200 dark:border-white/10">
                            {{ __('Reverter Ação') }}
                        </button>
                    </div>
                </div>
            </template>
            @endforeach
        </aside>
        @endif
    </div>
</div>