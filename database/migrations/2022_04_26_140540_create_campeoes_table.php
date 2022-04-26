<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampeoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nx_510_bl_champions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('team_id_1')->unsigned();
            $table->bigInteger('team_id_2')->unsigned();
            $table->bigInteger('team_id_3')->unsigned();
            $table->timestamp('date')->nullable();
            $table->timestamps();

            $table->foreign('team_id_1')
                ->references('id')
                ->on('nx510_bl_teams');

            $table->foreign('team_id_2')
                ->references('id')
                ->on('nx510_bl_teams');

            $table->foreign('team_id_3')
                ->references('id')
                ->on('nx510_bl_teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nx_510_bl_champions');
    }
}
