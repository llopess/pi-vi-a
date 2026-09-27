<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AnimalRequest;
use App\Models\Animal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnimalController extends Controller
{
    /** Listagem administrativa (RF11). */
    public function index(Request $request): View
    {
        $animais = Animal::query()
            ->with('fotoPrincipal')
            ->withCount('solicitacoes')
            ->when($request->query('situacao'), fn ($q, $v) => $q->where('situacao', $v))
            ->latest('data_recebimento')
            ->paginate(15)
            ->withQueryString();

        return view('admin.animais.index', compact('animais'));
    }

    public function create(): View
    {
        return view('admin.animais.create', ['animal' => new Animal()]);
    }

    public function store(AnimalRequest $request): RedirectResponse
    {
        $animal = Animal::create($request->safe()->except('fotos'));
        $this->salvarFotos($animal, $request->file('fotos', []));

        return redirect()->route('admin.animais.index')
            ->with('sucesso', "Animal {$animal->nome} cadastrado.");
    }

    public function show(Animal $animal): RedirectResponse
    {
        return redirect()->route('admin.animais.edit', $animal);
    }

    public function edit(Animal $animal): View
    {
        $animal->load(['fotos', 'devolucoes']);

        return view('admin.animais.edit', compact('animal'));
    }

    public function update(AnimalRequest $request, Animal $animal): RedirectResponse
    {
        $animal->update($request->safe()->except('fotos'));
        $this->salvarFotos($animal, $request->file('fotos', []));

        return redirect()->route('admin.animais.edit', $animal)
            ->with('sucesso', 'Alterações salvas.');
    }

    /** Exclusão (RF11). Bloqueada se houver solicitações vinculadas. */
    public function destroy(Animal $animal): RedirectResponse
    {
        if ($animal->solicitacoes()->exists()) {
            return back()->with('erro', "{$animal->nome} possui solicitações e não pode ser excluído.");
        }

        $animal->delete();

        return redirect()->route('admin.animais.index')
            ->with('sucesso', "Animal {$animal->nome} excluído.");
    }

    /** A primeira foto enviada vira principal se o animal ainda não tiver uma. */
    private function salvarFotos(Animal $animal, array $arquivos): void
    {
        $temPrincipal = $animal->fotos()->where('principal', true)->exists();

        foreach ($arquivos as $arquivo) {
            $animal->fotos()->create([
                'caminho_arquivo' => $arquivo->store('animais', 'public'),
                'principal' => ! $temPrincipal,
            ]);
            $temPrincipal = true;
        }
    }
}