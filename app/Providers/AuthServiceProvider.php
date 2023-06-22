<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Se Encuentra El Rol
        $administrador = Role::where('name', 'Administrador')->first();
        $manager = Role::where('name', 'Manager')->first();

        // Se Asignan Los Permisos Al Rol
        $administrador->givePermissionTo('accederImpresiones');
        $administrador->givePermissionTo('accederUsuarios');
        $manager->givePermissionTo('accederUsuarios');
    }
}
