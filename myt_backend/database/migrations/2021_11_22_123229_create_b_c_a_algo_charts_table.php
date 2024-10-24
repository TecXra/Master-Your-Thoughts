<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBCAAlgoChartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b_c_a_algo_charts', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->string('image');
            $table->bigInteger('level_id')->unsigned();
            $table->foreign('level_id')
              ->references('id')->on('b_c_a_levels')
              ->onDelete('cascade');
            $table->tinyInteger('activities');


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
        Schema::dropIfExists('b_c_a_algo_charts');
    }
}
