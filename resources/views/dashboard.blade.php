@extends('layouts.admin')

@section('titulo', 'Painel')

@section('conteudo')
<h1 class="admin-titulo">Painel</h1>

<h2 style="font-size: 1rem; color: var(--tinta-500); margin: 0 0 0.6rem;">Animais</h2>
<div class="dash-grade" style="margin-bottom: 1.5rem;">
    @foreach(\App\Enums\SituacaoAnimal::cases() as $situacao)
        <a href="{{ route('admin.animais.index', ['situacao' => $situacao->value]) }}" class="admin-cartao" style="text-decoration: none; color: inherit;">
            <div class="dash-numero">{{ $animaisPorSituacao[$situacao->value] ?? 0 }}</div>
            <div class="dash-rotulo">{{ $situacao->label() }}</div>
        </a>
    @endforeach
</div>

<h2 style="font-size: 1rem; color: var(--tinta-500); margin: 0 0 0.6rem;">Solicitações</h2>
<div class="dash-grade" style="margin-bottom: 1.5rem;">
    <a href="{{ route('admin.solicitacoes.index', ['status' => 'aguardando_resposta']) }}" class="admin-cartao dash-cartao-destaque" style="text-decoration: none; color: inherit;">
        <div class="dash-numero">{{ $aguardando }}</div>
        <div class="dash-rotulo">Aguardando resposta</div>
    </a>
    <a href="{{ route('admin.solicitacoes.index', ['status' => 'em_andamento']) }}" class="admin-cartao" style="text-decoration: none; color: inherit;">
        <div class="dash-numero">{{ $emAndamento }}</div>
        <div class="dash-rotulo">Em andamento</div>
    </a>
</div>

<div class="admin-cartao">
    <h2 style="margin-top: 0; font-size: 1rem;">Últimas solicitações aguardando resposta</h2>
    @forelse($recentes as $solicitacao)
        <p style="margin: 0.4rem 0;">
            <a href="{{ route('admin.solicitacoes.show', $solicitacao) }}">{{ $solicitacao->animal->nome }}</a>
            — {{ $solicitacao->solicitante->nome }}
            <small style="color: var(--tinta-500);">({{ $solicitacao->created_at->format('d/m/Y') }})</small>
        </p>
    @empty
        <p>Nenhuma solicitação pendente.</p>
    @endforelse
</div>
@endsection