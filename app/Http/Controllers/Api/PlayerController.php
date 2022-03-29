<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Player;
use App\Models\MatchEvent;
use App\Models\Positions;
use App\Models\SeasonTeam;
use App\Models\Matchs;
use App\Models\HistoricoAtleta;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PlayerController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $dataForm = $request->all();

        // validate incoming request

        if ($request->search && $request->team_id){

            $players = Player::with('team')
            ->where('team_id', '=', $request->team_id)
            ->where('first_name', 'like', '%' . $request->search . '%')
            ->orWhere('last_name', 'like', '%' . $request->search . '%')
            ->get();
        }else if ($request->search){
            $players = Player::with('team')
            ->where('first_name', 'like', '%' . $request->search . '%')
            ->orWhere('last_name', 'like', '%' . $request->search . '%')
            ->get();
        }else{
            $players = Player::with('team')
            ->where('team_id', '=', $request->team_id)
            ->get();
        }

        if (!$players) {
            return response()->json(['error' => 'Jogador não encontrado!'], 200);
        }

        return response()->json([
            'type' => 'success',
            'message' => 'Atletas recuperados com sucesso',
            'data' => $players,
        ], 200);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Player::with('team')->paginate();
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

        // validate incoming request

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'dataNascimento' => 'required',
            'matricula' => 'required',
            'team_id' => 'exists:App\Models\Team,id',
            'position_id' =>  'exists:App\Models\Positions,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'type' => 'fail',
                'data' => $validator->errors(),
            ]);
        }

        $dataForm['def_img'] = "sem-foto.jpg";

        if (strpos($request->def_img, ';base64')) {

            try {
                $image_64 = $request->def_img; //your base64 encoded data

                $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf

                $replace = substr($image_64, 0, strpos($image_64, ',') + 1);

                // find substring fro replace here eg: data:image/png;base64,

                $image = str_replace($replace, '', $image_64);

                $image = str_replace(' ', '+', $image);

                $name = uniqid(date('His'));

                $imageName = $name . "." . $extension;

                $upload =  Storage::disk('public')->put('/players/' . $imageName, base64_decode($image));
            } catch (\Exception $e) {
                return response()->json(['error' => 'Falha ao fazer upload drive'], 500);
            }

            if (!$upload) {
                return response()->json(['error' => 'Falha ao fazer upload drive 2'], 500);
            } else {
                $dataForm['def_img'] = $imageName;
            }
        }

        $data = $this->model->create($dataForm);
        $dataHistorico = new HistoricoAtleta();
        $dataHistorico->team_id=$data->team_id;
        $dataHistorico->player_id=$data->id;

        $seassonTeam = SeasonTeam::where('team_id', '=', $data->team_id)->first();

        if ($seassonTeam) {
            $dataHistorico->session_id=$seassonTeam->season_id;
            $dataHistorico->save();
        }

        return response()->json([
            'type' => 'success',
            'success' => true,
            'message' => 'Atleta cadastrado com sucesso',
            'data' => $data,
        ], 200);
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

        //updated, return success response
        return response()->json([
            'success' => true,
            'type' => 'success',
            'message' => 'Operação realizada com sucesso',
            'data' =>   $dataRetorno
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
        $mysqlRegister = Player::find($id);

        if (!$mysqlRegister) {
            return response()->json(['error' => 'Valor não encontrado!'], 200);
        }

        // validate incoming request

        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'team_id' => 'exists:App\Models\Team,id',
            'position_id' =>  'exists:App\Models\Positions,id',
        ]);


        //Validate data
        $data = $request->only(
            'first_name',
            'last_name',
            'nick',
            'about',
            'position_id',
            'def_img',
            'team_id',
            'rg',
            'cpf',
            'matricula',
            'email',
            'altura',
            'federado',
            'suspensoRodadas',
            'dataNascimento'
        );


        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        $imageName = $mysqlRegister->def_img;

        if (strpos($request->def_img, ';base64')) {

            if ($mysqlRegister->def_img) {

                if ($imageName != "sem-foto.jpg") {

                    try {
                        $delete =  Storage::disk('public')->delete('/players/' . $mysqlRegister->def_img);
                    } catch (\Exception $e) {
                        return response()->json(['error' => 'Falha ao fazer delete drive'], 500);
                    }
                }
            }


            try {
                $image_64 = $request->def_img; //your base64 encoded data

                $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf

                $replace = substr($image_64, 0, strpos($image_64, ',') + 1);

                // find substring fro replace here eg: data:image/png;base64,

                $image = str_replace($replace, '', $image_64);

                $image = str_replace(' ', '+', $image);

                $name = uniqid(date('His'));

                $imageName = $name . "." . $extension;

                $upload =  Storage::disk('public')->put('/players/' . $imageName, base64_decode($image));
            } catch (\Exception $e) {
                return response()->json(['error' => 'Falha ao fazer upload drive'], 500);
            }

            if (!$upload) {
                return response()->json(['error' => 'Falha ao fazer upload drive 2'], 500);
            }
        }

        //Request is valid, update
        $update = $mysqlRegister->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'nick' => $request->nick,
            'about' => $request->about,
            'position_id' => $request->position_id,
            'def_img' => $imageName,
            'team_id' => $request->team_id,
            'rg' => $request->rg,
            'cpf' => $request->cpf,
            'matricula' => $request->matricula,
            'email' => $request->email,
            'altura' => $request->altura,
            'federado' => $request->federado,
            'suspensoRodadas' => $request->suspensoRodadas,
            'dataNascimento' => $request->dataNascimento
        ]);

        return response()->json([
            'success' => true,
            'type' => 'success',
            'message' => 'Atualização realizada com sucesso',
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

        $mysqlRegister = Player::find($id);

        if (!$mysqlRegister) {
            return response()->json(['error' => 'Valor não encontrado!'], 200);
        }


        if ($mysqlRegister->def_img) {

            try {

                $delete =  Storage::disk('public')->delete('/player/' . $mysqlRegister->def_img);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Falha ao fazer delete drive'], 500);
            }
        }

        $mysqlRegister->delete();

        return response()->json([
            'success' => true,
            'type' => 'success',
            'message' => 'Equipe excluida com sucesso'
        ], Response::HTTP_OK);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mysqlRegister = Player::with('team')->find($id);

        if (!$mysqlRegister) {
            return response()->json(['error' => 'Jogador não encontrado!'], 200);
        }

        //updated, return success response
        return response()->json([
            'success' => true,
            'message' => 'Operação realizada com sucesso',
            'data' => $mysqlRegister
        ], Response::HTTP_OK);
    }
}
