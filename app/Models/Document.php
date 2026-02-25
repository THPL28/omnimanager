<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    protected $fillable = [
        'grupo_economico_id', 'setor', 'descricao', 'current_path', 'mime', 'size', 'uploaded_by'
    ];

    public function grupo(): BelongsTo
    {
        return $this->belongsTo(GrupoEconomico::class, 'grupo_economico_id');
    }

    public function versions()
    {
        return $this->hasMany(DocumentVersion::class);
    }
}
