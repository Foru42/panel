<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('user_koloreak', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('login_id');
            $table->foreign('login_id')->references('id')->on('usuarios')->onDelete('cascade');
            $table->string('sidebar');
            $table->string('panel');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_koloreak');
    }
};
