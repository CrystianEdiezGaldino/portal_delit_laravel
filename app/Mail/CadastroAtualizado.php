<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CadastroAtualizado extends Mailable
{
    use Queueable, SerializesModels;

    public $nome;
    public $ime;

    public function __construct($nome, $ime)
    {
        $this->nome = $nome;
        $this->ime = $ime;
    }

    public function build()
    {
        return $this->subject('Cadastro Atualizado - Portal DelitCuritiba')
                    ->view('emails.cadastro_atualizado')
                    ->from('no-reply@delitcuritiba.org', 'Portal DelitCuritiba');
    }
} 