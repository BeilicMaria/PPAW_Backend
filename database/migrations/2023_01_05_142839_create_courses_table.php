<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->integer('FK_subjectId')->unsigned();
            $table->foreign('FK_subjectId')
                ->references('id')->on('subjects');
            $table->integer('FK_classId')->unsigned();
            $table->foreign('FK_classId')
                ->references('id')->on('classes');
            $table->integer('FK_teacherId')->unsigned();
            $table->foreign('FK_teacherId')
                ->references('id')->on('users');
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
        Schema::dropIfExists('courses');
    }
}
