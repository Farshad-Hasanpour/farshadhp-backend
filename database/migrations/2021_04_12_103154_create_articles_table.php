<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
			$table->Increments('id');
			$table->Integer('author_id')->unsigned()->nullable();
			$table->Integer('thumbnail_id')->unsigned()->nullable();
			$table->Integer('banner_id')->unsigned()->nullable();
			$table->string('title', 128)->unique()->nullable();
			$table->string('slug', 128)->unique()->nullable();
			$table->string('excerpt', 256)->nullable();
			$table->text('content')->nullable();
			$table->enum('state', ['submitted', 'published'])->default('submitted');
			$table->timestamps();
			
			$table->engine = 'InnoDB';
			$table->foreign('author_id')->references('id')->on('users')->onUpdate('restrict')->onDelete('set null');
			$table->foreign('thumbnail_id')->references('id')->on('files')->onUpdate('restrict')->onDelete('set null');
			$table->foreign('banner_id')->references('id')->on('files')->onUpdate('restrict')->onDelete('set null');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
