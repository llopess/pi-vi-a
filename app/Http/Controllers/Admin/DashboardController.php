<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusSolicitacao;
use App\Http\Controllers\Controller;
use App\Models\Animal;
use App\Models\Solicitacao;
use Illuminate\View\View;

class DashboardController extends Controller {
    /** Painel com indicadores (RF10). */
    public function __invoke(): View {
        $animaisPorSituacao = Animal::query()
            ->toBase()
            ->selectRaw('situacao, count(*) as total')
            ->groupBy('situacao')
            ->pluck('total', 'situacao');

        $aguardando = Solicitacao::where('status', StatusSolicitacao::AguardandoResposta)->count();
        $emAndamento = Solicitacao::where('status', StatusSolicitacao::EmAndamento)->count();

        $recentes = Solicitacao::query()
            ->with(['animal', 'solicitante'])
            ->where('status', StatusSolicitacao::AguardandoResposta)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('animaisPorSituacao', 'aguardando', 'emAndamento', 'recentes'));
    }
}