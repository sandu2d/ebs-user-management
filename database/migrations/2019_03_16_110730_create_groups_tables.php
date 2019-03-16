<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->integer('created_at')->unsigned();
            $table->integer('updated_at')->unsigned();
        });

        Schema::create('user_groups', function (Blueprint $table) {
            // Columns
            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('group_id')->unsigned();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('group_id')->references('id')->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_groups');
        Schema::dropIfExists('groups');
    }
}
