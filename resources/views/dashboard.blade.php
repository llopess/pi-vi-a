@extends('layouts.admin')

@section('titulo', 'Painel')

@section('conteudo')
<h1 class="admin-titulo">Painel</h1>
<div class="admin-cartao">
    <p>Bem-vindo, {{ auth()->user()->name }}. Os indicadores entram aqui em breve.</p>
</div>
@endsection