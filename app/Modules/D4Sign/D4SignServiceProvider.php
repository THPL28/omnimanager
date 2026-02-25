<?php

namespace App\Modules\D4Sign;

use Illuminate\Support\ServiceProvider;

class D4SignServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind D4Sign client or config here
    }

    public function boot()
    {
        // Load module routes if file exists
        if (file_exists(base_path('routes/modules/d4sign.php'))) {
            $this->loadRoutesFrom(base_path('routes/modules/d4sign.php'));
        }

        // Load module views
        $this->loadViewsFrom(__DIR__ . '/../../resources/views/modules/d4sign', 'modules.d4sign');
    }
}
