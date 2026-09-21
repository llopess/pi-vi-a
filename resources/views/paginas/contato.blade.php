@extends('layouts.publico')

@section('titulo', 'Contato')

@section('conteudo')
<div class="pagina-institucional">
    <nav class="breadcrumb" aria-label="Você está aqui">
        <a href="{{ route('catalogo.index') }}">Animais para adoção</a>
        <span class="breadcrumb-sep" aria-hidden="true">›</span>
        <span aria-current="page">Contato</span>
    </nav>

    <h1>Contato</h1>

    <p>Fale com a equipe municipal de bem-estar animal:</p>

    <ul class="contato-lista">
        <li><strong>E-mail:</strong> bem-estar-animal@municipio.example</li>
        <li><strong>Telefone:</strong> (53) 0000-0000</li>
        <li><strong>Atendimento presencial:</strong> Secretaria de Bem-Estar Animal — seg. a sex., 8h às 14h</li>
    </ul>

    <p>Para dúvidas sobre uma solicitação de adoção já enviada, utilize o link de acompanhamento recebido no envio do formulário.</p>

    <p class="pagina-nota">Dados de contato fictícios — projeto acadêmico (UCPel, 2026).</p>
</div>
@endsection