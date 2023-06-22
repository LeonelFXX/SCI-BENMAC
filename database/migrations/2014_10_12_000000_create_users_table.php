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
            $table->increments('id'); // ID (Usuario)
            $table->string('matricula')->unique(); // Matrícula OR Clave Administrativa
            $table->string('name'); // Nombre(s)
            $table->string('apellido_paterno'); // Apellido Paterno
            $table->string('apellido_materno'); // Apellido Materno
            $table->string('licenciatura'); // Licenciatura
            $table->string('telefono'); // Teléfono
            $table->string('email')->unique(); // Correo Electrónico
            $table->timestamp('email_verified_at')->nullable(); // Verificar Correo Electrónico
            $table->string('password'); // Contraseña
            $table->float('saldo', 8, 2)->default(0.00); // Saldo DEFAULT: $0.00
            $table->string('tipo_usuario')->default('Estudiante'); // Tipo Usuario DEFAULT: Estudiante
            $table->rememberToken(); 
            $table->timestamps();
        });

        
        DB::table('users')->insert([
            'matricula' => '482100078',
            'name' => 'Edgar Leonel',
            'apellido_paterno' => 'Acevedo',
            'apellido_materno' => 'Cuevas',
            'licenciatura' => 'Personal Administrativo',
            'telefono' => '4924920523',
            'email' => 'edgarleonel@benmac.edu.mx',
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
