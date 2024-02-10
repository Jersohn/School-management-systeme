<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar_schedule', function (Blueprint $table) {
            $table->id();
            $table->string('class')->nullable();
            $table->string('teacher')->nullable();
            $table->string('subject')->nullable();
            $table->string('classroom')->nullable();
            $table->string('color')->nullable();

            $table->datetime('start')->nullable();
            $table->datetime('end')->nullable();
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
        Schema::dropIfExists('calendar_schedule');
    }
}
