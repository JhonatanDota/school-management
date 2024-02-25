<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduledLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scheduled_lessons', function (Blueprint $table) {
            $table->id();
            $table->integer('course_lesson_id')->unsigned();
            $table->foreign('course_lesson_id')->references('id')->on('course_lessons');
            $table->integer('klass_id')->unsigned();
            $table->foreign('klass_id')->references('id')->on('klasses');
            $table->datetime('datetime');
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('scheduled_lessons');
    }
}
