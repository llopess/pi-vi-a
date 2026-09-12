<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('titulo', 'Adoção de Animais') - Adopatinhas</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:wght@600;700&family=Public+Sans:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/publico.css') }}">
</head>
<body>
  <header class="navbar">
    <a href="{{route('catalogo.index') }}" class="navbar-marca">
      <span class="navbar-logo" aria-hidden="true"></span>
      <span class="navbar-nome">Adopatinhas<span class="navbar-nome-sub">Bem-Estar Animal</span></span>
    </a>
  </header>

  <main class="conteudo">
        @yield('conteudo')
    </main>

    <footer class="rodape">
        <div class="rodape-colunas">
            <div>
                <h3>Sobre o serviço</h3>
                <p>Adopatinhas é a plataforma de bem-estar animal para divulgação e adoção responsável de animais resgatados.</p>
            </div>
            <div>
                <h3>Páginas</h3>
                <ul>
                    <li><a href="{{ route('catalogo.index') }}">Animais para adoção</a></li>
                    <li><a href="#">Sobre</a></li>
                    <li><a href="#">Contato</a></li>
                </ul>
            </div>
            <div>
                <h3>Contato</h3>
                <p>bem-estar-animal@municipio.example<br>(53) 0000-0000</p>
            </div>
        </div>
        <p class="rodape-legal">Projeto acadêmico — dados fictícios. UCPel, 2026.</p>
    </footer>

    <script src="{{ asset('js/publico.js') }}" defer></script>
</body>
</html>