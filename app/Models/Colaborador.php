<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable; 
use OwenIt\Auditing\Auditable as AuditableTrait;

class Colaborador extends Model  implements Auditable
{
    use HasFactory, AuditableTrait;

    // Campos preenchíveis em massa
    protected $fillable = [
        'nome',
        'email',
        'cpf',
        'cargo',
        'unidade_id',
        'status',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    // Relacionamento: Um Colaborador pertence a uma Unidade
    public function unidade(): BelongsTo
    {
        return $this->belongsTo(Unidade::class);
    }
}