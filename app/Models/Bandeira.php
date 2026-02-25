<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable; 
use OwenIt\Auditing\Auditable as AuditableTrait;

class Bandeira extends Model implements Auditable
{
    use HasFactory, AuditableTrait;

    // Campos preenchíveis em massa
    protected $fillable = [
        'nome',
        'grupo_economico_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    // Relacionamento: Uma Bandeira pertence a um Grupo Econômico
    public function grupoEconomico()
    {
        return $this->belongsTo(GrupoEconomico::class, 'grupo_economico_id');
    }

    // Relacionamento: Uma Bandeira tem muitas Unidades
    public function unidades(): HasMany
    {
        return $this->hasMany(Unidade::class);
    }
}