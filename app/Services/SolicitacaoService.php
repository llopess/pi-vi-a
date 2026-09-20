<?php

namespace App\Services;

use App\Enums\StatusSolicitacao;
use App\Models\Animal;
use App\Models\Solicitacao;
use App\Models\Solicitante;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SolicitacaoService
{
    /**
     * Registra o interesse em adoção (UC04).
     * Localiza o solicitante pelo e-mail ou o cria com novo token UUID (RNF08),
     * e vincula a solicitação ao animal com status inicial "aguardando resposta".
     */
    public function registrar(Animal $animal, array $dados): Solicitacao
    {
        return DB::transaction(function () use ($animal, $dados) {
            $solicitante = Solicitante::firstOrNew(['email' => $dados['email']]);

            $solicitante->fill([
                'nome' => $dados['nome'],
                'telefone' => $dados['telefone'],
                'cidade' => $dados['cidade'],
            ]);

            if (! $solicitante->exists) {
                $solicitante->token = (string) Str::uuid();
            }

            $solicitante->save();

            return $solicitante->solicitacoes()->create([
                'animal_id' => $animal->id,
                'status' => StatusSolicitacao::AguardandoResposta,
                'tipo_moradia' => $dados['tipo_moradia'],
                'possui_outros_animais' => (bool) ($dados['possui_outros_animais'] ?? false),
                'possui_telas_protecao' => (bool) ($dados['possui_telas_protecao'] ?? false),
                'observacoes' => $dados['observacoes'] ?? null,
            ]);
        });
    }
}