<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sistema_operativo', function (Blueprint $table) {
            $table->id();
            $table->string('izena');
            $table->text('desk');

        });
    }

    public function down()
    {
        Schema::dropIfExists('sistema_operativo');
    }
};
