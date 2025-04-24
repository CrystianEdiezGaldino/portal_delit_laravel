<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CadastroRealizado extends Mailable
{
    use Queueable, SerializesModels;

    public $dados;

    public function __construct($dados)
    {
        $this->dados = $dados;
    }

    public function build()
    {
        Log::info('Mensagem de sessão: ' . session('success'));
        return $this->subject('📬 Cadastro Realizado - Portal Delit Curitiba')
                   ->view('emails.cadastro_realizado');
    }
} 