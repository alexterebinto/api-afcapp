<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use App\Models\Content;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;

class ContentControllerMobile extends Controller
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $model;

    protected $user;

    public function __construct(Content $modelConstructor, Request $request)
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

        $url = $_ENV['SFTP_PATH_NOTICIAS'];

        $json = json_decode(file_get_contents($url), true);

        $arrayContent = array();

        foreach ($json as $noticia) {


            if (isset($noticia['acf'])) {

                if ($noticia['acf']) {

                    if ($noticia['acf']['segmento_esportivo'] != false) {

                        if ($noticia['acf']['segmento_esportivo']) {

                            $segmento = $noticia['acf']['segmento_esportivo'];

                            foreach ($segmento as $rr) {

                                if ($rr['post_name'] == 'futebol-society') {
                                    $content = new Content();
                                    $content->id = $noticia['id'];
                                    $content->date = $noticia['date'];
                                    $content->slug = $noticia['slug'];
                                    $content->link = $noticia['link'];
                                    $content->title = $noticia['title'];
                                    $content->content = $noticia['content'];
                                    $content->media = $noticia['_embedded']['wp:featuredmedia'];

                                    array_push($arrayContent, $content);
                                }
                            }
                        }
                    }
                }
            } else {

                foreach ($json as $noticia) {

                    $content = new Content();
                    $content->id = $noticia['id'];
                    $content->date = $noticia['date'];
                    $content->slug = $noticia['slug'];
                    $content->link = $noticia['link'];
                    $content->title = $noticia['title'];
                    $content->content = $noticia['content'];
                    $content->media = $noticia['featured_media_src_url'];

                    array_push($arrayContent, $content);
                }

                //updated, return success response
                return response()->json([
                    'success' => true,
                    'message' => 'Operação realizada com sucesso',
                    'data' => $arrayContent
                ], Response::HTTP_OK);
            }
        }

        //updated, return success response
        return response()->json([
            'success' => true,
            'message' => 'Operação realizada com sucesso',
            'data' => $arrayContent
        ], Response::HTTP_OK);
    }
}
