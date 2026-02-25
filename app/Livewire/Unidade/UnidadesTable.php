<?php

namespace App\Livewire\Unidade;

use Livewire\Component;
use App\Models\Unidade;
use App\Models\Bandeira;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class UnidadesTable extends Component
{
    use WithPagination;

    // --- PROPRIEDADES DE ESTADO ---
    public string $search = '';
    public bool $showingModal = false;
    public string $nome_fantasia = '';
    public string $razao_social = '';
    public string $cnpj = '';
    public ?int $bandeira_id = null; // FK para Bandeira
    public ?int $unidadeId = null; // ID da unidade em edição

    // --- FILTROS E SELEÇÃO ---
    public $selectedBandeira = 'Todos';
    public $selectedStatus = 'Todos';
    public array $selectedUnidades = [];
    public bool $selectAll = false;
    
    // Regras de validação
    protected function rules(): array
    {
        return [
            'nome_fantasia' => 'required|string|max:255',
            'razao_social' => 'required|string|max:255',
            'cnpj' => [
                'required',
                'string',
                'size:14',
                Rule::unique('unidades', 'cnpj')->ignore($this->unidadeId)
            ],
            'bandeira_id' => 'required|exists:bandeiras,id', 
        ];
    }
    
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value): void
    {
        if ($value) {
            $this->selectedUnidades = Unidade::pluck('id')->map(fn($id) => (string)$id)->toArray();
        } else {
            $this->selectedUnidades = [];
        }
    }

    public function updatedSelectedUnidades(): void
    {
        $this->selectAll = count($this->selectedUnidades) === Unidade::count();
    }

    public function setFilterBandeira($bandeira): void
    {
        $this->selectedBandeira = $bandeira;
        $this->resetPage();
    }

    public function setFilterStatus($status): void
    {
        $this->selectedStatus = $status;
        $this->resetPage();
    }
    
    // Função auxiliar para limpar CNPJ
    private function cleanCnpj(string $cnpj): string
    {
        return preg_replace('/[^0-9]/', '', $cnpj);
    }

    // --- MÉTODOS DE CRUD ---

    public function showCreateModal(): void
    {
        $this->resetValidation();
        $this->reset(['nome_fantasia', 'razao_social', 'cnpj', 'bandeira_id', 'unidadeId']);
        $this->showingModal = true;
    }

    public function showEditModal(int $unidadeId): void
    {
        $this->resetValidation();
        $unidade = Unidade::findOrFail($unidadeId);

        $this->unidadeId = $unidade->id;
        $this->nome_fantasia = $unidade->nome_fantasia;
        $this->razao_social = $unidade->razao_social;
        $this->cnpj = $unidade->cnpj;
        $this->bandeira_id = $unidade->bandeira_id;

        $this->showingModal = true;
    }

    public function saveUnidade(): void
    {
        $this->cnpj = $this->cleanCnpj($this->cnpj);
        $this->validate();

        $data = [
            'nome_fantasia' => $this->nome_fantasia,
            'razao_social' => $this->razao_social,
            'cnpj' => $this->cnpj,
            'bandeira_id' => $this->bandeira_id,
        ];

        Unidade::updateOrCreate(['id' => $this->unidadeId], $data);

        $this->showingModal = false;
        $this->reset(['nome_fantasia', 'razao_social', 'cnpj', 'bandeira_id', 'unidadeId']);
        session()->flash('success', $this->unidadeId ? 'Unidade atualizada!' : 'Unidade criada!');
    }
    
    public function deleteUnidade(int $unidadeId): void
    {
        Unidade::destroy($unidadeId);
        session()->flash('success', 'Unidade excluída!');
    }

    public function render()
    {
        $bandeiras = Bandeira::orderBy('nome')->get(['id', 'nome']);

        $query = Unidade::with(['bandeira.grupoEconomico']) 
            ->when($this->search, function ($query) {
                $query->where('nome_fantasia', 'like', '%' . $this->search . '%')
                      ->orWhere('razao_social', 'like', '%' . $this->search . '%')
                      ->orWhere('cnpj', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedBandeira !== 'Todos', function ($query) {
                $query->whereHas('bandeira', function($q) {
                    $q->where('nome', $this->selectedBandeira);
                });
            })
            ->orderBy('nome_fantasia', 'asc');

        return view('livewire.unidade.unidades-table', [
            'unidades' => $query->paginate(10),
            'bandeiras' => $bandeiras,
        ])->layout('layouts.app');
    }
}