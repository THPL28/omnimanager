<?php

namespace App\Modules\Document;

use Illuminate\Support\ServiceProvider;

class DocumentServiceProvider extends ServiceProvider
{
    public function register()
    {
        // load module config or bindings here
    }

    public function boot()
    {
        // Load module routes if file exists
        if (file_exists(base_path('routes/modules/document.php'))) {
            $this->loadRoutesFrom(base_path('routes/modules/document.php'));
        }

        // Load module views
        $this->loadViewsFrom(__DIR__ . '/../../resources/views/modules/document', 'modules.document');
    }
}
