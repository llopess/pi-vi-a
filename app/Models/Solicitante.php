<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Solicitante extends Model
{
    protected $table = 'solicitantes';

    protected $fillable = ['nome', 'email', 'telefone', 'cidade', 'token'];

    public function solicitacoes(): HasMany
    {
        return $this->hasMany(Solicitacao::class);
    }
}
