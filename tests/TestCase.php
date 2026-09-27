<?php

namespace Tests;

use App\Models\Animal;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase {
    /** Cria um animal com valores padrão, sobrescrevíveis. */
    protected function criarAnimal(array $atributos = []): Animal {
        return Animal::create(array_merge([
            'nome' => 'Rex',
            'especie' => 'cao',
            'porte' => 'medio',
            'sexo' => 'macho',
            'data_nascimento_estimada' => now()->subYears(2),
            'situacao' => 'disponivel',
            'data_recebimento' => now()->subMonth(),
        ], $atributos));
    }

    /** Dados válidos do formulário de interesse. */
    protected function dadosSolicitacao(array $sobrescrever = []): array {
        return array_merge([
            'nome' => 'Maria Teste',
            'email' => 'maria@example.com',
            'telefone' => '53999990000',
            'cidade' => 'Pelotas',
            'tipo_moradia' => 'casa',
            'possui_outros_animais' => '1',
        ], $sobrescrever);
    }
}