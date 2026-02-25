<?php

namespace App\Livewire\GrupoEconomico;

use Livewire\Component;
use App\Models\GrupoEconomico; 
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class GruposEconomicosTable extends Component
{
    use WithPagination;

    // --- LISTING PROPS ---
    public string $search = '';
    public string $status = ''; 
    public string $sortField = 'nome';
    public string $sortDirection = 'asc';
    public string $viewMode = 'table'; // 'table' or 'grid'

    // --- BULK ACTIONS ---
    public array $selected = [];
    public bool $selectAll = false;

    // --- FORM PROPS ---
    public bool $showingModal = false;
    public ?int $grupoId = null; 
    
    // Model Fields
    public string $nome = '';
    public string $cnpj = '';
    public string $responsavel = '';
    public string $formStatus = 'ativo';

    // Validation
    protected function rules(): array
    {
        return [
            'nome' => [
                'required', 'string', 'max:255', 
                Rule::unique('grupo_economicos', 'nome')->ignore($this->grupoId)
            ],
            'cnpj' => ['nullable', 'string', 'max:20'],
            'responsavel' => ['nullable', 'string', 'max:255'],
            'formStatus' => ['required', 'in:ativo,pendente,arquivado'],
        ];
    }
    
    public function updatingSearch() { $this->resetPage(); }
    public function updatingStatus() { $this->resetPage(); }

    // --- SORTING ---
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function setStatusFilter($status)
    {
        $this->status = $status;
        $this->resetPage();
    }

    public function setViewMode($mode)
    {
        $this->viewMode = $mode;
    }

    // --- BULK ACTIONS ---
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = $this->getFilteredQuery()->pluck('id')->map(fn($id) => (string)$id)->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function deleteSelected()
    {
        if (empty($this->selected)) return;
        
        GrupoEconomico::whereIn('id', $this->selected)->delete();
        $this->selected = [];
        $this->selectAll = false;
        
        session()->flash('success', 'Registros selecionados excluídos com sucesso!');
    }

    // --- CRUD METHODS ---
    public function showCreateModal(): void
    {
        $this->resetValidation();
        $this->reset(['nome', 'cnpj', 'responsavel', 'grupoId']); 
        $this->formStatus = 'ativo';
        $this->showingModal = true;
    }

    public function showEditModal(int $grupoId): void
    {
        $this->resetValidation();
        $grupo = GrupoEconomico::findOrFail($grupoId);

        $this->grupoId = $grupo->id;
        $this->nome = $grupo->nome;
        $this->cnpj = $grupo->cnpj ?? '';
        $this->responsavel = $grupo->responsavel ?? '';
        $this->formStatus = $grupo->status ?? 'ativo';

        $this->showingModal = true;
    }

    public function saveGrupo(): void
    {
        $this->validate();

        $data = [
            'nome' => $this->nome,
            'cnpj' => $this->cnpj,
            'responsavel' => $this->responsavel,
            'status' => $this->formStatus,
        ];

        if ($this->grupoId) {
            $grupo = GrupoEconomico::findOrFail($this->grupoId);
            $grupo->update($data);
            $message = 'Grupo Econômico atualizado com sucesso!';
        } else {
            GrupoEconomico::create($data);
            $message = 'Grupo Econômico criado com sucesso!';
        }

        $this->showingModal = false; 
        $this->reset(['nome', 'cnpj', 'responsavel', 'grupoId']); 
        session()->flash('success', $message); 
    }
    
    public function deleteGrupo(int $grupoId): void
    {
        GrupoEconomico::destroy($grupoId);
        session()->flash('success', 'Grupo Econômico excluído com sucesso!');
    }
    
    // --- EXPORT ---
    public function exportCsv()
    {
        $fileName = 'grupos_economicos_' . date('Y-m-d_H-i') . '.csv';
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $columns = ['ID', 'Nome', 'CNPJ', 'Responsável', 'Status', 'Criado em'];
        
        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $this->getFilteredQuery()->chunk(100, function($grupos) use ($file) {
                foreach ($grupos as $grupo) {
                    fputcsv($file, [
                        $grupo->id,
                        $grupo->nome,
                        $grupo->cnpj,
                        $grupo->responsavel,
                        $grupo->status,
                        $grupo->created_at,
                    ]);
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Helper for Query to avoid duplication in render and bulk/export
    protected function getFilteredQuery()
    {
        return GrupoEconomico::query() 
            ->when($this->search, function ($q) {
                $q->where(function($sub) {
                    $sub->where('nome', 'like', '%' . $this->search . '%')
                        ->orWhere('cnpj', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status, function ($q) {
                $q->where('status', $this->status);
            })
            ->orderBy($this->sortField, $this->sortDirection);
    }

    public function render()
    {
        return view('livewire.grupo-economico.grupos-economicos-table', [
            'grupos' => $this->getFilteredQuery()->paginate(10),
        ])->layout('layouts.executive');
    }
}