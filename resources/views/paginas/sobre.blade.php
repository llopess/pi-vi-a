@extends('layouts.publico')

@section('titulo', 'Sobre o serviço')

@section('conteudo')
<div class="pagina-institucional">
    <nav class="breadcrumb" aria-label="Você está aqui">
        <a href="{{ route('catalogo.index') }}">Animais para adoção</a>
        <span class="breadcrumb-sep" aria-hidden="true">›</span>
        <span aria-current="page">Sobre</span>
    </nav>

    <h1>Sobre o Adopatinhas</h1>

    <p>O Adopatinhas é uma plataforma de bem-estar animal para divulgação e adoção responsável de cães e gatos resgatados.</p>

    <p>Os animais deste mural foram resgatados, receberam cuidados veterinários e estão prontos para um novo lar. Cada perfil apresenta as características, a condição de saúde e a data de chegada do animal ao serviço.</p>

    <h2>Como funciona a adoção</h2>
    <ol>
        <li><strong>Escolha</strong> — navegue pelo mural e conheça os animais disponíveis;</li>
        <li><strong>Manifeste interesse</strong> — preencha o formulário na página do animal, com algumas perguntas sobre o seu lar;</li>
        <li><strong>Acompanhe</strong> — você recebe um link exclusivo para acompanhar o andamento da sua solicitação;</li>
        <li><strong>Conheça e adote</strong> — aprovada a solicitação, a equipe entra em contato para agendar a visita e a entrega.</li>
    </ol>

    <h2>Adoção responsável</h2>
    <p>As perguntas do formulário não são burocracia: elas ajudam a equipe a garantir que cada animal vá para um lar preparado para recebê-lo, reduzindo o risco de devolução e de novo abandono.</p>

    <p class="pagina-nota">Projeto acadêmico desenvolvido para as disciplinas de Engenharia de Software III e Programação Back-End (UCPel). Todos os dados são fictícios.</p>
</div>
@endsection