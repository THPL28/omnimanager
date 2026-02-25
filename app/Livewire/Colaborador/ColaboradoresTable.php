<?php

namespace App\Livewire\Colaborador;

use Livewire\Component;
use App\Models\Colaborador;
use App\Models\Unidade; // Importe o modelo Unidade
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class ColaboradoresTable extends Component
{
    use WithPagination;

    // --- PROPRIEDADES DE ESTADO ---
    public string $search = '';
    public bool $showingModal = false;
    public string $nome = '';
    public string $email = '';
    public string $cpf = '';
    public string $cargo = '';
    public ?int $unidade_id = null; // FK para Unidade
    public ?int $colaboradorId = null; // ID do colaborador em edição
    public string $status = 'Ativo';
    
    // --- FILTROS E SELEÇÃO ---
    public $selectedUnidade = 'Todos';
    public $selectedStatus = 'Ativo'; 
    public array $selectedColaboradores = [];
    public bool $selectAll = false;
    
    // Regras de validação
    protected function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('colaboradors', 'email')->ignore($this->colaboradorId)
            ],
            'cpf' => [
                'required',
                'string',
                'size:11', 
                Rule::unique('colaboradors', 'cpf')->ignore($this->colaboradorId)
            ],
            'cargo' => 'nullable|string|max:100',
            'unidade_id' => 'required|exists:unidades,id', 
            'status' => 'required|in:Ativo,Férias,Desligado',
        ];
    }
    
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatedSelectAll($value): void
    {
        if ($value) {
            $this->selectedColaboradores = Colaborador::pluck('id')->map(fn($id) => (string)$id)->toArray();
        } else {
            $this->selectedColaboradores = [];
        }
    }

    public function updatedSelectedColaboradores(): void
    {
        $this->selectAll = count($this->selectedColaboradores) === Colaborador::count();
    }

    public function setFilterUnidade($unidade): void
    {
        $this->selectedUnidade = $unidade;
        $this->resetPage();
    }

    public function setFilterStatus($status): void
    {
        $this->selectedStatus = $status;
        $this->resetPage();
    }
    
    private function cleanCpf(string $cpf): string
    {
        return preg_replace('/[^0-9]/', '', $cpf);
    }

    // --- MÉTODOS DE CRUD ---

    public function showCreateModal(): void
    {
        $this->resetValidation();
        $this->reset(['nome', 'email', 'cpf', 'cargo', 'unidade_id', 'colaboradorId', 'status']);
        $this->status = 'Ativo';
        $this->showingModal = true;
    }

    public function showEditModal(int $colaboradorId): void
    {
        $this->resetValidation();
        $colaborador = Colaborador::findOrFail($colaboradorId);

        $this->colaboradorId = $colaborador->id;
        $this->nome = $colaborador->nome;
        $this->email = $colaborador->email;
        $this->cpf = $colaborador->cpf;
        $this->cargo = $colaborador->cargo ?? '';
        $this->unidade_id = $colaborador->unidade_id;
        $this->status = $colaborador->status;

        $this->showingModal = true;
    }

    public function saveColaborador(): void
    {
        $this->cpf = $this->cleanCpf($this->cpf);
        $this->validate();

        $data = [
            'nome' => $this->nome,
            'email' => $this->email,
            'cpf' => $this->cpf,
            'cargo' => $this->cargo,
            'unidade_id' => $this->unidade_id,
            'status' => $this->status,
        ];

        Colaborador::updateOrCreate(['id' => $this->colaboradorId], $data);

        $this->showingModal = false;
        $this->reset(['nome', 'email', 'cpf', 'cargo', 'unidade_id', 'colaboradorId', 'status']);
        session()->flash('success', $this->colaboradorId ? 'Colaborador atualizado!' : 'Colaborador criado!');
    }
    
    public function deleteColaborador(int $colaboradorId): void
    {
        Colaborador::destroy($colaboradorId);
        session()->flash('success', 'Colaborador excluído!');
    }

    public function updateColaboradorStatus(int $id, string $newStatus): void
    {
        $colaborador = Colaborador::findOrFail($id);
        $colaborador->status = $newStatus;
        $colaborador->save();
        session()->flash('success', "Status de {$colaborador->nome} atualizado para {$newStatus}!");
    }

    public function render()
    {
        $unidadesList = Unidade::orderBy('nome_fantasia')->get(['id', 'nome_fantasia']);

        $query = Colaborador::with(['unidade.bandeira.grupoEconomico']) 
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->where('nome', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('cpf', 'like', '%' . $this->search . '%')
                      ->orWhere('cargo', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedUnidade !== 'Todos', function ($query) {
                $query->whereHas('unidade', function($q) {
                    $q->where('nome_fantasia', $this->selectedUnidade);
                });
            })
            ->when($this->selectedStatus !== 'Todos', function ($query) {
                $query->where('status', $this->selectedStatus);
            })
            ->orderBy('nome', 'asc');

        return view('livewire.colaborador.colaboradores-table', [
            'colaboradores' => $query->paginate(10),
            'unidades' => $unidadesList,
        ])->layout('layouts.app');
    }
}