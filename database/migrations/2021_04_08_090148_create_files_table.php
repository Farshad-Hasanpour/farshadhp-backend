<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
			$table->Increments('id');
			$table->Integer('user_id')->unsigned();
			$table->string('public_id', 32);
			$table->string('original_filename', 64);
			$table->string('caption', 64)->nullable();
			$table->string('url', 255);
			$table->Integer('KB')->unsigned();
			$table->string('file_type', 7);
			$table->string('format', 7);
			$table->date('create_date')->default(date('y-m-d'));
	
			$table->engine = 'InnoDB';
			$table->foreign('user_id')->references('id')->on('users')->onUpdate('restrict')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
