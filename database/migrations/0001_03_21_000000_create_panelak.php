<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('panelak', function (Blueprint $table) {
            $table->id();
            $table->string('izena');
            $table->text('desk');
            $table->string('irudi');
            $table->unsignedBigInteger('so_id');


            $table->foreign('so_id')->references('id')->on('sistema_operativo')->onDelete('cascade');
      
        });
    }

    public function down()
    {
        Schema::dropIfExists('panelak');
    }
};
