<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('questions', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('categorie_id')->nullable()->unsigned();
			$table->foreign('categorie_id')->references('id')->on('question_categories');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->string('description');
			$table->integer('image_id')->nullable()->unsigned();
			$table->foreign('image_id')->references('id')->on('images');
			$table->integer('type');
			$table->integer('lines');
			$table->boolean('soft_delete');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists('questions');
	}
}
