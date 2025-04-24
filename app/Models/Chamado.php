<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chamado extends Model
{
    protected $table = 'chamados';

    protected $fillable = [
        'usuario_ime',
        'atendente_ime',
        'titulo',
        'descricao',
        'prioridade',
        'status',
        'data_abertura',
        'data_atendimento',
        'data_fechamento'
    ];

    protected $dates = [
        'data_abertura',
        'data_atendimento',
        'data_fechamento'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_ime', 'ime');
    }

    public function atendente()
    {
        return $this->belongsTo(Usuario::class, 'atendente_ime', 'ime');
    }
} 