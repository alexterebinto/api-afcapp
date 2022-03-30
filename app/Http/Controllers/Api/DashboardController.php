<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\StandingController;
use App\Models\Matchs;
use App\Models\Team;
use App\Models\Matchday;
use App\Models\Group;
use App\Models\GroupTeam;
use App\Models\Season;
use App\Models\SeasonTeam;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data['atletas'] = 841;
        $data['usuarios'] = 9;
        $data['campeonatos'] = 13;
        $data['times'] = 37;

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
