<?php

namespace App\Models;

use App\Enums\StatusSolicitacao;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Solicitacao extends Model
{
    protected $table = 'solicitacoes';

    protected $fillable = [
        'solicitante_id', 'animal_id', 'status', 'tipo_moradia',
        'possui_outros_animais', 'possui_telas_protecao', 'observacoes',
    ];

    protected function casts(): array
    {
        return [
            'status' => StatusSolicitacao::class,
            'possui_outros_animais' => 'boolean',
            'possui_telas_protecao' => 'boolean',
        ];
    }

    public function solicitante(): BelongsTo
    {
        return $this->belongsTo(Solicitante::class);
    }

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }
}
