<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumns("users", [
                "userName", "lastName", "firstName", "phone", "dateOfBirth",
                "status", "FK_roleId"
            ])) {
                $table->string('userName')->unique();;
                $table->string('lastName');
                $table->string('firstName');
                $table->string('phone');
                $table->date('dateOfBirth');
                $table->boolean('status');
                $table->integer('FK_roleId')->unsigned();
                $table->foreign('FK_roleId')
                    ->references('id')->on('roles');
            }
            if (Schema::hasColumn("users", "name")) {
                $table->dropColumn("name");
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumns("users", [
                "userName", "lastName", "firstName", "phone", "dateOfBirth",
                "status", "FK_roleId"
            ])) {
                $table->dropColumn("userName");
                $table->dropColumn("lastName");
                $table->dropColumn("firstName");
                $table->dropColumn("phone");
                $table->dropColumn("status");
                $table->dropColumn("dateOfBirth");
                $table->dropColumn("FK_roleId");
            }
        });
    }
}
