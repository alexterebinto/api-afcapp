<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use App\Models\Season;
use App\Models\SeasonTeam;
use App\Models\Team;
use App\Models\Matchs;
use App\Models\Matchday;
use App\Models\Tournament;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class TournamentControllerMobile extends Controller
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $model;

    protected $user;

    public function __construct(Tournament $modelConstructor, Request $request)
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
        $mysqlRegister = Tournament::where('published', '=',  'S')->orderBy('id', 'DESC')->paginate();

            //updated, return success response
            return response()->json([
                'success' => true,
                'message' => 'Opearação realizada com sucesso',
                'data' =>  $mysqlRegister
            ], Response::HTTP_OK);
    }

}
