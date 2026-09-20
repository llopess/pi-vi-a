<?php

namespace App\Http\Controllers\Publico;

use App\Enums\SituacaoAnimal;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSolicitacaoRequest;
use App\Models\Animal;
use App\Services\SolicitacaoService;
use Illuminate\Http\RedirectResponse;

class SolicitacaoController extends Controller
{
    public function __construct(private readonly SolicitacaoService $service)
    {
    }

    /** Registro de interesse em adoção (RF05 — UC04). */
    public function store(StoreSolicitacaoRequest $request, Animal $animal): RedirectResponse
    {
        abort_unless($animal->situacao === SituacaoAnimal::Disponivel, 404);

        $solicitacao = $this->service->registrar($animal, $request->validated());

        return redirect()
            ->route('acompanhar.show', $solicitacao->solicitante->token)
            ->with('solicitacao_criada', $animal->nome);
    }
}