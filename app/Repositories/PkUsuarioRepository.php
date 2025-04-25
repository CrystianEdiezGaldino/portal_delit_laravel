<?php

namespace App\Repositories;

use App\Models\PkUsuario;
use Illuminate\Support\Facades\DB;

class PkUsuarioRepository
{
    protected $model;

    public function __construct(PkUsuario $model)
    {
        $this->model = $model;
    }

    public function criar(array $dados)
    {
        return $this->model->create($dados);
    }

    public function atualizar($id, array $dados)
    {
        $pkUsuario = $this->model->findOrFail($id);
        $pkUsuario->update($dados);
        return $pkUsuario;
    }

    public function buscarPorIme($ime)
    {
        return $this->model->where('ime_num', $ime)->first();
    }

    public function deletar($id)
    {
        $pkUsuario = $this->model->findOrFail($id);
        $pkUsuario->delete();
        return true;
    }
} 