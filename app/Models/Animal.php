<?php

namespace App\Models;

use App\Enums\Especie;
use App\Enums\Porte;
use App\Enums\Sexo;
use App\Enums\SituacaoAnimal;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

class Animal extends Model
{
    protected $table = 'animais';

    protected $fillable = [
        'nome', 'especie', 'porte', 'sexo', 'data_nascimento_estimada',
        'situacao', 'castrado', 'vacinado', 'vermifugado',
        'descricao', 'data_recebimento',
    ];

    protected function casts(): array
    {
        return [
            'especie' => Especie::class,
            'porte' => Porte::class,
            'sexo' => Sexo::class,
            'situacao' => SituacaoAnimal::class,
            'castrado' => 'boolean',
            'vacinado' => 'boolean',
            'vermifugado' => 'boolean',
            'data_nascimento_estimada' => 'date',
            'data_recebimento' => 'date',
        ];
    }

    public function fotos(): HasMany
    {
        return $this->hasMany(FotoAnimal::class);
    }

    public function fotoPrincipal(): HasOne
    {
        return $this->hasOne(FotoAnimal::class)->where('principal', true);
    }

    public function devolucoes(): HasMany
    {
        return $this->hasMany(Devolucao::class);
    }

    public function solicitacoes(): HasMany
    {
        return $this->hasMany(Solicitacao::class);
    }

    /** Apenas animais visíveis no catálogo público (RF01). */
    public function scopeDisponiveis(Builder $query): Builder
    {
        return $query->where('situacao', SituacaoAnimal::Disponivel);
    }

    /** Idade em texto amigável, calculada da data de nascimento estimada. */
    public function getIdadeTextoAttribute(): string
    {
        $meses = (int) $this->data_nascimento_estimada->diffInMonths(Carbon::now());

        if ($meses < 12) {
            return $meses . ' ' . ($meses === 1 ? 'mês' : 'meses');
        }

        $anos = intdiv($meses, 12);

        return $anos . ' ' . ($anos === 1 ? 'ano' : 'anos');
    }

    /** Filtro por faixa de idade (RF02): filhote, jovem, adulto, idoso. */
    public function scopeFaixaIdade(Builder $query, string $faixa): Builder
    {
        $hoje = Carbon::now();

        return match ($faixa) {
            'filhote' => $query->where('data_nascimento_estimada', '>', $hoje->copy()->subYear()),
            'jovem' => $query->whereBetween('data_nascimento_estimada', [
                $hoje->copy()->subYears(3), $hoje->copy()->subYear(),
            ]),
            'adulto' => $query->whereBetween('data_nascimento_estimada', [
                $hoje->copy()->subYears(8), $hoje->copy()->subYears(3),
            ]),
            'idoso' => $query->where('data_nascimento_estimada', '<=', $hoje->copy()->subYears(8)),
            default => $query,
        };
    }
}
