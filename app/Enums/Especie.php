<?php

namespace App\Enums;

enum Especie: string
{
    case Cao = 'cao';
    case Gato = 'gato';

    public function label(): string
    {
        return match ($this) {
            self::Cao => 'Cão',
            self::Gato => 'Gato',
        };
    }
}
