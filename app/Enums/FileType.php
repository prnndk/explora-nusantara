<?php

namespace App\Enums;

enum FileType: string
{
    case IMAGE = 'image';
    case PDF = 'pdf';

    public static function getToArray(): array
    {
        return [
            self::IMAGE->value,
            self::PDF->value,
        ];
    }
}
