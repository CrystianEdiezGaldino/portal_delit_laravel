<?php

namespace App\Services;

use App\Models\Usuario;
use App\Models\PkUsuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PrimeiroAcessoService
{
    protected $usuario;
    protected $pkUsuario;
    protected $emailService;

    public function __construct(Usuario $usuario, PkUsuario $pkUsuario, EmailService $emailService)
    {
        $this->usuario = $usuario;
        $this->pkUsuario = $pkUsuario;
        $this->emailService = $emailService;
    }

    public function verificarDados($ime, $cpf)
    {
        $pkUsuario = $this->pkUsuario->where('ime_num', $ime)->first();

        if (!$pkUsuario) {
            throw new \Exception('IME não encontrado');
        }

        if ($pkUsuario->cic !== $cpf) {
            throw new \Exception('CPF não confere');
        }

        return $pkUsuario;
    }

    public function gerarSenhaAleatoria()
    {
        return Str::random(6);
    }

    public function criarPrimeiroAcesso($pkUsuario)
    {
        try {
            DB::beginTransaction();

            $senha = $this->gerarSenhaAleatoria();
            
            $usuario = $this->usuario->updateOrCreate(
                ['ime' => $pkUsuario->ime_num],
                [
                    'nome' => $pkUsuario->cadastro,
                    'email' => $pkUsuario->email,
                    'senha' => md5($senha),
                    'role' => 'usuario',
                    'status' => 'ativo',
                    'grau' => $pkUsuario->ativo_no_grau
                ]
            );

            // Envia email com as credenciais
            $dadosEmail = [
                'nome' => $usuario->nome,
                'ime' => $usuario->ime,
                'email' => $usuario->email,
                'senha' => $senha
            ];

            $this->emailService->enviarEmailPrimeiroAcesso($dadosEmail);

            DB::commit();
            return $usuario;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
} 