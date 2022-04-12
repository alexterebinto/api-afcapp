<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterarTabelaBanners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nx510_bl_banners', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('t_id')->unsigned();
            $table->string('nome', 255);
            $table->longText('descricao', 255)->nullable();
            $table->string('site', 255)->nullable();
            $table->string('def_img', 255);
            $table->enum('publicado', array('N', 'S'))->default('N')->nullable();
            $table->timestamps();

            $table->foreign('t_id')
                ->references('id')
                ->on('nx510_bl_tournament')
                ->onDelete('cascade');
        });

        DB::table('nx510_bl_banners')->insert([
            't_id' => '1',
            'descricao' => 'Anuncie Aqui',
            'nome' => 'Anuncie Aqui',
            'def_img' => 'anuncie.jpg',
            'publicado' => 'S',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nx510_bl_banners');
    }
}
