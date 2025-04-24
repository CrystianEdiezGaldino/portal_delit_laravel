<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    protected $table = 'contatos';

    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'assunto',
        'mensagem',
        'status'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function scopePendentes($query)
    {
        return $query->where('status', 'pendente');
    }

    public function scopeRespondidos($query)
    {
        return $query->where('status', 'respondido');
    }

    public function scopeArquivados($query)
    {
        return $query->where('status', 'arquivado');
    }
} 