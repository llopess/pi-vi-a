<?php

namespace Tests\Feature;

use App\Models\Solicitante;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SolicitacaoPublicaTest extends TestCase {
    use RefreshDatabase;

    public function test_envio_valido_cria_solicitacao_e_redireciona_para_acompanhamento(): void {
        $animal = $this->criarAnimal();

        $resposta = $this->post(route('solicitacao.store', $animal), $this->dadosSolicitacao());

        $solicitante = Solicitante::first();
        $this->assertNotNull($solicitante->token);
        $resposta->assertRedirect(route('acompanhar.show', $solicitante->token));
        $this->assertDatabaseHas('solicitacoes', [
            'animal_id' => $animal->id,
            'status' => 'aguardando_resposta',
        ]);
    }

    public function test_mesmo_email_reaproveita_o_solicitante(): void {
        $this->post(route('solicitacao.store', $this->criarAnimal()), $this->dadosSolicitacao());
        $this->post(route('solicitacao.store', $this->criarAnimal()), $this->dadosSolicitacao());

        $this->assertDatabaseCount('solicitantes', 1);
        $this->assertDatabaseCount('solicitacoes', 2);
    }

    public function test_dados_invalidos_sao_rejeitados(): void {
        $animal = $this->criarAnimal();

        $this->post(route('solicitacao.store', $animal), $this->dadosSolicitacao([
            'email' => 'nao-e-email',
            'tipo_moradia' => 'barraca',
        ]))->assertSessionHasErrors(['email', 'tipo_moradia']);

        $this->assertDatabaseCount('solicitacoes', 0);
    }

    public function test_nao_aceita_interesse_em_animal_indisponivel(): void {
        $animal = $this->criarAnimal(['situacao' => 'adotado']);

        $this->post(route('solicitacao.store', $animal), $this->dadosSolicitacao())
            ->assertNotFound();
    }

    public function test_token_invalido_retorna_404(): void {
        $this->get('/acompanhar/token-que-nao-existe')->assertNotFound();
    }
}