<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable; 
use OwenIt\Auditing\Auditable as AuditableTrait;

class Unidade extends Model  implements Auditable
{
    use HasFactory, AuditableTrait;

    // Campos preenchíveis em massa
    protected $fillable = [
        'nome_fantasia',
        'razao_social',
        'cnpj',
        'bandeira_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
    // Relacionamento: Uma Unidade pertence a uma Bandeira
    public function bandeira(): BelongsTo
    {
        return $this->belongsTo(Bandeira::class);
    }

    // Relacionamento: Uma Unidade tem muitos Colaboradores
    public function colaboradores(): HasMany
    {
        return $this->hasMany(Colaborador::class);
    }
}