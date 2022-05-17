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
use App\Models\MatchEvent;
use App\Models\Tournament;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;



class MatchsControllerMobile extends Controller
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
    public function matchdetail($idTorneio)
    {
        //selecionar maximo seasson id do torneio
        $seasson = Season::where('t_id', '=', $idTorneio)->orderBy('id', 'DESC')->first();

        $id = $seasson->id;

        if (!$seasson) {
            return response()->json(['error' => 'Temporada não encontrada!'], 200);
        }

        $matchs = DB::table('nx510_bl_matchday')
            ->join('nx510_bl_match', 'nx510_bl_matchday.id', '=', 'nx510_bl_match.m_id')
            ->where('nx510_bl_matchday.s_id', '=', $id)
            ->where('nx510_bl_match.m_played', '=', '1')
            ->orderByRaw('nx510_bl_match.m_date DESC')
            ->paginate(30);


        foreach ($matchs  as $m) {

            $team1 = Team::find($m->team1_id);
            $team2 = Team::find($m->team2_id);
            $m->team1_id = $team1;
            $m->team2_id = $team2;
        }


        //updated, return success response
        return response()->json([
            $matchs,
        ], Response::HTTP_OK);
    }





    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function played($idTorneio)
    {

        //selecionar maximo seasson id do torneio
        $mysqlRegister = Season::where('t_id', '=', $idTorneio)->orderBy('id', 'DESC')->first();

        $id = $mysqlRegister->id;

        if (!$mysqlRegister) {
            return response()->json(['error' => 'Temporada não encontrada!'], 200);
        }

        $matchs = DB::table('nx510_bl_matchday')
            ->join('nx510_bl_match', 'nx510_bl_matchday.id', '=', 'nx510_bl_match.m_id')
            ->where('nx510_bl_matchday.s_id', '=', $id)
            ->where('nx510_bl_match.m_played', '=', '1')
            ->orderByRaw('nx510_bl_match.m_date DESC')
            ->paginate(30);


        foreach ($matchs  as $m) {

            $team1 = Team::find($m->team1_id);
            $team2 = Team::find($m->team2_id);
            $m->team1_id = $team1;
            $m->team2_id = $team2;
        }


        //updated, return success response
        return response()->json([
            $matchs,
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($idTorneio)
    {
        //selecionar maximo seasson id do torneio
        $mysqlRegister = Season::where('t_id', '=', $idTorneio)->orderBy('id', 'DESC')->first();

        $id = $mysqlRegister->id;

        if (!$mysqlRegister) {
            return response()->json(['error' => 'Temporada não encontrada!'], 200);
        }

        $matchs = DB::table('nx510_bl_matchday')
            ->join('nx510_bl_match', 'nx510_bl_matchday.id', '=', 'nx510_bl_match.m_id')
            ->where('nx510_bl_matchday.s_id', '=', $id)
            ->where('nx510_bl_match.m_played', '=', '0')
            ->whereRaw('nx510_bl_match.m_location is not null')
            ->orderByRaw('nx510_bl_match.m_date DESC ')
            ->paginate(30);

        $matchsLocation = array();


        foreach ($matchs  as $m) {


            if (trim($m->m_location) != "") {
                $team1 = Team::find($m->team1_id);
                $team2 = Team::find($m->team2_id);
                $m->team1_id = $team1;
                $m->team2_id = $team2;

                $m->score1 = "";
                $m->score2 = "";
                array_push($matchsLocation, $m);
            }
        }


        //updated, return success response
        return response()->json([
            $matchsLocation,
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($idMatch)
    {

        $mysqlRegister = Matchs::find($idMatch);


        if (!$mysqlRegister) {
            return response()->json(['error' => 'Registro não encontrado!'], 200);
        }

        $team1 = Team::find($mysqlRegister->team1_id);
        $team2 = Team::find($mysqlRegister->team2_id);
        $mysqlRegister->team1_id = $team1;
        $mysqlRegister->team2_id = $team2;

        $dataRetorno['id'] = $mysqlRegister->id;
        $dataRetorno['m_id'] = $mysqlRegister->m_id;
        $dataRetorno['match_descr'] = $mysqlRegister->match_descr;
        $dataRetorno['team1_id'] = $mysqlRegister->team1_id->id;
        $dataRetorno['team1_name'] = $team1->t_name;

        $dataRetorno['team2_id'] = $mysqlRegister->team2_id->id;
        $dataRetorno['team2_name'] = $team2->t_name;

        $dataRetorno['score1'] = $mysqlRegister->score1;
        $dataRetorno['score2'] = $mysqlRegister->score2;

        $data = $mysqlRegister->m_date;
        $horaJogo = $mysqlRegister->m_time;

        $dataJogo = $data[8] . $data[9] . "/" . $data[5] . $data[6] . "/" . $data[0] . $data[1] . $data[2] . $data[3];
        $dataPartida = $dataJogo;
        $dataRetorno['date'] = $dataPartida;
        $dataRetorno['hour'] = $horaJogo;

        $mysqlFind = MatchEvent::with('event')->with('player')->where('match_id', '=', $idMatch)->get();

        $team1_events = array();
        $team2_events = array();

        foreach ($mysqlFind as $event) {

            if ($event->player->nick == "") {
                $nick = explode(" ", $event->player->first_name);
                $detalhe['nick'] = $nick[0];
            } else {
                $detalhe['nick'] = $event->player->nick;
            }

            $detalhe['player_id'] = $event->player_id;
            $detalhe['first_name'] = $event->player->first_name;

            $detalhe['ecount'] = $event->ecount;
            $detalhe['minutes'] = $event->minutes;
            $detalhe['e_name'] = $event->event->e_name;
            $detalhe['e_img'] = "storage/events/" . $event->event->e_img;

            if ($event->t_id == $mysqlRegister->team1_id->id) {

                array_push($team1_events, $detalhe);
            } else if ($event->t_id == $mysqlRegister->team2_id->id) {
                array_push($team2_events, $detalhe);
            }
        }

        $dataRetorno['team1_events'] = $team1_events;
        $dataRetorno['team2_events'] = $team2_events;


        //updated, return success response
        return response()->json([
            'success' => true,
            'message' => 'Operação realizada com sucesso',
            'data' => $dataRetorno
        ], Response::HTTP_OK);
    }
}
