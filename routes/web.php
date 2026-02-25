<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::view('/', 'welcome');

// DEBUG ROUTE - REMOVE LATER
// DEBUG ROUTE - REMOVE LATER
// Route::get('/debug-locale', function () { ... });

Route::get('dashboard', function () {
    return view('dashboard', [
        'totalGrupos' => \App\Models\GrupoEconomico::count(),
        'totalBandeiras' => \App\Models\Bandeira::count(),
        'totalUnidades' => \App\Models\Unidade::count(),
        'totalColaboradores' => \App\Models\Colaborador::count(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('relatorios/colaboradores', \App\Livewire\Relatorios\ColaboradoresReport::class)
    ->middleware(['auth'])
    ->name('relatorios.colaboradores');

Route::get('unidades', \App\Livewire\Unidade\UnidadesTable::class)
    ->middleware(['auth', 'verified'])
    ->name('unidades.index');

Route::get('colaboradores', \App\Livewire\Colaborador\ColaboradoresTable::class)
    ->middleware(['auth', 'verified'])
    ->name('colaboradores.index');

Route::get('auditoria', \App\Livewire\Auditoria\AuditLog::class)
    ->middleware(['auth', 'verified'])
    ->name('auditoria.index');

Route::get('documentos', \App\Livewire\DocumentCenter::class)
    ->middleware(['auth', 'verified'])
    ->name('documentos.index');

Route::get('grupos', \App\Livewire\GrupoEconomico\GruposEconomicosTable::class)
    ->middleware(['auth', 'verified'])
    ->name('grupos.index');

Route::get('bandeiras', \App\Livewire\Bandeira\BandeirasTable::class)
    ->middleware(['auth', 'verified'])
    ->name('bandeiras.index');

Route::get('usuarios', \App\Livewire\User\UsersTable::class)
    ->middleware(['auth', 'verified'])
    ->name('usuarios.index');

Route::get('language/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'pt_BR', 'es', 'fr', 'de', 'it', 'zh_CN', 'ja', 'ru'])) {
        abort(400);
    }

    if (auth()->check()) {
        auth()->user()->update(['locale' => $locale]);
    }

    Session::put('locale', $locale);

    return redirect()->back();
})->name('language.switch');

Route::get('onboarding', \App\Livewire\Onboarding::class)
    ->middleware(['auth', 'verified'])
    ->name('onboarding');

require __DIR__.'/auth.php';