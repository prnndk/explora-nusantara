<?php

use App\Events\UserCreated;
use App\Events\ValidateUserEmail;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\RegisterStep;
use App\Mail\SendOtp;
use App\Models\Otp;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

Route::middleware('guest')->group(function () {
    Route::get('/register', RegisterStep::class)->name('register');

    Route::get('login', Login::class)->name('login');
});


Route::middleware(['auth', 'verify-registration'])->group(function () {
    Route::get('testing', function () {
        event(new ValidateUserEmail(Auth::user()));
        // return view('testing');
    })->name('testing');

    Route::get('/', function () {
        return redirect()->route('dashboard');
    })->name('home');

    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login');
    })->name('logout');

    Route::prefix('dashboard')->group(function () {


        Route::prefix('admin')->middleware(['role:admin'])->group(function () {
            Route::prefix('product')->group(function () {
                Route::get('/', function () {
                    return view('admin.product.index');
                })->name('admin.product.index');
            });
        });
        Route::prefix('seller')->middleware(['role:seller'])->group(function () {
            Route::prefix('product')->group(function () {
                Route::get('/', function () {
                    return view('seller.product.index');
                });
                Route::get('/create', function () {
                    return view('seller.product.create');
                })->name('seller.product.create');
            });
        });
        Route::prefix('buyer')->middleware(['role:buyer'])->group(function () {
            Route::prefix('product')->group(function () {
                Route::get('/', function () {
                    return view('buyer.product.index');
                });
                Route::get('/detail', function () {
                    return view('buyer.product.detail');
                });
                Route::get('/checkout', function () {
                    return view('buyer.product.checkout');
                });
                Route::get('/checkout-success', function () {
                    return view('buyer.product.checkout-success');
                });
            });
        });

    });

    Route::get('/user-profile', function () {
        return view('user-profile');
    })->name('user-profile');

    Route::get('/user-profile/{User:id}/change-password', function () {
        return view('change-password');
    });

    Route::get('/table-example', function () {
        return view('table-example');
    });
});