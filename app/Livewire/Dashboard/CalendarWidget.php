<?php

namespace App\Livewire\Dashboard;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Livewire\Component;

/**
 * Componente Livewire do Calendário do Dashboard.
 * 
 * Este componente gerencia toda a lógica do calendário: navegação entre meses,
 * seleção de datas, e operações CRUD (Criar, Ler, Atualizar, Deletar) de eventos.
 * Como um componente Livewire 3, ele é reativo e atualiza a interface sem recarregar a página.
 */
class CalendarWidget extends Component
{
    // --- ESTADO DO CALENDÁRIO ---
    
    // Mês e Ano atualmente visíveis no calendário
    public $currentMonth;
    public $currentYear;
    
    // Data selecionada pelo usuário (padrão: hoje) no formato Y-m-d
    public $selectedDate;
    
    // Lista de eventos e grid de dias (utilizados para renderizar a interface)
    public $events = [];
    public $daysInMonth = [];

    // --- ESTADO DO MODAL ---
    
    // Controla a visibilidade do modal de edição/criação
    public $showEventModal = false;
    
    // Define se estamos editando um evento existente ou criando um novo
    public $isEditing = false;
    public $eventId = null;

    // --- CAMPOS DO FORMULÁRIO ---
    
    public $title = '';
    public $description = '';
    public $icon = 'event';
    public $time = '09:00';
    public $reminder = false;
    public $reminderTime = '';

    // Armazena o evento que disparou um lembrete no momento
    public $activeReminder = null;

    /**
     * Regras de validação para o formulário.
     * O Livewire usa isso automaticamente ao chamar $this->validate().
     */
    protected $rules = [
        'title' => 'required|min:3',
        'time' => 'required',
        'icon' => 'required',
    ];

    /**
     * O método mount() é o 'construtor' do componente Livewire.
     * Aqui inicializamos o estado inicial com a data atual.
     */
    public function mount()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->selectedDate = now()->format('Y-m-d');
        
        $this->loadEvents();
    }

    public function loadEvents()
    {
        // Load events for the selected month to show dots/indicators
        // And specifically for the selected date for the timeline
        
        // Optimizing: Just load for current month view + selected day
        // For simplicity in this widget, we might just load current month
    }

    /**
     * Propriedade Computada: Retorna os eventos do dia selecionado.
     * Usamos o prefixo 'get...Property' para criar uma Computed Property no Livewire.
     * Isso é eficiente pois o resultado é cacheado durante o mesmo request.
     */
    public function getEventsForSelectedDayProperty()
    {
        return Event::where('user_id', auth()->id())
            ->whereDate('start_time', $this->selectedDate)
            ->orderBy('start_time')
            ->get();
    }

    /**
     * Propriedade Computada: Gera a grade (grid) do mês atual.
     * Calcula quantos dias o mês tem e em qual dia da semana ele começa,
     * preenchendo as células vazias necessárias para que o dia 1 caia no local correto.
     */
    public function getMonthGridProperty()
    {
        $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1);
        $daysInMonth = $date->daysInMonth;
        $firstDayOfWeek = $date->dayOfWeek; // 0 (Dom) - 6 (Sab)
        
        $grid = [];
        
        // Células vazias antes do início do mês (ex: se o mês começa na quarta, pula dom, seg e ter)
        for ($i = 0; $i < $firstDayOfWeek; $i++) {
            $grid[] = null;
        }
        
        // Preenche com os números dos dias (1, 2, 3...)
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $grid[] = $day;
        }
 
        return $grid;
    }

    /**
     * Navega para o mês anterior.
     */
    public function previousMonth()
    {
        $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        // Ao trocar de mês, selecionamos por padrão o primeiro dia.
        $this->selectedDate = $date->startOfMonth()->format('Y-m-d');
    }

    /**
     * Navega para o próximo mês.
     */
    public function nextMonth()
    {
        $date = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
        $this->selectedDate = $date->startOfMonth()->format('Y-m-d');
    }

    /**
     * Define a data selecionada quando o usuário clica em um dia no calendário.
     */
    public function selectDate($day)
    {
        if (!$day) return;
        $this->selectedDate = Carbon::createFromDate($this->currentYear, $this->currentMonth, $day)->format('Y-m-d');
    }

    /**
     * Prepara o formulário para criar um novo evento.
     */
    public function openAddModal()
    {
        // Limpa os campos para evitar que dados de um evento editado anteriormente apareçam.
        $this->reset(['title', 'description', 'time', 'reminder', 'reminderTime', 'eventId', 'isEditing']);
        $this->icon = 'event';
        $this->time = now()->format('H:i');
        $this->showEventModal = true;
    }

    /**
     * Carrega os dados de um evento para edição.
     */
    public function editEvent($id)
    {
        $event = Event::find($id);
        
        // Verificação de segurança: apenas o dono do evento pode editá-lo.
        if ($event && $event->user_id === auth()->id()) {
            $this->eventId = $event->id;
            $this->isEditing = true;
            $this->title = $event->title;
            $this->description = $event->description;
            $this->icon = $event->icon;
            $this->time = $event->start_time->format('H:i');
            
            if ($event->reminder_at) {
                $this->reminder = true;
                $this->reminderTime = $event->reminder_at->format('H:i');
            } else {
                $this->reminder = false;
                $this->reminderTime = '';
            }

            $this->showEventModal = true;
            
            // Dispara um evento do navegador (browser event) para que o editor de texto rico (Quill/Trix) 
            // no front-end carregue o conteúdo atualizado.
            $this->dispatch('set-editor-content', content: $this->description);
        }
    }

    /**
     * Salva ou atualiza o evento no banco de dados.
     */
    public function saveEvent()
    {
        $this->validate();

        // Combina a data selecionada com o horário preenchido para criar um objeto Carbon.
        $startDateTime = Carbon::createFromFormat('Y-m-d H:i', $this->selectedDate . ' ' . $this->time);
        
        $reminderAt = null;
        if ($this->reminder && $this->reminderTime) {
            $reminderAt = Carbon::createFromFormat('Y-m-d H:i', $this->selectedDate . ' ' . $this->reminderTime);
        }

        if ($this->isEditing) {
            $event = Event::find($this->eventId);
            $event->update([
                'title' => $this->title,
                'description' => $this->description,
                'icon' => $this->icon,
                'start_time' => $startDateTime,
                'reminder_at' => $reminderAt,
            ]);
        } else {
            // Criação de um novo registro. Associamos ao ID do usuário autenticado.
            Event::create([
                'user_id' => auth()->id(),
                'title' => $this->title,
                'description' => $this->description,
                'icon' => $this->icon,
                'start_time' => $startDateTime,
                'reminder_at' => $reminderAt,
            ]);
        }

        $this->showEventModal = false;
        
        // Notifica o front-end para atualizar visualmente a lista de eventos.
        $this->dispatch('refresh-calendar');
    }

    /**
     * Remove um evento.
     */
    public function deleteEvent($id)
    {
        Event::where('id', $id)->where('user_id', auth()->id())->delete();
    }

    /**
     * Lógica de Lembretes: Verifica se há eventos com remetente agendado para o minuto atual.
     * Este método é chamado via polling (wire:poll) no front-end.
     */
    public function checkReminders()
    {
        $now = now();
        $start = $now->copy()->startOfMinute();
        $end = $now->copy()->endOfMinute();

        // Busca eventos do usuário logado que tenham lembrete marcado para agora.
        $events = Event::where('user_id', auth()->id())
            ->whereBetween('reminder_at', [$start, $end])
            ->get();

        foreach ($events as $event) {
            // Dispara um alerta visual (toast/notificação) no front-end.
            $this->dispatch('trigger-reminder', [
                'title' => $event->title,
                'body' => __('Seu evento começa às :time', ['time' => $event->start_time->format('H:i')]),
                'icon' => $event->icon
            ]);
            $this->activeReminder = $event;
        }
    }

    /**
     * Propriedade Computada: Retorna as datas que possuem eventos no mês atual.
     * Isso evita rodar uma query para cada dia no loop do Blade (Problema N+1).
     */
    public function getEventDatesProperty()
    {
        $start = Carbon::createFromDate($this->currentYear, $this->currentMonth, 1)->startOfMonth();
        $end = $start->copy()->endOfMonth();

        return Event::where('user_id', auth()->id())
            ->whereBetween('start_time', [$start, $end])
            ->pluck('start_time')
            ->map(fn($date) => $date->format('Y-m-d'))
            ->unique()
            ->toArray();
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div class="p-6 flex items-center justify-center h-full min-h-[400px]">
            <div class="flex flex-col items-center gap-4">
                <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-primary"></div>
                 <p class="text-sm text-slate-500 animate-pulse">{{ __('Carregando Calendário...') }}</p>
            </div>
        </div>
        HTML;
    }
}
