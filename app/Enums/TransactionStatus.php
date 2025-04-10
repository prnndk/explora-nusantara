<?php

namespace App\Enums;

enum TransactionStatus: string
{
    case NEW_REQUEST = 'new_request';
    case DONE = 'done';
    case SHIPPING = 'shipping';
    case ORDER = 'order';
    case PENDING = 'pending';
    case CANCELED = 'canceled';
    case REJECTED = 'rejected';
    case NEW_OFFER = 'new_offer';
    case REQUEST = 'request';

    public static function getToArray(): array
    {
        return [
            self::NEW_REQUEST->value,
            self::DONE->value,
            self::SHIPPING->value,
            self::ORDER->value,
            self::PENDING->value,
            self::CANCELED->value,
            self::REJECTED->value,
            self::NEW_OFFER->value,
            self::REQUEST->value,
        ];
    }
}