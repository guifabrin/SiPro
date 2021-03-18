<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsInTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions_in_tests', function (Blueprint $table) {
            $table->biginteger('test_id')->unsigned();
            $table->foreign('test_id')->references('id')->on('tests');
            $table->biginteger('question_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('questions');
            $table->unique(['test_id', 'question_id'], 'questions_in_tests_unique');
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
        Schema::dropIfExists('questions_in_tests');
    }
}
