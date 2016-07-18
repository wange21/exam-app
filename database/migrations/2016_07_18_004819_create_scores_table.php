<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            // student id
            $table->integer('id')->unsigned()->index();
            // total scores
            $table->smallInteger('scores')->unsigned()->default(0);
            // true-false scores
            $table->smallInteger('true_false')->unsigned()->default(0);
            // multi-choice scores
            $table->smallInteger('multi_choice')->unsigned()->default(0);
            // blank-fill scores
            $table->smallInteger('blank_fill')->unsigned()->default(0);
            // short-answer scores
            $table->smallInteger('short_answer')->unsigned()->default(0);
            // general scores
            $table->smallInteger('general')->unsigned()->default(0);
            // program-blank-fill scores
            $table->smallInteger('program_blank_fill')->unsigned()->default(0);
            // program scores
            $table->smallInteger('program')->unsigned()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('scores');
    }
}
