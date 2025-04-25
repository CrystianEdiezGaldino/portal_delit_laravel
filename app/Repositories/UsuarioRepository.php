<?php

namespace App\Repositories;

use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioRepository
{
    protected $model;

    public function __construct(Usuario $model)
    {
        $this->model = $model;
    }

    public function criar(array $dados)
    {
        return $this->model->create($dados);
    }

    public function atualizar($id, array $dados)
    {
        $usuario = $this->model->findOrFail($id);
        $usuario->update($dados);
        return $usuario;
    }

    public function buscarPorIme($ime)
    {
        return $this->model->where('ime', $ime)->first();
    }

    public function deletar($id)
    {
        $usuario = $this->model->findOrFail($id);
        $usuario->delete();
        return true;
    }

    public function listarUsuarios($filtros = [])
    {
        $query = $this->model->query();

        if (!empty($filtros['nome'])) {
            $query->where('nome', 'like', "%{$filtros['nome']}%");
        }

        if (!empty($filtros['ime'])) {
            $query->where('ime', 'like', "%{$filtros['ime']}%");
        }

        if (!empty($filtros['grau'])) {
            $query->where('grau', $filtros['grau']);
        }

        return $query->paginate(100);
    }
} 