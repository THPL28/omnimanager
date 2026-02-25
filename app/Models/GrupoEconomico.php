<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable; 
use OwenIt\Auditing\Auditable as AuditableTrait;

class GrupoEconomico extends Model implements Auditable
{
    use HasFactory, AuditableTrait;

    // Garante que o Eloquent use a tabela correta (padrão Laravel: grupo_economicos)
    protected $table = 'grupo_economicos'; 
    
    // Campos que podem ser preenchidos via Mass Assignment (Criação/Edição)
    protected $fillable = [
        'nome',
        'cnpj',
        'responsavel',
        'status',
    ];
    
    // Opcional: define as colunas de data
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    
    // Relacionamento (será usado no CRUD de Bandeira)
    public function bandeiras()
    {
        return $this->hasMany(Bandeira::class, 'grupo_economico_id');
    }
}