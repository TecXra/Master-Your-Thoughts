<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserThemeSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_theme_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('font_family');
            $table->integer('navbar_style')->default(config('MYT.navbar_style.transparent'));
            $table->string('navbar_color')->nullable();
            $table->string('sidebar_color');
            $table->integer('default_theme')->default(config('MYT.default_theme.light'));
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->softDeletes();
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
        Schema::dropIfExists('user_theme_settings');
    }
}
