<?php

namespace App\Services;

use App\Mail\CadastroRealizado;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailService
{
    public function enviarEmailCadastro($dados)
    {
        try {
            Mail::to($dados['email'])->send(new CadastroRealizado($dados));
            return true;
        } catch (\Exception $e) {
            Log::error('Erro ao enviar email de cadastro: ' . $e->getMessage());
            return false;
        }
    }

    public function enviarEmailPrimeiroAcesso($dados)
    {
        try {
            Mail::to($dados['email'])->send(new CadastroRealizado($dados));
            return true;
        } catch (\Exception $e) {
            Log::error('Erro ao enviar email de primeiro acesso: ' . $e->getMessage());
            return false;
        }
    }
} 