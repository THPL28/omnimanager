<?php

use Illuminate\Support\Facades\Route;
use App\Modules\D4Sign\Http\Controllers\D4SignController;

Route::middleware(['web', 'auth'])
    ->prefix('d4sign')
    ->name('d4sign.')
    ->group(function () {
        Route::get('/', [D4SignController::class, 'index'])->name('index');
        Route::post('/sign', [D4SignController::class, 'sign'])->name('sign');
        Route::get('/status/{document}', [D4SignController::class, 'status'])->name('status');
    });
