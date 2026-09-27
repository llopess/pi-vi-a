<?php

namespace Tests\Feature;

use App\Enums\SituacaoAnimal;
use App\Enums\StatusSolicitacao;
use App\Models\User;
use App\Services\SolicitacaoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase {
    use RefreshDatabase;

    private function logar(): void {
        $this->actingAs(User::factory()->create());
    }

    private function registrarSolicitacao($animal, string $email = 'maria@example.com') {
        return app(SolicitacaoService::class)
            ->registrar($animal, $this->dadosSolicitacao(['email' => $email]));
    }

    public function test_visitante_nao_autenticado_e_redirecionado_ao_login(): void {
        $this->get(route('admin.animais.index'))->assertRedirect(route('login'));
    }

    public function test_aceitar_solicitacao_coloca_animal_em_processo(): void {
        $this->logar();
        $animal = $this->criarAnimal();
        $solicitacao = $this->registrarSolicitacao($animal);

        $this->patch(route('admin.solicitacoes.status', $solicitacao), ['status' => 'em_andamento']);

        $this->assertSame(StatusSolicitacao::EmAndamento, $solicitacao->fresh()->status);
        $this->assertSame(SituacaoAnimal::EmProcesso, $animal->fresh()->situacao);
    }

    public function test_nao_aceita_segunda_solicitacao_de_animal_em_processo(): void {
        $this->logar();
        $animal = $this->criarAnimal();
        $primeira = $this->registrarSolicitacao($animal, 'a@example.com');
        $segunda = $this->registrarSolicitacao($animal, 'b@example.com');

        $this->patch(route('admin.solicitacoes.status', $primeira), ['status' => 'em_andamento']);
        $this->patch(route('admin.solicitacoes.status', $segunda), ['status' => 'em_andamento'])
            ->assertSessionHas('erro');

        $this->assertSame(StatusSolicitacao::AguardandoResposta, $segunda->fresh()->status);
    }

    public function test_finalizar_adota_o_animal_e_cancela_as_demais(): void {
        $this->logar();
        $animal = $this->criarAnimal();
        $primeira = $this->registrarSolicitacao($animal, 'a@example.com');
        $segunda = $this->registrarSolicitacao($animal, 'b@example.com');

        $this->patch(route('admin.solicitacoes.status', $primeira), ['status' => 'em_andamento']);
        $this->patch(route('admin.solicitacoes.status', $primeira), ['status' => 'finalizada']);

        $this->assertSame(SituacaoAnimal::Adotado, $animal->fresh()->situacao);
        $this->assertSame(StatusSolicitacao::Cancelada, $segunda->fresh()->status);
    }

    public function test_transicao_fora_do_fluxo_e_recusada(): void {
        $this->logar();
        $solicitacao = $this->registrarSolicitacao($this->criarAnimal());

        $this->patch(route('admin.solicitacoes.status', $solicitacao), ['status' => 'finalizada'])
            ->assertSessionHas('erro');

        $this->assertSame(StatusSolicitacao::AguardandoResposta, $solicitacao->fresh()->status);
    }

    public function test_animal_com_solicitacoes_nao_pode_ser_excluido(): void {
        $this->logar();
        $animal = $this->criarAnimal();
        $this->registrarSolicitacao($animal);

        $this->delete(route('admin.animais.destroy', $animal))->assertSessionHas('erro');

        $this->assertDatabaseHas('animais', ['id' => $animal->id]);
    }

    public function test_devolucao_retorna_animal_ao_mural(): void {
        $this->logar();
        $animal = $this->criarAnimal(['situacao' => 'adotado']);

        $this->post(route('admin.animais.devolucoes.store', $animal), [
            'data_saida' => now()->subMonth()->format('Y-m-d'),
            'data_retorno' => now()->format('Y-m-d'),
            'motivo' => 'Mudança para imóvel que não aceita animais.',
        ]);

        $this->assertSame(SituacaoAnimal::Disponivel, $animal->fresh()->situacao);
        $this->assertDatabaseCount('devolucoes', 1);
    }
}