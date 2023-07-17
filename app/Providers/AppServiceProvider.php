<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
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
        // Carga El Número De Solicitudes De Engargolado Pendientes
        $solicitudes = DB::table('bindings')
            ->where('estado', '=', 'Pendiente')
            ->count();

        // Carga El Número De Solicitudes De Impresión Pendientes
        $solicitudes_impresiones = DB::table('impressions')
            ->where('estado', '=', 'Pendiente')
            ->count();

        // Carga El Número De Solicitudes De Copias Pendientes
        $solicitudes_copias = DB::table('copies')
            ->where('estado', '=', 'Pendiente')
            ->count();

        view()->share([
            'solicitudes' => $solicitudes,
            'solicitudes_impresiones' => $solicitudes_impresiones,
            'solicitudes_copias' => $solicitudes_copias
        ]);
    }
}