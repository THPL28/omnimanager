<?php

namespace App\Livewire\Auditoria;

use Livewire\Component;
use Livewire\WithPagination;
use OwenIt\Auditing\Models\Audit; // Importe o modelo de auditoria

class AuditLog extends Component
{
    use WithPagination;

    // --- PROPRIEDADES DE ESTADO DOS FILTROS ---
    public string $search = '';
    public string $event = '';
    public string $model = '';
    
    // Lista de tipos de eventos e modelos auditados
    public $events = ['created', 'updated', 'deleted'];
    public $models = [
        'GrupoEconomico', 
        'Bandeira', 
        'Unidade', 
        'Colaborador',
    ];


    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    
    public function updatedEvent(): void
    {
        $this->resetPage();
    }
    
    public function updatedModel(): void
    {
        $this->resetPage();
    }


    public function render()
    {
        // AJUSTE CRÍTICO: Removido with('user') e filtros complexos que dependiam da relação 'user'.
        // Isso garante que a tabela de logs apareça, mesmo que a relação de usuário falhe.
        $audits = Audit::query()
            ->when($this->search, function ($query) {
                // Busca simples no tipo de entidade ou no conteúdo alterado
                $query->where('auditable_type', 'like', '%' . $this->search . '%')
                      ->orWhere('new_values', 'like', '%' . $this->search . '%')
                      // Também permite buscar pelo ID do usuário (sem resolver o nome)
                      ->orWhere('user_id', $this->search);
            })
            ->when($this->event, function ($query) {
                $query->where('event', $this->event);
            })
            ->when($this->model, function ($query) {
                // Filtra pelo nome do modelo (ex: 'Unidade')
                $modelNamespace = "App\\Models\\{$this->model}";
                $query->where('auditable_type', $modelNamespace);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);


        return view('livewire.auditoria.audit-log', [
            'audits' => $audits,
        ])->layout('layouts.app');
       
    }
}