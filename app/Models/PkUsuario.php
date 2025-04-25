<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PkUsuario extends Model
{
    use HasFactory;

    protected $table = 'pk_usuarios';
    public $timestamps = false;
    public $incrementing = false;

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
        'casamento',
        'rg',
        'orgao_expedidor',
        'iniciado_loja',
        'numero_loja',
        'potencia_inicial',
        'cidade2',
        'estado2',
        'membro_ativo_loja',
        'numero_da_loja',
        'cidade3',
        'estado3',
        'apr_em',
        'comp_em',
        'mest_em',
        'mi_em',
        'potencia_corpo_filosofico',
        'codigo',
        'tipo_categoria',
        'cond_rec',
        'cond_gr_rec',
        'cond_mont',
        'rec',
        'gr_rec',
        'monte',
        'condecoracoes_scb',
        'grau_4_em',
        'col_corpo_1',
        'diploma_4_num',
        'grau_5_em',
        'col_corpo_05',
        'diploma_5_num',
        'grau_7_em',
        'col_corpo_14',
        'diploma_7_num',
        'grau_9_em',
        'col_corpo_2',
        'diploma_9_num',
        'grau_10_em',
        'col_corpo_3',
        'diploma_10_num',
        'grau_14_em',
        'col_corpo_4',
        'diploma_14_num',
        'grau_15_em',
        'col_corpo_5',
        'diploma_15_num',
        'grau_16_em',
        'col_corpo_15',
        'diploma_16_num',
        'grau_17_em',
        'col_corpo_16',
        'diploma_17_num',
        'grau_18_em',
        'col_corpo_6',
        'breve_18_num',
        'grau_19_em',
        'col_corpo_7',
        'diploma_19_num',
        'grau_22_em',
        'col_corpo_8',
        'diploma_22_num',
        'grau_29_em',
        'col_corpo_9',
        'diploma_29_num',
        'grau_30_em',
        'col_corpo_10',
        'patente_30_num',
        'grau_31_em',
        'col_corpo_11',
        'patente_31_num',
        'grau_32_em',
        'col_corpo_12',
        'patente_32_num',
        'grau_33_em',
        'col_corpo_13',
        'patente_33_num'
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