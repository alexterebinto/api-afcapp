<?php

$servername="127.0.0.1:3306";
$base = "ccfute89_api-afcapp";
$prefixo = "nx510";
$username='ccfute89_root';
$password='qwop&1971';

// Create connection

$conexao = mysqli_connect($servername, $username, $password, $base);

$id_match = (isset($_GET['id_match'])) ? $_GET['id_match'] : 1;

$queryM = "SELECT * FROM  nx510_bl_match a,nx510_bl_matchday  b WHERE a.m_id = b.id and a.id = " . $id_match;

$sqlM = mysqli_query($conexao, $queryM) or die("ERRO no comando SQL 3:");

while ($campo2 = mysqli_fetch_row($sqlM)) {

  $idTime = $campo2[3];
  $idTime2 = $campo2[4];
  $data = utf8_encode($campo2[10]);
  $horaJogo = utf8_encode($campo2[11]);
  $rodada = utf8_encode($campo2[15]);
}

$token = (isset($_GET['token'])) ? $_GET['token'] : 1;

$token = trim($token);

$query = "SELECT * FROM  nx510_bl_teams WHERE id = " . $idTime;

//echo $query;

$query2 = "SELECT * FROM  nx510_bl_teams WHERE id = " . $idTime2;

$sqlTimes = mysqli_query($conexao, $query) or die("ERRO no comando SQL 3:");
$sqlTimes2 = mysqli_query($conexao, $query2) or die("ERRO no comando SQL 4:");

$userNoticias = array();

while ($campo = mysqli_fetch_row($sqlTimes)) {

  $id          = utf8_encode($campo[0]);
  $name        = $campo[1];
  $cidade      = utf8_encode($campo[6]);
  $foto        = utf8_encode($campo[6]);
  $cpf        = utf8_encode($campo[9]);
}


while ($campo2 = mysqli_fetch_row($sqlTimes2)) {

  $id2          = utf8_encode($campo2[0]);
  $name2        = $campo2[1];
  $cidade2      = utf8_encode($campo2[6]);
  $foto2        = utf8_encode($campo2[6]); 
  $cpf2        = utf8_encode($campo2[9]);
}


//lista de atletas

$sql = 'SELECT * FROM nx510_bl_players a, nx510_bl_positions b where b.id = a.position_id and a.team_id=' . $idTime . ' order by a.first_name';

$sqlTimes = mysqli_query($conexao, $sql) or die("ERRO no comando SQL 1:");

$arrayAtletas = array();

while ($campo = mysqli_fetch_row($sqlTimes)) {
  $id_jogador = $campo['0'];
  $posicao = $campo['9'];
  $posicao = strtoupper($posicao[0] . $posicao[1] . $posicao[2]);
  $nome_completo = trim($campo['1']) .  " " . trim($campo['2']);
  $nome_completo = trim($nome_completo);
  $apelido = explode(" ", $campo['1']);
  $apelidoFinal   = utf8_encode($campo['3']);
  if ($apelidoFinal == "") {
    $apelidoFinal = utf8_encode($apelido[0]);
  }
  $camisa = $campo['10'];

  $nomeCurto =  trim($campo['1']);
  $nc = explode(" ", $nomeCurto);
  $apeAtleta = utf8_encode($campo['3']);

  if ($apeAtleta == "") {
    $apeAtleta = $nc[0];

    $apelidoFinal = "";
  }

  $nome_completo = substr($nome_completo, 0, 24);


  //verificar suspensao 

  $sql_cartoes = "SELECT 
                                    nx510_bl_match.m_date as 'data',
                                    nx510_bl_players.team_id as 'time',
                                    nx510_bl_players.id as 'player_id',
                                    nx510_bl_players.first_name as nome,
                                    nx510_bl_players.last_name as 'sobrenome',
                                    nx510_bl_match_events.e_id, 
                                    nx510_bl_events.e_name,
                                    nx510_bl_matchday.m_name as rodada
                                  FROM
                                    nx510_bl_match
                                    INNER JOIN nx510_bl_matchday ON (nx510_bl_match.m_id = nx510_bl_matchday.id)
                                    INNER JOIN nx510_bl_match_events ON (nx510_bl_match.id = nx510_bl_match_events.match_id)
                                    INNER JOIN nx510_bl_players ON (nx510_bl_match_events.player_id = nx510_bl_players.id)
                                    INNER JOIN nx510_bl_teams ON (nx510_bl_players.team_id = nx510_bl_teams.id)
                                    INNER JOIN nx510_bl_events ON (nx510_bl_match_events.e_id = nx510_bl_events.id)
                                    where e_id < 3	
                                    and m_date between '2021-01-01' and '2021-12-31'
                                    and player_id = ' $id_jogador' ORDER BY CONVERT(nx510_bl_matchday.m_name, SIGNED INTEGER); ";

  $query_cartoes =  mysqli_query($conexao, $sql_cartoes);

  $total_amarelo = 0;
  $total_vermelho = 0;
  $is_suspenso = 0;
  $ultima_rodada_amarelo = "";


  while ($campo_cartoes = mysqli_fetch_row($query_cartoes)) {

    $data_cartao =  $campo_cartoes[0];
    $tipo_cartao =  $campo_cartoes[5];
    $nome_cartao =  $campo_cartoes[6];
    $rodada_cartao =  $campo_cartoes[7];


    //pegar somente da rodada 
    //	echo $rodada . "-" . $rodada_cartao . "=" . $player_id . " **" . $tipo_cartao . "<br>";


    if ($rodada_cartao < $rodada) {



      if ($tipo_cartao == "1") {


        if ($rodada_cartao < 31) {
          $total_amarelo++;
          $ultima_rodada_amarelo = $rodada_cartao;
        }
      }

      if ($tipo_cartao == "2") {



        $total_vermelho++;

        //verificar se a expuls???o foi na rodada anterior
        if ($rodada_cartao == ($rodada - 1)) {

          //	echo "aqui2";
          //$teste = $rodada_cartao . "**" . ($rodada-1);
          //echo $teste; 

          $is_suspenso = 1;
        }
      }
    }
  }


  if ($total_amarelo == "3" || $total_amarelo == "6" || $total_amarelo == "9" || $total_amarelo == "12" || $total_amarelo == "15" || $total_amarelo == "18" || $total_amarelo == "21" || $total_amarelo == "24") {

    if ($ultima_rodada_amarelo == ($rodada - 1)) {

      $is_suspenso = 1;
    }
  }





  //fim suspensao   
  ///////////////////// 

  $nome_completo =  ucwords(strtolower($nome_completo));
  $arrayAtleta = array(
    "idAtleta" => $id_jogador,
    "nomeCompleto" => $nome_completo,
    "apelido" => $apeAtleta,
    "nomeCurto" => $nc[0],
    "fotoAtleta" => $fotoAtl,
    "posicao" => $posicao,
    "dataNas" => "XXX",
    "rg" => $camisa ,
    "isSuspenso" => $is_suspenso
  );


  array_push($arrayAtletas, $arrayAtleta);
}


//lista de atletas 2

$sql = 'SELECT * FROM nx510_bl_players a, nx510_bl_positions b where b.id = a.position_id and a.team_id=' . $idTime2 . ' order by a.first_name';

$sqlTimes = mysqli_query($conexao, $sql) or die("ERRO no comando SQL 2 :");

$arrayAtletas2 = array();
$arrayPartida = array();

while ($campo = mysqli_fetch_row($sqlTimes)) {

  $apelidoFinal = "";
  $id_jogador = $campo['0'];
  $posicao = $campo['9'];
  $posicao = strtoupper($posicao[0] . $posicao[1] . $posicao[2]);
  $nome_completo = trim($campo['1']) .  " " . trim($campo['2']);
  $nome_completo = trim($nome_completo);
  $apelido = explode(" ", $campo['1']);
  $apelidoFinal   = $campo['3'];
  $camisa2   = $campo['10'];
  if ($apelidoFinal == "") {
    $apelidoFinal = utf8_encode($apelido[0]);
  }

  $nomeCurto =  trim(utf8_encode($campo['1']));
  $nc = explode(" ", $nomeCurto);
  $apeAtleta = utf8_encode($campo['3']);

  if ($apeAtleta == "") {
    $apeAtleta = $nc[0];
  }

  $nome_completo = substr($nome_completo, 0, 24);


  //verificar suspensao 

  $sql_cartoes = "SELECT 
                                    nx510_bl_match.m_date as 'data',
                                    nx510_bl_players.team_id as 'time',
                                    nx510_bl_players.id as 'player_id',
                                    nx510_bl_players.first_name as nome,
                                    nx510_bl_players.last_name as 'sobrenome',
                                    nx510_bl_match_events.e_id, 
                                    nx510_bl_events.e_name,
                                    nx510_bl_matchday.m_name as rodada
                                  FROM
                                    nx510_bl_match
                                    INNER JOIN nx510_bl_matchday ON (nx510_bl_match.m_id = nx510_bl_matchday.id)
                                    INNER JOIN nx510_bl_match_events ON (nx510_bl_match.id = nx510_bl_match_events.match_id)
                                    INNER JOIN nx510_bl_players ON (nx510_bl_match_events.player_id = nx510_bl_players.id)
                                    INNER JOIN nx510_bl_teams ON (nx510_bl_players.team_id = nx510_bl_teams.id)
                                    INNER JOIN nx510_bl_events ON (nx510_bl_match_events.e_id = nx510_bl_events.id)
                                    where e_id < 3	
                                    and m_date between '2021-01-01' and '2021-12-31'
                                    and player_id = ' $id_jogador' ORDER BY CONVERT(nx510_bl_matchday.m_name, SIGNED INTEGER); ";

  $query_cartoes =  mysqli_query($conexao, $sql_cartoes);




  $total_amarelo = 0;
  $total_vermelho = 0;
  $is_suspenso = 0;
  $ultima_rodada_amarelo = "";


  while ($campo_cartoes = mysqli_fetch_row($query_cartoes)) {

    $data_cartao =  $campo_cartoes[0];
    $tipo_cartao =  $campo_cartoes[5];
    $nome_cartao =  $campo_cartoes[6];
    $rodada_cartao =  $campo_cartoes[7];


    //pegar somente da rodada 
    //	echo $rodada . "-" . $rodada_cartao . "=" . $player_id . " **" . $tipo_cartao . "<br>";


    if ($rodada_cartao < $rodada) {



      if ($tipo_cartao == "1") {


        if ($rodada_cartao < 31) {
          $total_amarelo++;
          $ultima_rodada_amarelo = $rodada_cartao;
        }
      }

      if ($tipo_cartao == "2") {



        $total_vermelho++;

        //verificar se a expuls???o foi na rodada anterior
        if ($rodada_cartao == ($rodada - 1)) {

          //	echo "aqui2";
          //$teste = $rodada_cartao . "**" . ($rodada-1);
          //echo $teste; 

          $is_suspenso = 1;
        }
      }
    }
  }


  if ($total_amarelo == "3" || $total_amarelo == "6" || $total_amarelo == "9" || $total_amarelo == "12" || $total_amarelo == "15" || $total_amarelo == "18" || $total_amarelo == "21" || $total_amarelo == "24") {

    if ($ultima_rodada_amarelo == ($rodada - 1)) {

      $is_suspenso = 1;
    }
  }





  //fim suspensao   
  ///////////////////// 
  $nome_completo =  ucwords(strtolower($nome_completo));



  $arrayAtleta2 = array(
    "idAtleta" => $id_jogador,
    "nomeCompleto" => $nome_completo,
    "apelido" => $apeAtleta,
    "nomeCurto" => $nc[0],
    "fotoAtleta" => $fotoAtl,
    "posicao" => $posicao,
    "dataNas" => "XXX",
    "rg" => $camisa2,
    "isSuspenso" => $is_suspenso
  );



  array_push($arrayAtletas2, $arrayAtleta2);
}

$dataJogo = $data[8] . $data[9] . "/" . $data[5] . $data[6] . "/" . $data[0] . $data[1] . $data[2] . $data[3];

$dataPartida = $dataJogo." " . $horaJogo;


$arraySimples = array(
  "dataPartida" => $dataPartida,
  "rodada" => $rodada
);



array_push($arrayPartida, $arraySimples);




$array = array(
  "tid" => $idTime,
  "nomeEquipe" => $name,
  "escudoEquipe" => $foto,
  "atletas" => $arrayAtletas,
  "tid2" => $idTime2,
  "nomeEquipe2" => $name2,
  "escudoEquipe2" => $foto2,
  "atletas2" => $arrayAtletas2,
  "partida" => $arrayPartida
);



array_push($userNoticias, $array);

header("Content-Type: application/json; charset=utf-8");
echo json_encode(array("equipe" => $userNoticias), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);



function validarToken($str)
{

  date_default_timezone_set('America/Sao_Paulo');
  $date = date('Y-m-d');
  $strComparar = 'amadorfc' . $date;
  $strComparar = md5($strComparar);

  if ($str == $strComparar) {
    return true;
  } else {
    return false;
  }
}
