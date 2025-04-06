<x-mail::message>
    # Confirm email address

    Thank you for signing up with us. 
    
    To complete your registration, please verify your email address by entering the
    OTP code below.

# {{ $otp->otp_code }}
    If you did not request this code, please ignore this email. The code will expire in 60 minutes.

    P.S. Do not reply to this email. This is an automated message and replies are not monitored.
</x-mail::message>
