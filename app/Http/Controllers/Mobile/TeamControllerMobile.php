<?php

namespace App\Http\Controllers\Mobile;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Team;
use App\Models\Player;
use App\Models\MatchEvent;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\StandingController;
use App\Models\Season;


class TeamControllerMobile extends Controller
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

    public function goals($idTorneio, $idTime)
    {

        //selecionar maximo seasson id do torneio
        $mysqlRegister = Season::where('t_id', '=', $idTorneio)->orderBy('id', 'DESC')->first();

        $seasonId = $mysqlRegister->id;

        $mysqlRegister = Season::find($seasonId);

        if (!$mysqlRegister) {
            return response()->json(['error' => 'Temporada não encontrada!'], 200);
        }

        $matchs = DB::table('nx510_bl_matchday')
            ->join('nx510_bl_match', 'nx510_bl_matchday.id', '=', 'nx510_bl_match.m_id')
            ->join('nx510_bl_match_events', 'nx510_bl_match.id', '=', 'nx510_bl_match_events.match_id')
            ->where('nx510_bl_matchday.s_id', '=', $seasonId)
            ->where('nx510_bl_match.m_played', '=', '1')
            ->where('nx510_bl_match_events.e_id', '=', '3')
            ->orderByRaw('nx510_bl_matchday.id ASC')
            ->select('player_id')
            ->get();

        $players = array();
        $table_view = array();

        foreach ($matchs  as $m) {
            array_push($players, $m->player_id);
        }

        $filters = array_count_values($players);

        $i = 1;
        foreach ($filters as $key  => $val) {

            $url = $_ENV['APP_URL'] . "/api/v1/image?filename=" . $_ENV['SFTP_PATH_PHOTO_ATLETA'];
            $url = $_ENV['SFTP_PATH_PHOTO_ATLETA'];


            $player = Player::with('team')->find($key);
            $table_view[$i]['id'] = $player->id;
            $table_view[$i]['first_name'] = $player->first_name;
            $table_view[$i]['last_name'] = $player->last_name;
            $table_view[$i]['def_img'] = $url . $player->def_img;
            $table_view[$i]['team_id'] = $player->team_id;
            $table_view[$i]['t_name'] = $player->team->t_name;
            $table_view[$i]['goals'] = $val;
            $i++;
        }

        $sort_arr = array();
        foreach ($table_view as $uniqid => $row) {
            foreach ($row as $key => $value) {
                $sort_arr[$key][$uniqid] = $value;
            }
        }

        if ($i > 1) {
            array_multisort($sort_arr['goals'], SORT_DESC, $table_view);
        }


        $list =   $table_view;
        $cont = 1;
        $classificacao = array();

        foreach ($list as $obj) {

            if ($idTime == $obj["team_id"]) {
                $obj["position"] = $cont;
                $cont++;
                array_push($classificacao, $obj);
            }
        }


        //updated, return success response
        return response()->json([
            $classificacao
        ], Response::HTTP_OK);
    }





    public function standing($seasonId, $id)
    {
        $seasson = Season::find($seasonId);


        if (!$seasson) {
            return response()->json(['error' => 'Temporada não encontrada!'], 200);
        }

        $dataRetorno['standing'] = StandingController::getStandingTime($seasonId, $id);

        //updated, return success response
        return response()->json([
            'success' => true,
            'message' => 'Classificação recuperado com sucesso',
            'data' => $dataRetorno
        ], Response::HTTP_OK);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function sequence($idTorneio, $id)
    {
        $team = Team::find($id);

        //selecionar maximo seasson id do torneio
        $mysqlRegister = Season::where('t_id', '=', $idTorneio)->orderBy('id', 'DESC')->first();

        $seasson = $mysqlRegister->id;

        $arraySequencia = array();

        $matchs = DB::table('nx510_bl_matchday')
            ->join('nx510_bl_match', 'nx510_bl_matchday.id', '=', 'nx510_bl_match.m_id')
            ->where('nx510_bl_matchday.s_id', '=', $seasson)
            ->where('nx510_bl_match.m_played', '=', '1')
            ->where('nx510_bl_match.team1_id', '=', $id)
            ->orWhere('nx510_bl_match.team2_id', '=', $id)
            ->orderByRaw('nx510_bl_match.m_date DESC')
            ->get();

        foreach ($matchs as $mm) {

            if ($mm->team1_id == $id) {
                if ($mm->score1 > $mm->score2) {
                    $tipoSequencia = "V";
                } else if ($mm->score1 == $mm->score2) {
                    $tipoSequencia = "E";
                } else if ($mm->score1 < $mm->score2) {
                    $tipoSequencia = "D";
                }

                array_push($arraySequencia, $tipoSequencia);
            } else if ($mm->team2_id == $id) {


                if ($mm->score1 < $mm->score2) {
                    $tipoSequencia = "V";
                } else if ($mm->score1 == $mm->score2) {
                    $tipoSequencia = "E";
                } else if ($mm->score1 > $mm->score2) {
                    $tipoSequencia = "D";
                }

                array_push($arraySequencia, $tipoSequencia);
            }
        }

        $team['sequence'] = $arraySequencia;


        //updated, return success response
        return response()->json([
            'success' => true,
            'message' => 'Sequencia carregada com sucesso',
            'data' => $team
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function lastmatchs($idTorneio, $id)
    {
        $team = Team::find($id);

        //selecionar maximo seasson id do torneio
        $mysqlRegister = Season::where('t_id', '=', $idTorneio)->orderBy('id', 'DESC')->first();

        $seasson = $mysqlRegister->id;


        $matchs = DB::table('nx510_bl_matchday')
            ->join('nx510_bl_match', 'nx510_bl_matchday.id', '=', 'nx510_bl_match.m_id')
            ->where('nx510_bl_matchday.s_id', '=', $seasson)
            ->where('nx510_bl_match.m_played', '=', '1')
            ->where('nx510_bl_match.team1_id', '=', $id)
            ->orWhere('nx510_bl_match.team2_id', '=', $id)
            ->orderByRaw('nx510_bl_match.m_date DESC')
            ->get();


        $team['matchs'] = $matchs;

        //updated, return success response
        return response()->json([
            'success' => true,
            'message' => 'Ultimos jogos carregadas com sucesso',
            'data' => $team
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function nextmatchs($idTorneio, $id)
    {

        //selecionar maximo seasson id do torneio
        $mysqlRegister = Season::where('t_id', '=', $idTorneio)->orderBy('id', 'DESC')->first();

        $seasson = $mysqlRegister->id;

        $team = Team::find($id);

        $nextMatchs = DB::table('nx510_bl_matchday')
            ->join('nx510_bl_match', 'nx510_bl_matchday.id', '=', 'nx510_bl_match.m_id')
            ->where('nx510_bl_matchday.s_id', '=', $seasson)
            ->where('nx510_bl_match.m_played', '=', '0')
            ->where('nx510_bl_match.team1_id', '=', $id)
            ->orWhere('nx510_bl_match.team2_id', '=', $id)
            ->orderByRaw('nx510_bl_match.m_date DESC')
            ->get();

        $team['nextMatchs'] = $nextMatchs;

        //updated, return success response
        return response()->json([
            'success' => true,
            'message' => 'Proximos carregadas com sucesso',
            'data' => $team
        ], Response::HTTP_OK);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function stats($idTorneio, $id)
    {

        //selecionar maximo seasson id do torneio
        $mysqlRegister = Season::where('t_id', '=', $idTorneio)->orderBy('id', 'DESC')->first();

        $seasson = $mysqlRegister->id;
        // $seasson = 39;


        $team = Team::find($id);

        $golsMarcados = 0;
        $golsSofridos = 0;
        $vitorias = 0;
        $empates = 0;
        $derrotas = 0;
        $vitoriasMandante = 0;
        $empatesMandante = 0;
        $derrotasMandante = 0;
        $vitoriasVisitante = 0;
        $empatesVisitante = 0;
        $derrotasVisitante = 0;
        $totalCartaoAmarelo = 0;
        $totalCartaoVermelho = 0;
        $totalCartaoAzul = 0;

        $matchs = DB::table('nx510_bl_matchday')
            ->join('nx510_bl_match', 'nx510_bl_matchday.id', '=', 'nx510_bl_match.m_id')
            ->where('nx510_bl_matchday.s_id', '=', $seasson)
            ->where('nx510_bl_match.m_played', '=', '1')
            ->orderByRaw('nx510_bl_match.m_date DESC')
            ->get();

        foreach ($matchs as $mm) {

            if ($mm->team1_id == $id) {

                $golsMarcados = $golsMarcados + $mm->score1;
                $golsSofridos = $golsSofridos + $mm->score2;

                if ($mm->score1 > $mm->score2) {
                    $vitoriasMandante++;
                } else if ($mm->score1 == $mm->score2) {
                    $empatesMandante++;
                } else if ($mm->score1 < $mm->score2) {
                    $derrotasMandante++;
                }

                $events = MatchEvent::where('match_id', '=', $mm->id)->get();

                foreach ($events as $e) {

                    if ($e->e_id == 1) {
                        $totalCartaoAmarelo++;
                    } else if ($e->e_id == 2) {
                        $totalCartaoVermelho++;
                    } else if ($e->e_id == 4) {
                        $totalCartaoAzul++;
                    }
                }
            } else if ($mm->team2_id == $id) {

                $golsMarcados = $golsMarcados + $mm->score2;
                $golsSofridos = $golsSofridos + $mm->score1;

                if ($mm->score1 < $mm->score2) {
                    $vitoriasVisitante++;
                } else if ($mm->score1 == $mm->score2) {
                    $empatesVisitante++;
                } else if ($mm->score1 > $mm->score2) {
                    $derrotasVisitante++;
                }


                $events = MatchEvent::where('match_id', '=', $mm->id)->get();

                foreach ($events as $e) {

                    if ($e->e_id == 1) {
                        $totalCartaoAmarelo++;
                    } else if ($e->e_id == 2) {
                        $totalCartaoVermelho++;
                    } else if ($e->e_id == 4) {
                        $totalCartaoAzul++;
                    }
                }
            }
        }

        $vitorias = 0 + $vitoriasVisitante + $vitoriasVisitante;
        $empates = 0 + $empatesVisitante + $empatesMandante;
        $derrotas = 0 + $derrotasVisitante + $derrotasMandante;

        //calcular aproveitamento
        $totalJogos = $vitorias + $empates + $derrotas;

        $aproveitamento = 0;
        $aproveitamentoMandante = 0;
        $aproveitamentoVisitante = 0;

        if ($totalJogos > 0) {

            $totalPontos = $totalJogos * 3;

            if ($vitorias > 0) {
                $pontosVitorias = $vitorias * 3;
            } else {
                $pontosVitorias = 0;
            }

            $pontosEmpates = $empates;

            $totalPontosTime = $pontosVitorias + $pontosEmpates;

            if ($totalPontosTime > 0) {

                $aproveitamento = (100 * $totalPontosTime) / $totalPontos;
                $aproveitamento = round($aproveitamento, 2);
            }
        }

        //calcular aproveitamento - mandante
        $totalJogosMandante = $vitoriasMandante + $empatesMandante + $derrotasMandante;

        if ($totalJogosMandante > 0) {

            $totalPontosMandante = $totalJogosMandante * 3;

            if ($vitoriasMandante > 0) {
                $pontosVitoriasMandante = $vitoriasMandante * 3;
            } else {
                $pontosVitoriasMandante = 0;
            }

            $pontosEmpatesMandante = $empatesMandante;

            $totalPontosTimeMandante = $pontosVitoriasMandante + $pontosEmpatesMandante;

            if ($totalPontosTimeMandante > 0) {

                $aproveitamentoMandante = (100 * $totalPontosTimeMandante) / $totalPontosMandante;
                $aproveitamentoMandante = round($aproveitamentoMandante, 2);
            } else {
                $aproveitamentoMandante = 0;
            }
        }

        //calcular aproveitamento - visitante
        $totalJogosVisitante = $vitoriasVisitante + $empatesVisitante + $derrotasVisitante;

        if ($totalJogosVisitante > 0) {

            $totalPontosVisitante = $totalJogosVisitante * 3;

            if ($vitoriasVisitante > 0) {
                $pontosVitoriasVisitante = $vitoriasVisitante * 3;
            } else {
                $pontosVitoriasVisitante = 0;
            }

            $pontosEmpatesVisitante = $empatesVisitante;

            $totalPontosTimeVisitante = $pontosVitoriasVisitante + $pontosEmpatesVisitante;

            if ($totalPontosTimeVisitante > 0) {

                $aproveitamentoVisitante = (100 * $totalPontosTimeVisitante) / $totalPontosVisitante;
                $aproveitamentoVisitante = round($aproveitamentoVisitante, 2);
            } else {
                $aproveitamentoVisitante = 0;
            }
        }


        $team['totalGames'] = $totalJogos;
        $team['win'] = $vitorias;
        $team['draw'] = $empates;
        $team['lost'] = $derrotas;
        $team['points'] = ($vitorias * 3) + $empates;
        $team['goal_score'] = $golsMarcados;
        $team['goals_conc'] = $golsSofridos;
        $team['goals_dif'] = $golsMarcados - $golsSofridos;
        $team['enjoyment'] = $aproveitamento;
        $team['enjoymentHome'] = $aproveitamentoMandante;
        $team['enjoymentAway'] = $aproveitamentoVisitante;
        $team['count_yellow'] = $totalCartaoAmarelo;
        $team['count_red'] = $totalCartaoVermelho;
        //$team['count_blue'] = $totalCartaoAzul;


        //updated, return success response
        return response()->json([
            'success' => true,
            'message' => 'Estatisticas carregadas com sucesso',
            'data' => $team
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function seasonteam($idTorneio, $id)
    {

        //selecionar maximo seasson id do torneio
        $mysqlRegister = Season::where('t_id', '=', $idTorneio)->orderBy('id', 'DESC')->first();

        $seasson = $mysqlRegister->id;

        $data = Team::with('players')->where('id', '=', $id)->paginate();

        foreach ($data   as $teams) {

            foreach ($teams['players']  as $player) {

                $url = $_ENV['APP_URL'] . "/api/v1/image?filename=" . $_ENV['SFTP_PATH_PHOTO_ATLETA'];
                $url = $_ENV['SFTP_PATH_PHOTO_ATLETA'];
                $img = $player->def_img;
                $player->def_img =  $url . $img;


                $amarelos = DB::table('nx510_bl_matchday')
                    ->join('nx510_bl_match', 'nx510_bl_matchday.id', '=', 'nx510_bl_match.m_id')
                    ->join('nx510_bl_match_events', 'nx510_bl_match.id', '=', 'nx510_bl_match_events.match_id')
                    ->where('nx510_bl_matchday.s_id', '=', $seasson)
                    ->where('nx510_bl_match.m_played', '=', '1')
                    ->where('nx510_bl_match_events.e_id', '=', '1')
                    ->where('nx510_bl_match_events.player_id', '=',  $player->id)
                    ->orderByRaw('nx510_bl_matchday.id ASC')
                    ->select('player_id')
                    ->get();


                $amarelosTotal = array();

                foreach ($amarelos  as $m) {
                    array_push($amarelosTotal, $m->player_id);
                }

                $filtersAmarelo = array_count_values($amarelosTotal);

                $player["yellow"] = "0";
                foreach ($filtersAmarelo  as $key  => $val) {
                    $player["yellow"] = $val;
                }

                $reds = DB::table('nx510_bl_matchday')
                    ->join('nx510_bl_match', 'nx510_bl_matchday.id', '=', 'nx510_bl_match.m_id')
                    ->join('nx510_bl_match_events', 'nx510_bl_match.id', '=', 'nx510_bl_match_events.match_id')
                    ->where('nx510_bl_matchday.s_id', '=', $seasson)
                    ->where('nx510_bl_match.m_played', '=', '1')
                    ->where('nx510_bl_match_events.e_id', '=', '2')
                    ->where('nx510_bl_match_events.player_id', '=',  $player->id)
                    ->orderByRaw('nx510_bl_matchday.id ASC')
                    ->select('player_id')
                    ->get();


                $redsTotal = array();

                foreach ($reds  as $m) {
                    array_push($redsTotal, $m->player_id);
                }

                $filtersRed = array_count_values($redsTotal);

                $player["red"] = "0";
                foreach ($filtersRed  as $key  => $val) {
                    $player["red"] = $val;
                }

                $blues = DB::table('nx510_bl_matchday')
                    ->join('nx510_bl_match', 'nx510_bl_matchday.id', '=', 'nx510_bl_match.m_id')
                    ->join('nx510_bl_match_events', 'nx510_bl_match.id', '=', 'nx510_bl_match_events.match_id')
                    ->where('nx510_bl_matchday.s_id', '=', $seasson)
                    ->where('nx510_bl_match.m_played', '=', '1')
                    ->where('nx510_bl_match_events.e_id', '=', '4')
                    ->where('nx510_bl_match_events.player_id', '=',  $player->id)
                    ->orderByRaw('nx510_bl_matchday.id ASC')
                    ->select('player_id')
                    ->get();


                $blueTotal = array();

                foreach ($blues  as $m) {
                    array_push($blueTotal, $m->player_id);
                }

                $filtersBlue = array_count_values($blueTotal);

                $player["blue"] = "0";
                foreach ($filtersBlue  as $key  => $val) {
                    $player["blue"] = $val;
                }

                $gols = DB::table('nx510_bl_matchday')
                    ->join('nx510_bl_match', 'nx510_bl_matchday.id', '=', 'nx510_bl_match.m_id')
                    ->join('nx510_bl_match_events', 'nx510_bl_match.id', '=', 'nx510_bl_match_events.match_id')
                    ->where('nx510_bl_matchday.s_id', '=', $seasson)
                    ->where('nx510_bl_match.m_played', '=', '1')
                    ->where('nx510_bl_match_events.e_id', '=', '3')
                    ->where('nx510_bl_match_events.player_id', '=',  $player->id)
                    ->orderByRaw('nx510_bl_matchday.id ASC')
                    ->select('player_id')
                    ->get();


                $golsTotal = array();

                foreach ($gols   as $m) {
                    array_push($golsTotal, $m->player_id);
                }

                $filtersGols = array_count_values($golsTotal);

                $player["gols"] = "0";
                foreach ($filtersGols  as $key  => $val) {
                    $player["gols"] = $val;
                }
            }
        }

        //updated, return success response
        return response()->json([
            'success' => true,
            'message' => 'Atletas carregados com sucesso',
            'data' => $data
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
        $data = Team::with('players')->where('id', '=', $id)->paginate();

        foreach ($data   as $teams) {

            foreach ($teams['players']  as $player) {

                $url = $_ENV['APP_URL'] . "/api/v1/image?filename=" . $_ENV['SFTP_PATH_PHOTO_ATLETA'];
                $url = $_ENV['SFTP_PATH_PHOTO_ATLETA'];
                $img = $player->def_img;
                $player->def_img =  $url . $img;
            }
        }
        //updated, return success response
        return response()->json([
            'success' => true,
            'message' => 'Operação realizada com sucesso',
            'data' => $data
        ], Response::HTTP_OK);
    }
}
