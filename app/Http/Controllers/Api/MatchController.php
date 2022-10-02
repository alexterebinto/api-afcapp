<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Matchs;
use App\Models\Team;
use App\Models\Matchday;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class MatchController extends Controller
{


    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $model;

    protected $user;

    public function __construct(Matchs $modelConstructor, Request $request)
    {
        $this->model = $modelConstructor;
        $this->request = $request;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->model->paginate();

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
            'matchs' => 'required|array|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'type' => 'fail',
                'data' => $validator->errors(),
            ]);
        }


        foreach ($dataForm['matchs'] as $resposta) {

            $cobRes = new Matchs();
            $cobRes->team1_id = $resposta['team1_id'];
            $cobRes->team2_id = $resposta['team2_id'];
            $cobRes->m_id = $resposta['m_id'];
            $cobRes->m_date = $resposta['m_date'];
            $cobRes->m_time = $resposta['m_time'];

            $cobRes->m_location = $resposta['m_location'] ?? "A definir";


            // $cobRes->m_location = $resposta['m_location'];


            $dataT = Team::where('id', '=', $cobRes->team1_id)->first();

            if (!$dataT) {

                return response()->json([
                    'type' => 'error',
                    'message' => 'Equipe invalida',
                    'data' => $cobRes,
                ], 409);
            }

            $dataT2 = Team::where('id', '=', $cobRes->team2_id)->first();

            if (!$dataT2) {

                return response()->json([
                    'type' => 'error',
                    'message' => 'Equipe invalida',
                    'data' => $cobRes,
                ], 409);
            }

            $cobRes->match_descr =  $dataT->t_name . " X " .  $dataT2->t_name;

            $dataS = Matchday::where('id', '=', $resposta['m_id'])->first();

            if (!$dataS) {

                return response()->json([
                    'type' => 'error',
                    'message' => 'Rodada invalida',
                    'data' => $cobRes,
                ], 409);
            }

            array_push($array, $cobRes);
        }

        foreach ($array as $st) {

            $st->save();
        }


        return response()->json([
            'type' => 'success',
            'message' => 'Rodadas cadastradas com sucesso',
            'data' => $array,
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
        $mysqlRegister = Matchs::with('events')->find($id);

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


    public function update(Request $request, $id)
    {
        $mysqlRegister = Matchs::find($id);

        if (!$mysqlRegister) {
            return response()->json(['error' => 'Partida não encontrada!'], 200);
        }

        //Request is valid, update
        $update = $mysqlRegister->update([
            'score1' => $request->score1,
            'score2' => $request->score2,
            'published' => $request->published,
            'is_extra' => $request->is_extra,
            'm_played' => $request->m_played,
            'm_date' => $request->m_date,
            'm_time' => $request->m_time,
            'm_location' => $request->m_location
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Atualização da partida realizada com sucesso',
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

        $mysqlRegister = Matchs::find($id);

        if (!$mysqlRegister) {
            return response()->json(['error' => 'Valor não encontrado!'], 200);
        }

        $mysqlRegister->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jogo excluido com sucesso'
        ], Response::HTTP_OK);
    }
}
