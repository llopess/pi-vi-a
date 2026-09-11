<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogoController extends Controller
{
    public function index(Request $request): View {
        $filtros = $request->only(['especie', 'porte', 'sexo', 'idade', 'castrado', 'vacinado', 'vermifugado']);

        $animais = Animal::query()
            ->disponiveis()
            ->with('fotoPrincipal')
            ->when($filtros['especie'] ?? null, fn ($q, $v) => $q->where('especie', $v))
            ->when($filtros['porte'] ?? null, fn ($q, $v) => $q->where('porte', $v))
            ->when($filtros['sexo'] ?? null, fn ($q, $v) => $q->where('sexo', $v))
            ->when($filtros['idade'] ?? null, fn ($q, $v) => $q->faixaIdade($v))
            ->when(isset($filtros['castrado']), fn ($q) => $q->where('castrado', true))
            ->when(isset($filtros['vacinado']), fn ($q) => $q->where('vacinado', true))
            ->when(isset($filtros['vermifugado']), fn ($q) => $q->where('vermifugado', true))
            ->latest('data_recebimento')
            ->paginate(12)
            ->withQueryString();

        $totalFiltros = count(array_filter($filtros, fn($v) => $v !== null && $v !== ''));

        return view('catalogo.index', compact('animais', 'filtros', 'totalFiltros'));
    }
}
