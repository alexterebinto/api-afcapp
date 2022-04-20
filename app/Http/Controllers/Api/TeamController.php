<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Team;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $model;

    protected $user;

    public function __construct(Team $modelConstructor, Request $request)
    {
        $this->model = $modelConstructor;
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function players($id)
    {
        $data = Team::with('players')->where('id', '=', $id)->paginate();
        return response()->json($data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->model->orderBy('t_name')->paginate(50);

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
            't_name' => 'required|unique:nx510_bl_teams'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'type' => 'fail',
                'data' => $validator->errors(),
            ]);
        }

        if (strpos($request->t_emblem, ';base64')) {
            try {
                $image_64 = $request->t_emblem; //your base64 encoded data

                $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf

                $replace = substr($image_64, 0, strpos($image_64, ',') + 1);

                // find substring fro replace here eg: data:image/png;base64,

                $image = str_replace($replace, '', $image_64);

                $image = str_replace(' ', '+', $image);

                $name = uniqid(date('His'));

                $imageName = $name . "." . $extension;

                $upload =  Storage::disk('ftp')->put($_ENV['SFTP_DIRETORIO_TEAMS'] . $imageName, base64_decode($image));
            } catch (\Exception $e) {
                return response()->json(['error' => 'Falha ao fazer upload drive'], 500);
            }

            if (!$upload) {
                return response()->json(['error' => 'Falha ao fazer upload drive 2'], 500);
            } else {
                $dataForm['t_emblem'] = $imageName;
            }
        } else {
            $dataForm['t_emblem'] = 'semescudo.jpg';
        }

        $data = $this->model->create($dataForm);

        return response()->json([
            'type' => 'success',
            'message' => 'Equipe cadastrado com sucesso',
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
        $mysqlRegister = Team::find($id);

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $mysqlRegister = Team::find($id);

        if (!$mysqlRegister) {
            return response()->json(['error' => 'Valor não encontrado!'], 200);
        }

        //Validate data
        $data = $request->only(
            't_name',
            't_descr',
            't_about',
            't_yteam',
            'def_img',
            't_emblem',
            't_city',
            't_coach',
            't_secondary_color',
            't_main_color',
            't_initials',
            't_email',
            't_representative',
            't_assistant_1',
            't_assistant_2',
            't_assistant_3',
            't_director',
            't_foundation',
            't_id_cidade'
        );


        // validate incoming request

        $validator = Validator::make($request->all(), [
            't_name' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }


        $imageName =  $mysqlRegister->t_emblem;

        if (strpos($request->t_emblem, ';base64')) {

            if ($imageName != "semescudo.jpg") {
                try {
                    $delete =  Storage::disk('ftp')->delete($_ENV['SFTP_DIRETORIO_TEAMS'] . $mysqlRegister->t_emblem);
                } catch (\Exception $e) {
                    return response()->json(['error' => 'Falha ao fazer delete drive'], 500);
                }
            }

            try {
                $image_64 = $request->t_emblem; //your base64 encoded data

                $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf

                $replace = substr($image_64, 0, strpos($image_64, ',') + 1);

                // find substring fro replace here eg: data:image/png;base64,

                $image = str_replace($replace, '', $image_64);

                $image = str_replace(' ', '+', $image);

                $name = uniqid(date('His'));

                $imageName = $name . "." . $extension;

                $upload =  Storage::disk('ftp')->put($_ENV['SFTP_DIRETORIO_TEAMS']  . $imageName, base64_decode($image));
            } catch (\Exception $e) {
                return response()->json(['error' => 'Falha ao fazer upload drive'], 500);
            }

            if (!$upload) {
                return response()->json(['error' => 'Falha ao fazer upload drive 2'], 500);
            }
        } else {
            $imageName = 'semescudo.jpg';
        }


        //Request is valid, update
        $update = $mysqlRegister->update([
            't_name' => $request->t_name,
            't_descr' => $request->t_descr,
            't_about' => $request->t_about,
            't_yteam' => $request->t_yteam,
            'def_img' => $request->def_img,
            't_emblem' => $imageName,
            't_city' => $request->t_city,
            't_coach' => $request->t_coach,
            't_secondary_color' => $request->t_secondary_color,
            't_main_color' => $request->t_main_color,
            't_initials' => $request->t_initials,
            't_email' => $request->t_email,
            't_representative' => $request->t_representative,
            't_assistant_1' => $request->t_assistant_1,
            't_assistant_2' => $request->t_assistant_2,
            't_assistant_3' => $request->t_assistant_3,
            't_director' => $request->t_director,
            't_foundation' => $request->t_foundation,
            't_id_cidade' => $request->t_id_cidade
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
        $mysqlRegister = Team::find($id);

        if (!$mysqlRegister) {
            return response()->json(['error' => 'Valor não encontrado!'], 200);
        }

        try {
            $delete =  Storage::disk('ftp')->delete($_ENV['SFTP_DIRETORIO_TEAMS'] . $mysqlRegister->t_emblem);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Falha ao fazer delete drive'], 500);
        }



        $mysqlRegister->delete();

        return response()->json([
            'success' => true,
            'message' => 'Equipe excluida com sucesso'
        ], Response::HTTP_OK);
    }
}
