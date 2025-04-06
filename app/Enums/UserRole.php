<?php

namespace App\Enums;

enum UserRole: string
{
    /**
     * The user is a buyer.
     */
    case BUYER = 'buyer';
    /**
     * The user is a seller.
     */
    case SELLER = 'seller';
    /**
     * The user is an admin.
     */
    case ADMIN = 'admin';


    /**
     * Get the array of user roles enums.
     *
     * @return array
     */
    public static function getToArray(): array
    {
        return [
            self::BUYER->value,
            self::SELLER->value,
            self::ADMIN->value,
        ];
    }
}
