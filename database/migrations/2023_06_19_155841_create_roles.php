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
        $administrador = Role::create(['name' => 'Administrador']);
        Role::create(['name' => 'Manager']);
        Role::create(['name' => 'Usuario']);

        $usuario = User::find(1);

        $usuario->assignRole($administrador);

        Permission::create(['name' => 'accederImpresiones']);
        Permission::create(['name' => 'accederUsuarios']);
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