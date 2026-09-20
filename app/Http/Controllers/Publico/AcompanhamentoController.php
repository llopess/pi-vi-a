<?php

namespace App\Http\Controllers\Publico;

use App\Http\Controllers\Controller;
use App\Models\Solicitante;
use Illuminate\View\View;

class AcompanhamentoController extends Controller
{
    /** Acompanhamento das solicitações por link único (RF07 — UC06). */
    public function show(string $token): View
    {
        $solicitante = Solicitante::query()
            ->where('token', $token)
            ->firstOrFail();

        $solicitacoes = $solicitante->solicitacoes()
            ->with('animal.fotoPrincipal')
            ->latest()
            ->get();

        return view('acompanhamento.show', compact('solicitante', 'solicitacoes'));
    }
}