<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\RegisterStep;
use Illuminate\Support\Facades\Route;

Route::get('/register', RegisterStep::class)->name('register');
Route::get('testing', function () {
    return view('testing');
})->name('testing');

Route::get('dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('login', Login::class)->name('login');
