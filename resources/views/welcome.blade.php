<!DOCTYPE html>
<html class="dark" lang="pt-BR">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ __('OmniManager - Controle Financeiro para a Empresa Moderna') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#1313ec",
                        "primary-hover": "#2e2ef1",
                        "background-light": "#f6f6f8",
                        "background-dark": "#050508", // Darker for Linear look
                        "surface-dark": "#121217",
                        "border-dark": "rgba(255, 255, 255, 0.08)",
                    },
                    fontFamily: {
                        "display": ["Inter", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.375rem", "lg": "0.5rem", "xl": "0.75rem", "2xl": "1rem", "full": "9999px"},
                    backgroundImage: {
                        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
                    }
                },
            },
        }
    </script>
    <style>
        /* Custom scrollbar for a cleaner look */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #050508; 
        }
        ::-webkit-scrollbar-thumb {
            background: #333; 
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555; 
        }
        
        .glass-nav {
            background: rgba(5, 5, 8, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .text-glow {
            text-shadow: 0 0 40px rgba(255,255,255,0.1);
        }
        
        .hero-glow {
            background: radial-gradient(circle at center, rgba(19, 19, 236, 0.15) 0%, rgba(5, 5, 8, 0) 70%);
        }

        /* Subtle grid background */
        .bg-grid {
            background-size: 40px 40px;
            background-image: linear-gradient(to right, rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                              linear-gradient(to bottom, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-gray-300 font-display antialiased overflow-x-hidden selection:bg-primary selection:text-white">
<!-- Top Navigation -->
<nav class="fixed top-0 left-0 right-0 z-50 glass-nav h-16 flex items-center justify-center transition-all duration-300">
    <div class="w-full max-w-[1200px] px-6 flex items-center justify-between">
        <div class="flex items-center gap-3 text-white">
            <div class="size-6 text-primary">
                <x-application-logo class="w-full h-full" />
            </div>
            <h2 class="text-white text-lg font-bold tracking-tight">OmniManager</h2>
        </div>
        <div class="hidden md:flex items-center gap-8">
            <a class="text-gray-400 hover:text-white text-sm font-medium transition-colors" href="#features">{{ __('Recursos') }}</a>
            <a class="text-gray-400 hover:text-white text-sm font-medium transition-colors" href="#how-it-works">{{ __('Como funciona') }}</a>
            <a class="text-gray-400 hover:text-white text-sm font-medium transition-colors" href="#testimonials">{{ __('Depoimentos') }}</a>
            <a class="text-gray-400 hover:text-white text-sm font-medium transition-colors" href="#">{{ __('Preços') }}</a>
        </div>
        <div class="flex items-center gap-4">
            <a class="hidden sm:block text-sm font-medium text-white hover:text-gray-300" href="{{ route('login') }}">{{ __('Login') }}</a>
            <button class="flex items-center justify-center rounded-lg h-9 px-4 bg-white/10 hover:bg-white/20 border border-white/5 text-white text-sm font-medium transition-all group">
                <span class="truncate">{{ __('Solicitar Demo') }}</span>
                <span class="material-symbols-outlined text-[16px] ml-1 group-hover:translate-x-0.5 transition-transform">arrow_forward</span>
            </button>
        </div>
    </div>
</nav>
<main class="relative flex flex-col items-center w-full pt-20">
<!-- Hero Section -->
<section class="relative w-full max-w-[1200px] px-6 py-20 md:py-32 flex flex-col items-center text-center">
<!-- Background Decoration -->
<div class="absolute inset-0 -z-10 overflow-hidden pointer-events-none">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[600px] hero-glow opacity-60 blur-3xl"></div>
    <div class="absolute top-[100px] left-1/2 -translate-x-1/2 w-full h-full bg-grid opacity-20 mask-image-gradient"></div>
</div>
<!-- Badge -->
<div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 text-xs font-medium text-primary mb-8 animate-fade-in-up">
    <span class="flex h-2 w-2 rounded-full bg-primary animate-pulse"></span>
    {{ __('Novo: Integração com Bancos Globais v2.0') }}
</div>
<!-- Heading -->
<h1 class="text-white text-5xl md:text-7xl font-bold tracking-tight leading-[1.1] mb-6 max-w-4xl text-glow bg-clip-text text-transparent bg-gradient-to-b from-white to-white/60">
    {{ __('Controle Financeiro para a Empresa Moderna') }}
</h1>
<!-- Subheading -->
<p class="text-gray-400 text-lg md:text-xl font-normal leading-relaxed max-w-2xl mb-10">
    {{ __('Unifique entidades, automatize conciliações e capacite sua equipe financeira com o OmniManager. A plataforma definitiva para CFOs.') }}
</p>
<!-- CTA Buttons -->
<div class="flex flex-col sm:flex-row items-center gap-4 w-full justify-center mb-16">
    <button class="h-12 px-8 rounded-full bg-primary hover:bg-primary-hover text-white text-sm font-semibold tracking-wide shadow-[0_0_20px_-5px_rgba(19,19,236,0.5)] transition-all hover:scale-105 active:scale-95 flex items-center justify-center gap-2">
        {{ __('Solicitar Demonstração') }}
        <span class="material-symbols-outlined text-[18px]">chevron_right</span>
    </button>
    <button class="h-12 px-8 rounded-full bg-transparent border border-white/20 hover:bg-white/5 text-white text-sm font-medium transition-all flex items-center justify-center">
        {{ __('Ver vídeo de apresentação') }}
    </button>
</div>
<!-- Dashboard Preview (3D Tilt Effect Simulation) -->
<div class="relative w-full max-w-5xl group perspective-1000">
    <div class="relative rounded-xl border border-border-dark bg-surface-dark/50 backdrop-blur-sm shadow-2xl overflow-hidden aspect-[16/9] md:aspect-[21/9] transition-transform duration-700 hover:scale-[1.01]">
        <!-- Header of the fake UI -->
        <div class="h-10 border-b border-border-dark flex items-center px-4 gap-2 bg-white/5">
            <div class="w-3 h-3 rounded-full bg-red-500/20 border border-red-500/50"></div>
            <div class="w-3 h-3 rounded-full bg-yellow-500/20 border border-yellow-500/50"></div>
            <div class="w-3 h-3 rounded-full bg-green-500/20 border border-green-500/50"></div>
        </div>
        <!-- Image Content -->
        <div class="w-full h-full bg-cover bg-center" data-alt="Modern dark dashboard interface showing financial charts and data analytics grid" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAwfZOPdJGxxZrt2AU8jp0HzNM3uTms7TzGSUlQe4PNNvBRAHVgiaKBgNcS0pP9de2N4c-F49hoWhQxfNShAdw_p2hW95N0CghSTEh2tEd5AhNEdS1bd1WY68I0I6vVsFy1y5fVvdTAXUziy-_WFj7FpNgcjDE2fra_9AapTpe-P3iO6lkZkZi5lRZvJF2XTLz1Dej-T-ACIFi5oFWoSo2dMT4gM69rLOLnXSZ8W2Hi00YydLJnXrusgdP-aWxiMZFwrH4MX650dngz'); opacity: 0.8;">
            <!-- Overlay gradient to blend with footer of image -->
            <div class="absolute inset-0 bg-gradient-to-t from-background-dark via-transparent to-transparent opacity-60"></div>
        </div>
    </div>
    <!-- Glow behind the dashboard -->
    <div class="absolute -inset-1 bg-primary/20 blur-2xl -z-10 rounded-[2rem] opacity-40"></div>
</div>
</section>
<!-- Brands / Social Proof -->
<section class="w-full border-y border-border-dark bg-white/[0.02]">
    <div class="max-w-[1200px] mx-auto px-6 py-10">
        <p class="text-center text-sm text-gray-500 mb-8 font-medium">{{ __('CONFIADO POR LÍDERES FINANCEIROS EM') }}</p>
        <div class="flex flex-wrap justify-center items-center gap-12 md:gap-20 opacity-50 grayscale hover:grayscale-0 transition-all duration-500">
            <!-- Simple Text Logos for Demo -->
            <span class="text-xl font-bold text-white tracking-widest">ACME Corp</span>
            <span class="text-xl font-bold text-white tracking-widest font-serif italic">GlobalBank</span>
            <span class="text-xl font-bold text-white tracking-tighter">FINTECH<span class="text-primary">.io</span></span>
            <span class="text-xl font-bold text-white tracking-widest">STRATOS</span>
            <span class="text-xl font-bold text-white tracking-widest border-2 border-white p-1">SQUARE</span>
        </div>
    </div>
</section>
<!-- Features Section (Bento Grid) -->
<section class="w-full max-w-[1200px] px-6 py-24" id="features">
    <div class="flex flex-col gap-4 mb-16 max-w-2xl">
        <h2 class="text-white text-3xl md:text-4xl font-bold tracking-tight">{{ __('Destaques do Sistema') }}</h2>
        <p class="text-gray-400 text-lg">{{ __('Tudo o que você precisa para uma gestão financeira de alta performance em uma única plataforma.') }}</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1 -->
        <div class="group relative p-8 rounded-2xl bg-surface-dark border border-border-dark hover:border-primary/30 transition-colors overflow-hidden">
            <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 transition-opacity">
                <span class="material-symbols-outlined text-8xl text-primary">account_tree</span>
            </div>
            <div class="relative z-10 flex flex-col h-full">
                <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary mb-6 group-hover:scale-110 transition-transform duration-300">
                    <span class="material-symbols-outlined text-2xl">account_tree</span>
                </div>
                <h3 class="text-white text-xl font-bold mb-3">{{ __('Gestão de Multi-entidades') }}</h3>
                <p class="text-gray-400 leading-relaxed text-sm">{{ __('Gerencie múltiplas empresas e filiais em uma única árvore hierárquica unificada. Consolidação automática de balanços.') }}</p>
            </div>
        </div>
        <!-- Card 2 -->
        <div class="group relative p-8 rounded-2xl bg-surface-dark border border-border-dark hover:border-primary/30 transition-colors overflow-hidden">
            <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 transition-opacity">
                <span class="material-symbols-outlined text-8xl text-primary">bolt</span>
            </div>
            <div class="relative z-10 flex flex-col h-full">
                <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary mb-6 group-hover:scale-110 transition-transform duration-300">
                    <span class="material-symbols-outlined text-2xl">bolt</span>
                </div>
                <h3 class="text-white text-xl font-bold mb-3">{{ __('Controle em Tempo Real') }}</h3>
                <p class="text-gray-400 leading-relaxed text-sm">{{ __('Visibilidade financeira instantânea. Dashboards atualizados a cada transação, sem esperar o fechamento do mês.') }}</p>
            </div>
        </div>
        <!-- Card 3 -->
        <div class="group relative p-8 rounded-2xl bg-surface-dark border border-border-dark hover:border-primary/30 transition-colors overflow-hidden">
            <div class="absolute top-0 right-0 p-8 opacity-10 group-hover:opacity-20 transition-opacity">
                <span class="material-symbols-outlined text-8xl text-primary">groups</span>
            </div>
            <div class="relative z-10 flex flex-col h-full">
                <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary mb-6 group-hover:scale-110 transition-transform duration-300">
                    <span class="material-symbols-outlined text-2xl">groups</span>
                </div>
                <h3 class="text-white text-xl font-bold mb-3">{{ __('Colaboração Fluida') }}</h3>
                <p class="text-gray-400 leading-relaxed text-sm">{{ __('Trabalhe em sincronia com sua equipe, contadores e auditores externos com permissões granulares e logs de auditoria.') }}</p>
            </div>
        </div>
    </div>
</section>
<!-- How It Works Section -->
<section class="w-full bg-surface-dark/30 border-y border-border-dark py-24" id="how-it-works">
    <div class="max-w-[960px] mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-white text-3xl font-bold tracking-tight mb-4">{{ __('Fluxo de Trabalho Inteligente') }}</h2>
            <p class="text-gray-400">{{ __('Do dado bruto ao insight estratégico em segundos.') }}</p>
        </div>
        <div class="relative">
            <!-- Connecting Line (Vertical on mobile) -->
            <div class="absolute left-[19px] top-4 bottom-4 w-0.5 bg-gradient-to-b from-primary/50 via-primary/20 to-transparent md:hidden"></div>
            <div class="flex flex-col gap-12">
                <!-- Step 1 -->
                <div class="flex gap-6 md:items-center group">
                    <div class="relative z-10 flex-shrink-0 w-10 h-10 rounded-full bg-surface-dark border border-primary text-primary flex items-center justify-center shadow-[0_0_15px_-3px_rgba(19,19,236,0.3)]">
                        <span class="material-symbols-outlined text-sm">cloud_download</span>
                    </div>
                    <div class="flex-1 md:grid md:grid-cols-2 md:gap-12 md:items-center">
                        <div class="md:text-right order-1 md:order-1">
                            <h3 class="text-white text-lg font-bold mb-1">{{ __('Ingestão de Dados') }}</h3>
                            <p class="text-gray-400 text-sm">{{ __('Conexão via API Bancária e ERPs.') }}</p>
                        </div>
                        <div class="hidden md:block w-full h-[1px] bg-border-dark order-2 relative">
                            <div class="absolute right-0 -top-1 w-2 h-2 rounded-full bg-primary/50"></div>
                        </div>
                        <div class="mt-4 md:mt-0 order-3 md:order-3 md:col-span-2 md:w-1/2 md:ml-auto md:pl-12">
                            <!-- Abstract visualization could go here, simplified text for now -->
                            <div class="p-4 rounded border border-border-dark bg-surface-dark/50">
                                <div class="flex items-center gap-3 text-xs text-gray-500 font-mono">
                                    <span class="text-green-400">GET</span> /api/v1/transactions <span class="ml-auto">200 OK</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Step 2 -->
                <div class="flex gap-6 md:items-center group">
                    <div class="relative z-10 flex-shrink-0 w-10 h-10 rounded-full bg-surface-dark border border-gray-700 text-gray-400 group-hover:border-primary group-hover:text-primary transition-colors flex items-center justify-center">
                        <span class="material-symbols-outlined text-sm">neurology</span>
                    </div>
                    <div class="flex-1 md:grid md:grid-cols-2 md:gap-12 md:items-center">
                        <div class="mt-4 md:mt-0 order-3 md:order-1 md:col-span-2 md:w-1/2 md:mr-auto md:pr-12 md:text-right">
                            <div class="p-4 rounded border border-border-dark bg-surface-dark/50">
                                <div class="flex items-center gap-2 mb-2">
                                    <div class="h-1.5 w-12 bg-primary rounded-full"></div>
                                    <div class="h-1.5 w-8 bg-gray-700 rounded-full"></div>
                                </div>
                                <div class="text-xs text-gray-500 font-mono">Processing logic...</div>
                            </div>
                        </div>
                        <div class="hidden md:block w-full h-[1px] bg-border-dark order-2 relative"></div>
                        <div class="order-1 md:order-3">
                            <h3 class="text-white text-lg font-bold mb-1">{{ __('Motor de IA') }}</h3>
                            <p class="text-gray-400 text-sm">{{ __('Conciliação automática e categorização.') }}</p>
                        </div>
                    </div>
                </div>
                <!-- Step 3 -->
                <div class="flex gap-6 md:items-center group">
                    <div class="relative z-10 flex-shrink-0 w-10 h-10 rounded-full bg-surface-dark border border-gray-700 text-gray-400 group-hover:border-primary group-hover:text-primary transition-colors flex items-center justify-center">
                        <span class="material-symbols-outlined text-sm">monitoring</span>
                    </div>
                    <div class="flex-1 md:grid md:grid-cols-2 md:gap-12 md:items-center">
                        <div class="md:text-right order-1 md:order-1">
                            <h3 class="text-white text-lg font-bold mb-1">{{ __('Relatórios Estratégicos') }}</h3>
                            <p class="text-gray-400 text-sm">{{ __('Dashboards prontos para diretoria.') }}</p>
                        </div>
                        <div class="hidden md:block w-full h-[1px] bg-border-dark order-2 relative">
                            <div class="absolute left-0 -top-1 w-2 h-2 rounded-full bg-primary/50"></div>
                        </div>
                        <div class="mt-4 md:mt-0 order-3 md:order-3 md:col-span-2 md:w-1/2 md:ml-auto md:pl-12">
                            <div class="p-4 rounded border border-border-dark bg-surface-dark/50 flex gap-2 items-end h-16">
                                <div class="w-1/4 h-3/4 bg-primary/80 rounded-t"></div>
                                <div class="w-1/4 h-1/2 bg-primary/40 rounded-t"></div>
                                <div class="w-1/4 h-full bg-primary rounded-t"></div>
                                <div class="w-1/4 h-2/3 bg-primary/60 rounded-t"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Testimonials -->
<section class="w-full max-w-[1200px] px-6 py-24" id="testimonials">
    <h2 class="text-center text-white text-3xl font-bold tracking-tight mb-16">{{ __('O que dizem os líderes') }}</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Testimonial 1 -->
        <div class="p-6 rounded-xl bg-surface-dark border border-border-dark flex flex-col gap-4">
            <div class="flex gap-1 text-primary">
                <span class="material-symbols-outlined text-sm">star</span>
                <span class="material-symbols-outlined text-sm">star</span>
                <span class="material-symbols-outlined text-sm">star</span>
                <span class="material-symbols-outlined text-sm">star</span>
                <span class="material-symbols-outlined text-sm">star</span>
            </div>
            <p class="text-gray-300 text-sm leading-relaxed">{{ __('"O OmniManager transformou a forma como fechamos o mês. O que levava 10 dias agora fazemos em 2. A visibilidade multi-entidade é imbatível."') }}</p>
            <div class="mt-auto flex items-center gap-3 pt-4 border-t border-border-dark">
                <div class="w-10 h-10 rounded-full bg-cover bg-center" data-alt="Portrait of a professional woman in a suit" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBUwkKyNn7iUB7T6E8EM1nRtJA3anD9djqXHzulUzC5syZwfeWoVgIwIAIzC9doqeVxPlADMTsbXUBty40pYMxgzO72jkfVVsHuHFNC-9PX9x-nQ7GBUV5YnuNpU71ycdh9S4j5nocPSLhgvN-78cgAgAGCDVC36wbcFpOCn417WMB4Y2CNG7qFrF-LfS8EkcIChAnLKxWpJL2WSDaq9m_BNpckCrAI0BYwwYUmRmT0rP9U21-3R-iO2GZ3NODP9xfIRUbl38kCl-L9');"></div>
                <div>
                    <div class="text-white text-sm font-semibold">Ana Silva</div>
                    <div class="text-gray-500 text-xs">CFO, TechFlow Inc.</div>
                </div>
            </div>
        </div>
        <!-- Testimonial 2 -->
        <div class="p-6 rounded-xl bg-surface-dark border border-border-dark flex flex-col gap-4">
            <div class="flex gap-1 text-primary">
                <span class="material-symbols-outlined text-sm">star</span>
                <span class="material-symbols-outlined text-sm">star</span>
                <span class="material-symbols-outlined text-sm">star</span>
                <span class="material-symbols-outlined text-sm">star</span>
                <span class="material-symbols-outlined text-sm">star</span>
            </div>
            <p class="text-gray-300 text-sm leading-relaxed">{{ __('"Interface limpa, rápida e intuitiva. Minha equipe não precisou de treinamento complexo para começar a usar. A automação é real."') }}</p>
            <div class="mt-auto flex items-center gap-3 pt-4 border-t border-border-dark">
                <div class="w-10 h-10 rounded-full bg-cover bg-center" data-alt="Portrait of a professional man in a blue shirt" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDBJq-SglsSXV0r9bT_Da-mO5uUHkwIenSYx1r0xfBOIACT-AMBcFRRFeOBHlrv3CC7dp-Iv4SzCBOIpyuuBxieqQGXd6bVQSO-HjWGL8TWI9Oe-fdPU5otL6FgL7pBZ0Mk1l7ko_7h8aoAUDNDLOmw3xqyEoDTjLGwqXvltmazhACBNa8HygiS94ptyed91qnWZNIvxyPl7hP1Y49Z6S7JWGH3CwBRp8PsyHWqxpLEyvt7wGAmsHo4ej-Ew8rDzDqhfk35aSyJYFAp');"></div>
                <div>
                    <div class="text-white text-sm font-semibold">Roberto Mendes</div>
                    <div class="text-gray-500 text-xs">Controller, Grupo Solar</div>
                </div>
            </div>
        </div>
        <!-- Testimonial 3 -->
        <div class="p-6 rounded-xl bg-surface-dark border border-border-dark flex flex-col gap-4 md:col-span-2 lg:col-span-1">
            <div class="flex gap-1 text-primary">
                <span class="material-symbols-outlined text-sm">star</span>
                <span class="material-symbols-outlined text-sm">star</span>
                <span class="material-symbols-outlined text-sm">star</span>
                <span class="material-symbols-outlined text-sm">star</span>
                <span class="material-symbols-outlined text-sm">star</span>
            </div>
            <p class="text-gray-300 text-sm leading-relaxed">{{ __('"A precisão dos dados melhorou drasticamente. É a ferramenta essencial para qualquer empresa que busca compliance e agilidade."') }}</p>
            <div class="mt-auto flex items-center gap-3 pt-4 border-t border-border-dark">
                <div class="w-10 h-10 rounded-full bg-cover bg-center" data-alt="Portrait of a smiling professional man" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDRUzT6UN2h47Iy0Ji2dKrxZHtg5eIjKfnUet5rsQEz83nA1pL-PdO-xfuobRO87eT_n3JNijhsztCMs6e3md_8lv0SAQpOaodUU8OHBLQbC2eZ7bVu85j94ODmzmO42i8w_NSKP-E_WOFJ_KR_StwxjWCfFp1j8o2lfkX-9MX3nyL-vWjI68K0Hk4ozrRLYbvD8JS5gWQOuTBG8JtvK5pVZ1I6wg1saZ-ofdT3LA640xkec3ZqYIkbNJVu_LfqILByvVEcp2Jbd6hR');"></div>
                <div>
                    <div class="text-white text-sm font-semibold">Carlos Ferreira</div>
                    <div class="text-gray-500 text-xs">Diretor Financeiro, LogiCorp</div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Final CTA / Footer -->
<section class="w-full relative py-24 overflow-hidden">
    <div class="absolute inset-0 bg-primary/5"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-background-dark via-background-dark/80 to-transparent"></div>
    <div class="relative z-10 max-w-[600px] mx-auto px-6 text-center">
        <div class="inline-flex items-center justify-center p-3 mb-6 bg-primary/10 rounded-full text-primary">
            <span class="material-symbols-outlined text-3xl">rocket_launch</span>
        </div>
        <h2 class="text-white text-4xl md:text-5xl font-bold tracking-tight mb-6">{{ __('Pronto para elevar seu financeiro?') }}</h2>
        <p class="text-gray-400 mb-10 text-lg">{{ __('Junte-se a centenas de empresas que já modernizaram sua gestão.') }}</p>
        <form class="flex flex-col gap-4 bg-surface-dark/80 backdrop-blur border border-border-dark p-6 rounded-2xl shadow-2xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex flex-col text-left gap-1">
                    <label class="text-xs font-semibold text-gray-500 uppercase" for="name">{{ __('Nome') }}</label>
                    <input class="bg-background-dark border border-border-dark rounded-lg px-4 py-2.5 text-white placeholder-gray-600 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all" id="name" placeholder="{{ __('Seu nome') }}" type="text"/>
                </div>
                <div class="flex flex-col text-left gap-1">
                    <label class="text-xs font-semibold text-gray-500 uppercase" for="email">{{ __('Email Corporativo') }}</label>
                    <input class="bg-background-dark border border-border-dark rounded-lg px-4 py-2.5 text-white placeholder-gray-600 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all" id="email" placeholder="voce@empresa.com" type="email"/>
                </div>
            </div>
            <div class="flex flex-col text-left gap-1">
                <label class="text-xs font-semibold text-gray-500 uppercase" for="company">{{ __('Empresa') }}</label>
                <input class="bg-background-dark border border-border-dark rounded-lg px-4 py-2.5 text-white placeholder-gray-600 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all" id="company" placeholder="{{ __('Nome da sua empresa') }}" type="text"/>
            </div>
            <button class="mt-2 w-full h-12 rounded-lg bg-primary hover:bg-primary-hover text-white font-bold transition-colors" type="button">{{ __('Solicitar Contato') }}</button>
            <p class="text-xs text-gray-600 text-center mt-2">{{ __('Sem compromisso. Seus dados estão seguros.') }}</p>
        </form>
    </div>
</section>
<!-- Footer Links -->
<footer class="w-full border-t border-border-dark bg-background-dark py-12">
    <div class="max-w-[1200px] mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-2 text-white">
            <div class="size-5 text-gray-500">
                <x-application-logo class="w-full h-full" />
            </div>
            <span class="text-sm font-semibold text-gray-500">OmniManager © 2023</span>
        </div>
        <div class="flex gap-8">
            <a class="text-xs text-gray-500 hover:text-white transition-colors" href="#">{{ __('Privacidade') }}</a>
            <a class="text-xs text-gray-500 hover:text-white transition-colors" href="#">{{ __('Termos') }}</a>
            <a class="text-xs text-gray-500 hover:text-white transition-colors" href="#">Twitter</a>
            <a class="text-xs text-gray-500 hover:text-white transition-colors" href="#">LinkedIn</a>
        </div>
    </div>
</footer>
</main>
</body>
</html>
