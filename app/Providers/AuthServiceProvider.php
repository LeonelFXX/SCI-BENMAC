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
        $admin_general = Role::where('name', 'Administrador_General')->first();
        $admin_engargolados = Role::where('name', 'Administrador_Engargolados')->first();
        $admin_impresiones = Role::where('name', 'Administrador_Impresiones')->first();
        $manager = Role::where('name', 'Manager')->first();
        $personal_administrativo = Role::where('name', 'Personal_Administrativo')->first();
        $usuario = Role::where('name', 'Usuario')->first();

        // Administrador
        $admin_general->givePermissionTo('accederAdministradorGeneral');
        $admin_general->givePermissionTo('accederImpresiones');
        $admin_general->givePermissionTo('accederUsuarios');
        $admin_general->givePermissionTo('accederEngargolados');
        $admin_general->givePermissionTo('accederSolicitudesImpresiones');
        $admin_general->givePermissionTo('accederPersonalAdministrativo');
        $admin_general->givePermissionTo('accederEstudiante');

        // Administrador Engargolados
        $admin_engargolados->givePermissionTo('accederEngargolados');

        // Administrador Solicitudes De Impresión
        $admin_impresiones->givePermissionTo('accederSolicitudesImpresiones');

        // Manager
        $manager->givePermissionTo('accederUsuarios');
    
        // Personal Administrativo
        $personal_administrativo->givePermissionTo('accederPersonalAdministrativo');
        $personal_administrativo->givePermissionTo('accederEstudiante');

        // Usuario
        $usuario->givePermissionTo('accederEstudiante');
    }
}
