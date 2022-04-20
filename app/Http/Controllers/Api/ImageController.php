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

class ImageController extends Controller
{


    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $model;

    protected $user;





    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function imagetest(Request $request)
    {



        $dataForm = $request->all();

        // validate incoming request

        $validator = Validator::make($request->all(), [
            'filename' => 'required',
        ]);


        // O arquivo. Dependendo da configuração do PHP pode ser uma URL.
        $filename = $dataForm['filename'];

        $filename = 'https://images.sportmanager.com.br/curitibano/players/sem-foto.jpg';

        // Largura e altura máximos (máximo, pois como é proporcional, o resultado varia)
        // No caso da pergunta, basta usar $_GET['width'] e $_GET['height'], ou só
        // $_GET['width'] e adaptar a fórmula de proporção abaixo.
        $width = 400;
        $height = 150;

        // Obtendo o tamanho original
        list($width_orig, $height_orig) = getimagesize($filename);

        // Calculando a proporção
        $ratio_orig = $width_orig / $height_orig;

        if ($width / $height > $ratio_orig) {
            $width = $height * $ratio_orig;
        } else {
            $height = $width / $ratio_orig;
        }

        // O resize propriamente dito. Na verdade, estamos gerando uma nova imagem.
        $image_p = imagecreatetruecolor($width, $height);
        $image = imagecreatefromjpeg($filename);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

        $file = basename($filename);
        $file_extension = strtolower(substr(strrchr($file, "."), 1));

        switch ($file_extension) {
            case "gif":
                $ctype = "image/gif";
                break;
            case "png":
                $ctype = "image/png";
                break;
            case "jpeg":
            case "jpg":
                $ctype = "image/jpeg";
                break;
            default:
        }



        // Gerando a imagem de saída para ver no browser, qualidade 75%:

        header('Content-type: ' . $ctype);
        $test =  imagejpeg($image_p, null, 100);

        return  $test;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function image(Request $request)
    {

        $dataForm = $request->all();

        // validate incoming request

        $validator = Validator::make($request->all(), [
            'filename' => 'required',
        ]);


        // O arquivo. Dependendo da configuração do PHP pode ser uma URL.
        $filename = $dataForm['filename'];

        //$filename = 'http://exemplo.com/original.jpg';

        // Largura e altura máximos (máximo, pois como é proporcional, o resultado varia)
        // No caso da pergunta, basta usar $_GET['width'] e $_GET['height'], ou só
        // $_GET['width'] e adaptar a fórmula de proporção abaixo.
        $width = 400;
        $height = 150;

        // Obtendo o tamanho original
        list($width_orig, $height_orig) = getimagesize($filename);

        // Calculando a proporção
        $ratio_orig = $width_orig / $height_orig;

        if ($width / $height > $ratio_orig) {
            $width = $height * $ratio_orig;
        } else {
            $height = $width / $ratio_orig;
        }

        // O resize propriamente dito. Na verdade, estamos gerando uma nova imagem.
        $image_p = imagecreatetruecolor($width, $height);
        $image = imagecreatefromjpeg($filename);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

        $file = basename($filename);
        $file_extension = strtolower(substr(strrchr($file, "."), 1));

        switch ($file_extension) {
            case "gif":
                $ctype = "image/gif";
                break;
            case "png":
                $ctype = "image/png";
                break;
            case "jpeg":
            case "jpg":
                $ctype = "image/jpeg";
                break;
            default:
        }

        // Gerando a imagem de saída para ver no browser, qualidade 75%:
        $test =  imagejpeg($image_p, null, 100);
        //updated, return success response
        return response()($test, Response::HTTP_OK)->header('Content-type: ' . $ctype)->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')->header('Access-Control-Allow-Headers');
    }
}
