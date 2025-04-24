<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planilha extends Model
{
    protected $table = 'planilhas';

    protected $fillable = [
        'nome',
        'caminho',
        'grau_acesso'
    ];

    public function getUrlAttribute()
    {
        return asset($this->caminho);
    }
} 