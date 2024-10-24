<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMytResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('myt_responses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tag_id')->nullable();
            $table->longText('response');
            $table->enum('type', ['PracticeCheck', 'VideoReview']);
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
        Schema::dropIfExists('myt_responses');
    }
}
