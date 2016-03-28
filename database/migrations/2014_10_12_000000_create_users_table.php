<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->unique();
            $table->string('token')->nullable();
            $table->boolean('verified')->default(false);
            $table->integer('userable_id')->unsigned()->nullable();
            $table->string('userable_type')->nullable();
            $table->string('password', 60);
            $table->string('handle')->nullable();
//            $table->integer('group_id')->unsigned()->nullable()->index();
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
