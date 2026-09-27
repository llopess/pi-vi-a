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
@endsection