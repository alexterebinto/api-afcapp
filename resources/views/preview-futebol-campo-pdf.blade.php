<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF</title>
</head>

<style type="text/css">
    * {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 12px;
    }

    td {
        border: 1px lightgray solid;
        margin: 0;
        height: 25px;
        padding-left: 3px;
        font-size: 11px;
    }

    .tabelaPrincipal {
        width: 1000px;
        border: 1px lightgray solid;

    }

    .borderCimaFundo {
        background-color: lightgray;
    }

    .page-break {
        page-break-after: always;
    }

</style>

<body>
    <table class="tabelaPrincipal" cellpadding="0" cellspacing="0" style="width: 740px;">
        <tr>
            <td width="153">
                <div align="center"><img src="{{ $sumula['logo'] }}" width="190" height="70" /></div>
            </td>
            <td colspan="6" class="borderCimaFundo">
                <p align="center" style="font-size: 10px; text-transform: uppercase;">
                    <strong>{{ $sumula['tournament']->name }}
                </p>
                <p align="center" style="font-size: 10px;  text-transform: uppercase;">
                    <b>{{ $sumula['match']->m_location }}
                        {{ $sumula['match']->m_date }} {{ $sumula['match']->m_time }}
                        1 Rodada</strong></b>
                </p>
                <p align="center" style="font-size: 10px; font-weight: bold;">P{{ $sumula['match']->id }} - SUMULA E
                    PREVIEW PARTIDA </b>
                    </strong></p>
            </td>
        </tr>
        <tr>
            <td class="borderCima" colspan="3"
                STYLE=" padding:10px; BORDER-RIGHT:NONE; text-align: center; text-transform: uppercase;">

                <img style="width:100px; border:1px rgb(217, 220, 220) solid; border-radius:5em "
                    src="{{ $sumula['team_1']->logo }}" />
            </td>

            <td width="" td colspan="4" style="padding:10px; text-align: center; text-transform: uppercase;">
                <img style="width:100px; border:1px rgb(205, 212, 211) solid; border-radius:5em "
                    src="{{ $sumula['team_2']->logo }}" />
            </td>
        </tr>

    </table>

    <table cellpadding="0" cellspacing="0" style="width: 740px;">
        <tr>
            <td colspan="10" class="borderCimaFundo"
                style="text-transform: :uppercase; height: 13px !important; padding: 5px; text-align: center; font-size: 20px; background-color:#8ac4cd; color:white;">
                <div align="center"
                    style="text-transform: :uppercase; height: 13px !important; padding: 5px; text-align: center; font-size: 18px; background-color:#8ac4cd; color:white;">
                    ESTATÍSTICAS DO CONFRONTO - {{ $sumula['totalJogos'] }} Jogo(s)
                    Realizados</div>
            </td>
        </tr>
    </table>

    <table cellpadding="0" cellspacing="0" style="width: 740px;">
        <tr>
            <td colspan="5" width="100"
                style="height: 13px !important; padding: 5px; text-align: center; font-size: 16px; background-color:#295987; color:white;">
                {{ $sumula['totalVitorias1'] }} V
            </td>


            <td colspan="2" width="50"
                style="height: 13px !important; padding: 5px; text-align: center; font-size: 16px; background-color:#295987; color:white;">
                {{ $sumula['totalEmpates'] }} E
            </td>

            <td colspan="3" width="100"
                style="height: 13px !important; padding: 5px; text-align: center; font-size: 16px; background-color:#295987; color:white;">
                {{ $sumula['totalVitorias2'] }} V
            </td>


        </tr>
    </table>

    <table cellpadding="0" cellspacing="0" style="width: 740px;">
        <tr>
            <td colspan="10"
                style="text-transform: :uppercase; height: 13px !important; padding: 10px; text-align: center; font-size: 18px; color:white;">
                <div align="center"
                    style="text-transform: :uppercase; height: 13px !important; padding: 5px; text-align: center; font-size: 18px; background-color:white; color:#4c92d3;">
                    GOLS - {{ $sumula['totalGols'] }} Gols(s)
                    marcados <img src="{{ $sumula['gol'] }}" width="20" height="20" style="margin-left:10px;" />
                </div>
            </td>
        </tr>
    </table>

    <table cellpadding="0" cellspacing="0" style="width: 740px;">
        <tr>
            <td colspan="5" width="100"
                style="text-transform: :uppercase; height: 13px !important; padding: 5px; text-align: center; font-size: 16px; background-color:#4c92d3; color:white;">
                {{ $sumula['totalGols1'] }} {{ $sumula['team_1']->t_initials }}
            </td>


            <td colspan="2" width="50"
                style="text-transform: :uppercase; height: 13px !important; padding: 5px; text-align: center; font-size: 16px; background-color:#4c92d3; color:white;">
                {{ $sumula['totalGols2'] }} {{ $sumula['team_2']->t_initials }}
            </td>

            <td colspan="3" width="100"
                style=" text-transform: :uppercase;height: 13px !important; padding: 5px; text-align: center; font-size: 16px; background-color:#4c92d3; color:white;">
                Média : {{ $sumula['mediaGols'] }}
            </td>


        </tr>
    </table>

    @if (isset($sumula['ultimoJogo']))
        <table cellpadding="0" cellspacing="0" style="width: 740px;" style="">
            <tr>
                <td colspan="10"
                    style="text-transform: :uppercase; height: 13px !important; padding: 10px; text-align: center; font-size: 18px; color:white;">
                    <div align="center"
                        style="text-transform: :uppercase; height: 13px !important; padding: 5px; text-align: center; font-size: 18px; background-color:white; color:#4c92d3;">
                        ULTIMO CONFRONTO
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="10"
                    style="text-transform: :uppercase; height: 13px !important; padding: 10px; text-align: center; font-size: 16px; color:white;">
                    <div
                        style="text-transform: :uppercase; height: 13px !important; padding: 5px; text-align: center; font-size: 14px; background-color:white; color:#4c92d3;">
                        {{ $sumula['ultimoJogo']->m_date }} {{ $sumula['ultimoJogo']->m_location }}
                    </div>
                </td>
            </tr>

            <tr>
                <td colspan="10"
                    style="border:none !important; float:left; text-transform: :uppercase; height: 60px !important; padding: 10px; text-align: center; font-size: 16px; color:#295987;">

                    <table width="100%"
                        style="float:left; text-transform: :uppercase; height: 30px; border:1px white solid; background-color:lightgray; ">
                        <tr>
                            <td width="50" align="center;" style="border:1px white lightgray; " width="50"><img
                                    style="margin-left:30px; width:40px; border:1px lightgray solid; border-radius:5em "
                                    src="{{ $sumula['team_1']->logo }}" /></td>
                            <td width="30" width="50" align="center;"
                                style="font-size: 22px; border:1px lightgray solid;">


                                @if ($sumula['ultimoJogo']->team1_id == $sumula['team_1']->id)
                                    {{ $sumula['ultimoJogo']->score1 }}
                                @endif

                                @if ($sumula['ultimoJogo']->team2_id == $sumula['team_1']->id)
                                    {{ $sumula['ultimoJogo']->score2 }}
                                @endif


                            </td>
                            <td width="50" align="center;" width="10"
                                style="font-size: 20px; border:1px lightgray solid;">X
                            </td>
                            <td width="50" align="center;" style="font-size: 22px; border:1px lightgray solid"
                                width="20">

                                @if ($sumula['ultimoJogo']->team1_id == $sumula['team_2']->id)
                                    {{ $sumula['ultimoJogo']->score1 }}
                                @endif

                                @if ($sumula['ultimoJogo']->team2_id == $sumula['team_2']->id)
                                    {{ $sumula['ultimoJogo']->score2 }}
                                @endif



                            </td>
                            <td width="50" align="center;" style="border:1px lightgray solid; " width="50"><img
                                    style="margin-left:30px; width:40px; border:1px lightgray solid; border-radius:5em "
                                    src="{{ $sumula['team_2']->logo }}" /></td>
                        </tr>
                    </table>

                </td>
            </tr>

        </table>
    @endif

    <div style="width:740px; float:left;">
        <div style="width:350px; float:left;">
            <table cellpadding="0" cellspacing="0" style="width: 330px;">
                <tr>
                    <td colspan="3" style="text-align: center; color:white; font-size:15px; background-color:#295987;">
                        Súmula
                        da Partida</td>
                </tr>
                @forelse($sumula['eventosUltimoJogo'] as $evento)
                    <tr>
                        <td class='borderCima' style='text-align:center;' width='25'><img style="width:50px;"
                                src="{{ $evento->player_photo }}" </td>

                        <td class="borderCima" style="text-align:center;" width="70">
                            {{ $evento->player_name }}

                        </td>
                        <td class="borderCima" style="text-align:center;" width="30">
                            {{ $evento->minutes }}'

                            @if ($evento->e_id == '1')
                                <img src="{{ $sumula['amarelo'] }}" width="20" height="20"
                                    style="margin-left:10px;" />
                            @endif

                            @if ($evento->e_id == '2')
                                <img src="{{ $sumula['vermelho'] }}" width="20" height="20"
                                    style="margin-left:10px;" />
                            @endif

                            @if ($evento->e_id == '3')
                                <img src="{{ $sumula['gol'] }}" width="20" height="20" style="margin-left:10px;" />
                            @endif


                        </td>

                    </tr>
                @empty
                @endforelse

            </table>

        </div>

        <div style="width:350px; float:right;">
            <table cellpadding="0" cellspacing="0" style="width: 340px;">

                <tr>
                    <td colspan="3" style="text-align: center; color:white; font-size:15px; background-color:#295987;">
                        Jogadores Suspensos</td>
                </tr>

                <tr>
                    <td colspan="3" style="text-align: center;  font-size:15px; ">
                        -</td>
                </tr>




            </table>

            <table cellpadding="0" cellspacing="0" style="width: 340px;">

                <tr>
                    <td colspan="3" style="text-align: center; color:white; font-size:15px; background-color:#295987;">
                        Jogadores Pendurados</td>
                </tr>

                <tr>
                    <td colspan="3" style="text-align: center;  font-size:15px; ">
                        -</td>
                </tr>



            </table>

        </div>



    </div>






</body>

</html>
