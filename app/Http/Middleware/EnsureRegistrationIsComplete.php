<?php

namespace App\Http\Middleware;

use App\Enums\RegisterStatus;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRegistrationIsComplete
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->getUserCurrentRegisterStatus() === RegisterStatus::VERIFIED->value) {
            return $next($request);
        }

        $user_current_step = $request->user()->getUserCurrentRegisterStatus();

        if ($user_current_step === RegisterStatus::WAITING->value) {
            $user_current_step = 'otp';
        } elseif ($user_current_step === RegisterStatus::CONFIRMED->value) {
            $user_current_step = 'register-data';
        }

        $user_id = $request->user()->id;

        // logout the user
        auth()->logout();
        // invalidate the session
        $request->session()->invalidate();
        // regenerate the session token
        $request->session()->regenerateToken();
        // redirect to the registration page

        session()->put('register', [
            'user_id' => $user_id,
            'current_step' => $user_current_step,
        ]);

        return redirect()->route('register');
    }
}
