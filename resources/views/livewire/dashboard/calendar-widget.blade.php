<div class="h-full flex flex-col" wire:poll.60s="checkReminders">
    
    <!-- Header -->
    <div class="p-4 border-b border-slate-200 dark:border-border-dark flex items-center justify-between bg-white dark:bg-surface-dark rounded-t-xl">
        <h3 class="text-base font-semibold text-slate-900 dark:text-white">{{ __('Agenda') }}</h3>
        <div class="flex gap-1" wire:ignore>
            <button wire:click="previousMonth" class="p-1 hover:bg-slate-100 dark:hover:bg-white/10 rounded transition-colors text-slate-500 dark:text-gray-400">
                <span class="material-symbols-outlined text-[18px]">chevron_left</span>
            </button>
            <span class="text-sm font-medium pt-1 min-w-[100px] text-center dark:text-white">
                {{ \Carbon\Carbon::createFromDate($currentYear, $currentMonth, 1)->locale('pt_BR')->isoFormat('MMMM YYYY') }}
            </span>
            <button wire:click="nextMonth" class="p-1 hover:bg-slate-100 dark:hover:bg-white/10 rounded transition-colors text-slate-500 dark:text-gray-400">
                <span class="material-symbols-outlined text-[18px]">chevron_right</span>
            </button>
        </div>
    </div>

    <!-- Calendar Body -->
    <div class="flex-1 flex flex-col p-4 bg-white dark:bg-surface-dark gap-6">
        
        <!-- Grid -->
        <div class="flex flex-col gap-2">
            <div class="grid grid-cols-7 text-center mb-1">
                @foreach(['D','S','T','Q','Q','S','S'] as $d)
                    <span class="text-xs font-medium text-slate-400 dark:text-gray-600">{{ $d }}</span>
                @endforeach
            </div>
            <div class="grid grid-cols-7 gap-y-2 gap-x-1 text-center text-sm">
                @foreach($this->monthGrid as $day)
                    @if($day)
                        @php
                            $dateKey = \Carbon\Carbon::createFromDate($currentYear, $currentMonth, $day)->format('Y-m-d');
                            $isSelected = $selectedDate === $dateKey;
                            $isToday = \Carbon\Carbon::createFromDate($currentYear, $currentMonth, $day)->isToday();
                            $hasEvent = in_array($dateKey, $this->eventDates);
                        @endphp
                        <button wire:click="selectDate({{ $day }})" 
                              class="py-1 rounded cursor-pointer transition-colors relative flex items-center justify-center
                              {{ $isSelected ? 'bg-primary text-white font-medium shadow-sm shadow-primary/30' : ($isToday ? 'bg-slate-100 dark:bg-white/10 text-primary font-bold' : 'text-slate-700 dark:text-gray-300 hover:bg-slate-100 dark:hover:bg-white/10') }}">
                            {{ $day }}
                            @if($hasEvent)
                                <span class="absolute bottom-1 right-1 sm:bottom-0.5 sm:left-1/2 sm:-translate-x-1/2 size-1 rounded-full {{ $isSelected ? 'bg-white' : 'bg-primary' }}"></span>
                            @endif
                        </button>
                    @else
                        <span></span>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Timeline / Events List -->
        <div class="flex-1 flex flex-col border-t border-slate-100 dark:border-white/5 pt-4 overflow-hidden">
            <div class="flex justify-between items-center mb-3">
                <p class="text-xs font-semibold text-slate-400 dark:text-gray-600 uppercase tracking-wider">
                    {{ \Carbon\Carbon::parse($selectedDate)->locale('pt_BR')->isoFormat('ddd, D [de] MMMM') }}
                </p>
                <button wire:click="openAddModal" class="text-xs flex items-center gap-1 text-primary hover:text-primary-hover font-medium px-2 py-1 rounded hover:bg-primary/5 transition-colors">
                    <span class="material-symbols-outlined text-[14px]">add</span> {{ __('Adicionar') }}
                </button>
            </div>

            <div class="overflow-y-auto pr-1 space-y-3 custom-scrollbar h-full min-h-[150px]">
                @forelse($this->eventsForSelectedDay as $event)
                    <div class="flex gap-3 items-start group relative">
                        <!-- Timeline Line -->
                        <div class="flex flex-col items-center">
                            <span class="text-xs font-bold text-slate-900 dark:text-white">{{ $event->start_time->format('H:i') }}</span>
                            <div class="h-full w-px bg-slate-200 dark:bg-white/10 my-1 group-last:hidden min-h-[20px]"></div>
                        </div>
                        
                        <!-- Event Card -->
                        <div class="flex-1 pb-2">
                             <div wire:click="editEvent({{ $event->id }})" class="p-3 bg-slate-50 dark:bg-white/5 rounded-lg border border-slate-100 dark:border-white/5 hover:border-primary/30 dark:hover:border-primary/30 hover:bg-slate-100 dark:hover:bg-white/10 transition-all cursor-pointer group/card relative overflow-hidden">
                                <div class="flex justify-between items-start mb-1">
                                    <div class="flex items-center gap-2">
                                        <span class="material-symbols-outlined text-[18px] text-primary">{{ $event->icon }}</span>
                                        <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $event->title }}</p>
                                    </div>
                                    @if($event->reminder_at)
                                        <span class="material-symbols-outlined text-[14px] text-amber-500" title="Lembrete: {{ $event->reminder_at->format('H:i') }}">notifications_active</span>
                                    @endif
                                </div>
                                <div class="text-xs text-slate-500 dark:text-gray-400 prose prose-invert prose-xs max-w-none line-clamp-2">
                                    {!! $event->description !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-slate-400 dark:text-gray-600 text-sm flex flex-col items-center">
                        <span class="material-symbols-outlined text-2xl mb-1 opacity-50">event_busy</span>
                        {{ __('Nenhum evento para este dia.') }}
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- ADD/EDIT MODAL -->
    @if($showEventModal)
    <div class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
        
        <div class="bg-white dark:bg-surface-dark rounded-2xl shadow-2xl w-full max-w-lg border border-slate-200 dark:border-border-dark overflow-hidden animate-in zoom-in-95 duration-200"
             @click.away="showEventModal = false">
            
            <div class="px-6 py-4 border-b border-slate-200 dark:border-[rgba(255,255,255,0.08)] flex justify-between items-center bg-slate-50 dark:bg-white/5">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">{{ $isEditing ? 'edit_calendar' : 'event_available' }}</span>
                    {{ $isEditing ? __('Editar Evento') : __('Novo Evento') }}
                </h3>
                <button wire:click="$set('showEventModal', false)" class="text-slate-400 hover:text-slate-500 dark:hover:text-gray-300 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            
            <div class="p-6 space-y-5">
                <!-- Title & Time -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="col-span-2 space-y-1">
                        <label class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase">{{ __('Título') }}</label>
                        <input type="text" wire:model="title" class="w-full rounded-lg border-slate-300 dark:border-white/10 bg-white dark:bg-black/20 text-slate-900 dark:text-white focus:ring-primary focus:border-primary" placeholder="{{ __('Ex: Reunião de Diretoria') }}">
                        @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase">{{ __('Horário') }}</label>
                        <input type="time" wire:model="time" class="w-full rounded-lg border-slate-300 dark:border-white/10 bg-white dark:bg-black/20 text-slate-900 dark:text-white focus:ring-primary focus:border-primary">
                    </div>
                </div>

                <!-- Icon Picker -->
                <div class="space-y-1">
                    <label class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase">{{ __('Ícone') }}</label>
                    <div class="flex gap-2 overflow-x-auto pb-2 no-scrollbar">
                        @foreach(['event', 'work', 'videocam', 'flight', 'lunch_dining', 'celebration', 'warning', 'check_circle', 'schedule', 'groups'] as $ico)
                            <button wire:click="$set('icon', '{{ $ico }}')" 
                                    class="size-10 rounded-lg border flex items-center justify-center transition-all shrink-0
                                    {{ $icon === $ico ? 'bg-primary text-white border-primary shadow-lg shadow-primary/30' : 'bg-slate-50 dark:bg-white/5 border-slate-200 dark:border-white/10 text-slate-500 hover:bg-slate-100 dark:hover:bg-white/10' }}">
                                <span class="material-symbols-outlined">{{ $ico }}</span>
                            </button>
                        @endforeach
                    </div>
                </div>

                <!-- Rich Text Description -->
                <div class="space-y-1" wire:ignore>
                    <label class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase">{{ __('Descrição (Rich Text)') }}</label>
                    <!-- Simple Toolbar -->
                    <div class="border border-slate-300 dark:border-white/10 rounded-lg overflow-hidden bg-white dark:bg-black/20 focus-within:ring-1 focus-within:ring-primary focus-within:border-primary transition-all">
                        <div class="flex items-center gap-1 p-1 border-b border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/5">
                            <button type="button" @click="document.execCommand('bold', false, null)" class="p-1.5 rounded hover:bg-slate-200 dark:hover:bg-white/10 text-slate-600 dark:text-gray-300" title="Negrito">
                                <span class="material-symbols-outlined text-[18px]">format_bold</span>
                            </button>
                            <button type="button" @click="document.execCommand('italic', false, null)" class="p-1.5 rounded hover:bg-slate-200 dark:hover:bg-white/10 text-slate-600 dark:text-gray-300" title="Itálico">
                                <span class="material-symbols-outlined text-[18px]">format_italic</span>
                            </button>
                            <button type="button" @click="document.execCommand('underline', false, null)" class="p-1.5 rounded hover:bg-slate-200 dark:hover:bg-white/10 text-slate-600 dark:text-gray-300" title="Sublinhado">
                                <span class="material-symbols-outlined text-[18px]">format_underlined</span>
                            </button>
                            <button type="button" @click="document.execCommand('formatBlock', false, '<h3>')" class="p-1.5 rounded hover:bg-slate-200 dark:hover:bg-white/10 text-slate-600 dark:text-gray-300" title="Cabeçalho">
                                <span class="material-symbols-outlined text-[18px]">format_size</span>
                            </button>
                            <div class="w-px h-4 bg-slate-300 dark:bg-white/20 mx-1"></div>
                            <button type="button" @click="document.execCommand('strikeThrough', false, null)" class="p-1.5 rounded hover:bg-slate-200 dark:hover:bg-white/10 text-slate-600 dark:text-gray-300" title="{{ __('Riscado') }}">
                                <span class="material-symbols-outlined text-[18px]">strikethrough_s</span>
                            </button>
                            <button type="button" @click="document.execCommand('justifyLeft', false, null)" class="p-1.5 rounded hover:bg-slate-200 dark:hover:bg-white/10 text-slate-600 dark:text-gray-300" title="{{ __('Alinhar Esquerda') }}">
                                <span class="material-symbols-outlined text-[18px]">format_align_left</span>
                            </button>
                            <button type="button" @click="document.execCommand('justifyCenter', false, null)" class="p-1.5 rounded hover:bg-slate-200 dark:hover:bg-white/10 text-slate-600 dark:text-gray-300" title="{{ __('Centralizar') }}">
                                <span class="material-symbols-outlined text-[18px]">format_align_center</span>
                            </button>
                            <button type="button" @click="document.execCommand('insertUnorderedList', false, null)" class="p-1.5 rounded hover:bg-slate-200 dark:hover:bg-white/10 text-slate-600 dark:text-gray-300" title="{{ __('Lista') }}">
                                <span class="material-symbols-outlined text-[18px]">format_list_bulleted</span>
                            </button>
                        </div>
                        <div x-data 
                             class="w-full min-h-[100px] p-3 text-sm text-slate-900 dark:text-white outline-none empty:before:content-[attr(placeholder)] empty:before:text-slate-400" 
                             contenteditable="true" 
                             placeholder="{{ __('Detalhes do evento...') }}"
                             @input="$wire.set('description', $el.innerHTML)"
                             x-ref="editor">
                             {!! $description !!}
                        </div>
                        <!-- Listen for external description update (edit mode) -->
                        <div x-init="$wire.on('set-editor-content', ({ content }) => { $refs.editor.innerHTML = content; })"></div>
                    </div>
                </div>

                <!-- Reminder -->
                <div class="flex items-center gap-3 p-3 rounded-lg border border-slate-200 dark:border-white/10 bg-slate-50 dark:bg-white/5">
                    <div class="flex items-center h-5">
                       <input id="reminder" wire:model.live="reminder" type="checkbox" class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary dark:bg-gray-700 dark:border-gray-600">
                    </div>
                    <div class="flex-1">
                        <label for="reminder" class="text-sm font-medium text-slate-900 dark:text-white select-none cursor-pointer">{{ __('Definir Lembrete Personalizado') }}</label>
                        @if($reminder)
                            <div class="mt-2 animate-in slide-in-from-top-2">
                                <label class="text-xs text-slate-500 mb-1 block">{{ __('Horário do alerta:') }}</label>
                                <input type="time" wire:model="reminderTime" class="w-32 rounded-lg border-slate-300 dark:border-white/10 bg-white dark:bg-black/20 text-slate-900 dark:text-white text-sm py-1">
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-slate-50 dark:bg-white/5 border-t border-slate-200 dark:border-[rgba(255,255,255,0.08)] flex justify-between">
                @if($isEditing)
                    <button wire:click="deleteEvent({{ $eventId }})" wire:confirm="{{ __('Excluir este evento?') }}" class="text-red-500 hover:text-red-700 font-medium text-sm flex items-center gap-1">
                        <span class="material-symbols-outlined text-[18px]">delete</span> {{ __('Excluir') }}
                    </button>
                @else
                    <div></div>
                @endif
                <div class="flex gap-3">
                    <button wire:click="$set('showEventModal', false)" class="px-4 py-2 text-sm font-medium text-slate-700 dark:text-gray-300 hover:bg-slate-100 dark:hover:bg-white/5 rounded-lg transition-colors">
                        {{ __('Cancelar') }}
                    </button>
                    <button wire:click="saveEvent" class="px-4 py-2 text-sm font-medium text-white bg-primary hover:bg-primary-hover rounded-lg shadow-sm shadow-primary/30 transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">save</span> {{ __('Salvar') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- CUSTOM REMINDER ALERT (Toast) -->
    <!-- Alpine x-data to listen for event -->
    <div x-data="{ show: false, title: '', body: '', icon: '' }" 
         x-on:trigger-reminder.window="
            title = $event.detail.title;
            body = $event.detail.body;
            icon = $event.detail.icon;
            show = true; 
            setTimeout(() => show = false, 8000);
            const audio = new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3');
            audio.play().catch(e => console.log('Audio require interaction'));
         "
         class="fixed bottom-6 right-6 z-[100]">
        
        <div x-show="show" 
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="max-w-sm w-full bg-white dark:bg-surface-dark shadow-2xl rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden border-l-4 border-primary">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="size-10 rounded-full bg-primary/10 flex items-center justify-center text-primary animate-pulse">
                            <span class="material-symbols-outlined" x-text="icon || 'notifications'"></span>
                        </div>
                    </div>
                    <div class="ml-3 w-0 flex-1 pt-0.5">
                        <p class="text-sm font-medium text-slate-900 dark:text-white" x-text="title">{{ __('Lembrete!') }}</p>
                        <p class="mt-1 text-sm text-slate-500 dark:text-gray-400" x-text="body">{{ __('Seu evento começa agora.') }}</p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button @click="show = false" class="bg-white dark:bg-transparent rounded-md inline-flex text-slate-400 hover:text-slate-500 focus:outline-none">
                            <span class="sr-only">Close</span>
                            <span class="material-symbols-outlined">close</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
