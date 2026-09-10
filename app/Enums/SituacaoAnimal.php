<?php

namespace App\Enums;

enum SituacaoAnimal: string
{
    case Disponivel = 'disponivel';
    case EmProcesso = 'em_processo';
    case Adotado = 'adotado';

    public function label(): string
    {
        return match ($this) {
            self::Disponivel => 'Disponível',
            self::EmProcesso => 'Em processo de adoção',
            self::Adotado => 'Adotado',
        };
    }
}
