<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('productos', function (Blueprint $table) {
            $table->unsignedInteger('color_id')->nullable();
            $table->unsignedInteger('modelo_id')->nullable();
            $table->unsignedInteger('tela_id')->nullable();
            $table->unsignedInteger('talla_id')->nullable();
            $table->unsignedInteger('sub_modelo_id')->nullable();
            $table->unsignedInteger('temporada_id')->nullable();
            $table->unsignedInteger('genero_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
