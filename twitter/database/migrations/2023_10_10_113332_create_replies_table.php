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
        Schema::create('replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tweet_id')->comment('ツイートID');
            $table->unsignedBigInteger('user_id')->commnet('リプライしたユーザーID');
            $table->string('body')->comment('リプライ本文');
            $table->timestamps();

            $table->foreign('tweet_id')
                ->references('id')->on('tweets')->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('replies');
    }
};