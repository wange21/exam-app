<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            // global student id
            $table->increments('id');
            // exam id the student belong to
            $table->integer('exam')->unsigned()->index();
            // student name
            $table->char('name', 16);
            // student number
            $table->char('number', 16);
            // major
            $table->char('major', 32);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('students');
    }
}
