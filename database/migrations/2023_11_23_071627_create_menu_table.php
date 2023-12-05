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
        Schema::create('menu', function (Blueprint $table) {
            $table->id();
            $table->String('nama');
            $table->integer('harga');
            $table->String('gambar');
            $table->timestamps();

            $table->unsignedBigInteger('cafe_id');
 
            $table->foreign('cafe_id')->references('id')->on('cafe');

            $table->unsignedBigInteger('user_id');
 
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu');
    }
};
