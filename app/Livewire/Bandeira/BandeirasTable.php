<?php

namespace App\Livewire\Bandeira;

use Livewire\Component;
use App\Models\Bandeira;
use App\Models\GrupoEconomico; // Importe o modelo GrupoEconomico
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class BandeirasTable extends Component
{
    use WithPagination;

    // --- PROPRIEDADES DE ESTADO ---
    public string $search = '';
    public bool $showingModal = false;
    public string $nome = '';
    public ?int $grupo_economico_id = null; // FK para Grupo Econômico
    public ?int $bandeiraId = null; // ID da bandeira em edição

    // --- FILTROS E SELEÇÃO ---
    public $selectedGrupo = 'Todos';
    public $selectedStatus = 'Todos';
    public array $selectedBandeiras = [];
    public bool $selectAll = false;
    
    // Regras de validação
    protected function rules(): array
    {
        return [
            'nome' => [
                'required', 
                'string', 
                'max:255', 
                // Garante que o nome da bandeira seja único, ignorando a bandeira atual na edição
                Rule::unique('bandeiras', 'nome')->ignore($this->bandeiraId) 
            ],
            // Valida se o grupo_economico_id é obrigatório e existe na tabela 'grupo_economicos'
            'grupo_economico_id' => 'required|exists:grupo_economicos,id', 
        ];
    }
    
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value): void
    {
        if ($value) {
            $this->selectedBandeiras = Bandeira::pluck('id')->map(fn($id) => (string)$id)->toArray();
        } else {
            $this->selectedBandeiras = [];
        }
    }

    public function updatedSelectedBandeiras(): void
    {
        $this->selectAll = count($this->selectedBandeiras) === Bandeira::count();
    }

    public function setFilterGrupo($grupo): void
    {
        $this->selectedGrupo = $grupo;
        $this->resetPage();
    }

    public function setFilterStatus($status): void
    {
        $this->selectedStatus = $status;
        $this->resetPage();
    }

    // --- MÉTODOS DE CRUD ---

    public function showCreateModal(): void
    {
        $this->resetValidation();
        $this->reset(['nome', 'grupo_economico_id', 'bandeiraId']);
        $this->showingModal = true;
    }

    public function showEditModal(int $bandeiraId): void
    {
        $this->resetValidation();
        $bandeira = Bandeira::findOrFail($bandeiraId);

        $this->bandeiraId = $bandeira->id;
        $this->nome = $bandeira->nome;
        $this->grupo_economico_id = $bandeira->grupo_economico_id;

        $this->showingModal = true;
    }

    public function saveBandeira(): void
    {
        $this->validate();

        $data = [
            'nome' => $this->nome,
            'grupo_economico_id' => $this->grupo_economico_id,
        ];

        if ($this->bandeiraId) {
            Bandeira::findOrFail($this->bandeiraId)->update($data);
            $message = 'Bandeira atualizada com sucesso!';
        } else {
            Bandeira::create($data);
            $message = 'Bandeira criada com sucesso!';
        }

        $this->showingModal = false;
        $this->reset(['nome', 'grupo_economico_id', 'bandeiraId']);
        session()->flash('success', $message);
    }
    
    public function deleteBandeira(int $bandeiraId): void
    {
        Bandeira::destroy($bandeiraId);
        session()->flash('success', 'Bandeira excluída com sucesso!');
    }


    public function render()
    {
        // Lista de Grupos Econômicos para popular o SELECT no modal
        $grupos = GrupoEconomico::orderBy('nome')->get(['id', 'nome']);

        // Query de Bandeiras (incluindo o relacionamento para exibição na tabela)
        $query = Bandeira::with('grupoEconomico')
            ->withCount('unidades')
            ->when($this->search, function ($query) {
                $query->where('nome', 'like', '%' . $this->search . '%')
                      ->orWhereHas('grupoEconomico', function($q) {
                          $q->where('nome', 'like', '%' . $this->search . '%');
                      });
            })
            ->when($this->selectedGrupo !== 'Todos', function ($query) {
                $query->whereHas('grupoEconomico', function($q) {
                    $q->where('nome', $this->selectedGrupo);
                });
            })
            // Nota: Status não existe no banco, então o filtro é apenas visual por enquanto
            ->orderBy('nome', 'asc');

        return view('livewire.bandeira.bandeiras-table', [
            'bandeiras' => $query->paginate(10),
            'grupos' => $grupos, // Passa os grupos para a view
        ])->layout('layouts.app');
    }
}