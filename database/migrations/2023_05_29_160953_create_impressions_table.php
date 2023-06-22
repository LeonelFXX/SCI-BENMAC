<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('impressions', function (Blueprint $table) {
            $table->increments('id'); // ID (Impresión)
            $table->unsignedInteger('user_id'); // ID (Usuario)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Relación "One-To-Many"
            $table->integer('numero_hojas'); // Número Hojas Documento
            $table->integer('numero_copias'); // Número Copias Documento (Juegos)
            $table->string('tamaño'); // Tamaño
            $table->string('color'); // Color
            $table->string('impresora'); // Impresora
            $table->date('fecha_impresion')->default(DB::raw('CURRENT_TIMESTAMP')); // Fecha DEFAULT: Current Timestamp
            $table->integer('total_hojas'); // Total Hojas Impresas
            $table->float('coste_impresion'); // Total Coste Impresión
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('impressions');
    }
};