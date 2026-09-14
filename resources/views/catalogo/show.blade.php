@extends('layouts.publico')

@section('titulo', $animal->nome)

@section('conteudo')
<nav class="breadcrumb" aria-label="Você está aqui">
    <a href="{{ route('catalogo.index') }}">Animais para adoção</a>
    <span class="breadcrumb-sep" aria-hidden="true">›</span>
    <span aria-current="page">{{ $animal->nome }}</span>
</nav>

<article class="detalhe-pagina">

    <div class="detalhe-colunas">
        {{-- Galeria de fotos --}}
        <div class="detalhe-galeria">
            <div class="detalhe-foto-principal">
                @if($animal->fotos->isNotEmpty())
                    <img id="foto-principal" src="{{ asset('storage/' . ($animal->fotoPrincipal?->caminho_arquivo ?? $animal->fotos->first()->caminho_arquivo)) }}" alt="Foto de {{ $animal->nome }}">
                @else
                    <span class="detalhe-semfoto" aria-hidden="true">{{ $animal->especie->value === 'gato' ? '🐱' : '🐶' }}</span>
                @endif
            </div>
            @if($animal->fotos->count() > 1)
                <div class="detalhe-miniaturas">
                    @foreach($animal->fotos as $foto)
                        <button type="button" class="miniatura" data-foto="{{ asset('storage/' . $foto->caminho_arquivo) }}">
                            <img src="{{ asset('storage/' . $foto->caminho_arquivo) }}" alt="Miniatura de {{ $animal->nome }}">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Características e informações (RF04 — UC03) --}}
        <div class="detalhe-info">
            <h1 class="detalhe-nome">{{ $animal->nome }}</h1>

            <div class="card-pet-chips detalhe-chips">
                <span class="chip">{{ $animal->especie->label() }}</span>
                <span class="chip">{{ $animal->porte->label() }}</span>
                <span class="chip">{{ $animal->sexo->label() }}</span>
                <span class="chip">{{ $animal->idade_texto }}</span>
            </div>

            <ul class="detalhe-saude">
                <li class="{{ $animal->castrado ? 'sim' : 'nao' }}">{{ $animal->castrado ? '✓' : '✗' }} Castrado</li>
                <li class="{{ $animal->vacinado ? 'sim' : 'nao' }}">{{ $animal->vacinado ? '✓' : '✗' }} Vacinado</li>
                <li class="{{ $animal->vermifugado ? 'sim' : 'nao' }}">{{ $animal->vermifugado ? '✓' : '✗' }} Vermifugado</li>
            </ul>

            @if($animal->descricao)
                <p class="detalhe-descricao">{{ $animal->descricao }}</p>
            @endif

            <p class="detalhe-data">No Adopatinhas desde <strong>{{ $animal->data_recebimento->format('d/m/Y') }}</strong>.</p>

            @if($animal->situacao === \App\Enums\SituacaoAnimal::Disponivel)
                <button type="button" class="botao botao-primario botao-adotar" data-abrir-sheet>
                    Quero adotar {{ $animal->nome }}
                </button>
            @else
                <p class="detalhe-indisponivel">{{ $animal->situacao->label() }}</p>
            @endif
        </div>
    </div>

</article>
@endsection