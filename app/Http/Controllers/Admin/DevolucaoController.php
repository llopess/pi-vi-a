<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SituacaoAnimal;
use App\Http\Controllers\Controller;
use App\Models\Animal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DevolucaoController extends Controller {
    /** Registro de devolução de animal adotado (RF13 — UC10). */
    public function store(Request $request, Animal $animal): RedirectResponse {
        if ($animal->situacao !== SituacaoAnimal::Adotado) {
            return back()->with('erro', 'Só é possível registrar devolução de um animal adotado.');
        }

        $dados = $request->validate([
            'data_saida' => ['required', 'date', 'before_or_equal:data_retorno'],
            'data_retorno' => ['required', 'date', 'before_or_equal:today'],
            'motivo' => ['required', 'string', 'min:5', 'max:1000'],
        ]);

        DB::transaction(function () use ($animal, $dados) {
            $animal->devolucoes()->create($dados);
            $animal->update(['situacao' => SituacaoAnimal::Disponivel]);
        });

        return redirect()
            ->route('admin.animais.edit', $animal)
            ->with('sucesso', "Devolução registrada. {$animal->nome} voltou ao mural.");
    }
}