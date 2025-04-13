<?php

use App\Events\ValidateUserEmail;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\RegisterStep;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/register', RegisterStep::class)->name('register');

    Route::get('login', Login::class)->name('login');
});


Route::middleware(['auth', 'verify-registration'])->group(function () {
    Route::get('testing', function () {
        //        event(new ValidateUserEmail(Auth::user()));
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
                Route::get('/{product:id}', function (Product $product) {
                    return view('admin.product.detail', [
                        'product' => $product
                    ]);
                })->name('admin.product.detail');
            });

            Route::prefix('transaction')->group(function () {
                Route::get('/', function () {
                    return view('admin.transaction.index');
                })->name('admin.transaction.index');

                Route::get('/{transaction:id}', function (\App\Models\Transaction $transaction) {
                    return view('admin.transaction.detail', [
                        'transaction' => $transaction
                    ]);
                })->name('admin.transaction.detail');
            });
            Route::prefix('trade-meeting')->group(function () {
                Route::get('/', function () {
                    return view('admin.trade-meeting.index');
                })->name('admin.trade-meeting.index');
            });
            Route::prefix('contract')->group(function () {
                Route::get('/', function () {
                    return view('admin.contract.index');
                })->name('admin.contract.index');
                Route::get('/{contract:id}', function (\App\Models\Contract $contract) {
                    return view('admin.contract.detail', [
                        'contract' => $contract
                    ]);
                })->name('admin.contract.detail');
            });
        });
        Route::prefix('seller')->middleware(['role:seller'])->group(function () {
            Route::prefix('product')->group(function () {
                Route::get('/', function () {
                    return view('seller.product.index');
                })->name('seller.product.index');
                Route::get('/create', function () {
                    return view('seller.product.create');
                })->name('seller.product.create');
                Route::get('/{product:id}', function (Product $product) {
                    return view('seller.product.edit', [
                        'product' => $product
                    ]);
                })->name('seller.product.detail');
            });

            Route::prefix('transaction')->group(function () {
                Route::get('/', function () {
                    return view('seller.transaction.index');
                })->name('seller.transaction.index');

                Route::get('/{transaction:id}', function (\App\Models\Transaction $transaction) {
                    return view('seller.transaction.detail', [
                        'transaction' => $transaction
                    ]);
                })->name('seller.transaction.detail');
            });

            Route::prefix('trade-meeting')->group(function () {
                Route::get('/', function () {
                    return view('seller.trade-meeting.index');
                })->name('seller.trade-meeting.index');
            });
        });
        Route::prefix('buyer')->middleware(['role:buyer'])->group(function () {
            Route::prefix('product')->group(function () {
                Route::get('/', function () {
                    return view('buyer.product.index');
                })->name('buyer.product.index');

                Route::get('/checkout-success', function () {
                    return view('buyer.product.checkout-success');
                })->name('buyer.product.checkout-success');

                Route::get('/{product:id}', function (Product $product) {
                    return view('buyer.product.detail', [
                        'product' => $product
                    ]);
                })->name('buyer.product.detail');

                Route::get('/{product:id}/checkout', function (Product $product) {
                    return view('buyer.product.checkout', [
                        'product' => $product
                    ]);
                })->name('buyer.product.checkout');
            });

            Route::prefix('transaction')->group(function () {
                Route::get('/', function () {
                    return view('buyer.transaction.index');
                })->name('buyer.transaction.index');

                Route::get('/{transaction:id}', function (\App\Models\Transaction $transaction) {
                    return view('buyer.transaction.detail', [
                        'transaction' => $transaction
                    ]);
                })->name('buyer.transaction.detail');
            });
            Route::prefix('trade-meeting')->group(function () {
                Route::get('/', function () {
                    return view('buyer.trade-meeting.index');
                })->name('buyer.trade-meeting.index');
            });
        });

        Route::get('tutorial', function () {
            return view('tutorial');
        })->name('tutorial');
        Route::get('/user-profile', \App\Livewire\UserProfile::class)->name('user-profile');

        Route::get('/user-profile/change-password', \App\Livewire\ChangePassword::class)->name('user-profile.change-password');
    });

    Route::get('view-file/{file:id}', function (\App\Models\File $file) {
        $filePath = storage_path('app/public/' . $file->file_path);
        if (!file_exists($filePath)) {
            abort(404);
        }

        return response()->file($filePath);
    })->name('view-file');
});