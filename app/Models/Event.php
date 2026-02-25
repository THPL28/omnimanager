<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Modelo de Evento do Calendário
 *
 * Este modelo representa um compromisso ou atividade agendada pelo usuário.
 * Como bons desenvolvedores, usamos 'fillable' para proteção contra 'mass assignment'
 * e 'casts' para garantir que as datas sejam tratadas como objetos Carbon nativamente.
 */
class Event extends Model
{
    use HasFactory;

    /**
     * Define quais campos podem ser preenchidos em massa.
     * Isso é uma boa prática de segurança no Laravel.
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'icon',
        'start_time',
        'end_time',
        'reminder_at',
    ];

    /**
     * Mapeia os campos do banco de dados para tipos específicos do PHP.
     * Ao converter para 'datetime', o Laravel automaticamente nos entrega instâncias do Carbon,
     * permitindo formatar datas facilmente na interface (ex: ->format('H:i')).
     */
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'reminder_at' => 'datetime',
    ];

    /**
     * Relacionamento: Todo evento pertence a um único usuário.
     * Isso nos permite acessar o dono do evento via $event->user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
