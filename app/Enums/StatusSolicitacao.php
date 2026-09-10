<?php

namespace App\Enums;

enum StatusSolicitacao: string
{
    case AguardandoResposta = 'aguardando_resposta';
    case EmAndamento = 'em_andamento';
    case Finalizada = 'finalizada';
    case Cancelada = 'cancelada';

    public function label(): string
    {
        return match ($this) {
            self::AguardandoResposta => 'Aguardando resposta',
            self::EmAndamento => 'Em andamento',
            self::Finalizada => 'Finalizada',
            self::Cancelada => 'Cancelada',
        };
    }
}
