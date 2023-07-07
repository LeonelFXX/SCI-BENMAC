<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bindings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('impresion_id')->nullable();
            $table->foreign('impresion_id')->references('id')->on('impressions')->onDelete('set null');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->decimal('coste_engargolado', 10, 2);
            $table->date('fecha_engargolado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('estado')->default('Pendiente');
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
        Schema::dropIfExists('bindings');
    }
};
