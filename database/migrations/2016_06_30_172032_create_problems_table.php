<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('problems', function (Blueprint $table) {
            // problem id
            $table->increments('id');
            // the exam this problem belong to
            $table->integer('exam')->unsigned()->index();
            // problem title
            $table->char('title', 64);
            // problem description
            $table->text('description');
            // the score of the problem(0 - 255)
            $table->tinyInteger('score')->unsigned();
            // the source of the problem
            $table->smallInteger('source')->unsigned();
            // the owner of the problem
            $table->integer('user')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('problems');
    }
}
