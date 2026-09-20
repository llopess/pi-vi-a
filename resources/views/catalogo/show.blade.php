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
    <div class="sheet-fundo" data-fechar-sheet hidden></div>
<section class="sheet-form {{ $errors->any() ? 'aberta' : '' }}" id="sheet-form" aria-label="Formulário de interesse em adoção">
    <div class="sheet-alca" aria-hidden="true"></div>
    <div class="sheet-topo">
        <h2>Quero adotar {{ $animal->nome }}</h2>
        <button type="button" class="botao-fechar" data-fechar-sheet aria-label="Fechar formulário">×</button>
    </div>
 
    @if($errors->any())
        <div class="alerta alerta-erro" role="alert">
            Verifique os campos destacados e tente novamente.
        </div>
    @endif
 
    <form method="POST" action="{{ route('solicitacao.store', $animal) }}" class="interesse-form" id="form-interesse">
        @csrf
 
        <label class="campo">
            <span>Nome completo</span>
            <input type="text" name="nome" value="{{ old('nome') }}" required minlength="3" maxlength="120">
            @error('nome')<small class="campo-erro">{{ $message }}</small>@enderror
        </label>
 
        <label class="campo">
            <span>E-mail</span>
            <input type="email" name="email" value="{{ old('email') }}" required>
            @error('email')<small class="campo-erro">{{ $message }}</small>@enderror
        </label>
 
        <div class="campo-linha">
            <label class="campo">
                <span>Telefone</span>
                <input type="tel" name="telefone" value="{{ old('telefone') }}" required minlength="10" maxlength="20" placeholder="(53) 90000-0000">
                @error('telefone')<small class="campo-erro">{{ $message }}</small>@enderror
            </label>
 
            <label class="campo">
                <span>Cidade</span>
                <input type="text" name="cidade" value="{{ old('cidade') }}" required maxlength="80">
                @error('cidade')<small class="campo-erro">{{ $message }}</small>@enderror
            </label>
        </div>
 
        <label class="campo">
            <span>Tipo de moradia</span>
            <select name="tipo_moradia" required>
                <option value="" disabled @selected(!old('tipo_moradia'))>Selecione</option>
                <option value="casa" @selected(old('tipo_moradia') === 'casa')>Casa</option>
                <option value="apartamento" @selected(old('tipo_moradia') === 'apartamento')>Apartamento</option>
            </select>
            @error('tipo_moradia')<small class="campo-erro">{{ $message }}</small>@enderror
        </label>
 
        <fieldset class="campo-grupo">
            <legend>Sobre o seu lar</legend>
            <label class="campo-check"><input type="checkbox" name="possui_outros_animais" value="1" @checked(old('possui_outros_animais'))> Tenho outros animais</label>
            <label class="campo-check"><input type="checkbox" name="possui_telas_protecao" value="1" @checked(old('possui_telas_protecao'))> Janelas com telas de proteção</label>
        </fieldset>
 
        <label class="campo">
            <span>Observações (opcional)</span>
            <textarea name="observacoes" rows="3" maxlength="1000">{{ old('observacoes') }}</textarea>
            @error('observacoes')<small class="campo-erro">{{ $message }}</small>@enderror
        </label>
 
        {{-- Consentimento de armazenamento local (RF06, RNF09) — o dado fica só no navegador --}}
        <label class="campo-check campo-consentimento">
            <input type="checkbox" id="salvar-dados">
            Salvar meus dados neste dispositivo para facilitar solicitações futuras
        </label>
 
        <button type="submit" class="botao botao-primario botao-largo">Enviar solicitação</button>
    </form>
</section>
</article>
@endsection