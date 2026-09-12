@extends('layouts.publico')

@section('titulo', 'Animais para adoção')

@section('conteudo')
<div class="catalogo-pagina">

  {{-- Barra de filtros (mobile: abre a gaveta; desktop: a gaveta vira sidebar fixa) --}}
  <div class="filtros-barra">
    <h1 class="catalogo-titulo">Animais para adoção</h1>
    <button type="button" class="botao botao-contorno" data-abrir-drawer>
      Filtrar
      @if($totalFiltros > 0)
        <span class="filtros-contador">{{ $totalFiltros }}</span>
      @endif
    </button>
  </div>

  <div class="catalogo-corpo">

      {{-- Gaveta de filtros (RF02, RF03 — UC02) --}}
      <div class="drawer-fundo" data-fechar-drawer hidden></div>
      <aside class="drawer-filtros" id="drawer-filtros" aria-label="Filtros de pesquisa">
          <form method="GET" action="{{ route('catalogo.index') }}" class="filtros-form">
              <div class="drawer-topo">
                  <h2>Filtros</h2>
                  <button type="button" class="botao-fechar" data-fechar-drawer aria-label="Fechar filtros">×</button>
              </div>

              <label class="campo">
                  <span>Espécie</span>
                  <select name="especie">
                      <option value="">Todas</option>
                      <option value="cao" @selected(($filtros['especie'] ?? '') === 'cao')>Cão</option>
                      <option value="gato" @selected(($filtros['especie'] ?? '') === 'gato')>Gato</option>
                  </select>
              </label>

              <label class="campo">
                  <span>Porte</span>
                  <select name="porte">
                      <option value="">Todos</option>
                      <option value="pequeno" @selected(($filtros['porte'] ?? '') === 'pequeno')>Pequeno</option>
                      <option value="medio" @selected(($filtros['porte'] ?? '') === 'medio')>Médio</option>
                      <option value="grande" @selected(($filtros['porte'] ?? '') === 'grande')>Grande</option>
                  </select>
              </label>

              <label class="campo">
                  <span>Sexo</span>
                  <select name="sexo">
                      <option value="">Todos</option>
                      <option value="macho" @selected(($filtros['sexo'] ?? '') === 'macho')>Macho</option>
                      <option value="femea" @selected(($filtros['sexo'] ?? '') === 'femea')>Fêmea</option>
                  </select>
              </label>

              <label class="campo">
                  <span>Idade</span>
                  <select name="idade">
                      <option value="">Todas</option>
                      <option value="filhote" @selected(($filtros['idade'] ?? '') === 'filhote')>Filhote (até 1 ano)</option>
                      <option value="jovem" @selected(($filtros['idade'] ?? '') === 'jovem')>Jovem (1 a 3 anos)</option>
                      <option value="adulto" @selected(($filtros['idade'] ?? '') === 'adulto')>Adulto (3 a 8 anos)</option>
                      <option value="idoso" @selected(($filtros['idade'] ?? '') === 'idoso')>Idoso (8+ anos)</option>
                  </select>
              </label>

              <fieldset class="campo-grupo">
                  <legend>Saúde</legend>
                  <label class="campo-check"><input type="checkbox" name="castrado" value="1" @checked(isset($filtros['castrado']))> Castrado</label>
                  <label class="campo-check"><input type="checkbox" name="vacinado" value="1" @checked(isset($filtros['vacinado']))> Vacinado</label>
                  <label class="campo-check"><input type="checkbox" name="vermifugado" value="1" @checked(isset($filtros['vermifugado']))> Vermifugado</label>
              </fieldset>

              <div class="drawer-acoes">
                  <a href="{{ route('catalogo.index') }}" class="botao botao-texto">Limpar</a>
                  <button type="submit" class="botao botao-primario">Aplicar</button>
              </div>
          </form>
      </aside>

      {{-- Catálogo (RF01 — UC01) --}}
      <section class="catalogo-grade" aria-label="Animais disponíveis">
          @forelse($animais as $animal)
              <a href="#" class="card-pet">
                  <div class="card-pet-foto">
                      @if($animal->fotoPrincipal)
                          <img src="{{ asset('storage/' . $animal->fotoPrincipal->caminho_arquivo) }}" alt="Foto de {{ $animal->nome }}">
                      @else
                          <span class="card-pet-semfoto" aria-hidden="true">{{ $animal->especie->value === 'gato' ? '🐱' : '🐶' }}</span>
                      @endif
                  </div>
                  <div class="card-pet-info">
                      <strong class="card-pet-nome">{{ $animal->nome }}</strong>
                      <div class="card-pet-chips">
                          <span class="chip">{{ $animal->especie->label() }}</span>
                          <span class="chip">{{ $animal->porte->label() }}</span>
                          <span class="chip">{{ $animal->idade_texto }}</span>
                      </div>
                  </div>
              </a>
          @empty
              <div class="catalogo-vazio">
                  <p>Nenhum animal corresponde aos filtros escolhidos.</p>
                  <a href="{{ route('catalogo.index') }}" class="botao botao-contorno">Limpar filtros</a>
              </div>
          @endforelse
      </section>
  </div>

  <div class="paginacao">
      {{ $animais->links() }}
  </div>
</div>
@endsection