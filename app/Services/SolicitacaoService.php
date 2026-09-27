<?php

namespace App\Services;

use App\Enums\StatusSolicitacao;
use App\Models\Animal;
use App\Models\Solicitacao;
use App\Models\Solicitante;
use App\Enums\SituacaoAnimal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use DomainException;

class SolicitacaoService
{
    /**
     * Registra o interesse em adoção (UC04).
     * Localiza o solicitante pelo e-mail ou o cria com novo token UUID (RNF08),
     * e vincula a solicitação ao animal com status inicial "aguardando resposta".
     */
    public function registrar(Animal $animal, array $dados): Solicitacao {
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

    public function alterarStatus(Solicitacao $solicitacao, StatusSolicitacao $novo): void {
        $atual = $solicitacao->status;

        if (! $atual->podeIrPara($novo)) {
            throw new DomainException("Não é possível passar de \"{$atual->label()}\" para \"{$novo->label()}\".");
        }

        $animal = $solicitacao->animal;

        if ($novo === StatusSolicitacao::EmAndamento && $animal->situacao !== SituacaoAnimal::Disponivel) {
            throw new DomainException("{$animal->nome} não está disponível (situação: {$animal->situacao->label()}).");
        }

        DB::transaction(function () use ($solicitacao, $animal, $atual, $novo) {
            $solicitacao->update(['status' => $novo]);

            if ($novo === StatusSolicitacao::EmAndamento) {
                $animal->update(['situacao' => SituacaoAnimal::EmProcesso]);
            }

            if ($novo === StatusSolicitacao::Finalizada) {
                $animal->update(['situacao' => SituacaoAnimal::Adotado]);

                $animal->solicitacoes()
                    ->whereKeyNot($solicitacao->id)
                    ->whereIn('status', [StatusSolicitacao::AguardandoResposta, StatusSolicitacao::EmAndamento])
                    ->update(['status' => StatusSolicitacao::Cancelada]);
            }

            if ($novo === StatusSolicitacao::Cancelada && $atual === StatusSolicitacao::EmAndamento) {
                $animal->update(['situacao' => SituacaoAnimal::Disponivel]);
            }
        });
    }
}