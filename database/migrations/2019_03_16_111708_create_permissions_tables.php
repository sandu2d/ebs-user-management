<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('code');
            $table->integer('created_at')->unsigned();
            $table->integer('updated_at')->unsigned();
        });

        Schema::create('group_permissions', function (Blueprint $table) {
            // Columns
            $table->increments('id')->unsigned();
            $table->integer('group_id')->unsigned();
            $table->integer('permission_id')->unsigned();

            // Foreign keys
            $table->foreign('permission_id')->references('id')->on('permissions');
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
        Schema::dropIfExists('group_permissions');
        Schema::dropIfExists('permissions');
    }
}
