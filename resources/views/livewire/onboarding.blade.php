<div>
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary/20 rounded-full blur-[120px] opacity-40 animate-pulse"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-[#292348] rounded-full blur-[120px] opacity-40"></div>
        <div class="absolute top-[20%] right-[20%] w-[20%] h-[20%] bg-primary/10 rounded-full blur-[80px] opacity-30"></div>
    </div>
    <div class="layout-container w-full max-w-6xl px-4 md:px-8 py-8 flex flex-col items-center justify-center h-full min-h-screen">
        
        <!-- STEP 1 -->
        @if($step === 1)
        <div class="relative w-full max-w-[1024px] bg-surface-dark/80 border border-surface-border rounded-2xl shadow-2xl backdrop-blur-xl overflow-hidden flex flex-col md:flex-row h-auto min-h-[640px] animate-in fade-in slide-in-from-right-8 duration-500">
            <div class="relative w-full md:w-5/12 h-64 md:h-auto bg-[#0f0c1d] flex items-center justify-center overflow-hidden group">
                <div class="absolute inset-0 bg-cover bg-center opacity-60 mix-blend-overlay" data-alt="abstract dark geometric waves with purple lighting" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBL5Jg_7mAj6sYr1OCiOMhPe--XaXsjwgt2X5nNWkGSCBzXY1N6qmtWaeXCYPl8ngPVdvjQXDBkEZxGkPt0oxuUQ21d3YhLlMrTr4yOZd7RvBgaR0z5hq0K6_q6UaIB6ANSzhIIfNn1WuZa2hyWJPZnca9k7IFQMu3MiYumtsYN16HOL2ailIwHp97pHRINCIpGahCX__Paj3YJtlqYnC0ykSs8KPkHaM755SkEoIXWXXTV7r72eSMEFEHmQeZXKjVZMHoj5yLMA6o4");'>
                </div>
                <div class="relative z-10 p-8 rounded-full bg-surface-dark/50 border border-white/10 backdrop-blur-md shadow-[0_0_30px_rgba(19,19,236,0.2)] transition-transform duration-700 group-hover:scale-105">
                    <span class="material-symbols-outlined text-6xl md:text-7xl text-primary bg-gradient-to-br from-white to-primary bg-clip-text text-transparent" style="-webkit-text-fill-color: transparent;">
                        space_dashboard
                    </span>
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-surface-dark via-transparent to-transparent md:bg-gradient-to-r"></div>
            </div>
            <div class="flex-1 flex flex-col justify-between p-8 md:p-12 relative">
                <div class="flex justify-between items-center w-full mb-6">
                    <div class="flex gap-1.5">
                        <div class="h-1 w-8 rounded-full bg-primary shadow-[0_0_10px_rgba(19,19,236,0.5)]"></div>
                        <div class="h-1 w-8 rounded-full bg-white/10"></div>
                        <div class="h-1 w-8 rounded-full bg-white/10"></div>
                        <div class="h-1 w-8 rounded-full bg-white/10"></div>
                    </div>
                    <button wire:click="skip" class="text-gray-400 hover:text-white text-xs font-medium uppercase tracking-wider transition-colors cursor-pointer flex items-center gap-1 group/skip">
                        {{ __('Pular') }}
                        <span class="material-symbols-outlined text-base opacity-0 -ml-2 group-hover/skip:opacity-100 group-hover/skip:ml-0 transition-all">chevron_right</span>
                    </button>
                </div>
                <div class="flex flex-col gap-6 my-auto">
                    <div class="space-y-4">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 w-fit">
                            <span class="material-symbols-outlined text-primary text-xs">verified</span>
                            <span class="text-primary text-[10px] font-bold uppercase tracking-wider">{{ __('Passo 1 de 4') }}</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-bold text-white leading-[1.15] tracking-tight">
                            {{ __('Bem-vindo ao') }} <br/>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-500">OmniManager</span>
                        </h1>
                        <p class="text-gray-400 text-base leading-relaxed max-w-lg font-light">
                            {{ __('Uma plataforma unificada para grandes corporações. Simplifique a complexidade e potencialize seus resultados com nossos pilares de gestão.') }}
                        </p>
                    </div>
                    <!-- Features Step 1 -->
                    <div class="flex flex-col gap-4 mt-2">
                        <div class="flex items-start gap-4 p-3 rounded-lg hover:bg-white/5 transition-colors border border-transparent hover:border-white/5 group/feat">
                            <div class="p-2 rounded-md bg-white/5 text-gray-400 group-hover/feat:text-primary group-hover/feat:bg-primary/10 transition-colors">
                                <span class="material-symbols-outlined text-xl">domain</span>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-200">{{ __('Gerencie seus Grupos e Empresas') }}</h3>
                                <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">{{ __('Controle total sobre bandeiras, unidades e estrutura societária.') }}</p>
                            </div>
                        </div>
                         <div class="flex items-start gap-4 p-3 rounded-lg hover:bg-white/5 transition-colors border border-transparent hover:border-white/5 group/feat">
                            <div class="p-2 rounded-md bg-white/5 text-gray-400 group-hover/feat:text-primary group-hover/feat:bg-primary/10 transition-colors">
                                <span class="material-symbols-outlined text-xl">monitoring</span>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-200">{{ __('Controle Financeiro e Operacional') }}</h3>
                                <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">{{ __('Métricas em tempo real, relatórios avançados e auditoria completa.') }}</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 p-3 rounded-lg hover:bg-white/5 transition-colors border border-transparent hover:border-white/5 group/feat">
                            <div class="p-2 rounded-md bg-white/5 text-gray-400 group-hover/feat:text-primary group-hover/feat:bg-primary/10 transition-colors">
                                <span class="material-symbols-outlined text-xl">groups</span>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-gray-200">{{ __('Colabore e Organize') }}</h3>
                                <p class="text-xs text-gray-500 mt-0.5 leading-relaxed">{{ __('Gestão centralizada de usuários, permissões e documentos.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row items-center gap-4 mt-8 pt-6 border-t border-white/5">
                    <button wire:click="nextStep" class="w-full sm:w-auto flex-1 group relative overflow-hidden rounded-lg bg-primary hover:bg-primary/90 transition-all duration-300 h-11 px-8 flex items-center justify-center shadow-[0_0_20px_rgba(19,19,236,0.2)] hover:shadow-[0_0_30px_rgba(19,19,236,0.4)]">
                        <span class="relative z-10 text-white text-sm font-semibold tracking-wide flex items-center gap-2">
                            {{ __('Próximo') }}
                            <span class="material-symbols-outlined text-lg transition-transform group-hover:translate-x-1">arrow_forward</span>
                        </span>
                    </button>
                    <div class="hidden sm:flex text-gray-600 text-[10px] font-medium items-center gap-1.5 opacity-60">
                        <kbd class="px-1.5 py-0.5 border border-gray-700 rounded bg-white/5 font-sans">Enter</kbd> {{ __('para avançar') }}
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- STEP 2 -->
        @if($step === 2)
        <div class="relative w-full max-w-[1024px] bg-surface-dark/80 border border-surface-border rounded-2xl shadow-2xl backdrop-blur-xl overflow-hidden flex flex-col md:flex-row h-auto md:h-[600px] animate-in fade-in slide-in-from-right-8 duration-500">
            <div class="relative w-full md:w-1/2 h-64 md:h-full bg-[#0f0c1d] flex items-center justify-center overflow-hidden group">
                <div class="absolute inset-0 bg-cover bg-center opacity-60 mix-blend-overlay" data-alt="abstract dark geometric waves with purple lighting" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBL5Jg_7mAj6sYr1OCiOMhPe--XaXsjwgt2X5nNWkGSCBzXY1N6qmtWaeXCYPl8ngPVdvjQXDBkEZxGkPt0oxuUQ21d3YhLlMrTr4yOZd7RvBgaR0z5hq0K6_q6UaIB6ANSzhIIfNn1WuZa2hyWJPZnca9k7IFQMu3MiYumtsYN16HOL2ailIwHp97pHRINCIpGahCX__Paj3YJtlqYnC0ykSs8KPkHaM755SkEoIXWXXTV7r72eSMEFEHmQeZXKjVZMHoj5yLMA6o4");'>
                </div>
                <div class="relative z-10 p-8 rounded-full bg-surface-dark/50 border border-white/10 backdrop-blur-md shadow-[0_0_30px_rgba(19,19,236,0.2)] transition-transform duration-700 group-hover:scale-105">
                    <span class="material-symbols-outlined text-6xl md:text-8xl text-primary bg-gradient-to-br from-white to-primary bg-clip-text text-transparent" style="-webkit-text-fill-color: transparent;">
                        apartment
                    </span>
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-surface-dark via-transparent to-transparent md:bg-gradient-to-r"></div>
            </div>
            <div class="flex-1 flex flex-col justify-between p-8 md:p-12 lg:p-16 relative">
                <div class="flex justify-between items-center w-full mb-8 md:mb-0">
                    <div class="flex gap-1">
                        <div wire:click="$set('step', 1)" class="h-1.5 w-8 rounded-full bg-primary/40 cursor-pointer hover:opacity-80 transition-opacity"></div>
                        <div wire:click="$set('step', 2)" class="h-1.5 w-8 rounded-full bg-primary cursor-pointer hover:bg-primary/50 transition-colors"></div>
                        <div wire:click="$set('step', 3)" class="h-1.5 w-8 rounded-full bg-white/10 cursor-pointer hover:bg-primary/50 transition-colors"></div>
                        <div wire:click="$set('step', 4)" class="h-1.5 w-8 rounded-full bg-white/10 cursor-pointer hover:bg-primary/50 transition-colors"></div>
                    </div>
                    <button wire:click="skip" class="text-gray-400 hover:text-white text-sm font-medium transition-colors cursor-pointer flex items-center gap-1 group/skip">
                        {{ __('Pular') }}
                        <span class="material-symbols-outlined text-lg opacity-0 -ml-2 group-hover/skip:opacity-100 group-hover/skip:ml-0 transition-all">chevron_right</span>
                    </button>
                </div>
                <div class="flex flex-col gap-6 my-auto">
                    <div class="space-y-4">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 w-fit">
                            <span class="material-symbols-outlined text-primary text-xs">domain</span>
                            <span class="text-primary text-xs font-bold uppercase tracking-wider">{{ __('Passo 2 de 4') }}</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-[1.1] tracking-tight">
                            {{ __('Gerencie seus') }} <br/>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-500">{{ __('Grupos e Empresas') }}</span>
                        </h1>
                        <p class="text-gray-400 text-lg leading-relaxed max-w-md font-light">
                            {{ __('Obtenha controle total sobre suas bandeiras, unidades e estrutura societária. Centralize a gestão de múltiplas entidades com agilidade.') }}
                        </p>
                    </div>
                    <div class="flex flex-col gap-3 mt-4">
                        <div class="flex items-center gap-3 text-gray-300">
                            <span class="material-symbols-outlined text-primary text-xl">flag</span>
                            <span class="text-sm">{{ __('Controle de bandeiras e unidades') }}</span>
                        </div>
                         <div class="flex items-center gap-3 text-gray-300">
                            <span class="material-symbols-outlined text-primary text-xl">account_tree</span>
                            <span class="text-sm">{{ __('Estrutura societária hierárquica') }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row items-center gap-4 mt-8 md:mt-0 pt-6 border-t border-white/5">
                    <button wire:click="previousStep" class="w-full sm:w-auto px-6 h-12 rounded-lg text-gray-400 hover:text-white hover:bg-white/5 transition-colors font-medium text-sm flex items-center justify-center">
                        {{ __('Voltar') }}
                    </button>
                    <button wire:click="nextStep" class="w-full sm:w-auto flex-1 group relative overflow-hidden rounded-lg bg-primary hover:bg-primary/90 transition-all duration-300 h-12 px-8 flex items-center justify-center shadow-[0_0_20px_rgba(19,19,236,0.3)] hover:shadow-[0_0_30px_rgba(19,19,236,0.5)]">
                        <span class="relative z-10 text-white font-semibold tracking-wide flex items-center gap-2">
                            {{ __('Próximo') }}
                            <span class="material-symbols-outlined text-lg transition-transform group-hover:translate-x-1">arrow_forward</span>
                        </span>
                    </button>
                    <div class="hidden sm:flex text-gray-500 text-xs font-medium items-center gap-2 ml-2">
                        <span class="px-1.5 py-0.5 border border-gray-700 rounded text-[10px] bg-white/5">Enter</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- STEP 3 -->
        @if($step === 3)
        <div class="relative w-full max-w-[1024px] bg-surface-dark/80 border border-surface-border rounded-2xl shadow-2xl backdrop-blur-xl overflow-hidden flex flex-col md:flex-row h-auto md:h-[600px] animate-in fade-in slide-in-from-right-8 duration-500">
            <div class="relative w-full md:w-1/2 h-64 md:h-full bg-[#0f0c1d] flex items-center justify-center overflow-hidden group">
                <div class="absolute inset-0 bg-cover bg-center opacity-60 mix-blend-overlay" data-alt="abstract dark geometric waves with purple lighting" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBL5Jg_7mAj6sYr1OCiOMhPe--XaXsjwgt2X5nNWkGSCBzXY1N6qmtWaeXCYPl8ngPVdvjQXDBkEZxGkPt0oxuUQ21d3YhLlMrTr4yOZd7RvBgaR0z5hq0K6_q6UaIB6ANSzhIIfNn1WuZa2hyWJPZnca9k7IFQMu3MiYumtsYN16HOL2ailIwHp97pHRINCIpGahCX__Paj3YJtlqYnC0ykSs8KPkHaM755SkEoIXWXXTV7r72eSMEFEHmQeZXKjVZMHoj5yLMA6o4");'>
                </div>
                <div class="relative z-10 p-8 rounded-full bg-surface-dark/50 border border-white/10 backdrop-blur-md shadow-[0_0_30px_rgba(19,19,236,0.2)] transition-transform duration-700 group-hover:scale-105">
                    <span class="material-symbols-outlined text-6xl md:text-8xl text-primary bg-gradient-to-br from-white to-primary bg-clip-text text-transparent" style="-webkit-text-fill-color: transparent;">
                        query_stats
                    </span>
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-surface-dark via-transparent to-transparent md:bg-gradient-to-r"></div>
            </div>
            <div class="flex-1 flex flex-col justify-between p-8 md:p-12 lg:p-16 relative">
                <div class="flex justify-between items-center w-full mb-8 md:mb-0">
                    <div class="flex gap-1">
                        <div wire:click="$set('step', 1)" class="h-1.5 w-8 rounded-full bg-primary cursor-pointer hover:opacity-80 transition-opacity"></div>
                        <div wire:click="$set('step', 2)" class="h-1.5 w-8 rounded-full bg-primary cursor-pointer hover:bg-primary/50 transition-colors"></div>
                        <div wire:click="$set('step', 3)" class="h-1.5 w-8 rounded-full bg-primary cursor-pointer hover:bg-primary/50 transition-colors"></div>
                        <div wire:click="$set('step', 4)" class="h-1.5 w-8 rounded-full bg-white/10 cursor-pointer hover:bg-primary/50 transition-colors"></div>
                    </div>
                    <button wire:click="skip" class="text-gray-400 hover:text-white text-sm font-medium transition-colors cursor-pointer flex items-center gap-1 group/skip">
                        {{ __('Pular') }}
                        <span class="material-symbols-outlined text-lg opacity-0 -ml-2 group-hover/skip:opacity-100 group-hover/skip:ml-0 transition-all">chevron_right</span>
                    </button>
                </div>
                <div class="flex flex-col gap-6 my-auto">
                    <div class="space-y-4">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 w-fit">
                            <span class="material-symbols-outlined text-primary text-xs">analytics</span>
                            <span class="text-primary text-xs font-bold uppercase tracking-wider">{{ __('Passo 3 de 4') }}</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-[1.1] tracking-tight">
                            {{ __('Controle Financeiro') }} <br/>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-500">{{ __('e Operacional') }}</span>
                        </h1>
                        <p class="text-gray-400 text-lg leading-relaxed max-w-md font-light">
                            {{ __('Obtenha precisão absoluta com métricas em tempo real, relatórios avançados e auditoria completa para suportar decisões estratégicas.') }}
                        </p>
                    </div>
                    <div class="flex flex-col gap-3 mt-4">
                        <div class="flex items-center gap-3 text-gray-300">
                            <span class="material-symbols-outlined text-primary text-xl">check_circle</span>
                            <span class="text-sm">{{ __('Auditoria completa de transações') }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-gray-300">
                            <span class="material-symbols-outlined text-primary text-xl">check_circle</span>
                            <span class="text-sm">{{ __('Métricas e KPIs em tempo real') }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row items-center gap-4 mt-8 md:mt-0 pt-6 border-t border-white/5">
                    <button wire:click="previousStep" class="w-full sm:w-auto h-12 px-6 rounded-lg border border-surface-border text-gray-400 hover:text-white hover:bg-white/5 transition-all duration-300 font-medium">
                        {{ __('Voltar') }}
                    </button>
                    <button wire:click="nextStep" class="w-full sm:w-auto flex-1 group relative overflow-hidden rounded-lg bg-primary hover:bg-primary/90 transition-all duration-300 h-12 px-8 flex items-center justify-center shadow-[0_0_20px_rgba(19,19,236,0.3)] hover:shadow-[0_0_30px_rgba(19,19,236,0.5)]">
                        <span class="relative z-10 text-white font-semibold tracking-wide flex items-center gap-2">
                            {{ __('Próximo') }}
                            <span class="material-symbols-outlined text-lg transition-transform group-hover:translate-x-1">arrow_forward</span>
                        </span>
                    </button>
                    <div class="hidden sm:flex text-gray-500 text-xs font-medium items-center gap-2">
                        <span class="px-1.5 py-0.5 border border-gray-700 rounded text-[10px] bg-white/5">Enter</span> {{ __('para avançar') }}
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- STEP 4 -->
        @if($step === 4)
        <div class="relative w-full max-w-[1024px] bg-surface-dark/80 border border-surface-border rounded-2xl shadow-2xl backdrop-blur-xl overflow-hidden flex flex-col md:flex-row h-auto md:h-[600px] animate-in fade-in slide-in-from-right-8 duration-500">
            <div class="relative w-full md:w-1/2 h-64 md:h-full bg-[#0f0c1d] flex items-center justify-center overflow-hidden group">
                <div class="absolute inset-0 bg-cover bg-center opacity-60 mix-blend-overlay" data-alt="abstract dark geometric waves with purple lighting" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBL5Jg_7mAj6sYr1OCiOMhPe--XaXsjwgt2X5nNWkGSCBzXY1N6qmtWaeXCYPl8ngPVdvjQXDBkEZxGkPt0oxuUQ21d3YhLlMrTr4yOZd7RvBgaR0z5hq0K6_q6UaIB6ANSzhIIfNn1WuZa2hyWJPZnca9k7IFQMu3MiYumtsYN16HOL2ailIwHp97pHRINCIpGahCX__Paj3YJtlqYnC0ykSs8KPkHaM755SkEoIXWXXTV7r72eSMEFEHmQeZXKjVZMHoj5yLMA6o4");'>
                </div>
                <div class="relative z-10 p-8 rounded-full bg-surface-dark/50 border border-white/10 backdrop-blur-md shadow-[0_0_30px_rgba(19,19,236,0.2)] transition-transform duration-700 group-hover:scale-105">
                    <span class="material-symbols-outlined text-6xl md:text-8xl text-primary bg-gradient-to-br from-white to-primary bg-clip-text text-transparent" style="-webkit-text-fill-color: transparent;">
                        admin_panel_settings
                    </span>
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-surface-dark via-transparent to-transparent md:bg-gradient-to-r"></div>
            </div>
            <div class="flex-1 flex flex-col justify-between p-8 md:p-12 lg:p-16 relative">
                <div class="flex justify-between items-center w-full mb-8 md:mb-0">
                    <div class="flex gap-1">
                        <div wire:click="$set('step', 1)" class="h-1.5 w-8 rounded-full bg-primary cursor-pointer hover:opacity-80 transition-opacity"></div>
                        <div wire:click="$set('step', 2)" class="h-1.5 w-8 rounded-full bg-primary cursor-pointer hover:bg-primary/50 transition-colors"></div>
                        <div wire:click="$set('step', 3)" class="h-1.5 w-8 rounded-full bg-primary cursor-pointer hover:bg-primary/50 transition-colors"></div>
                        <div wire:click="$set('step', 4)" class="h-1.5 w-8 rounded-full bg-primary cursor-pointer hover:bg-primary/50 transition-colors"></div>
                    </div>
                    <button wire:click="skip" class="text-gray-400 hover:text-white text-sm font-medium transition-colors cursor-pointer flex items-center gap-1 group/skip">
                        {{ __('Pular') }}
                        <span class="material-symbols-outlined text-lg opacity-0 -ml-2 group-hover/skip:opacity-100 group-hover/skip:ml-0 transition-all">chevron_right</span>
                    </button>
                </div>
                <div class="flex flex-col gap-6 my-auto">
                    <div class="space-y-4">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 border border-primary/20 w-fit">
                            <span class="material-symbols-outlined text-primary text-xs">flag</span>
                            <span class="text-primary text-xs font-bold uppercase tracking-wider">{{ __('Passo 4 de 4') }}</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white leading-[1.1] tracking-tight">
                            {{ __('Colabore e') }} <br/>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-500">{{ __('Organize') }}</span>
                        </h1>
                        <p class="text-gray-400 text-lg leading-relaxed max-w-md font-light">
                            {{ __('Gestão centralizada de usuários e permissões. Mantenha seus documentos seguros e sua equipe alinhada em um único ambiente.') }}
                        </p>
                    </div>
                    <div class="flex flex-col gap-3 mt-4">
                        <div class="flex items-center gap-3 text-gray-300">
                            <span class="material-symbols-outlined text-primary text-xl">verified_user</span>
                            <span class="text-sm">{{ __('Controle de acesso granular') }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-gray-300">
                            <span class="material-symbols-outlined text-primary text-xl">folder_shared</span>
                            <span class="text-sm">{{ __('Repositório de documentos seguro') }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row items-center gap-4 mt-8 md:mt-0 pt-6 border-t border-white/5">
                    <button wire:click="previousStep" class="w-full sm:w-auto px-6 h-12 rounded-lg text-gray-400 hover:text-white font-medium transition-colors hover:bg-white/5 flex items-center justify-center gap-2 order-2 sm:order-1">
                        <span class="material-symbols-outlined text-lg">arrow_back</span>
                        {{ __('Voltar') }}
                    </button>
                    <button wire:click="finish" class="w-full sm:w-auto flex-1 group relative overflow-hidden rounded-lg bg-primary hover:bg-primary/90 transition-all duration-300 h-12 px-8 flex items-center justify-center shadow-[0_0_20px_rgba(19,19,236,0.3)] hover:shadow-[0_0_30px_rgba(19,19,236,0.5)] order-1 sm:order-2">
                        <span class="relative z-10 text-white font-semibold tracking-wide flex items-center gap-2">
                            {{ __('Acessar Sistema') }}
                            <span class="material-symbols-outlined text-lg transition-transform group-hover:translate-x-1">rocket_launch</span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        @endif

        <div class="mt-8 text-center animate-fade-in opacity-40 hover:opacity-80 transition-opacity">
            <p class="text-gray-500 text-xs font-medium tracking-wide uppercase">{{ __('Sistema de Gestão de Grupos Econômicos') }}</p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowRight' || e.key === 'Enter') {
             // Dispatch Livewire event or click next button safely
             const nextBtn = document.querySelector('button[wire\\:click="nextStep"]');
             if(nextBtn) nextBtn.click();

             const finishBtn = document.querySelector('button[wire\\:click="finish"]');
             if(finishBtn) finishBtn.click();
        }
        if (e.key === 'ArrowLeft') {
             const prevBtn = document.querySelector('button[wire\\:click="previousStep"]');
             if(prevBtn) prevBtn.click();
        }
    });
</script>
