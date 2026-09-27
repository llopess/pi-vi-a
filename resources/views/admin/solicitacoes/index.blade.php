@extends('layouts.admin')

@section('titulo', 'Solicitações')

@section('conteudo')
<h1 class="admin-titulo">Solicitações</h1>

<form method="GET" action="{{ route('admin.solicitacoes.index') }}" class="admin-barra">
    <label class="campo" style="margin: 0; flex-direction: row; align-items: center; gap: 0.5rem;">
        <span>Status:</span>
        <select name="status" onchange="this.form.submit()">
            <option value="">Todos</option>
            @foreach(\App\Enums\StatusSolicitacao::cases() as $opcao)
                <option value="{{ $opcao->value }}" @selected(request('status') === $opcao->value)>{{ $opcao->label() }}</option>
            @endforeach
        </select>
    </label>
</form>

<div class="admin-tabela-wrap">
    <table class="admin-tabela">
        <thead>
            <tr>
                <th>Data</th>
                <th>Animal</th>
                <th>Interessado</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($solicitacoes as $solicitacao)
                <tr>
                    <td>{{ $solicitacao->created_at->format('d/m/Y') }}</td>
                    <td><strong>{{ $solicitacao->animal->nome }}</strong></td>
                    <td>{{ $solicitacao->solicitante->nome }}<br><small>{{ $solicitacao->solicitante->cidade }}</small></td>
                    <td><span class="selo selo-{{ $solicitacao->status->value }}">{{ $solicitacao->status->label() }}</span></td>
                    <td><a href="{{ route('admin.solicitacoes.show', $solicitacao) }}" class="botao botao-contorno botao-mini">Abrir</a></td>
                </tr>
            @empty
                <tr><td colspan="5">Nenhuma solicitação encontrada.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="paginacao">{{ $solicitacoes->links() }}</div>
@endsection