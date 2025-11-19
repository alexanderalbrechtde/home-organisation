<?php

namespace Framework\Enums;

enum Location
{
    case App;
    case Framework;

    public static function toArray(): array
    {
        return array_column(self::cases(), null, 'name');
    }
}

