<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogoTest extends TestCase {
    use RefreshDatabase;

    public function test_catalogo_exibe_apenas_animais_disponiveis(): void {
        $this->criarAnimal(['nome' => 'Disponivel']);
        $this->criarAnimal(['nome' => 'Registrado', 'situacao' => 'registrado']);
        $this->criarAnimal(['nome' => 'Adotado', 'situacao' => 'adotado']);

        $this->get(route('catalogo.index'))
            ->assertOk()
            ->assertSee('Disponivel')
            ->assertDontSee('Registrado')
            ->assertDontSee('Adotado');
    }

    public function test_filtro_por_especie(): void {
        $this->criarAnimal(['nome' => 'Totó', 'especie' => 'cao']);
        $this->criarAnimal(['nome' => 'Mingau', 'especie' => 'gato']);

        $this->get(route('catalogo.index', ['especie' => 'gato']))
            ->assertSee('Mingau')
            ->assertDontSee('Totó');
    }

    public function test_detalhe_de_animal_inexistente_retorna_404(): void {
        $this->get('/detalhe/999')->assertNotFound();
    }
}