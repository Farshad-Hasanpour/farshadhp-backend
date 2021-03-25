<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


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
            
            $table->Increments('id');
            $table->smallInteger('role_id')->unsigned()->nullable();
            $table->string('username', 32)->unique();
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->boolean('suspended')->default(false);
            $table->date('create_date')->default(date('y-m-d'));
            $table->string('name', 64)->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('birthday')->nullable();
            $table->string('location', 128)->nullable();
            $table->string('website', 255)->nullable();
            $table->string('social_github', 64)->nullable();
            $table->string('social_whatsapp', 15)->nullable();
            $table->string('social_telegram', 64)->nullable();
            $table->string('social_linkedin', 64)->nullable();
            $table->string('social_twitter', 64)->nullable();
            $table->string('social_instagram', 64)->nullable();
            
            $table->engine = 'InnoDB';
            $table->foreign('role_id')->references('id')->on('roles')->onUpdate('restrict')->onDelete('set null');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
