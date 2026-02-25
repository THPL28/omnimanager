<?php

namespace App\Exports;

use App\Models\Colaborador;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class ColaboradoresExport implements FromQuery, WithHeadings, ShouldAutoSize, WithMapping
{
    // Propriedades para receber os filtros do Livewire
    protected $grupo_economico_id;
    protected $bandeira_id;
    protected $search;

    public function __construct($grupo_economico_id, $bandeira_id, $search)
    {
        $this->grupo_economico_id = $grupo_economico_id;
        $this->bandeira_id = $bandeira_id;
        $this->search = $search;
    }

    /**
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function query()
    {
        // Usa a mesma lógica de consulta do componente Livewire
        $query = Colaborador::with(['unidade.bandeira.grupoEconomico'])
            ->when($this->search, function ($query) {
                $query->where('nome', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%')
                      ->orWhere('cpf', 'like', '%' . $this->search . '%');
            })
            ->when($this->bandeira_id, function ($query) {
                $query->whereHas('unidade', function ($query) {
                    $query->where('bandeira_id', $this->bandeira_id);
                });
            })
            ->when($this->grupo_economico_id && !$this->bandeira_id, function ($query) {
                $query->whereHas('unidade.bandeira', function ($query) {
                    $query->where('grupo_economico_id', $this->grupo_economico_id);
                });
            })
            ->orderBy('nome', 'asc');
            
        return $query;
    }
    
    /**
     * Define os cabeçalhos da planilha
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nome',
            'Email',
            'CPF',
            'Unidade',
            'Bandeira',
            'Grupo Econômico',
            'Data de Criação',
        ];
    }
    
    /**
     * Mapeia os dados do modelo para as colunas da planilha
     */
    public function map($colaborador): array
    {
        return [
            $colaborador->id,
            $colaborador->nome,
            $colaborador->email,
            $colaborador->cpf,
            $colaborador->unidade->nome_fantasia ?? 'N/A',
            $colaborador->unidade->bandeira->nome ?? 'N/A',
            $colaborador->unidade->bandeira->grupoEconomico->nome ?? 'N/A',
            $colaborador->created_at->format('d/m/Y H:i:s'),
        ];
    }
}