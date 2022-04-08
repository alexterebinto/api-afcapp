<?php

namespace App\Http\Controllers\Api;

use App\Models\Team;
use App\Models\Group;
use App\Models\Matchs;
use App\Models\Season;
use App\Models\Matchday;
use App\Models\GroupTeam;
use App\Models\SeasonTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Api\StandingController;

class DashboardController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $atletas = DB::table('nx510_bl_players')->count();
        $users = DB::table('users')->count();
        $teams = DB::table('nx510_bl_teams')->count();
        $season = DB::table('nx510_bl_seasons')->count();


        $data['atletas'] = $atletas;
        $data['usuarios'] = $users;
        $data['campeonatos'] = $season;
        $data['times'] = $teams;

        //updated, return success response
        return response()->json([
            'success' => true,
            'message' => 'Dashboard realizado com sucesso',
            'data' => $data
        ], Response::HTTP_OK);
    }

    public function show($seasonId)
    {
        $seasson = Season::find($seasonId);


        if (!$seasson) {
            return response()->json(['error' => 'Temporada não encontrada!'], 200);
        }

        $dataRetorno['standing'] = StandingController::getStanding($seasonId);

        //updated, return success response
        return response()->json([
            'success' => true,
            'message' => 'Dashboard realizado com sucesso',
            'data' => $dataRetorno
        ], Response::HTTP_OK);
    }
}
