<?php

namespace App\Mail;

use App\Models\Token;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecuperarSenha extends Mailable {

    use Queueable,
        SerializesModels;

    protected $dados;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Token $token, User $user) {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {

        $url = env('URL_FRONT');

        return $this->subject('Recuperação de Senha')
                        ->view('mail.recuperarsenha')
                        ->with([
                            'token' => $this->token,
                            'url' => $url,
                            'user' => $this->user
        ]);
    }

}
