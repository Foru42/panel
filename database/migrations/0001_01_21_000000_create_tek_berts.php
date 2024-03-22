<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('teknologia_bertsioa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teknologia_id');
            $table->string('izena');


            $table->foreign('teknologia_id')->references('id')->on('teknologiak')->onDelete('cascade');
      
        });
    }

    public function down()
    {
        Schema::dropIfExists('teknologia_bertsioa');
    }
};
