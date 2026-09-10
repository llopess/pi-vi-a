<?php

namespace App\Enums;

enum Sexo: string
{
    case Macho = 'macho';
    case Femea = 'femea';

    public function label(): string
    {
        return match ($this) {
            self::Macho => 'Macho',
            self::Femea => 'Fêmea',
        };
    }
}
