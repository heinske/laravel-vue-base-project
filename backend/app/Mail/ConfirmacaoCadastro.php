<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmacaoCadastro extends Mailable {

    use Queueable,
        SerializesModels;

    protected $user;
    protected $password;
    protected $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $password, $token) {
        $this->user = $user;
        $this->password = $password;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {

        $url = env('URL_FRONT')."/alterar-senha/".$this->token;

        return $this->subject('Confirmação de Cadastro')
                        ->view('mail.confirmacao_cadastro')
                        ->with([
                            'user' => $this->user,
                            'url' => $url,
                            'password' => $this->password
        ]);
    }

}
