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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->String('komentar');
            $table->integer('rating');
            $table->tinyInteger('status');
            $table->timestamps();

            $table->unsignedBigInteger('cafe_id');
 
            $table->foreign('cafe_id')->references('id')->on('cafe');

            $table->unsignedBigInteger('user_id');
 
            $table->foreign('user_id')->references('id')->on('users');

            // $table->foreign('cafe_id')->references('id')->on('cafe')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratings');
    }
};
