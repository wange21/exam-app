<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswerGeneralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answer_general', function (Blueprint $table) {
            // answer id
            $table->increments('id');
            // student id(each student in any exam have an unique id)
            $table->integer('student')->unsigned();
            // question id
            $table->integer('question')->unsigned();
            // answer(file name)
            $table->string('answer');
            // score
            $table->tinyInteger('score')->unsigned()->nullable();
            // create an index with student and question
            $table->index(['student', 'question']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('answer_general');
    }
}
