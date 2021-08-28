<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SeasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nx510_bl_seasons')->insert([
            "t_id" => "1",
            'published' => 'N',
            "s_name" =>  "temporada 2021",
            "s_descr" =>  "descricao 2021",
            "published" =>  "N",
            "s_win_point" =>  "3",
            "s_lost_point" => "0",
            "s_enbl_extra" =>  "0",
            "s_extra_win" => "3",
            "s_extra_lost" =>  "0",
            "s_draw_point" =>  "1",
            "s_groups" =>  "0",
            "s_draw_away" => "1",
            "s_lost_away" =>  "O",
            "s_win_away" =>  "3"

        ]);
    }
}
