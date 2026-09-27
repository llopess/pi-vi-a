@extends('layouts.admin')

@section('titulo', 'Solicitação #' . $solicitacao->id)

@section('conteudo')
<div class="admin-barra">
    <h1 class="admin-titulo" style="margin: 0;">Solicitação #{{ $solicitacao->id }}</h1>
    <span class="selo selo-{{ $solicitacao->status->value }}">{{ $solicitacao->status->label() }}</span>
</div>

{{-- Ações: um botão por transição permitida (RF15) --}}
@if($solicitacao->status->proximos())
    <div class="admin-cartao admin-acoes" style="margin-bottom: 1rem;">
        @foreach($solicitacao->status->proximos() as $novo)
            @php
                $rotulo = match ($novo) {
                    \App\Enums\StatusSolicitacao::EmAndamento => 'Aceitar',
                    \App\Enums\StatusSolicitacao::Finalizada => 'Concluir adoção',
                    \App\Enums\StatusSolicitacao::Cancelada => $solicitacao->status === \App\Enums\StatusSolicitacao::AguardandoResposta ? 'Recusar' : 'Cancelar',
                    default => $novo->label(),
                };
                $perigo = $novo === \App\Enums\StatusSolicitacao::Cancelada;
            @endphp
            <form method="POST" action="{{ route('admin.solicitacoes.status', $solicitacao) }}" onsubmit="return confirm('{{ $rotulo }} esta solicitação?');">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="{{ $novo->value }}">
                <button type="submit" class="botao {{ $perigo ? 'botao-perigo' : 'botao-primario' }}">{{ $rotulo }}</button>
            </form>
        @endforeach
    </div>
@endif

<div class="dash-grade" style="grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); align-items: start;">
    <div class="admin-cartao">
        <h2 style="margin-top: 0; font-size: 1rem;">Animal</h2>
        <p><strong>{{ $solicitacao->animal->nome }}</strong> — {{ $solicitacao->animal->especie->label() }}, {{ $solicitacao->animal->porte->label() }}</p>
        <p>Situação: <span class="selo selo-{{ $solicitacao->animal->situacao->value }}">{{ $solicitacao->animal->situacao->label() }}</span></p>
        <a href="{{ route('admin.animais.edit', $solicitacao->animal) }}">Ver cadastro do animal</a>
    </div>

    <div class="admin-cartao">
        <h2 style="margin-top: 0; font-size: 1rem;">Interessado</h2>
        <p><strong>{{ $solicitacao->solicitante->nome }}</strong></p>
        <p>{{ $solicitacao->solicitante->email }}<br>{{ $solicitacao->solicitante->telefone }}<br>{{ $solicitacao->solicitante->cidade }}</p>
    </div>

    <div class="admin-cartao">
        <h2 style="margin-top: 0; font-size: 1rem;">Triagem</h2>
        <p>Moradia: {{ $solicitacao->tipo_moradia === 'casa' ? 'Casa' : 'Apartamento' }}</p>
        <p>Outros animais: {{ $solicitacao->possui_outros_animais ? 'Sim' : 'Não' }}</p>
        <p>Telas de proteção: {{ $solicitacao->possui_telas_protecao ? 'Sim' : 'Não' }}</p>
        @if($solicitacao->observacoes)
            <p><em>{{ $solicitacao->observacoes }}</em></p>
        @endif
    </div>

    {{-- Histórico interno de devoluções (RF13) — nunca exibido no público --}}
    @if($solicitacao->animal->devolucoes->isNotEmpty())
        <div class="admin-cartao" style="border-left: 5px solid var(--coral-500);">
            <h2 style="margin-top: 0; font-size: 1rem;">Devoluções anteriores deste animal</h2>
            @foreach($solicitacao->animal->devolucoes as $devolucao)
                <p><strong>{{ $devolucao->data_retorno->format('d/m/Y') }}</strong> — {{ $devolucao->motivo }}</p>
            @endforeach
        </div>
    @endif
</div>

<p style="margin-top: 1.25rem;"><a href="{{ route('admin.solicitacoes.index') }}">← Voltar às solicitações</a></p>
@endsection