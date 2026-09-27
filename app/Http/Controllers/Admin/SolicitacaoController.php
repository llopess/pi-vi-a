<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusSolicitacao;
use App\Http\Controllers\Controller;
use App\Models\Solicitacao;
use App\Services\SolicitacaoService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SolicitacaoController extends Controller {
    public function __construct(private readonly SolicitacaoService $service) {
    }

    /** Listagem das solicitações (RF14). */
    public function index(Request $request): View {
        $solicitacoes = Solicitacao::query()
            ->with(['animal', 'solicitante'])
            ->when($request->query('status'), fn ($q, $v) => $q->where('status', $v))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.solicitacoes.index', compact('solicitacoes'));
    }

    /** Detalhe com dados do interessado e triagem (RF14). */
    public function show(Solicitacao $solicitacao): View {
        $solicitacao->load(['animal.devolucoes', 'solicitante']);

        return view('admin.solicitacoes.show', compact('solicitacao'));
    }

    /** Transição de status (RF15, RF16). */
    public function alterarStatus(Request $request, Solicitacao $solicitacao): RedirectResponse {
        $dados = $request->validate([
            'status' => ['required', Rule::enum(StatusSolicitacao::class)],
        ]);

        try {
            $this->service->alterarStatus($solicitacao, StatusSolicitacao::from($dados['status']));
        } catch (DomainException $e) {
            return back()->with('erro', $e->getMessage());
        }

        return back()->with('sucesso', 'Status atualizado.');
    }
}