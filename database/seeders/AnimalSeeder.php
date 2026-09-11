<?php

namespace Database\Seeders;

use App\Models\Animal;
use App\Models\Devolucao;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AnimalSeeder extends Seeder
{
    /** Dados fictícios de demonstração (RNF10). */
    public function run(): void
    {
        $hoje = Carbon::now();

        $animais = [
            ['nome' => 'Tobias', 'especie' => 'cao', 'porte' => 'medio', 'sexo' => 'macho', 'meses' => 36, 'castrado' => true, 'vacinado' => true, 'vermifugado' => true, 'recebido' => 120, 'descricao' => 'Dócil e brincalhão, convive bem com outros cães. Adora passeios e é muito apegado a pessoas.'],
            ['nome' => 'Mel', 'especie' => 'cao', 'porte' => 'pequeno', 'sexo' => 'femea', 'meses' => 8, 'castrado' => false, 'vacinado' => true, 'vermifugado' => true, 'recebido' => 45, 'descricao' => 'Filhote resgatada com a ninhada. Muito curiosa e cheia de energia.'],
            ['nome' => 'Frajola', 'especie' => 'gato', 'porte' => 'pequeno', 'sexo' => 'macho', 'meses' => 24, 'castrado' => true, 'vacinado' => true, 'vermifugado' => false, 'recebido' => 200, 'descricao' => 'Tranquilo e independente. Prefere ambientes calmos e janelas com sol.'],
            ['nome' => 'Luna', 'especie' => 'gato', 'porte' => 'pequeno', 'sexo' => 'femea', 'meses' => 14, 'castrado' => true, 'vacinado' => true, 'vermifugado' => true, 'recebido' => 90, 'descricao' => 'Carinhosa e sociável, convive bem com outros gatos.'],
            ['nome' => 'Thor', 'especie' => 'cao', 'porte' => 'grande', 'sexo' => 'macho', 'meses' => 60, 'castrado' => true, 'vacinado' => true, 'vermifugado' => true, 'recebido' => 300, 'descricao' => 'Porte grande e temperamento calmo. Ideal para casas com pátio.'],
            ['nome' => 'Pipoca', 'especie' => 'cao', 'porte' => 'pequeno', 'sexo' => 'femea', 'meses' => 30, 'castrado' => true, 'vacinado' => false, 'vermifugado' => true, 'recebido' => 60, 'descricao' => 'Pequena e esperta. Late pouco e se adapta bem a apartamentos.'],
            ['nome' => 'Simba', 'especie' => 'gato', 'porte' => 'medio', 'sexo' => 'macho', 'meses' => 48, 'castrado' => true, 'vacinado' => true, 'vermifugado' => true, 'recebido' => 150, 'descricao' => 'Gato adulto, tranquilo, acostumado com ambientes internos.'],
            ['nome' => 'Nina', 'especie' => 'cao', 'porte' => 'medio', 'sexo' => 'femea', 'meses' => 108, 'castrado' => true, 'vacinado' => true, 'vermifugado' => true, 'recebido' => 400, 'descricao' => 'Idosa serena, busca um lar tranquilo para descansar. Muito companheira.'],
            ['nome' => 'Bento', 'especie' => 'cao', 'porte' => 'grande', 'sexo' => 'macho', 'meses' => 20, 'castrado' => false, 'vacinado' => true, 'vermifugado' => false, 'recebido' => 30, 'descricao' => 'Jovem e ativo, precisa de espaço e exercício diário.'],
            ['nome' => 'Amora', 'especie' => 'gato', 'porte' => 'pequeno', 'sexo' => 'femea', 'meses' => 6, 'castrado' => false, 'vacinado' => true, 'vermifugado' => true, 'recebido' => 20, 'descricao' => 'Filhote resgatada de terreno baldio. Brincalhona e afetuosa.'],
            ['nome' => 'Zeca', 'especie' => 'cao', 'porte' => 'medio', 'sexo' => 'macho', 'meses' => 84, 'castrado' => true, 'vacinado' => true, 'vermifugado' => true, 'recebido' => 500, 'descricao' => 'Adulto tranquilo. Já passou por adoção anterior e retornou ao abrigo; segue sociável e confiante.'],
            ['nome' => 'Mimi', 'especie' => 'gato', 'porte' => 'pequeno', 'sexo' => 'femea', 'meses' => 40, 'castrado' => true, 'vacinado' => false, 'vermifugado' => false, 'recebido' => 75, 'descricao' => 'Reservada no início, muito carinhosa quando ganha confiança.'],
        ];

        foreach ($animais as $dados) {
            $animal = Animal::create([
                'nome' => $dados['nome'],
                'especie' => $dados['especie'],
                'porte' => $dados['porte'],
                'sexo' => $dados['sexo'],
                'data_nascimento_estimada' => $hoje->copy()->subMonths($dados['meses']),
                'situacao' => 'disponivel',
                'castrado' => $dados['castrado'],
                'vacinado' => $dados['vacinado'],
                'vermifugado' => $dados['vermifugado'],
                'descricao' => $dados['descricao'],
                'data_recebimento' => $hoje->copy()->subDays($dados['recebido']),
            ]);

            // Exemplo de histórico de devolução (uso interno — RF13): Zeca.
            if ($dados['nome'] === 'Zeca') {
                Devolucao::create([
                    'animal_id' => $animal->id,
                    'data_saida' => $hoje->copy()->subDays(320),
                    'data_retorno' => $hoje->copy()->subDays(250),
                    'motivo' => 'Família mudou-se para imóvel que não aceita animais.',
                ]);
            }
        }
    }
}