<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Painel') — Adopatinhas Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin-body">

    <aside class="admin-menu">
        <div class="admin-marca">
            <span class="admin-logo" aria-hidden="true">🐾</span>
            <span class="admin-nome">Adopatinhas<small>Painel administrativo</small></span>
        </div>

        <nav class="admin-nav" aria-label="Menu administrativo">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'ativo' : '' }}">Painel</a>
            <a href="{{ route('admin.animais.index') }}" class="{{ request()->routeIs('admin.animais.*') ? 'ativo' : '' }}">Animais</a>
            <a href="{{ route('admin.solicitacoes.index') }}" class="{{ request()->routeIs('admin.solicitacoes.*') ? 'ativo' : '' }}">Solicitações</a>
        </nav>

        <div class="admin-rodape-menu">
            <a href="{{ route('catalogo.index') }}" target="_blank">Ver site público ↗</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="admin-sair">Sair ({{ auth()->user()->name }})</button>
            </form>
        </div>
    </aside>

    <main class="admin-conteudo">
        @if(session('sucesso'))
            <div class="alerta alerta-sucesso" role="status">{{ session('sucesso') }}</div>
        @endif

        @yield('conteudo')
    </main>

</body>
</html>