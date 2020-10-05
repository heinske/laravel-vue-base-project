<?php

namespace App\Mail;

use App\Models\Evento;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmacaoCredenciamentoParticipante extends Mailable {

    use Queueable,
        SerializesModels;

    protected $dados;
    protected $evento;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $dados, Evento $evento) {
        $this->dados = $dados;
        $this->evento = $evento;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->subject('Confirmação de Credenciamento de Participante')
                    ->view('mail.confirmacao_credenciamento_participante')
                    ->with(['dados' => $this->dados, 'evento' => $this->evento]);
    }

}
