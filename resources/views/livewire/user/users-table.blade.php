<div class="flex-1 flex flex-col h-full min-w-0 overflow-hidden bg-background-light dark:bg-background-dark relative">
    {{-- Header Section --}}
    <header class="flex flex-col z-10 bg-background-light dark:bg-background-dark border-b border-gray-200 dark:border-white/5">
        <div class="px-6 pt-5 pb-4 flex items-start justify-between">
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-2 text-xs font-medium">
                    <span class="text-slate-400 dark:text-gray-500">{{ __('Configurações') }}</span>
                    <span class="text-slate-300 dark:text-gray-700">/</span>
                    <span class="text-slate-900 dark:text-gray-200">{{ __('Usuários e Perfis') }}</span>
                </div>
                <h2 class="text-slate-900 dark:text-white text-xl font-semibold tracking-tight">{{ __('Gestão de Usuários') }}</h2>
            </div>
            <div class="flex items-center gap-3">
                <button class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm font-medium text-slate-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5 transition-colors border border-gray-200 dark:border-white/10 shadow-sm">
                    <span class="material-symbols-outlined text-[18px]">file_upload</span>
                    <span>{{ __('Importar') }}</span>
                </button>
                <button wire:click="showCreateModal" class="flex items-center gap-2 bg-primary hover:bg-primary-hover text-white px-4 py-2 rounded-lg text-sm font-bold transition-all shadow-lg shadow-primary/20 active:scale-95">
                    <span class="material-symbols-outlined text-[18px]">person_add</span>
                    <span>{{ __('Novo Usuário') }}</span>
                </button>
            </div>
        </div>

        {{-- Tabs & Filters Bar --}}
        <div class="px-6 pb-0 flex flex-col gap-4">
            <div class="flex items-center justify-between border-b border-gray-200 dark:border-white/[0.06]">
                <div class="flex items-center gap-6 overflow-x-auto no-scrollbar -mb-px">
                    <button wire:click="setFilterRole('Todos')" class="pb-3 border-b-2 {{ $selectedRole === 'Todos' ? 'border-primary text-primary' : 'border-transparent text-slate-500 dark:text-[#8A8F98]' }} text-sm font-semibold whitespace-nowrap transition-all">
                        {{ __('Todos') }}
                        <span class="ml-1.5 text-[10px] bg-primary/10 px-1.5 py-0.5 rounded-full text-primary">{{ $totalCount }}</span>
                    </button>
                    <button wire:click="setFilterRole('admin')" class="pb-3 border-b-2 {{ $selectedRole === 'admin' ? 'border-primary text-primary' : 'border-transparent text-slate-500 dark:text-[#8A8F98]' }} hover:text-slate-700 dark:hover:text-gray-200 text-sm font-semibold whitespace-nowrap transition-all">
                        {{ __('Administradores') }}
                        <span class="ml-1.5 text-[10px] bg-primary/5 px-1.5 py-0.5 rounded-full text-slate-400 group-hover:text-primary transition-colors">{{ $adminsCount }}</span>
                    </button>
                    <button wire:click="setFilterRole('gerente')" class="pb-3 border-b-2 {{ $selectedRole === 'gerente' ? 'border-primary text-primary' : 'border-transparent text-slate-500 dark:text-[#8A8F98]' }} hover:text-slate-700 dark:hover:text-gray-200 text-sm font-semibold whitespace-nowrap transition-all">
                        {{ __('Gerentes') }}
                        <span class="ml-1.5 text-[10px] bg-primary/5 px-1.5 py-0.5 rounded-full text-slate-400 group-hover:text-primary transition-colors">{{ $gerentesCount }}</span>
                    </button>
                </div>
                
                <div class="flex items-center gap-3 pb-2">
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 dark:text-gray-600 text-[18px]">search</span>
                        <input wire:model.live.debounce.500ms="search" class="w-64 bg-transparent border border-transparent hover:border-gray-200 dark:hover:border-white/10 focus:bg-white dark:focus:bg-[#16181D] focus:border-primary/50 text-slate-900 dark:text-white text-sm rounded-md pl-9 pr-2 py-1.5 outline-none transition-all placeholder:text-slate-400 dark:placeholder:text-gray-600" placeholder="{{ __('Buscar usuário...') }}" type="text"/>
                    </div>
                    <div class="h-4 w-px bg-gray-200 dark:bg-white/10 mx-1"></div>
                    <button class="text-slate-400 dark:text-gray-500 hover:text-primary dark:hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-[20px]">filter_list</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    {{-- Content Area --}}
    <div class="flex-1 overflow-auto p-6 no-scrollbar">
        @if (session()->has('success'))
            <div class="mb-4 p-3 bg-emerald-500/10 border border-emerald-500/20 rounded-xl flex items-center gap-3 text-emerald-600 dark:text-emerald-400 text-sm animate-in fade-in slide-in-from-top-2">
                <span class="material-symbols-outlined text-[20px]">check_circle</span>
                {{ session('success') }}
            </div>
        @endif

        <div class="border border-gray-200 dark:border-white/[0.06] rounded-xl overflow-hidden bg-white dark:bg-surface-dark shadow-sm">
            <table class="min-w-full">
                <thead class="bg-gray-50/50 dark:bg-white/[0.02] border-b border-gray-200 dark:border-white/[0.06]">
                    <tr>
                        <th class="px-6 py-4 text-left w-12">
                            <input wire:model.live="selectAll" class="rounded border-gray-300 dark:border-white/20 bg-white dark:bg-white/5 text-primary focus:ring-0 size-3.5 cursor-pointer" type="checkbox"/>
                        </th>
                        <th class="px-6 py-4 text-left text-[11px] font-bold text-slate-500 dark:text-gray-500 uppercase tracking-widest">{{ __('Usuário') }}</th>
                        <th class="px-6 py-4 text-left text-[11px] font-bold text-slate-500 dark:text-gray-500 uppercase tracking-widest">{{ __('Perfil & Cargo') }}</th>
                        <th class="px-6 py-4 text-left text-[11px] font-bold text-slate-500 dark:text-gray-500 uppercase tracking-widest hidden lg:table-cell">{{ __('Grupo Econômico') }}</th>
                        <th class="px-6 py-4 text-left text-[11px] font-bold text-slate-500 dark:text-gray-500 uppercase tracking-widest text-center">{{ __('2FA') }}</th>
                        <th class="px-6 py-4 text-left text-[11px] font-bold text-slate-500 dark:text-gray-500 uppercase tracking-widest text-center">{{ __('Acesso') }}</th>
                        <th class="px-6 py-4 text-right text-[11px] font-bold text-slate-500 dark:text-gray-500 uppercase tracking-widest">{{ __('Ações') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-white/[0.04]">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02] transition-colors group {{ !$user->is_active ? 'bg-gray-50/50 dark:bg-black/10' : '' }}">
                            <td class="px-6 py-4">
                                <input value="{{ $user->id }}" wire:model.live="selectedUsers" class="rounded border-gray-300 dark:border-white/20 bg-white dark:bg-white/5 text-primary focus:ring-0 size-3.5 cursor-pointer" type="checkbox"/>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="size-9 rounded-full bg-primary/10 text-primary border border-primary/20 flex items-center justify-center text-xs font-bold shrink-0">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div class="flex flex-col {{ !$user->is_active ? 'opacity-50' : '' }}">
                                        <span class="text-sm font-bold text-slate-900 dark:text-gray-200 group-hover:text-primary transition-colors">{{ $user->name }}</span>
                                        <span class="text-[11px] text-slate-500 dark:text-gray-500">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-1.5 {{ !$user->is_active ? 'opacity-50' : '' }}">
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider
                                            @if($user->role === 'admin') bg-purple-500/10 text-purple-600 dark:text-purple-400 border border-purple-500/20
                                            @elseif($user->role === 'gerente') bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-500/20
                                            @else bg-gray-500/10 text-gray-600 dark:text-gray-400 border border-gray-500/20 @endif">
                                            <span class="material-symbols-outlined text-[12px]">{{ $user->role === 'admin' ? 'admin_panel_settings' : ($user->role === 'gerente' ? 'manager' : 'person') }}</span>
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </div>
                                    <span class="text-xs text-slate-500 dark:text-gray-500 font-medium">{{ $user->cargo ?: __('Cargo não definido') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 hidden lg:table-cell">
                                <div class="flex items-center gap-2 {{ !$user->is_active ? 'opacity-50' : '' }}">
                                    @if($user->grupo)
                                        <div class="size-1.5 rounded-full bg-emerald-500"></div>
                                        <span class="text-xs font-bold text-slate-700 dark:text-gray-300">{{ $user->grupo->nome }}</span>
                                    @else
                                        <div class="size-1.5 rounded-full bg-slate-300 dark:bg-gray-700"></div>
                                        <span class="text-xs font-medium text-slate-400 dark:text-gray-600 italic">{{ __('Global') }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="material-symbols-outlined text-[20px] {{ $user->two_factor_enabled ? 'text-emerald-500' : 'text-slate-300 dark:text-gray-700' }}">
                                    {{ $user->two_factor_enabled ? 'check_circle' : 'remove_circle_outline' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button wire:click="toggleUserStatus({{ $user->id }})" class="relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-all duration-200 ease-in-out focus:outline-none {{ $user->is_active ? 'bg-primary shadow-[0_0_12px_rgba(var(--primary-rgb),0.3)]' : 'bg-gray-200 dark:bg-white/10' }}">
                                    <span class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $user->is_active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                </button>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button wire:click="showEditModal({{ $user->id }})" class="p-1.5 rounded-lg text-slate-400 hover:text-primary hover:bg-primary/10 transition-all">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </button>
                                    @if($user->id !== auth()->id())
                                        <button wire:click="deleteUser({{ $user->id }})" wire:confirm="{{ __('Excluir permanentemente este usuário?') }}" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-500/10 transition-all">
                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center gap-3 opacity-30">
                                    <span class="material-symbols-outlined text-[48px]">person_off</span>
                                    <p class="text-sm font-bold uppercase tracking-widest text-slate-500">{{ __('Nenhum usuário encontrado') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>

    {{-- Modal --}}
    @if ($showingModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm animate-in fade-in duration-200">
        <div class="bg-surface-light dark:bg-surface-dark rounded-2xl shadow-2xl w-full max-w-lg border border-gray-200 dark:border-white/10 animate-in zoom-in-95 duration-200">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-white/5 flex justify-between items-center">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <div class="size-8 rounded-lg bg-primary/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-[20px]">{{ $userId ? 'edit' : 'person_add' }}</span>
                    </div>
                    {{ $userId ? __('Editar Usuário') : __('Novo Usuário') }}
                </h3>
                <button wire:click="$set('showingModal', false)" class="size-8 flex items-center justify-center rounded-lg hover:bg-gray-100 dark:hover:bg-white/5 text-slate-400 hover:text-slate-500 transition-colors">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </button>
            </div>
            
            <form wire:submit.prevent="saveUser">
                <div class="p-6 space-y-4 max-h-[70vh] overflow-y-auto no-scrollbar">
                    {{-- Nome --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">{{ __('Nome Completo') }}</label>
                        <input type="text" wire:model.live="name" class="w-full bg-gray-50 dark:bg-background-dark border border-gray-200 dark:border-white/5 text-slate-900 dark:text-white text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all shadow-inner" placeholder="{{ __('Ex: Ana Silva') }}">
                        @error('name') <span class="text-red-500 text-[11px] font-semibold mt-1 block pl-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Email --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">{{ __('E-mail') }}</label>
                        <input type="email" wire:model.live="email" class="w-full bg-gray-50 dark:bg-background-dark border border-gray-200 dark:border-white/5 text-slate-900 dark:text-white text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all shadow-inner" placeholder="{{ __('ana@gestao.corp') }}">
                        @error('email') <span class="text-red-500 text-[11px] font-semibold mt-1 block pl-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        {{-- Role --}}
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">{{ __('Perfil') }}</label>
                            <select wire:model="role" class="w-full bg-gray-50 dark:bg-background-dark border border-gray-200 dark:border-white/5 text-slate-900 dark:text-white text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all shadow-inner uppercase tracking-wider font-bold">
                                <option value="user">{{ __('Colaborador') }}</option>
                                <option value="gerente">{{ __('Gerente') }}</option>
                                <option value="admin">{{ __('Administrador') }}</option>
                            </select>
                        </div>
                        {{-- Cargo --}}
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">{{ __('Cargo') }}</label>
                            <input type="text" wire:model.live="cargo" class="w-full bg-gray-50 dark:bg-background-dark border border-gray-200 dark:border-white/5 text-slate-900 dark:text-white text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all shadow-inner" placeholder="{{ __('Ex: Analista Sênior') }}">
                        </div>
                    </div>

                    {{-- Grupo Econômico --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">{{ __('Grupo Econômico Relacionado') }}</label>
                        <select wire:model="grupo_economico_id" class="w-full bg-gray-50 dark:bg-background-dark border border-gray-200 dark:border-white/5 text-slate-900 dark:text-white text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all shadow-inner font-medium">
                            <option value="">{{ __('Acesso Global (Sem restrição de grupo)') }}</option>
                            @foreach($grupos as $grupo)
                                <option value="{{ $grupo->id }}">{{ $grupo->nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Password --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest pl-1">{{ $userId ? __('Alterar Senha (opcional)') : __('Senha') }}</label>
                        <input type="password" wire:model.live="password" class="w-full bg-gray-50 dark:bg-background-dark border border-gray-200 dark:border-white/5 text-slate-900 dark:text-white text-sm rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all shadow-inner" placeholder="••••••••">
                        @error('password') <span class="text-red-500 text-[11px] font-semibold mt-1 block pl-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="bg-gray-50/50 dark:bg-white/[0.02] p-4 rounded-xl border border-gray-100 dark:border-white/5 space-y-3 mt-2">
                        <div class="flex items-center justify-between">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-700 dark:text-gray-300">{{ __('Conta Ativa') }}</span>
                                <span class="text-[10px] text-slate-500 dark:text-gray-500 font-medium">{{ __('Permitir acesso ao sistema') }}</span>
                            </div>
                            <button type="button" @click="$wire.is_active = !$wire.is_active" class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $is_active ? 'bg-primary' : 'bg-gray-200 dark:bg-white/10' }}">
                                <span class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $is_active ? 'translate-x-4' : 'translate-x-0' }}"></span>
                            </button>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-700 dark:text-gray-300">{{ __('Autenticação de 2 Fatores') }}</span>
                                <span class="text-[10px] text-slate-500 dark:text-gray-500 font-medium">{{ __('Exigir código adicional de login') }}</span>
                            </div>
                            <button type="button" @click="$wire.two_factor_enabled = !$wire.two_factor_enabled" class="relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $two_factor_enabled ? 'bg-emerald-500' : 'bg-gray-200 dark:bg-white/10' }}">
                                <span class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $two_factor_enabled ? 'translate-x-4' : 'translate-x-0' }}"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="p-6 pt-2 bg-gray-50/50 dark:bg-black/10 border-t border-gray-200 dark:border-white/5 flex justify-end gap-3 rounded-b-2xl">
                    <button type="button" wire:click="$set('showingModal', false)" class="px-5 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-white/5 rounded-xl transition-all">
                        {{ __('Cancelar') }}
                    </button>
                    <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-primary hover:bg-primary-hover rounded-xl shadow-lg shadow-primary/20 active:scale-95 transition-all">
                        {{ $userId ? __('Salvar Alterações') : __('Convidar Usuário') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
