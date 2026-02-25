<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Document;
use App\Policies\DocumentPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registrar policy de Document
        Gate::policy(Document::class, DocumentPolicy::class);
        
        // Carregar traduções customizadas
        $this->loadTranslationsFrom(resource_path('lang'), 'app');
    }
}
