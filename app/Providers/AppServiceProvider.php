<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Bien;
use App\Observers\BienObserver;
use App\Models\Organismo;
use App\Models\UnidadAdministradora;
use App\Models\Dependencia;
use App\Models\Usuario;
use App\Observers\ModelObserver;

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
        Bien::observe(BienObserver::class);
        // Register generic observer for other sections to record movimientos
        Organismo::observe(ModelObserver::class);
        UnidadAdministradora::observe(ModelObserver::class);
        Dependencia::observe(ModelObserver::class);
        Usuario::observe(ModelObserver::class);
    }
}
