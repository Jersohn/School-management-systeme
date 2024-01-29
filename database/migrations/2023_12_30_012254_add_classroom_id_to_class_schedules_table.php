<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClassroomIdToClassSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('class_schedules', function (Blueprint $table) {

            $table->unsignedBigInteger('classroom_id')->after('subject_id')->nullable();
            $table->foreign('classroom_id')->references('id')->on('classroom')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('class_schedules', function (Blueprint $table) {
            //
        });
    }
}
