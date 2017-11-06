<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Header extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('header', function (Blueprint $table) {
            $table->increments('id');
            $table->string('school');
            $table->string('title');
            $table->string('subtitle');
            $table->string('observation');
            $table->boolean('teacher');
            $table->boolean('date');
            $table->double('value', 8, 2);
            $table->text('imageb64');
            $table->boolean('soft_delete');
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
        Schema::dropIfExists('header');
    }
}
