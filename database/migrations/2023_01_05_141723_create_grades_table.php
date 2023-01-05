<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->increments('id');
            $table->double('grade',4,2);
            $table->integer('FK_studentId')->unsigned();
            $table->foreign('FK_studentId')
                ->references('id')->on('users');
            $table->integer('FK_teacherId')->unsigned();
            $table->foreign('FK_teacherId')
                ->references('id')->on('users');
            $table->integer('FK_subjectId')->unsigned();
            $table->foreign('FK_subjectId')
                ->references('id')->on('subjects');
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
        Schema::dropIfExists('grades');
    }
}
