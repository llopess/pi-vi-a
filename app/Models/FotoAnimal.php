<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FotoAnimal extends Model
{
    protected $table = 'fotos_animais';

    protected $fillable = ['animal_id', 'caminho_arquivo', 'principal'];

    protected function casts(): array
    {
        return ['principal' => 'boolean'];
    }

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }
}
