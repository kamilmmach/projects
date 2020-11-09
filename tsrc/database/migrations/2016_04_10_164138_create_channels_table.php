<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('password');
            $table->integer('owner_id')->unsigned();
            $table->foreign('owner_id')->references('id')->on('users');
            $table->integer('responder_id')->unsigned()->nullable();
            $table->foreign('responder_id')->references('id')->on('users');
            $table->timestamp('answered_at')->nullable();
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
        Schema::drop('channels');
    }
}
