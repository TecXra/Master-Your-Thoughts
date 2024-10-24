<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoopingDurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('looping_durations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('duration')->default(config('MYT.default_looping_duration'));  // duration in minutes
            $table->enum('type', ['PracticeCheck', 'VideoReview', 'Quotes']);
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
        Schema::dropIfExists('looping_durations');
    }
}
