<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArbitragemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nx510_arbitragem', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 255);
            $table->string('sobrenome', 255)->nullable();
            $table->enum('tipo', array('A', 'M'))->default('A')->nullable();
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
        Schema::dropIfExists('arbitragems');
    }
}
