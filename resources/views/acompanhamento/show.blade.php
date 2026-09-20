@extends('layouts.publico')

@section('titulo', 'Minhas solicitações')

@section('conteudo')
<div class="acompanhar-pagina">

    <nav class="breadcrumb" aria-label="Você está aqui">
        <a href="{{ route('catalogo.index') }}">Animais para adoção</a>
        <span class="breadcrumb-sep" aria-hidden="true">›</span>
        <span aria-current="page">Minhas solicitações</span>
    </nav>

    @if(session('solicitacao_criada'))
        <div class="alerta alerta-sucesso" role="status">
            <strong>Solicitação enviada!</strong>
            Registramos o seu interesse em adotar {{ session('solicitacao_criada') }}.
            <span class="alerta-destaque">Guarde este link — ele é o seu acesso para acompanhar suas solicitações:</span>
            <code class="alerta-link">{{ route('acompanhar.show', $solicitante->token) }}</code>
        </div>
    @endif

    <h1 class="catalogo-titulo">Minhas solicitações</h1>
    <p class="acompanhar-saudacao">Olá, {{ $solicitante->nome }}. Acompanhe abaixo o andamento das suas solicitações de adoção.</p>

    <div class="acompanhar-lista">
        @foreach($solicitacoes as $solicitacao)
            <div class="card-solicitacao">
                <div class="card-solicitacao-foto">
                    @if($solicitacao->animal->fotoPrincipal)
                        <img src="{{ asset('storage/' . $solicitacao->animal->fotoPrincipal->caminho_arquivo) }}" alt="Foto de {{ $solicitacao->animal->nome }}">
                    @else
                        <span aria-hidden="true">{{ $solicitacao->animal->especie->value === 'gato' ? '🐱' : '🐶' }}</span>
                    @endif
                </div>
                <div class="card-solicitacao-corpo">
                    <strong>{{ $solicitacao->animal->nome }}</strong>
                    <span class="status status-{{ $solicitacao->status->value }}">{{ $solicitacao->status->label() }}</span>
                    <small>Solicitado em {{ $solicitacao->created_at->format('d/m/Y') }} · Atualizado em {{ $solicitacao->updated_at->format('d/m/Y') }}</small>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection