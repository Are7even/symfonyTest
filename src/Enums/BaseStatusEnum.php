<?php

namespace App\Enums;

use JetBrains\PhpStorm\ArrayShape;

class BaseStatusEnum
{
    public const STATUS_ACTIVE = 1;
    public const STATUS_DRAFT = 0;

    #[ArrayShape([self::STATUS_ACTIVE => "mixed", self::STATUS_DRAFT => "mixed"])]
    public static function labels(): array
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_DRAFT => 'Draft',
        ];
    }

}