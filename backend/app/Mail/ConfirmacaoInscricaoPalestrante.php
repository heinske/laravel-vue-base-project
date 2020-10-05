<?php

namespace App\Mail;

use App\Models\Evento;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmacaoInscricaoPalestrante extends Mailable {

    use Queueable,
        SerializesModels;

    protected $dados;
    protected $url;
    protected $evento;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $dados, Evento $evento, $url) {
        $this->dados = $dados;
        $this->url = $url;
        $this->evento = $evento;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->subject('Confirmação de Incrição de Palestrante')
                    ->view('mail.confirmacao_inscricao_palestrante')
                    ->with(['dados' => $this->dados, 'url' => $this->url, 'evento' => $this->evento]);
    }

}
