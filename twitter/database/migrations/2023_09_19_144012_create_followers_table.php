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
        Schema::create('followers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('following_id')->comment('フォローしているユーザーID');
            $table->unsignedBigInteger('followed_id')->comment('フォローされているユーザーID');

            $table->foreign('following_id')
                ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('followed_id')
                ->references('id')->on('users')->onDelete('cascade');

            $table->unique(['following_id','followed_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('followers');
    }
};
