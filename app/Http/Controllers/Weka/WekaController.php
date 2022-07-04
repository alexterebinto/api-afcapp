<?php

namespace App\Http\Controllers\Weka;


use App\Models\Matchs;
use App\Models\Player;
use App\Models\Positions;
use App\Models\MatchEvent;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\HttpFoundation\Response;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use File;

class WekaController extends Controller
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
    public function weka1()
    {

        $id = 39;

        $teams = DB::table('nx510_bl_teams')
            ->join('nx510_bl_season_teams', 'nx510_bl_teams.id', '=', 'nx510_bl_season_teams.team_id')
            ->where('nx510_bl_season_teams.season_id', '=', $id)
            ->orderByRaw('nx510_bl_teams.t_name ASC')
            ->get();


        $destinationPath = public_path() . "/weka/";


        $data = '%% Monthly totals of international airline passengers (in thousands) for ';

        $data = $data . "\r" . '%% 1949-1960.';
        $data = $data . "\r";
        $data = $data . "\r" . '@relation airline_passengers';
        $data = $data . "\r" . '@attribute passenger_numbers numeric';
        $data = $data . "\r" . "@attribute Date date 'yyyy-MM-dd'";
        $data = $data . "\r" . '@data';
        $data = $data . "\r";
        $data = $data . "\r" . '112,1949-01-01';
        $data = $data . "\r" . '118,1949-02-01';
        $data = $data . "\r" . '132,1949-03-01';


        $file = time() . rand() . '_file.arff';
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        File::put($destinationPath . $file, $data);
        return response()->download($destinationPath . $file);
    }
}
