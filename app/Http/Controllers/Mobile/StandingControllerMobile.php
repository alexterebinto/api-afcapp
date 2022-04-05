<?php

namespace App\Http\Controllers\Mobile;

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

class StandingControllerMobile extends Controller
{


    public function show($id)
    {
        // $seasson = Season::find($seasonId);

        //selecionar maximo seasson id do torneio
        $seasson = Season::where('t_id', '=', $id)->orderBy('id', 'DESC')->first();


        if (!$seasson) {
            return response()->json(['error' => 'Temporada não encontrada!'], 200);
        }

        $dataRetorno['standing'] = StandingController::getStanding($seasson->id);

        //updated, return success response
        return response()->json([
            'success' => true,
            'message' => 'Dashboard realizado com sucesso',
            'data' => $dataRetorno
        ], Response::HTTP_OK);
    }
}
