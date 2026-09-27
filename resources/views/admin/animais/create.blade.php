@extends('layouts.admin')

@section('titulo', 'Cadastrar animal')

@section('conteudo')
<h1 class="admin-titulo">Cadastrar animal</h1>

<form method="POST" action="{{ route('admin.animais.store') }}" enctype="multipart/form-data" class="admin-cartao">
    @csrf
    @include('admin.animais._form')
    <button type="submit" class="botao botao-primario">Cadastrar</button>
</form>
@endsection