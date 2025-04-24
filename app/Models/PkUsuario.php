<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PkUsuario extends Model
{
    protected $table = 'pk_usuarios';

    protected $fillable = [
        'ime_num',
        'cadastro',
        'cic',
        'email',
        'ativo_no_grau',
        'pai',
        'mae',
        'nascimento',
        'cidade1',
        'estado1',
        'nacionalidade',
        'profissao',
        'endereco_residencial',
        'bairro',
        'cidade',
        'estado',
        'cep',
        'telefone_residencial',
        'telefone_comercial',
        'celular',
        'estado_civil',
        'numero_filhos',
        'sexo_m',
        'sexo_f',
        'esposa',
        'nascida',
        'casamento'
    ];

    protected $dates = [
        'nascimento',
        'nascida',
        'casamento'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'ime_num', 'ime');
    }
} 