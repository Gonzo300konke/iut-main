<?php

namespace App\Enums;

enum EstadoBien: string
{
    case DANADO = 'DAÑADO';
    case ACTIVO = 'ACTIVO';
    // Usamos EN_MANTENIMIENTO como valor almacenado en BD
    case EN_MANTENIMIENTO = 'EN_MANTENIMIENTO';
    case EN_CAMINO = 'EN_CAMINO';
    case EXTRAVIADO = 'EXTRAVIADO';
    case DESINCORPORADO = 'DESINCORPORADO';

    /** Etiqueta amigable (opcional) */
    public function label(): string
    {
        return match ($this) {
            self::DANADO => 'Dañado',
            self::ACTIVO => 'Activo',
            self::EN_MANTENIMIENTO => 'En mantenimiento',
            self::EN_CAMINO => 'En camino',
            self::EXTRAVIADO => 'Extraviado',
            self::DESINCORPORADO => 'Desincorporado',
        };
    }

    /** Arreglo de valores (útil para selects/validaciones) */
    public static function values(): array
    {
        return array_map(fn (self $c) => $c->value, self::cases());
    }
}
