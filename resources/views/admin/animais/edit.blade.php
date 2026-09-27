@extends('layouts.admin')

@section('titulo', 'Editar ' . $animal->nome)

@section('conteudo')
<h1 class="admin-titulo">Editar {{ $animal->nome }}</h1>

@if($animal->fotos->isNotEmpty())
    <div class="admin-cartao" style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 1rem;">
        @foreach($animal->fotos as $foto)
            <img class="admin-thumb" style="width: 80px; height: 80px;" src="{{ asset('storage/' . $foto->caminho_arquivo) }}" alt="">
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('admin.animais.update', $animal) }}" enctype="multipart/form-data" class="admin-cartao">
    @csrf
    @method('PUT')
    @include('admin.animais._form')
    <button type="submit" class="botao botao-primario">Salvar</button>
</form>

{{-- Histórico e registro de devoluções (RF13) — uso interno --}}
<div class="admin-cartao" style="margin-top: 1.5rem;">
    <h2 style="margin-top: 0; font-size: 1.1rem;">Devoluções</h2>

    @forelse($animal->devolucoes as $devolucao)
        <p>
            <strong>{{ $devolucao->data_saida->format('d/m/Y') }} → {{ $devolucao->data_retorno->format('d/m/Y') }}</strong><br>
            {{ $devolucao->motivo }}
        </p>
    @empty
        <p>Nenhuma devolução registrada.</p>
    @endforelse

    @if($animal->situacao === \App\Enums\SituacaoAnimal::Adotado)
        <form method="POST" action="{{ route('admin.animais.devolucoes.store', $animal) }}" style="margin-top: 1rem; border-top: 2px dashed var(--borda); padding-top: 1rem;">
            @csrf
            <div class="campo-linha">
                <label class="campo">
                    <span>Data de saída (entrega ao adotante)</span>
                    <input type="date" name="data_saida" value="{{ old('data_saida') }}" required>
                    @error('data_saida')<small class="campo-erro">{{ $message }}</small>@enderror
                </label>
                <label class="campo">
                    <span>Data de retorno</span>
                    <input type="date" name="data_retorno" value="{{ old('data_retorno', now()->format('Y-m-d')) }}" required>
                    @error('data_retorno')<small class="campo-erro">{{ $message }}</small>@enderror
                </label>
            </div>
            <label class="campo">
                <span>Motivo da devolução</span>
                <textarea name="motivo" rows="3" required>{{ old('motivo') }}</textarea>
                @error('motivo')<small class="campo-erro">{{ $message }}</small>@enderror
            </label>
            <button type="submit" class="botao botao-perigo" onclick="return confirm('Registrar devolução? O animal voltará ao mural.');">Registrar devolução</button>
        </form>
    @endif
</div>

@endsection