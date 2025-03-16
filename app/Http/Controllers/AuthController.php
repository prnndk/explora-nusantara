<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function authenticate(Request $request): RedirectResponse{

        $credentials = $request->only('email', 'password');
        
    }
}