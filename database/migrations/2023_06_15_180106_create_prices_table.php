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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->float('blanco_y_negro')->default(0.00); // Blanco Y Negro
            $table->float('color')->default(0.00); // Color
            $table->timestamps();
        });

        $byn = 1.00;
        $color = 2.00;

        DB::table('prices')->insert([
            'blanco_y_negro' => $byn,
            'color' => $color,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prices');
    }
};