<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignTeacherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assign_teacher', function (Blueprint $table) {
            $table->id();
            $table->integer('teacher_id')->comment('user_id=teacher_id');
            $table->json('class_id');
            $table->json('subject_id');
            $table->integer('year_id');

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
        Schema::dropIfExists('assign_teacher');
    }
}
