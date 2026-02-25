<?php

namespace App\Models;

// Importações padrão do Laravel...
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// REMOVIDO: use Laravel\Sanctum\HasApiTokens;

// Importações do Laravel Auditing
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\GrupoEconomico;


/**
 * Modelo de Usuário Principal.
 * 
 * Além das funcionalidades de autenticação padrão do Laravel, este modelo:
 * 1. Implementa 'Auditable' para registrar logs de mudanças automaticamente (via pacote owen-it/laravel-auditing).
 * 2. Possui um relacionamento com 'GrupoEconomico', permitindo vincular usuários a empresas específicas.
 */
class User extends Authenticatable implements Auditable 
{
    use HasFactory, Notifiable, AuditableTrait; 

    /**
     * Campos que podem ser preenchidos em massa.
     * Note a adição de 'grupo_economico_id' e 'role' para suporte multi-empresa e permissões.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'profile_photo_path',
        'grupo_economico_id',
        'role',
        'is_active',
        'two_factor_enabled',
        'cargo',
        'locale',
    ];

    /**
     * Campos sensíveis que não devem ser expostos em respostas API (JSON).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Conversão de tipos de atributos.
     * 'hashed' garante que a senha seja criptografada automaticamente ao salvar.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relacionamento: O usuário pertence a um Grupo Econômico.
     */
    public function grupo(): BelongsTo
    {
        return $this->belongsTo(GrupoEconomico::class, 'grupo_economico_id');
    }
}
