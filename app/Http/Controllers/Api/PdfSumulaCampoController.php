<?php

namespace App\Http\Controllers\Api;

use App\Models\Team;
use App\Models\Matchs;
use App\Models\Player;
use App\Models\Season;
use App\Models\Matchday;
use App\Models\Tournament;
use Illuminate\Http\Request;
use App\Models\PdfSumulaCampo;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PdfSumulaCampoController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $model;

    protected $user;

    public function __construct(PdfSumulaCampo $modelConstructor, Request $request)
    {
        $this->model = $modelConstructor;
        $this->request = $request;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function sumulaFutebolCampo($id)
    {
        $match = Matchs::where('m_id', '=', $id)->first();
        $matchday = Matchday::where('id', '=', $match->m_id)->first();

        $season = Season::where('id', '=', $matchday->s_id)->first();
        $tournament = Tournament::find($season->t_id);


        $sumula['match'] = $match;
        $sumula['matchday'] = $matchday;
        $sumula['season'] = $season;
        $sumula['tournament'] = $tournament;

        $team_1 = Team::find($match->team1_id);
        $team_1->t_initials = substr($team_1->t_name, 0, 3);


        $players1 = Player::where('team_id', '=', $match->team1_id)->where('position_id', '<', 13)->orderBy('first_name', 'ASC')->get();

        $team_2 = Team::find($match->team2_id);
        $team_2->t_initials = substr($team_2->t_name, 0, 3);
        $players2 = Player::where('team_id', '=', $match->team2_id)->orderBy('first_name', 'ASC')->get();

        $team_1['logo'] = PdfSumulaCampoController::getLogoClube($team_1);
        $team_2['logo'] = PdfSumulaCampoController::getLogoClube($team_2);

        $sumula['team_1'] = $team_1;
        $sumula['team_2'] = $team_2;
        $sumula['players2'] = $players2;
        $sumula['players1'] = $players1;
        $team_1['totalInscritos'] = count($sumula['players1']);
        $team_2['totalInscritos'] = count($sumula['players2']);

        $totalInscritos1 = count($sumula['players1']);
        $totalInscritos2 = count($sumula['players2']);

        $sumula['totalInscritos1'] = count($sumula['players1']);
        $sumula['totalInscritos2'] = count($sumula['players2']);
        $arrayVagasInscricoes1 = array();
        $arrayVagasInscricoes2 = array();

        for ($i = $team_1['totalInscritos']; $i < 30; $i++) {
            array_push($arrayVagasInscricoes1, "");
            $totalInscritos1++;
        }

        for ($i = $team_2['totalInscritos']; $i < 30; $i++) {
            array_push($arrayVagasInscricoes2, "");
            $totalInscritos2++;
        }

        $sumula['vagasInscricoes'] = $arrayVagasInscricoes1;
        $sumula['vagasInscricoes2'] = $arrayVagasInscricoes2;

        $sumula['logo'] = PdfSumulaCampoController::getLogo($tournament);
        $pdf = PDF::loadView('sumula-futebol-campo-pdf', compact('sumula'));
        $pdf->setOptions(['dpi' => 100, 'defaultFont' => 'sans-serif']);
        return $pdf->setPaper('a4')->stream(
            'invoice.pdf',
            array("Attachment" => false)
        );
    }

    public static function getLogoClube($team)
    {

        $opciones_ssl = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );

        $img_path = $_ENV['SFTP_PATH_LOGO_TEAM'] . $team->t_emblem;
        $extencion = pathinfo($img_path, PATHINFO_EXTENSION);
        $data = file_get_contents($img_path, false, stream_context_create($opciones_ssl));
        $img_base_64 = base64_encode($data);
        $path_img = 'data:image/' . $extencion . ';base64,' . $img_base_64;

        return $path_img;
    }


    public static function getLogo($tournament)
    {

        $opciones_ssl = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );

        $img_path = $_ENV['SFTP_PATH_LOGO_SUMULA'] . $tournament->logo;
        $extencion = pathinfo($img_path, PATHINFO_EXTENSION);
        $data = file_get_contents($img_path, false, stream_context_create($opciones_ssl));
        $img_base_64 = base64_encode($data);
        $path_img = 'data:image/' . $extencion . ';base64,' . $img_base_64;

        return $path_img;
    }
}
