<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Document\Http\Controllers\DocumentController;

Route::middleware(['web', 'auth'])->prefix('documentos')->name('documentos.')->group(function () {
    Route::get('/', [DocumentController::class, 'index'])->name('index');
    Route::get('/{document}/download/{version?}', [DocumentController::class, 'download'])->name('download');
    Route::get('/{document}', [DocumentController::class, 'show'])->name('show');
    // rotas adicionais (upload, versions) serão adicionadas aqui
});
