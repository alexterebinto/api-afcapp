<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Team;
use App\Models\Matchs;
use App\Models\Player;
use App\Models\Season;
use App\Models\Matchday;
use App\Models\Suspensao;
use App\Models\Tournament;
use Illuminate\Http\Request;
use App\Models\PdfSumulaCampo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PdfSumulaSuicoController extends Controller
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
    public function sumulaFutebolSuico($id)
    {
        $match = Matchs::where('id', '=', $id)->first();

        $matchday = Matchday::where('id', '=', $match->m_id)->first();

        $season = Season::where('id', '=', $matchday->s_id)->first();
        $tournament = Tournament::find($season->t_id);

        $createdAt = Carbon::parse($match->m_date);
        $match->m_date = $createdAt->format('d/m/Y');



        $sumula['match'] = $match;
        $sumula['matchday'] = $matchday;
        $sumula['season'] = $season;
        $sumula['tournament'] = $tournament;

        //icones
        $sumula['amarelo'] = PdfSumulaCampoController::getiIconeSuspensao($_ENV['SFTP_PATH_ICONES_AMARELO']);
        $sumula['vermelho'] = PdfSumulaCampoController::getiIconeSuspensao($_ENV['SFTP_PATH_ICONES_VERMELHO']);
        $sumula['suspensao'] = PdfSumulaCampoController::getiIconeSuspensao($_ENV['SFTP_PATH_ICONES_SUSPENSAO']);

        $team_1 = Team::find($match->team1_id);
        $team_1->t_initials = substr($team_1->t_name, 0, 3);

        $players1 = Player::where('team_id', '=', $match->team1_id)->where('position_id', '<', 12)->orderBy('first_name', 'ASC')->get();
        $treinador1 = Player::where('team_id', '=', $match->team1_id)->whereIn('position_id', [12, 16])->orderBy('first_name', 'ASC')->first();
        $auxiliar11 = Player::where('team_id', '=', $match->team1_id)->whereIn('position_id', [13])->orderBy('first_name', 'ASC')->first();
        $auxiliar12 = Player::where('team_id', '=', $match->team1_id)->whereIn('position_id', [14])->orderBy('first_name', 'ASC')->first();

        $team_2 = Team::find($match->team2_id);
        $team_2->t_initials = substr($team_2->t_name, 0, 3);
        $players2 = Player::where('team_id', '=', $match->team2_id)->where('position_id', '<', 12)->orderBy('first_name', 'ASC')->get();
        $treinador2 = Player::where('team_id', '=', $match->team2_id)->whereIn('position_id', [12, 16])->orderBy('first_name', 'ASC')->first();
        $auxiliar21 = Player::where('team_id', '=', $match->team2_id)->whereIn('position_id', [13])->orderBy('first_name', 'ASC')->first();
        $auxiliar22 = Player::where('team_id', '=', $match->team2_id)->whereIn('position_id', [14])->orderBy('first_name', 'ASC')->first();

        if ($treinador1) {
            $team_1['treinador'] = $treinador1;
        }

        if ($auxiliar11) {
            $team_1['$auxiliar11'] = $auxiliar11;
        }

        if ($auxiliar12) {
            $team_1['$auxiliar12'] = $auxiliar12;
        }


        if ($treinador2) {
            $team_2['treinador'] = $treinador2;
        }

        if ($auxiliar21) {
            $team_2['auxiliar21'] = $auxiliar21;
        }

        if ($auxiliar22) {
            $team_2['auxiliar22'] = $auxiliar22;
        }

        // return response()->json($team_1, 500);

        $team_1['logo'] = PdfSumulaCampoController::getLogoClube($team_1);
        $team_2['logo'] = PdfSumulaCampoController::getLogoClube($team_2);


        foreach ($players1  as $p) {

            $suspensao = Suspensao::where('player_id', '=', $p->id)->first();


            if (isset($suspensao)) {
                $p['suspensoPunicao'] = 1;
                $p['isSuspenso'] = 1;
            } else {
                $p['isSuspenso'] = 0;
                $p['suspensoAmarelo'] = 0;
                $p['suspensoVermelho'] = 0;
                $p['suspensoPunicao'] = 0;
            }
        }



        foreach ($players2  as $p) {

            $suspensao = Suspensao::where('player_id', '=', $p->id)->where('season_id', '=', $season->id)->where('m_id', '=', $matchday->m_name)->first();


            if (isset($suspensao)) {
                $p['suspensoPunicao'] = 1;
                $p['isSuspenso'] = 1;
            } else {

                $p['isSuspenso'] = 0;
                $p['suspensoAmarelo'] = 0;
                $p['suspensoVermelho'] = 0;
                $p['suspensoPunicao'] = 0;
            }
        }


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

        $matchs = DB::table('nx510_bl_matchday')
            ->join('nx510_bl_match', 'nx510_bl_matchday.id', '=', 'nx510_bl_match.m_id')
            ->where('nx510_bl_matchday.s_id', '=', $matchday->s_id)
            ->where('nx510_bl_match.m_played', '=', '1')
            ->orderByRaw('nx510_bl_matchday.id ASC')->get();

        $totalJogos1 = 0;
        $totalJogos2 = 0;
        $sumula['totalPartidasTime1'] = 0;
        $sumula['totalPartidasTime2'] = 0;

        foreach ($matchs  as $m) {

            if ($m->team1_id == $match->team1_id) {
                $totalJogos1++;
            } else if ($m->team2_id == $match->team1_id) {
                $totalJogos1++;
            }

            if ($m->team1_id == $match->team2_id) {
                $totalJogos2++;
            } else if ($m->team2_id == $match->team2_id) {
                $totalJogos2++;
            }
        }

        $sumula['totalPartidasTime1'] = $totalJogos1;
        $sumula['totalPartidasTime2'] = $totalJogos2;

        // return response()->json($players2, 500);

        $data = date("FjYg:ia");
        $sumula['logo'] = PdfSumulaSuicoController::getLogo($tournament);
        $pdf = PDF::loadView('sumula-futebol-suico-pdf', compact('sumula'));
        $pdf->setOptions(['dpi' => 100, 'defaultFont' => 'sans-serif']);
        return $pdf->setPaper('a4', 'landscape')->stream(
            'sumula-' . $data,
            array("Attachment" => false)
        );
    }

    public static function getiIconeSuspensao($icone)
    {
        $opciones_ssl = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );

        $img_path = $icone;
        $extencion = pathinfo($img_path, PATHINFO_EXTENSION);
        $data = file_get_contents($img_path, false, stream_context_create($opciones_ssl));
        $img_base_64 = base64_encode($data);
        $path_img = 'data:image/' . $extencion . ';base64,' . $img_base_64;

        return $path_img;
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
