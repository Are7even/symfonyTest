<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

class BaseStatusEnum extends Enum
{
    public const ACTIVE = 1;
    public const DRAFT = 0;

    public static function castValueIn(int $value): int
    {
        return $value;
    }
}