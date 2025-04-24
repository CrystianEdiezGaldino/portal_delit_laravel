<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContatoService
{
    public function enviarMensagem($dados)
    {
        try {
            $corpo = "
                <h2>Nova mensagem de contato</h2>
                <p><strong>Nome:</strong> {$dados['nome']}</p>
                <p><strong>Email:</strong> {$dados['email']}</p>
                <p><strong>Assunto:</strong> {$dados['assunto']}</p>
                <hr>
                <h3>Mensagem:</h3>
                <p>{$dados['mensagem']}</p>
            ";
            
            Mail::send([], [], function($message) use ($dados, $corpo) {
                $message->to('no-reply@delitcuritiba.org')
                        ->subject('Contato via Portal: ' . $dados['assunto'])
                        ->html($corpo);
            });
            
            return true;
        } catch (\Exception $e) {
            Log::error('Erro ao enviar mensagem de contato: ' . $e->getMessage());
            throw $e;
        }
    }
} 