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
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;



class SeasonControllerMobile extends Controller
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
    public function show($id)
    {
        //selecionar maximo seasson id do torneio
        $mysqlRegister = Season::where('t_id', '=', $id)->orderBy('id', 'DESC')->first();

        if (!$mysqlRegister) {
            return response()->json(['error' => 'Temporada não encontrada!'], 200);
        }

        $teams = DB::table('nx510_bl_teams')
            ->join('nx510_bl_season_teams', 'nx510_bl_teams.id', '=', 'nx510_bl_season_teams.team_id')
            ->where('nx510_bl_season_teams.season_id', '=', $id)
            ->orderByRaw('nx510_bl_teams.t_name ASC')
            ->get();

        foreach ($teams  as $t) {

            $t->id = $t->team_id;
        }



        $mysqlRegister['teamsSeason'] = $teams;




        //updated, return success response
        return response()->json([
            'success' => true,
            'message' => 'Operação realizada com sucesso',
            'data' => $mysqlRegister
        ], Response::HTTP_OK);
    }
}
