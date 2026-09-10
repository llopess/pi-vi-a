<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Devolucao extends Model
{
    protected $table = 'devolucoes';

    protected $fillable = ['animal_id', 'data_saida', 'data_retorno', 'motivo'];

    protected function casts(): array
    {
        return [
            'data_saida' => 'date',
            'data_retorno' => 'date',
        ];
    }

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }
}
