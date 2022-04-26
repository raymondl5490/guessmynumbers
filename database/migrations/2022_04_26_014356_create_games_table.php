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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('number_one');
            $table->tinyInteger('number_two');
            $table->tinyInteger('number_three');
            $table->string('author_name');
            $table->string('author_location')->nullable();
            $table->string('author_email')->nullable();
            $table->string('link')->nullable();
            $table->string('link_title')->nullable();
            $table->dateTime('game_start')->nullable();
            $table->dateTime('game_end')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
};
