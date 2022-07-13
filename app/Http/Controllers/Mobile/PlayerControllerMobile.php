<?php

namespace App\Http\Controllers\Mobile;


use App\Models\Matchs;
use App\Models\Player;
use App\Models\Positions;
use App\Models\MatchEvent;
use App\Models\SeasonTeam;

use Illuminate\Http\Request;
use App\Models\HistoricoAtleta;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\HttpFoundation\Response;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PlayerControllerMobile extends Controller
{


    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $model;

    protected $user;

    public function __construct(Player $modelConstructor, Request $request)
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
    public function atletaSumula($id, $idAtleta)
    {


        $mysqlRegister = Player::with('team')->find($idAtleta);

        if (!$mysqlRegister) {
            return response()->json(['error' => 'Jogador não encontrado!'], 200);
        }

        $events = MatchEvent::with('match')->with('event')->where('player_id', '=', $mysqlRegister->id)
            ->get();


        $position = Positions::find($mysqlRegister->position_id);

        $dataRetorno['id'] =  $mysqlRegister->id;
        $dataRetorno['first_name'] =  $mysqlRegister->first_name;
        $dataRetorno['last_name'] =  $mysqlRegister->last_name;
        $dataRetorno['nick'] =  $mysqlRegister->nick;
        $dataRetorno['position_name'] =  $position->name;
        $dataRetorno['def_img'] =  $mysqlRegister->def_img;
        $dataRetorno['team_id'] =  $mysqlRegister->team->id;
        $dataRetorno['team'] =  $mysqlRegister->team->t_name;
        $dataRetorno['team_logo'] =  $mysqlRegister->team->t_emblem;

        $rg = str_replace(".", "", $mysqlRegister->rg);


        $dataRetorno['rg'] =  $rg[0] . "." . $rg[1] . $rg[2] . "*****";
        $dataRetorno['dataNascimento'] =  substr($mysqlRegister->dataNascimento, 0, 10);

        $arrayEventos = array();

        foreach ($events as $evento) {

            $matchday = Matchs::with('matchday')->find($evento->match_id);

            if ($matchday->matchday->s_id == $id) {

                $dataEvento['id'] = $evento->id;
                $dataEvento['data'] = $evento->match->m_date;
                $dataEvento['ecount'] = $evento->ecount;
                $dataEvento['minutes'] = $evento->minutes;
                $dataEvento['match_descr'] = $evento->match->match_descr;
                $dataEvento['e_name'] = $evento->event->e_name;
                $dataEvento['e_img'] = $evento->event->e_img;
                array_push($arrayEventos, $dataEvento);
            }
        }

        $dataRetorno['events'] =  $arrayEventos;
        $dataRetorno['qrcode'] =  base64_encode(QrCode::format('png')->size(100)->generate($mysqlRegister->first_name . $mysqlRegister->last_nam));


        //updated, return success response
        return response()->json([
            'success' => true,
            'type' => 'success',
            'message' => 'Operação realizada com sucesso',
            'data' =>   $dataRetorno
        ], Response::HTTP_OK);
    }
}
