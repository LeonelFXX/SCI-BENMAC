<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash; // Lib: Encriptar Contraseña

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('matricula')->unique();
            $table->string('name');
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->string('licenciatura');
            $table->string('telefono');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->decimal('saldo', 10, 2)->default(0.00);
            $table->string('tipo_usuario');
            $table->rememberToken(); 
            $table->timestamps();
        });

        // Administrador General
        DB::table('users')->insert([
            'matricula' => '482100078',
            'name' => 'Edgar Leonel',
            'apellido_paterno' => 'Acevedo',
            'apellido_materno' => 'Cuevas',
            'licenciatura' => 'Personal Administrativo',
            'telefono' => '4924920523',
            'email' => 'leonelxo2020@gmail.com',
            'password' => Hash::make('Juni1200'),
            'tipo_usuario' => '1'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
