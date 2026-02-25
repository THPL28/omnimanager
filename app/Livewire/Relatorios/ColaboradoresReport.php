<?php

namespace App\Livewire\Relatorios;

use Livewire\Component;
use App\Models\Colaborador;
use App\Models\GrupoEconomico;
use App\Models\Bandeira;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel; // <-- Importe o Facade do Excel
use App\Exports\ColaboradoresExport;


class ColaboradoresReport extends Component
{
    use WithPagination;

    // --- PROPRIEDADES DE ESTADO DOS FILTROS ---
    public string $search = '';
    public ?int $grupo_economico_id = null;
    public ?int $bandeira_id = null;

    // Listas auxiliares para os filtros (não são bindadas, apenas listam opções)
    public $grupos;
    public $bandeirasDisponiveis = [];

    // --- CICLO DE VIDA (PARA CARREGAR DADOS INICIAIS) ---

    public function mount()
    {
        // Carrega todos os grupos na inicialização
        $this->grupos = GrupoEconomico::orderBy('nome')->get(['id', 'nome']);
        // Se um grupo já estiver selecionado (ex: ao voltar para a página), carrega as bandeiras
        if ($this->grupo_economico_id) {
            $this->loadBandeiras();
        } else {
            // Se nenhum grupo estiver selecionado, carrega todas as bandeiras disponíveis
            $this->bandeirasDisponiveis = Bandeira::orderBy('nome')->get(['id', 'nome']);
        }
    }

    // --- MÉTODOS DE FILTRO ---

    // Este método será chamado sempre que $grupo_economico_id mudar (via wire:model)
    public function updatedGrupoEconomicoId(): void
    {
        $this->resetPage(); // Reseta a paginação ao mudar o filtro
        $this->bandeira_id = null; // Zera a bandeira ao mudar o grupo
        $this->loadBandeiras();
    }

    public function updatedBandeiraId(): void
    {
        $this->resetPage(); // Reseta a paginação ao mudar o filtro
    }
    
    public function updatingSearch(): void
    {
        $this->resetPage(); // Reseta a paginação ao mudar a busca
    }

    // Lógica para carregar apenas as bandeiras do grupo selecionado
    private function loadBandeiras(): void
    {
        if ($this->grupo_economico_id) {
            $this->bandeirasDisponiveis = Bandeira::where('grupo_economico_id', $this->grupo_economico_id)
                                                  ->orderBy('nome')
                                                  ->get(['id', 'nome']);
        } else {
            // Se nenhum grupo estiver selecionado, mostra todas as bandeiras
             $this->bandeirasDisponiveis = Bandeira::orderBy('nome')->get(['id', 'nome']);
        }
    }
    
    // Método para limpar todos os filtros
    public function clearFilters(): void
    {
        $this->reset(['grupo_economico_id', 'bandeira_id', 'search']);
        $this->loadBandeiras(); // Recarrega todas as bandeiras
        $this->resetPage();
    }

    // Método para remover um filtro específico
    public function removeFilter(string $filter): void
    {
        if ($filter === 'search') $this->search = '';
        if ($filter === 'grupo') {
            $this->grupo_economico_id = null;
            $this->bandeira_id = null;
            $this->loadBandeiras();
        }
        if ($filter === 'bandeira') $this->bandeira_id = null;
        
        $this->resetPage();
    }
    // --- NOVO MÉTODO DE EXPORTAÇÃO ---
    public function export(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        // Pega o timestamp atual para nomear o arquivo
        $timestamp = now()->format('Ymd_His');
        $filename = "relatorio_colaboradores_{$timestamp}.xlsx";
        
        // Retorna o download usando a classe de exportação e os filtros atuais
        return Excel::download(
            new ColaboradoresExport(
                $this->grupo_economico_id, 
                $this->bandeira_id, 
                $this->search
            ), 
            $filename
        );
    }

    // --- MÉTODO RENDER (MONTAGEM DA CONSULTA) ---

    public function render()
    {
        $colaboradores = Colaborador::with(['unidade.bandeira.grupoEconomico'])
            ->when($this->search, function ($query) {
                // Filtro por nome, email ou cpf
                $query->where('nome', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('cpf', 'like', '%' . $this->search . '%');
            })
            ->when($this->bandeira_id, function ($query) {
                // Filtro por Bandeira (se a bandeira foi selecionada)
                $query->whereHas('unidade', function ($query) {
                    $query->where('bandeira_id', $this->bandeira_id);
                });
            })
            ->when($this->grupo_economico_id && !$this->bandeira_id, function ($query) {
                // Filtro por Grupo Econômico (se o grupo foi selecionado, mas a bandeira não)
                $query->whereHas('unidade.bandeira', function ($query) {
                    $query->where('grupo_economico_id', $this->grupo_economico_id);
                });
            })
            ->orderBy('nome', 'asc')
            ->paginate(15); // Paginação padrão

        return view('livewire.relatorios.colaboradores-report', [
            'colaboradores' => $colaboradores,
        ])->layout('layouts.app');
    }
}