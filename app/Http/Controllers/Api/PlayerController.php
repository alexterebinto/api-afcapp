<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Player;
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

        $validator = Validator::make($request->all(), [
            'search' => 'required|string|min:3|max:15',            
        ]);

        if ($validator->fails()) {
            return response()->json([
                'type' => 'fail',
                'data' => $validator->errors(),
            ]);
        }

        $players = Player::with('team')
        ->where('first_name', 'like', '%'.$request->search.'%')
        ->orWhere('last_name', 'like','%'.$request->search.'%')
        ->get();

        if (!$players) {
            return response()->json(['error' => 'Jogador não encontrado!'], 200);
        }

        return response()->json([
            'type' => 'success',
            'message' => 'Atletas recuperados com sucesso',
            'data' =>$players ,
        ], 200);




    }
    


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data= Player::with('team')->paginate(  );
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
            'team_id' => 'exists:App\Models\Team,id',
            'position_id' =>  'exists:App\Models\Positions,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'type' => 'fail',
                'data' => $validator->errors(),
            ]);
        }

        $dataForm['def_img'] ="sem-foto.jpg";

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

        return response()->json([
            'type' => 'success',
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

                if ($imageName!="sem-foto.jpg"){

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
            'message' => 'Equipe excluida com sucesso'
        ], Response::HTTP_OK);
    }
}
