<?php

use App\Models\User;
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
            $table->decimal('blanco_y_negro', 10, 2)->default(0.00);
            $table->decimal('color', 10, 2)->default(0.00);
            $table->decimal('engargolado', 10, 2)->default(0.00);
            $table->string('encargado');
            $table->timestamps();
        });

        $byn = 1.00;
        $color = 2.00;
        $engargolado = 15.00;
        
        $admin_general = User::find(1);

        DB::table('prices')->insert([
            'blanco_y_negro' => $byn,
            'color' => $color,
            'engargolado' => $engargolado,
            'encargado' => $admin_general->name
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