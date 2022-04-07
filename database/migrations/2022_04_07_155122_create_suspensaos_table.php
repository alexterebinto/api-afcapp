<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuspensaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nx_510_bl_suspensao', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('player_id')->unsigned();
            $table->bigInteger('m_id')->unsigned();
            $table->timestamp('m_date')->nullable();
            $table->bigInteger('match_id')->unsigned();
            $table->bigInteger('season_id')->unsigned();
            $table->string('totalPartidas');
            $table->timestamps();

            $table->foreign('match_id')
                ->references('id')
                ->on('nx510_bl_match')->onDelete('cascade');

            $table->foreign('season_id')
                ->references('id')
                ->on('nx510_bl_seasons')
                ->onDelete('cascade');

            $table->foreign('player_id')
                ->references('id')
                ->on('nx510_bl_players');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('suspensaos');
    }
}
