<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConteudoIead extends Model
{
    protected $table = 'conteudos_iead';

    protected $fillable = [
        'titulo',
        'descricao',
        'grau',
        'tipo_conteudo',
        'caminho_arquivo'
    ];

    public function getUrlAttribute()
    {
        return asset($this->caminho_arquivo);
    }
} 