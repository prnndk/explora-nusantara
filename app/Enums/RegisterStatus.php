<?php

namespace App\Enums;

enum RegisterStatus: string
{
    /**
     * The user has submitted registration form but not yet verified the OTP.
     */
    case WAITING = 'waiting';
    /**
     * The user has confirmed their registration need OTP to next step.
     */
    case CONFIRMED = 'confirmed';
    /**
     * The user current step is filling details.
     */
    case DETAIL = 'detail';
    /**
     * The user has verified their account.
     */
    case VERIFIED = 'verified';

    public static function getToArray(): array
    {
        return [
            self::CONFIRMED->value,
            self::DETAIL->value,
            self::VERIFIED->value,
            self::WAITING->value,
        ];
    }
}
