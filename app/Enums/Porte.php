<?php

namespace App\Enums;

enum Porte: string
{
    case Pequeno = 'pequeno';
    case Medio = 'medio';
    case Grande = 'grande';

    public function label(): string
    {
        return match ($this) {
            self::Pequeno => 'Pequeno',
            self::Medio => 'Médio',
            self::Grande => 'Grande',
        };
    }
}
