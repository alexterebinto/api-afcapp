<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use App\Models\Season;
use App\Models\SeasonTeam;
use App\Models\Team;
use App\Models\Matchs;
use App\Models\Matchday;
use App\Models\Tournament;
use App\Models\Player;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;



class EventsControllerMobile extends Controller
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $model;

    protected $user;

    public function __construct(Season $modelConstructor, Request $request)
    {
        $this->model = $modelConstructor;
        $this->request = $request;
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function goals($idTorneio)
    {

        //selecionar maximo seasson id do torneio
        $mysqlRegister = Season::where('t_id', '=', $idTorneio)->orderBy('id', 'DESC')->first();



        if (!$mysqlRegister) {
            return response()->json(['error' => 'Temporada não encontrada!'], 200);
        }


        $id = $mysqlRegister->id;

        $matchs = DB::table('nx510_bl_matchday')
            ->join('nx510_bl_match', 'nx510_bl_matchday.id', '=', 'nx510_bl_match.m_id')
            ->join('nx510_bl_match_events', 'nx510_bl_match.id', '=', 'nx510_bl_match_events.match_id')
            ->where('nx510_bl_matchday.s_id', '=', $id)
            ->where('nx510_bl_match.m_played', '=', '1')
            ->where('nx510_bl_match_events.e_id', '=', '3')
            ->orderByRaw('nx510_bl_matchday.id ASC')
            ->select('player_id')
            ->get();

        $players = array();
        $table_view = array();

        foreach ($matchs  as $m) {
            array_push($players, $m->player_id);
        }

        $filters = array_count_values($players);

        $i = 1;
        foreach ($filters as $key  => $val) {

            $url =  $_ENV['APP_URL'] . "/api/v1/image?filename=" . $_ENV['SFTP_PATH_PHOTO_ATLETA'];
            //$url = $_ENV['SFTP_PATH_PHOTO_ATLETA'];


            $player = Player::with('team')->find($key);
            $table_view[$i]['id'] = $player->id;
            $table_view[$i]['first_name'] = $player->first_name;
            $table_view[$i]['last_name'] = $player->last_name;



            if (!file_exists($_ENV['SFTP_PATH_PHOTO_ATLETA'] . $player->def_img)) {
                $table_view[$i]['def_img'] = $url . "sem-foto-homem.jpg";
            } else {
                $table_view[$i]['def_img'] = $url . $player->def_img;
            }

            $table_view[$i]['team_id'] = $player->team_id;
            $table_view[$i]['t_name'] = $player->team->t_name;
            $table_view[$i]['goals'] = $val;
            $i++;
        }

        $sort_arr = array();
        foreach ($table_view as $uniqid => $row) {
            foreach ($row as $key => $value) {
                $sort_arr[$key][$uniqid] = $value;
            }
        }

        if ($i > 1) {
            array_multisort($sort_arr['goals'], SORT_DESC, $table_view);
        }

        $list =   $table_view;

        $cont = 1;
        $classificacao = array();

        foreach ($list as $obj) {
            $obj["position"] = $cont;
            $cont++;
            array_push($classificacao, $obj);
        }


        //updated, return success response
        return response()->json([
            $classificacao
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function all($idTorneio)
    {
        //selecionar maximo seasson id do torneio
        $mysqlRegister = Season::where('t_id', '=', $idTorneio)->orderBy('id', 'DESC')->first();

        $id = $mysqlRegister->id;


        if (!$mysqlRegister) {
            return response()->json(['error' => 'Temporada não encontrada!'], 200);
        }

        $matchs = DB::table('nx510_bl_matchday')
            ->join('nx510_bl_match', 'nx510_bl_matchday.id', '=', 'nx510_bl_match.m_id')
            ->join('nx510_bl_match_events', 'nx510_bl_match.id', '=', 'nx510_bl_match_events.match_id')
            ->where('nx510_bl_matchday.s_id', '=', $id)
            ->where('nx510_bl_match.m_played', '=', '1')
            ->where('nx510_bl_match_events.e_id', '=', '3')
            ->orderByRaw('nx510_bl_matchday.id ASC')
            ->select('player_id')
            ->get();

        $players = array();
        $table_view = array();

        foreach ($matchs  as $m) {
            array_push($players, $m->player_id);
        }

        $filters = array_count_values($players);

        $i = 1;
        foreach ($filters as $key  => $val) {

            $url = $_ENV['APP_URL'] . "/api/v1/image?filename=" . $_ENV['SFTP_PATH_PHOTO_ATLETA'];
            // $url = $_ENV['SFTP_PATH_PHOTO_ATLETA'];


            $player = Player::with('team')->find($key);
            $table_view[$i]['id'] = $player->id;
            $table_view[$i]['first_name'] = $player->first_name;
            $table_view[$i]['last_name'] = $player->last_name;
            $table_view[$i]['def_img'] = $url . $player->def_img;
            $table_view[$i]['team_id'] = $player->team_id;
            $table_view[$i]['t_name'] = $player->team->t_name;
            $table_view[$i]['goals'] = $val;
            $i++;
        }

        $sort_arr = array();
        foreach ($table_view as $uniqid => $row) {
            foreach ($row as $key => $value) {
                $sort_arr[$key][$uniqid] = $value;
            }
        }



        if ($i > 1) {
            array_multisort($sort_arr['goals'], SORT_DESC, $table_view);
        }



        $list =   $table_view;

        $cont = 1;
        $classificacao = array();

        foreach ($list as $obj) {

            $obj["position"] = $cont;

            if ($cont < 11) {

                $obj["position"] = $cont;

                $amarelos = DB::table('nx510_bl_matchday')
                    ->join('nx510_bl_match', 'nx510_bl_matchday.id', '=', 'nx510_bl_match.m_id')
                    ->join('nx510_bl_match_events', 'nx510_bl_match.id', '=', 'nx510_bl_match_events.match_id')
                    ->where('nx510_bl_matchday.s_id', '=', $id)
                    ->where('nx510_bl_match.m_played', '=', '1')
                    ->where('nx510_bl_match_events.e_id', '=', '1')
                    ->where('nx510_bl_match_events.player_id', '=',  $obj["id"])
                    ->orderByRaw('nx510_bl_matchday.id ASC')
                    ->select('player_id')
                    ->get();


                $amarelosTotal = array();

                foreach ($amarelos  as $m) {
                    array_push($amarelosTotal, $m->player_id);
                }

                $filtersAmarelo = array_count_values($amarelosTotal);

                $obj["yellow"] = "0";
                foreach ($filtersAmarelo  as $key  => $val) {
                    $obj["yellow"] = $val;
                }

                $reds = DB::table('nx510_bl_matchday')
                    ->join('nx510_bl_match', 'nx510_bl_matchday.id', '=', 'nx510_bl_match.m_id')
                    ->join('nx510_bl_match_events', 'nx510_bl_match.id', '=', 'nx510_bl_match_events.match_id')
                    ->where('nx510_bl_matchday.s_id', '=', $id)
                    ->where('nx510_bl_match.m_played', '=', '1')
                    ->where('nx510_bl_match_events.e_id', '=', '2')
                    ->where('nx510_bl_match_events.player_id', '=',  $obj["id"])
                    ->orderByRaw('nx510_bl_matchday.id ASC')
                    ->select('player_id')
                    ->get();


                $redsTotal = array();

                foreach ($reds  as $m) {
                    array_push($redsTotal, $m->player_id);
                }

                $filtersRed = array_count_values($redsTotal);

                $obj["red"] = "0";
                foreach ($filtersRed  as $key  => $val) {
                    $obj["red"] = $val;
                }

                $blues = DB::table('nx510_bl_matchday')
                    ->join('nx510_bl_match', 'nx510_bl_matchday.id', '=', 'nx510_bl_match.m_id')
                    ->join('nx510_bl_match_events', 'nx510_bl_match.id', '=', 'nx510_bl_match_events.match_id')
                    ->where('nx510_bl_matchday.s_id', '=', $id)
                    ->where('nx510_bl_match.m_played', '=', '1')
                    ->where('nx510_bl_match_events.e_id', '=', '4')
                    ->where('nx510_bl_match_events.player_id', '=',  $obj["id"])
                    ->orderByRaw('nx510_bl_matchday.id ASC')
                    ->select('player_id')
                    ->get();


                $blueTotal = array();

                foreach ($blues  as $m) {
                    array_push($blueTotal, $m->player_id);
                }

                $filtersBlue = array_count_values($blueTotal);

                $obj["blue"] = "0";
                foreach ($filtersBlue  as $key  => $val) {
                    $obj["blue"] = $val;
                }

                $cont++;
                array_push($classificacao, $obj);
            }
        }


        //updated, return success response
        return response()->json([
            'success' => true,
            'message' => 'Operação realizada com sucesso',
            'data' => $classificacao
        ], Response::HTTP_OK);
    }
}
