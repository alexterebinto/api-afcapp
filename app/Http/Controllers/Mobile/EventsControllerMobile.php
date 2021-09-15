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
    public function goals($id)
    {
        $mysqlRegister = Season::find($id);

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

            $player = Player::with('team')->find($key);
            $table_view[$i]['id'] = $player->id;
            $table_view[$i]['first_name'] = $player->first_name;
            $table_view[$i]['last_name'] = $player->last_name;
            $table_view[$i]['def_img'] = $player->def_img;
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

        array_multisort($sort_arr['goals'], SORT_DESC, $table_view);

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
}
