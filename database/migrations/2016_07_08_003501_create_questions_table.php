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
            $table->enum('type', [
                'true-false',
                'multi-choice',
                'blank-fill',
                'short-answer',
                'general',
                'program-blank-fill',
                'program',
                'database-blank-fill',
                'database',
            ]);
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
