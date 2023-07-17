<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Roles
        $admin_general = Role::create(['name' => 'Administrador_General']);
        $admin_engargolados = Role::create(['name' => 'Administrador_Engargolados']);
        $admin_impresiones = Role::create(['name' => 'Administrador_Impresiones']);
        $manager = Role::create(['name' => 'Manager']);
        $personal_administrativo = Role::create(['name' => 'Personal_Administrativo']);
        $usuario = Role::create(['name' => 'Usuario']);
        
        // Encontrar Usuarios
        $a_g = User::find(1);

        // Asignar Rol A Usuario
        $a_g->assignRole($admin_general);

        Permission::create(['name' => 'accederAdministradorGeneral']);
        Permission::create(['name' => 'accederEngargolados']);
        Permission::create(['name' => 'accederSolicitudesImpresiones']);
        Permission::create(['name' => 'accederImpresiones']);
        Permission::create(['name' => 'accederUsuarios']);
        Permission::create(['name' => 'accederEstudiante']);
        Permission::create(['name' => 'accederPersonalAdministrativo']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
};