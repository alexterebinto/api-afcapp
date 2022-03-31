<?php

namespace App\Http\Controllers\Api;

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
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class SeasonController extends Controller
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
    public function matchsporid($id, $idMatchday)
    {
        $mysqlRegister = Matchday::where('s_id', '=',  $id)->where('id', '=',  $idMatchday)->get();


        $dataRetorno = array();


        foreach ($mysqlRegister  as $matchday) {

            $matchdays = Matchs::where('m_id', '=', $matchday->id)->get();

            foreach ($matchdays  as $mt) {

                $time1 = Team::where('id', '=', $mt['team1_id'])->first();
                $time2 = Team::where('id', '=', $mt['team2_id'])->first();
                $mt['match_descr'] = $time1->t_name . $time1->score1 . " X " . $time2->score2 . $time2->t_name ;
            }

            //updated, return success response
            return response()->json([
                'success' => true,
                'message' => 'Opearação realizada com sucesso',
                'data' => $matchdays
            ], Response::HTTP_OK);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function matchs($id)
    {
        $mysqlRegister = Season::with('matchdays')->find($id);

        if (!$mysqlRegister) {
            return response()->json(['error' => 'Registro não encontrado!'], 200);
        }

        $data = $mysqlRegister->matchdays;

        $dataRetorno = array();

        foreach ($data  as $match) {


            $matchdays = Matchs::where('m_id', '=', $match->id)->get();

            foreach ($matchdays  as $mt) {

                $time1 = Team::where('id', '=', $mt['team1_id'])->first();
                $time2 = Team::where('id', '=', $mt['team2_id'])->first();
                $mt['match_descr'] = $time1->t_name . " X " . $time2->t_name ;
            }

            $match['matchdays'] = $matchdays;

            array_push($dataRetorno, $match);
        }

        //updated, return success response
        return response()->json([
            'success' => true,
            'message' => 'Opearação realizada com sucesso',
            'data' => $dataRetorno
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function matchdays($id)
    {
        $mysqlRegister = Season::with('matchdays')->where('id', '=', $id)->get();

        if (!$mysqlRegister) {
            return response()->json(['error' => 'Registro não encontrado!'], 200);
        }

        //updated, return success response
        return response()->json([
            'success' => true,
            'message' => 'Operação realizada com sucesso',
            'data' => $mysqlRegister
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function tourseas($id)
    {

        $mysqlRegister = Tournament::with('season')->get();

        if (!$mysqlRegister) {
            return response()->json(['error' => 'Registro não encontrado!'], 200);
        }

        //updated, return success response
        return response()->json([
            'success' => true,
            'message' => 'Operação realizada com sucesso',
            'data' => $mysqlRegister
        ], Response::HTTP_OK);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->model->orderBy('id', 'DESC')->paginate();

        return response()->json($data, 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dataForm = $request->all();

        $array = array();

        // validate incoming request

        $validator = Validator::make($request->all(), [
            't_id' => 'exists:App\Models\Tournament,id',
            's_name' => 'required',
            's_descr' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'type' => 'fail',
                'data' => $validator->errors(),
            ]);
        }


        $data = $this->model->create($dataForm);

        foreach ($dataForm['teamsSeason'] as $resposta) {

            $cobRes = new SeasonTeam();
            $cobRes->team_id = $resposta['team_id'];
            $cobRes->season_id = $data->id;

            $dataT = Team::where('id', '=', $cobRes->team_id)->first();

            if ($dataT) {

                array_push($array, $cobRes);
            }
        }

        foreach ($array as $st) {

            $st->save();
        }

        return response()->json([
            'type' => 'success',
            'message' => 'Temporada cadastrado com sucesso',
            'data' => $data,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mysqlRegister = Season::find($id);

        if (!$mysqlRegister) {
            return response()->json(['error' => 'Temporada não encontrada!'], 200);
        }

        $mysqlRegisterSeasson = SeasonTeam::where('season_id', '=', $id)->get();

        $mysqlRegister['teamsSeason'] = $mysqlRegisterSeasson;

        //updated, return success response
        return response()->json([
            'success' => true,
            'message' => 'Operação realizada com sucesso',
            'data' => $mysqlRegister
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $mysqlRegister = Season::find($id);

        $dataForm = $request->all();

        if (!$mysqlRegister) {
            return response()->json(['error' => 'Temporada não encontrada!'], 200);
        }

        $validator = Validator::make($dataForm, [
            's_name' => 'required|string'
        ]);


        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is valid, update
        $update = $mysqlRegister->update([
            's_name' => $request->s_name,
            's_descr' => $request->s_descr,
            's_rounds' => $request->s_rounds,
            'published' => $request->published,
            's_win_point' => $request->s_win_point,
            's_lost_point' => $request->s_lost_point,
            's_enbl_extra' => $request->s_enbl_extra,
            's_extra_win' => $request->s_extra_win,
            's_extra_lost' => $request->s_extra_lost,
            's_draw_point' => $request->s_draw_point,
            's_groups' => $request->s_groups,
            's_win_away' => $request->s_win_away,
            's_draw_away' => $request->s_draw_away,
            's_lost_away' => $request->s_lost_away,
            's_segunda_fase_grupo' => $request->s_segunda_fase_grupo,
            's_segunda_fase_total_classificados' => $request->s_segunda_fase_total_classificados,
            's_segunda_fase_data' => $request->s_segunda_fase_data
        ]);

        if ($request->has('teamsSeason')) {

            $array = array();

            $res = SeasonTeam::where('season_id', '=', $id)->delete();

            foreach ($dataForm['teamsSeason'] as $resposta) {

                $cobRes = new SeasonTeam();
                $cobRes->team_id = $resposta['team_id'];
                $cobRes->season_id = $id;

                $dataT = Team::where('id', '=', $cobRes->team_id)->first();

                if ($dataT) {

                    array_push($array, $cobRes);
                }
            }

            foreach ($array as $st) {
                $st->save();
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Atualização da temporada realizada com sucesso',
            'data' => $mysqlRegister
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $mysqlRegister = Season::find($id);

        if (!$mysqlRegister) {
            return response()->json(['error' => 'Valor não encontrado!'], 200);
        }

        $mysqlRegister->delete();

        return response()->json([
            'success' => true,
            'message' => 'Temporada excluida com sucesso'
        ], Response::HTTP_OK);
    }
}
