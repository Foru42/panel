<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('iruzkinak', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Agregamos la columna para la clave foránea del usuario
            $table->string('title');
            $table->text('desk');
            $table->timestamps();

            // Definimos la clave foránea
            $table->foreign('user_id')->references('id')->on('usuarios')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('iruzkinak');
    }
};
