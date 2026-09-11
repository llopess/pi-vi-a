<h1>Catálogo - {{$animais->total()}} animais encontrados</h1>

<ul>
  @foreach($animais as $animal)
    <li>{{ $animal->nome }} - {{$animal->especie->label()}}, {{$animal->porte->label()}}, {{$animal->idade_texto}} </li>
  @endforeach
</ul>