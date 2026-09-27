<div class="campo-linha">
    <label class="campo">
        <span>Nome</span>
        <input type="text" name="nome" value="{{ old('nome', $animal->nome) }}" required maxlength="80">
        @error('nome')<small class="campo-erro">{{ $message }}</small>@enderror
    </label>

    <label class="campo">
        <span>Espécie</span>
        <select name="especie" required>
            @foreach(\App\Enums\Especie::cases() as $opcao)
                <option value="{{ $opcao->value }}" @selected(old('especie', $animal->especie?->value) === $opcao->value)>{{ $opcao->label() }}</option>
            @endforeach
        </select>
    </label>

    <label class="campo">
        <span>Porte</span>
        <select name="porte" required>
            @foreach(\App\Enums\Porte::cases() as $opcao)
                <option value="{{ $opcao->value }}" @selected(old('porte', $animal->porte?->value) === $opcao->value)>{{ $opcao->label() }}</option>
            @endforeach
        </select>
    </label>

    <label class="campo">
        <span>Sexo</span>
        <select name="sexo" required>
            @foreach(\App\Enums\Sexo::cases() as $opcao)
                <option value="{{ $opcao->value }}" @selected(old('sexo', $animal->sexo?->value) === $opcao->value)>{{ $opcao->label() }}</option>
            @endforeach
        </select>
    </label>

    <label class="campo">
        <span>Nascimento estimado</span>
        <input type="date" name="data_nascimento_estimada" value="{{ old('data_nascimento_estimada', $animal->data_nascimento_estimada?->format('Y-m-d')) }}" required>
        @error('data_nascimento_estimada')<small class="campo-erro">{{ $message }}</small>@enderror
    </label>

    <label class="campo">
        <span>Recebido em</span>
        <input type="date" name="data_recebimento" value="{{ old('data_recebimento', $animal->data_recebimento?->format('Y-m-d')) }}" required>
        @error('data_recebimento')<small class="campo-erro">{{ $message }}</small>@enderror
    </label>
</div>

@if($animal->exists)
    <label class="campo">
        <span>Situação</span>
        <select name="situacao">
            @foreach(\App\Enums\SituacaoAnimal::cases() as $opcao)
                <option value="{{ $opcao->value }}" @selected(old('situacao', $animal->situacao?->value) === $opcao->value)>{{ $opcao->label() }}</option>
            @endforeach
        </select>
    </label>
@endif

<fieldset class="campo-grupo">
    <legend>Saúde</legend>
    <label class="campo-check"><input type="checkbox" name="castrado" value="1" @checked(old('castrado', $animal->castrado))> Castrado</label>
    <label class="campo-check"><input type="checkbox" name="vacinado" value="1" @checked(old('vacinado', $animal->vacinado))> Vacinado</label>
    <label class="campo-check"><input type="checkbox" name="vermifugado" value="1" @checked(old('vermifugado', $animal->vermifugado))> Vermifugado</label>
</fieldset>

<label class="campo">
    <span>Descrição</span>
    <textarea name="descricao" rows="4" maxlength="2000">{{ old('descricao', $animal->descricao) }}</textarea>
</label>

<label class="campo">
    <span>Adicionar fotos (até 6, máx. 4 MB cada)</span>
    <input type="file" name="fotos[]" accept="image/*" multiple>
    @error('fotos.*')<small class="campo-erro">{{ $message }}</small>@enderror
</label>