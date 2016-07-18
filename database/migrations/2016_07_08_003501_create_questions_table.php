<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            // question id
            $table->increments('id');
            // the exam this question belong to
            $table->integer('exam')->unsigned()->index();
            // question type
            // 0 for true-false
            // 1 for multi-choice
            // 2 for blank-fill
            // 3 for short-answer
            // 4 for general-question
            // 5 for program-blank-fill
            // 6 for program
            // 7 for database-blank-fill(not supported now)
            // 8 for database(not supported now)
            $table->tinyInteger('type')->unsigned();
            // question description
            $table->text('description');
            // the score of the question(0 - 255)
            $table->tinyInteger('score')->unsigned();
            // the source of the question
            $table->smallInteger('source')->unsigned();
            // reference(0 stand this is a new question)
            $table->integer('ref')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('questions');
    }
}
