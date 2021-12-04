<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workouts', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('prevable');
            $table->foreignId('exercise_id')->constrained();
            $table->foreignId('program_id')->constrained();
            $table->foreignId('set_id')->nullable()->constrained();
            $table->integer('day')->unsigned()->nullable();
            $table->boolean('reps_based')->nullable();
            $table->integer('reps')->unsigned()->nullable();
            $table->boolean('time_based')->nullable();
            $table->integer('time')->unsigned()->nullable();
            $table->integer('set_number')->unsigned()->default(1);
            $table->integer('rest_time')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workouts');
    }
}
