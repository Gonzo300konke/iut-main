<?php

namespace App\Enums;

enum EstadoBien: string
{
    case DANADO = 'DAÑADO';
    case ACTIVO = 'ACTIVO';
    case EN_REPARACION = 'EN_REPARACION';
    case EN_CAMINO = 'EN_CAMINO';
    case EXTRAVIADO = 'EXTRAVIADO';

    /** Etiqueta amigable (opcional) */
    public function label(): string
    {
        return match ($this) {
            self::DANADO => 'Dañado',
            self::ACTIVO => 'Activo',
            self::EN_REPARACION => 'En reparación',
            self::EN_CAMINO => 'En camino',
            self::EXTRAVIADO => 'Extraviado',
        };
    }

    /** Arreglo de valores (útil para selects/validaciones) */
    public static function values(): array
    {
        return array_map(fn (self $c) => $c->value, self::cases());
    }
}
