<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSumulaArbritagemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nx510_bl_sumula_arbritagem', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_referee1')->unsigned();
            $table->bigInteger('id_referee2')->unsigned();
            $table->bigInteger('id_referee3')->unsigned();
            $table->bigInteger('match_id')->unsigned();
            $table->timestamps();

            $table->foreign('match_id')
                ->references('id')
                ->on('nx510_bl_match')->onDelete('cascade');

            $table->foreign('id_referee1')
                ->references('id')
                ->on('nx510_arbitragem');

            $table->foreign('id_referee2')
                ->references('id')
                ->on('nx510_arbitragem');

            $table->foreign('id_referee3')
                ->references('id')
                ->on('nx510_arbitragem');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sumula_arbritagems');
    }
}
