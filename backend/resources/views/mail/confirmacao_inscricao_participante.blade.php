<h3>Prezado(a) {{$dados['nome']}},</h3>

<p>Recebemos a confirmação de sua inscrição como participante para o evento {{ $evento->nome }}. Estamos felizes por ter você conosco.</p>
<p>Acesse o link para confirmar a autenticidade das informações e prossiga com a sua inscrição.</p>
<p><a href="{{ $url }}">Link de confirmação</a></p>
<p>Verifique sempre o seu e-mail e sua caixa de span pois enviaremos novas notificações em breve.</p>
<p>Atenciosamento, </p>
<p>{{ $evento->nome }}</p>
