<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('panel_tek', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('panel_id');
            $table->unsignedBigInteger('tek_id');
            $table->unsignedBigInteger('tek_bertsioa');
            $table->string('fav');
            $table->timestamps();

            $table->foreign('panel_id')->references('id')->on('panelak')->onDelete('cascade');
            $table->foreign('tek_id')->references('id')->on('teknologiak')->onDelete('cascade');
            $table->foreign('tek_bertsioa')->references('id')->on('teknologia_bertsioa')->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('panel_tek');
    }
};
