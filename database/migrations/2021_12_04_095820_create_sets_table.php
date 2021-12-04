<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sets', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('prevable');
            $table->foreignId('program_id')->constrained();
            $table->string('name');
            $table->integer('day')->unsigned()->nullable();
            $table->integer('set')->unsigned()->default(1);
            $table->integer('rest_time')->unsigned()->nullable();
            $table->boolean('warm_up_set')->nullable();
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
        Schema::dropIfExists('sets');
    }
}
