<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\RegisterStep;
use Illuminate\Support\Facades\Route;

Route::get('/register', RegisterStep::class)->name('register');

Route::get('login', Login::class)->name('login');

Route::group(['middleware' => 'auth'], function () {
    Route::get('testing', function () {
        return view('testing');
    })->name('testing');

    Route::get('/', function () {
        return redirect()->route('dashboard');
    })->name('home');

    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('logout', function () {
        auth()->logout();
        return redirect()->route('login');
    })->name('logout');

    Route::prefix('dashboard')->group(function () {
        Route::get('admin', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
        Route::get('seller', function () {
            return view('seller.dashboard');
        })->name('seller.dashboard');
        Route::get('buyer', function () {
            return view('buyer.dashboard');
        })->name('buyer.dashboard');
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

    Route::get('/buyer/product', function () {
        return view('buyer.product.index');
    });
});



