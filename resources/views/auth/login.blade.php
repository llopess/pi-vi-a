<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar — Adopatinhas Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        .login-body { display: grid; place-items: center; min-height: 100vh; padding: 1rem; }
        .login-caixa { width: 100%; max-width: 380px; }
        .login-marca { text-align: center; margin-bottom: 1.25rem; }
        .login-logo { font-size: 2.2rem; display: inline-block; transform: rotate(-4deg); }
        .login-titulo { font-weight: 800; color: var(--azul-900); font-size: 1.3rem; margin: 0.25rem 0 0; }
        .login-sub { font-size: 0.72rem; letter-spacing: 0.06em; text-transform: uppercase; color: var(--tinta-500); }
    </style>
</head>
<body class="admin-body login-body">
    <div class="login-caixa">
        <div class="login-marca">
            <span class="login-logo" aria-hidden="true">🐾</span>
            <h1 class="login-titulo">Adopatinhas</h1>
            <span class="login-sub">Painel administrativo</span>
        </div>

        <form method="POST" action="{{ route('login') }}" class="admin-cartao">
            @csrf

            @if($errors->any())
                <div class="alerta alerta-erro" role="alert">Credenciais inválidas.</div>
            @endif

            <label class="campo">
                <span>E-mail</span>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            </label>

            <label class="campo">
                <span>Senha</span>
                <input type="password" name="password" required autocomplete="current-password">
            </label>

            <label class="campo-check">
                <input type="checkbox" name="remember">
                Manter conectado
            </label>

            <button type="submit" class="botao botao-primario" style="width: 100%; justify-content: center; margin-top: 0.5rem;">Entrar</button>
        </form>
    </div>
</body>
</html>