<?php

namespace App\Repositories;

use App\Models\Usuario;
use App\Models\PkUsuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioRepository
{
    protected $usuario;
    protected $pkUsuario;

    public function __construct(Usuario $usuario, PkUsuario $pkUsuario)
    {
        $this->usuario = $usuario;
        $this->pkUsuario = $pkUsuario;
    }

    public function criarUsuario($dados)
    {
        try {
            DB::beginTransaction();

            $usuario = $this->usuario->create([
                'ime' => $dados['ime'],
                'nome' => $dados['nome'],
                'email' => $dados['email'],
                'senha' => md5($dados['senha']),
                'role' => $dados['role'] ?? 'usuario',
                'status' => 'ativo'
            ]);

            $this->pkUsuario->create([
                'ime_num' => $dados['ime'],
                'cadastro' => $dados['nome'],
                'email' => $dados['email'],
                'ativo_no_grau' => $dados['grau'] ?? 1
            ]);

            DB::commit();
            return $usuario;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function atualizarUsuario($ime, $dados)
    {
        try {
            DB::beginTransaction();

            $usuario = $this->usuario->where('ime', $ime)->first();
            $usuario->update([
                'nome' => $dados['nome'],
                'email' => $dados['email'],
                'role' => $dados['role'] ?? $usuario->role,
                'grau' => $dados['grau'] ?? $usuario->grau
            ]);

            $this->pkUsuario->where('ime_num', $ime)->update([
                'cadastro' => $dados['nome'],
                'email' => $dados['email'],
                'ativo_no_grau' => $dados['grau'] ?? 1
            ]);

            DB::commit();
            return $usuario;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deletarUsuario($ime)
    {
        try {
            DB::beginTransaction();

            $this->usuario->where('ime', $ime)->delete();
            $this->pkUsuario->where('ime_num', $ime)->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function buscarPorIme($ime)
    {
        return $this->usuario->where('ime', $ime)->first();
    }

    public function listarUsuarios($filtros = [])
    {
        $query = $this->usuario->query();

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