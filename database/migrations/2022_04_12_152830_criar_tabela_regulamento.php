<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriarTabelaRegulamento extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nx_510_bl_regulation', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('season_id')->unsigned();
            $table->string('title', 255);
            $table->longText('regulation', 255)->nullable();
            $table->string('link', 255)->nullable();
            $table->string('def_img', 255);
            $table->enum('publicado', array('N', 'S'))->default('N')->nullable();
            $table->timestamps();


            $table->foreign('season_id')
                ->references('id')
                ->on('nx510_bl_seasons')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nx_510_bl_regulation');
    }
}
