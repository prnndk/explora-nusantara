<?php

namespace App\Listeners;

use App\Enums\RegisterStatus;
use App\Models\Otp;
use App\Mail\SendOtp;
use App\Events\ValidateUserEmail;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailValidation
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ValidateUserEmail $event): void
    {
        //generate user otp
        $user = $event->user;

        if ($user->getUserCurrentRegisterStatus() != RegisterStatus::WAITING->value) {
            throw new Exception('Cannot sent email, user already verified in the system.');
        }

        //check if user already has otp
        $otp = Otp::where('user_id', $user->id)->first();

        if (!$otp || $otp->isExpired()) {
            $otp = Otp::create([
                'user_id' => $user->id,
                'otp_code' => random_int(10000, 99999),
            ]);
        }
        //send email to user
        Mail::to($user->email)->send(new SendOtp($user, $otp));
    }
}
