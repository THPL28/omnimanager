<x-executive-layout>
    <div class="max-w-7xl mx-auto flex flex-col gap-8 pb-10">
        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div class="flex flex-col gap-1">
                <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">{{ __('Dashboard Executivo') }}</h2>
                <p class="text-slate-500 dark:text-gray-400">{{ __('Visão geral da operação, conformidade e crescimento em tempo real.') }}</p>
            </div>
            <div class="flex items-center gap-2">
                <button class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-slate-600 dark:text-gray-300 bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-lg shadow-sm hover:bg-slate-50 dark:hover:bg-white/10 transition-all">
                    <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                    <span>{{ now()->locale(app()->getLocale())->isoFormat('MMMM YYYY') }}</span>
                </button>
                <a href="{{ route('relatorios.colaboradores') }}" wire:navigate class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-white bg-primary rounded-lg shadow-sm hover:bg-primary-hover shadow-glow transition-all">
                    <span class="material-symbols-outlined text-[18px]">download</span>
                    <span>{{ __('Exportar Relatório') }}</span>
                </a>
            </div>
        </div>

        {{-- Metrics Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Grupos --}}
            <div class="p-5 bg-white dark:bg-surface-dark rounded-xl border border-slate-200 dark:border-border-dark shadow-sm flex flex-col justify-between h-32 hover:border-primary/50 dark:hover:border-primary/50 transition-colors cursor-default group">
                <div class="flex justify-between items-start">
                    <p class="text-sm font-medium text-slate-500 dark:text-gray-400">{{ __('Grupos Econômicos') }}</p>
                    <span class="material-symbols-outlined text-slate-400 dark:text-gray-600 group-hover:text-primary transition-colors">domain</span>
                </div>
                <div class="flex items-end gap-3">
                    <span class="text-3xl font-bold text-slate-900 dark:text-white tabular-nums">{{ $totalGrupos }}</span>
                    <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/20 border dark:border-emerald-500/20 px-1.5 py-0.5 rounded mb-1 flex items-center">
                        <span class="material-symbols-outlined text-[12px] mr-0.5">trending_up</span>
                        2 {{ __('novos') }}
                    </span>
                </div>
            </div>

            {{-- Bandeiras --}}
            <div class="p-5 bg-white dark:bg-surface-dark rounded-xl border border-slate-200 dark:border-border-dark shadow-sm flex flex-col justify-between h-32 hover:border-primary/50 dark:hover:border-primary/50 transition-colors cursor-default group">
                <div class="flex justify-between items-start">
                    <p class="text-sm font-medium text-slate-500 dark:text-gray-400">{{ __('Bandeiras Ativas') }}</p>
                    <span class="material-symbols-outlined text-slate-400 dark:text-gray-600 group-hover:text-primary transition-colors">flag</span>
                </div>
                <div class="flex items-end gap-3">
                    <span class="text-3xl font-bold text-slate-900 dark:text-white tabular-nums">{{ $totalBandeiras }}</span>
                    <span class="text-xs font-medium text-slate-500 dark:text-gray-500 mb-1">{{ __('Total registrado') }}</span>
                </div>
            </div>

            {{-- Unidades --}}
            <div class="p-5 bg-white dark:bg-surface-dark rounded-xl border border-slate-200 dark:border-border-dark shadow-sm flex flex-col justify-between h-32 hover:border-primary/50 dark:hover:border-primary/50 transition-colors cursor-default group">
                <div class="flex justify-between items-start">
                    <p class="text-sm font-medium text-slate-500 dark:text-gray-400">{{ __('Unidades Operacionais') }}</p>
                    <span class="material-symbols-outlined text-slate-400 dark:text-gray-600 group-hover:text-primary transition-colors">store</span>
                </div>
                <div class="flex items-end gap-3">
                    <span class="text-3xl font-bold text-slate-900 dark:text-white tabular-nums">{{ $totalUnidades }}</span>
                    <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/20 border dark:border-emerald-500/20 px-1.5 py-0.5 rounded mb-1 flex items-center">
                        <span class="material-symbols-outlined text-[12px] mr-0.5">trending_up</span>
                        +5.2%
                    </span>
                </div>
            </div>

            {{-- Colaboradores --}}
            <div class="p-5 bg-white dark:bg-surface-dark rounded-xl border border-slate-200 dark:border-border-dark shadow-sm flex flex-col justify-between h-32 hover:border-primary/50 dark:hover:border-primary/50 transition-colors cursor-default group">
                <div class="flex justify-between items-start">
                    <p class="text-sm font-medium text-slate-500 dark:text-gray-400">{{ __('Colaboradores') }}</p>
                    <span class="material-symbols-outlined text-slate-400 dark:text-gray-600 group-hover:text-primary transition-colors">groups</span>
                </div>
                <div class="flex items-end gap-3">
                    <span class="text-3xl font-bold text-slate-900 dark:text-white tabular-nums">{{ $totalColaboradores }}</span>
                    <span class="text-xs font-medium text-slate-500 dark:text-gray-500 mb-1">{{ __('ativos na plataforma') }}</span>
                </div>
            </div>
        </div>

        {{-- Content Grid --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            {{-- Left Column (Actions & Activity) --}}
            <div class="xl:col-span-2 flex flex-col gap-6">
                {{-- Quick Actions --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('unidades.index') }}" wire:navigate class="flex flex-col items-center justify-center p-4 rounded-xl border border-dashed border-slate-300 dark:border-white/10 dark:bg-white/[0.02] hover:border-primary hover:bg-primary/5 dark:hover:bg-primary/10 hover:text-primary transition-all group gap-2 h-24">
                        <span class="material-symbols-outlined text-slate-400 dark:text-gray-500 group-hover:text-primary text-[28px]">add_business</span>
                        <span class="text-sm font-medium text-slate-600 dark:text-gray-300 group-hover:text-primary">{{ __('Nova Unidade') }}</span>
                    </a>
                    <a href="{{ route('colaboradores.index') }}" wire:navigate class="flex flex-col items-center justify-center p-4 rounded-xl border border-dashed border-slate-300 dark:border-white/10 dark:bg-white/[0.02] hover:border-primary hover:bg-primary/5 dark:hover:bg-primary/10 hover:text-primary transition-all group gap-2 h-24">
                        <span class="material-symbols-outlined text-slate-400 dark:text-gray-500 group-hover:text-primary text-[28px]">person_add</span>
                        <span class="text-sm font-medium text-slate-600 dark:text-gray-300 group-hover:text-primary">{{ __('Novo Colaborador') }}</span>
                    </a>
                    <a href="{{ route('auditoria.index') }}" wire:navigate class="flex flex-col items-center justify-center p-4 rounded-xl border border-dashed border-slate-300 dark:border-white/10 dark:bg-white/[0.02] hover:border-primary hover:bg-primary/5 dark:hover:bg-primary/10 hover:text-primary transition-all group gap-2 h-24">
                        <span class="material-symbols-outlined text-slate-400 dark:text-gray-500 group-hover:text-primary text-[28px]">fact_check</span>
                        <span class="text-sm font-medium text-slate-600 dark:text-gray-300 group-hover:text-primary">{{ __('Iniciar Auditoria') }}</span>
                    </a>
                    <a href="{{ route('documentos.index') }}" wire:navigate class="flex flex-col items-center justify-center p-4 rounded-xl border border-dashed border-slate-300 dark:border-white/10 dark:bg-white/[0.02] hover:border-primary hover:bg-primary/5 dark:hover:bg-primary/10 hover:text-primary transition-all group gap-2 h-24">
                        <span class="material-symbols-outlined text-slate-400 dark:text-gray-500 group-hover:text-primary text-[28px]">upload_file</span>
                        <span class="text-sm font-medium text-slate-600 dark:text-gray-300 group-hover:text-primary">{{ __('Upload Doc') }}</span>
                    </a>
                </div>

                {{-- Recent Activity Table --}}
                <div class="bg-white dark:bg-surface-dark border border-slate-200 dark:border-border-dark rounded-xl overflow-hidden shadow-sm">
                    <div class="px-6 py-4 border-b border-slate-200 dark:border-border-dark flex justify-between items-center">
                        <h3 class="text-base font-semibold text-slate-900 dark:text-white">{{ __('Atividade Recente') }}</h3>
                        <a class="text-xs font-medium text-primary hover:text-primary-hover transition-colors" href="{{ route('auditoria.index') }}" wire:navigate>{{ __('Ver todos') }}</a>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 dark:bg-white/[0.02] text-xs uppercase tracking-wider text-slate-500 dark:text-gray-500 font-semibold border-b border-slate-100 dark:border-border-dark">
                                    <th class="px-6 py-3">{{ __('Entidade') }}</th>
                                    <th class="px-6 py-3">{{ __('Ação') }}</th>
                                    <th class="px-6 py-3">{{ __('Responsável') }}</th>
                                    <th class="px-6 py-3">{{ __('Data') }}</th>
                                    <th class="px-6 py-3 text-right">{{ __('Status') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-white/5 text-sm">
                                <tr class="hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors group">
                                    <td class="px-6 py-4 font-medium text-slate-900 dark:text-white flex items-center gap-3">
                                        <div class="size-8 rounded bg-slate-100 dark:bg-white/5 flex items-center justify-center text-slate-500 dark:text-gray-400">
                                            <span class="material-symbols-outlined text-[18px]">store</span>
                                        </div>
                                        {{ __('Unidade') }} SP-JK
                                    </td>
                                    <td class="px-6 py-4 text-slate-600 dark:text-gray-400">{{ __('Auditoria Trimestral') }}</td>
                                    <td class="px-6 py-4 text-slate-600 dark:text-gray-400">
                                        <div class="flex items-center gap-2">
                                            <div class="size-6 rounded-full bg-slate-200 dark:bg-gray-700 bg-cover bg-center flex items-center justify-center text-xs font-bold text-slate-500">AP</div>
                                            <span>Ana P.</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 dark:text-gray-500">{{ __('Há 2 horas') }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-amber-50 dark:bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-transparent dark:border-amber-500/20">{{ __('Em Análise') }}</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors group">
                                    <td class="px-6 py-4 font-medium text-slate-900 dark:text-white flex items-center gap-3">
                                        <div class="size-8 rounded bg-slate-100 dark:bg-white/5 flex items-center justify-center text-slate-500 dark:text-gray-400">
                                            <span class="material-symbols-outlined text-[18px]">description</span>
                                        </div>
                                        {{ __('Contrato Social #203') }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-600 dark:text-gray-400">{{ __('Atualização de Documento') }}</td>
                                    <td class="px-6 py-4 text-slate-600 dark:text-gray-400">
                                        <div class="flex items-center gap-2">
                                            <div class="size-6 rounded-full bg-slate-200 dark:bg-gray-700 bg-cover bg-center flex items-center justify-center text-xs font-bold text-slate-500">RM</div>
                                            <span>Roberto M.</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 dark:text-gray-500">{{ __('Ontem') }}</td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-transparent dark:border-emerald-500/20">{{ __('Concluído') }}</span>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50 dark:hover:bg-white/[0.02] transition-colors group">
                                    <td class="px-6 py-4 font-medium text-slate-900 dark:text-white flex items-center gap-3">
                                        <div class="size-8 rounded bg-slate-100 dark:bg-white/5 flex items-center justify-center text-slate-500 dark:text-gray-400">
                                            <span class="material-symbols-outlined text-[18px]">groups</span>
                                        </div>
                                        {{ __('Equipe Vendas Sul') }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-600 dark:text-gray-400">{{ __('Novo Colaborador') }}</td>
                                    <td class="px-6 py-4 text-slate-600 dark:text-gray-400">
                                        <div class="flex items-center gap-2">
                                            <div class="size-6 rounded-full bg-slate-200 dark:bg-gray-700 bg-cover bg-center flex items-center justify-center text-xs font-bold text-slate-500">CS</div>
                                            <span>Camila S.</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 dark:text-gray-500">12 Out</td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 border border-transparent dark:border-emerald-500/20">{{ __('Concluído') }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Right Column (Agenda) --}}
            <div class="xl:col-span-1 border border-slate-200 dark:border-border-dark rounded-xl shadow-sm overflow-hidden h-full">
                <livewire:dashboard.calendar-widget lazy />
            </div>
        </div>
    </div>
</x-executive-layout>
