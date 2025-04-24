<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PrimeiroAcesso extends Mailable
{
    use Queueable, SerializesModels;

    public $ime;
    public $senha;
    public $nome;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($ime, $senha, $nome)
    {
        $this->ime = $ime;
        $this->senha = $senha;
        $this->nome = $nome;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nova Senha - Portal Delit Curitiba')
                    ->view('emails.primeiro_acesso')
                    ->with([
                        'ime' => $this->ime,
                        'senha' => $this->senha,
                        'nome' => $this->nome
                    ]);
    }
} 