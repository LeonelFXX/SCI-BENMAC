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
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Relación "One-To-Many"
            $table->integer('numero_hojas');
            $table->integer('numero_copias');
            $table->string('tamaño');
            $table->string('color');
            $table->string('impresora');
            $table->string('ubicacion');
            $table->date('fecha_impresion')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('total_hojas');
            $table->string('engargolado');
            $table->string('pago');
            $table->string('descripcion')->nullable();
            $table->string('estado');
            $table->decimal('coste_impresion', 10, 2);
            $table->string('encargado')->nullable();
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