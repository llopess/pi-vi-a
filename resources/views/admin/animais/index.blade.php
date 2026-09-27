@extends('layouts.admin')

@section('titulo', 'Animais')

@section('conteudo')
<div class="admin-barra">
    <h1 class="admin-titulo" style="margin: 0;">Animais</h1>
    <a href="{{ route('admin.animais.create') }}" class="botao botao-primario">+ Cadastrar animal</a>
</div>

<form method="GET" action="{{ route('admin.animais.index') }}" class="admin-barra">
    <label class="campo" style="margin: 0; flex-direction: row; align-items: center; gap: 0.5rem;">
        <span>Situação:</span>
        <select name="situacao" onchange="this.form.submit()">
            <option value="">Todas</option>
            <option value="registrado" @selected(request('situacao') === 'registrado')>Registrado</option>
            <option value="disponivel" @selected(request('situacao') === 'disponivel')>Disponível</option>
            <option value="em_processo" @selected(request('situacao') === 'em_processo')>Em processo</option>
            <option value="adotado" @selected(request('situacao') === 'adotado')>Adotado</option>
        </select>
    </label>
</form>

<div class="admin-tabela-wrap">
    <table class="admin-tabela">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nome</th>
                <th>Espécie / Porte</th>
                <th>Situação</th>
                <th>Solicitações</th>
                <th>Recebido em</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($animais as $animal)
                <tr>
                    <td>
                        @if($animal->fotoPrincipal)
                            <img class="admin-thumb" src="{{ asset('storage/' . $animal->fotoPrincipal->caminho_arquivo) }}" alt="">
                        @else
                            <span class="admin-thumb" aria-hidden="true">{{ $animal->especie->value === 'gato' ? '🐱' : '🐶' }}</span>
                        @endif
                    </td>
                    <td><strong>{{ $animal->nome }}</strong></td>
                    <td>{{ $animal->especie->label() }} · {{ $animal->porte->label() }}</td>
                    <td><span class="selo selo-{{ $animal->situacao->value }}">{{ $animal->situacao->label() }}</span></td>
                    <td>{{ $animal->solicitacoes_count }}</td>
                    <td>{{ $animal->data_recebimento->format('d/m/Y') }}</td>
                    <td>
                        <div class="admin-acoes">
                            <a href="{{ route('admin.animais.edit', $animal) }}" class="botao botao-contorno botao-mini">Editar</a>
                            <form method="POST" action="{{ route('admin.animais.destroy', $animal) }}" onsubmit="return confirm('Excluir {{ $animal->nome }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="botao botao-perigo botao-mini">Excluir</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7">Nenhum animal encontrado.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="paginacao">{{ $animais->links() }}</div>
@endsection