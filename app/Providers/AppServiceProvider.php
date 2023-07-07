<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Carga El Número De Solicitudes Pendientes
        $solicitudes = DB::table('bindings')
            ->where('estado', '=', 'Pendiente')
            ->count();

        $solicitudes_impresiones = DB::table('impressions')
            ->where('estado', '=', 'Pendiente')
            ->count();

        view()->share([
            'solicitudes' => $solicitudes,
            'solicitudes_impresiones' => $solicitudes_impresiones
        ]);
    }
}