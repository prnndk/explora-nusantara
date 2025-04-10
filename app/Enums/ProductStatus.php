<?php

namespace App\Enums;

enum ProductStatus: string
{
    case NEW_REQUEST = 'new_request';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
    case PENDING = 'pending';

    public static function getToArray(): array
    {
        return [
            self::NEW_REQUEST->value,
            self::APPROVED->value,
            self::REJECTED->value,
            self::PENDING->value,
        ];
    }   
}