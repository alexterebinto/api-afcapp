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
                <div align="center"><img src="{{ $sumula['logo'] }}" width="180" height="70" /></div>
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
        <table cellpadding="0" cellspacing="0" style="width: 740px;">
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
                    style="float:left; text-transform: :uppercase; height: 60px !important; padding: 10px; text-align: center; font-size: 16px; color:#295987;">

                    <table width="100%" style="float:left; text-transform: :uppercase; height: 30px;">
                        <tr>
                            <td width="50" align="center;"><img
                                    style="text-align: :center; width:60px; border:1px rgb(217, 220, 220) solid; border-radius:5em "
                                    src="{{ $sumula['team_1']->logo }}" /></td>
                            <td width="30" width="50" align="center;">1</td>
                            <td width="50" align="center;" width="10" style="font-size: 20px;">X</td>
                            <td width="50" align="center;" width="20">2</td>
                            <td width="50" align="center;" width="50"><img
                                    style="margin-left:30px; width:40px; border:1px rgb(217, 220, 220) solid; border-radius:5em "
                                    src="{{ $sumula['team_2']->logo }}" /></td>
                        </tr>
                    </table>

                </td>
            </tr>

        </table>
    @endif



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





    <table cellpadding="0" cellspacing="0" style="width: 740px;">
        <tr>
            <td style="height: 80px; text-align: center;  width: 80px; border-right: 1px whitesmoke solid;">
                <img style="width:60px;" src="{{ $sumula['team_1']->logo }}" />
            </td>

            <td colspan="3" style="background-color:  whitesmoke;">
                <div style="width:90%; padding-left: 10px;  text-transform: uppercase; width:100%; font-size: 24px;">
                    {{ $sumula['team_1']->t_name }}</div>
                <div style="width:100%; padding-left: 10px; padding-top:5px;">Total Inscritos :
                    {{ $sumula['team_1']->totalInscritos }}</div>
            </td>
        </tr>
        <tr>
            <td class="borderCima" style="text-align:center;" width="25"><b>N&ordm;</b></td>
            <td class="borderCima" width="170"><b>Nome dos Jogadores</b></td>
            <td width="90" style="text-align: center;"><b>R.G.</b>
            </td>
            <td><b>Assinatura</b></td>
        </tr>
        @forelse($sumula['players1'] as $jogadores1)
            <tr>
                <td class="borderCima" style="text-align:center;" width="25">
                </td>


                @if ($jogadores1->isSuspenso == '1')
                    <td class="borderCima" width="170" style="text-decoration: line-through;">
                    @else
                    <td class="borderCima" width="170">
                @endif



                {{ $jogadores1->first_name }}
                {{ $jogadores1->last_name }}

                @if ($jogadores1->federado == 'S')
                    *
                @endif

                @if ($jogadores1->suspensoAmarelo == '1')
                    <img src="{{ $sumula['amarelo'] }}" width="10" height="10" style="margin-left:10px;" />
                @endif


                @if ($jogadores1->suspensoVermelho == '1')
                    <img src="{{ $sumula['vermelho'] }}" width="10" height="10" style="margin-left:10px;" />
                @endif

                @if ($jogadores1->suspensoPunicao == '1')
                    <img src="{{ $sumula['suspensao'] }}" width="10" height="10" style="margin-left:10px;" />
                @endif



                </td>
                <td width="90" style="text-align: center;"> {{ $jogadores1->rg }}
                </td>
                <td></td>
            </tr>
        @empty

            <tr>
                <td class="borderCima" style="text-align:center;" width="25">
                </td>
                <td class="borderCima" width="170">a</td>
                <td width="90">
                </td>
                <td></td>
            </tr>
        @endforelse

        @foreach ($sumula['vagasInscricoes'] ?? '' as $data)
            <tr>
                <td class="borderCima" style="text-align:center;" width="25">
                </td>
                <td class="borderCima" width="170"></td>
                <td width="90">
                </td>
                <td></td>
            </tr>
        @endforeach

        <tr>
            <td colspan="4"
                style="background-color:  whitesmoke; text-transform: uppercase; text-align:center; font-weight:bold;">
                COMISSÃO TÉCNICA</td>
        </tr>

        <tr>
            <td class="borderCima" style="text-align:left;" colspan="2" width="190">
                <b> Técnico : </b>
                @if (isset($sumula['team_1']->treinador))
                    {{ $sumula['team_1']->treinador->first_name }}
                    {{ $sumula['team_1']->treinador->last_name }}
                @endif
            </td>
            <td width="90">
                @if (isset($sumula['team_1']->treinador))
                    {{ $sumula['team_1']->rg }}
                @endif
            </td>
            <td></td>
        </tr>

        <tr>
            <td class="borderCima" style="text-align:left;" colspan="2" width="190">
                <b> Aux. Técnico : </b>
                @if (isset($sumula['team_1']->auxiliar11))
                    {{ $sumula['team_1']->auxiliar11->first_name }}
                    {{ $sumula['team_1']->auxiliar11->last_name }}
                @endif
            </td>
            <td width="90">
                @if (isset($sumula['team_1']->auxiliar11))
                    {{ $sumula['team_1']->auxiliar11->rg }}
                @endif
            </td>
            </td>
            <td></td>
        </tr>

        <tr>
            <td class="borderCima" style="text-align:left;" colspan="2" width="190">
                <b> Aux. Técnico : </b>
                @if (isset($sumula['team_1']->auxiliar12))
                    {{ $sumula['team_1']->auxiliar12->first_name }}
                    {{ $sumula['team_1']->auxiliar12->last_name }}
                @endif
            </td>
            <td width="90">
                @if (isset($sumula['team_1']->auxiliar12))
                    {{ $sumula['team_1']->auxiliar12->rg }}
                @endif
            </td>
            </td>
            <td></td>
        </tr>

        <tr>
            <td class="borderCima" style="text-align:justify; padding: 5px;" colspan="4" width="190">
                CA (cart&atilde;o amarelo); CV (cart&atilde;o vermelho); 2&ordm; CA (segundo cart&atilde;o
                amarelo); CVD (cart&atilde;o vermelho direto). Situa&ccedil;&otilde;es poss&iacute;veis (colocar
                &quot;x&quot; nos espa&ccedil;os correspondentes): a) somente cart&atilde;o amarelo =
                &quot;x&rsquo; em CA; b) expuls&atilde;o por 2&ordm; CA = &quot;x&quot; em CA e &quot;x&quot; em
                2&ordm; CA;c) expuls&atilde;o direta = &quot;x&quot; em CVD; e d) cart&atilde;o amarelo seguido
                de expuls&atilde;o direta = &quot;x&quot; em CA e &quot;x&quot; em CVD.
            </td>
        </tr>
    </table>

    <!-- TIME 2 RELACAO GERAL -->
    <table cellpadding="0" cellspacing="0" style="width: 740px;">
        <tr>
            <td style="height: 80px; text-align: center;  width: 80px; border-right: 1px whitesmoke solid;">
                <img style="width:60px;" src="{{ $sumula['team_2']->logo }}" />
            </td>

            <td colspan="3" style="background-color:  whitesmoke;">
                <div style="width:90%; padding-left: 10px;  text-transform: uppercase; width:100%; font-size: 24px;">
                    {{ $sumula['team_2']->t_name }}</div>
                <div style="width:100%; padding-left: 10px; padding-top:5px;">Total Inscritos :
                    {{ $sumula['team_2']->totalInscritos }}</div>
            </td>
        </tr>
        <tr>
            <td class="borderCima" style="text-align:center;" width="25"><b>N&ordm;</b></td>
            <td class="borderCima" width="170"><b>Nome dos Jogadores</b></td>
            <td width="90" style="text-align: center;"><b>R.G.</b>
            </td>
            <td><b>Assinatura</b></td>
        </tr>
        @forelse($sumula['players2'] as $jogadores2)
            <tr>
                <td class="borderCima" style="text-align:center;" width="25">
                </td>

                @if ($jogadores2->isSuspenso == '1')
                    <td class="borderCima" width="170" style="text-decoration: line-through;">
                    @else
                    <td class="borderCima" width="170">
                @endif

                {{ $jogadores2->first_name }}
                {{ $jogadores2->last_name }}

                @if ($jogadores2->federado == 'S')
                    *
                @endif

                @if ($jogadores2->suspensoAmarelo == '1')
                    <img src="{{ $sumula['amarelo'] }}" width="10" height="10" style="margin-left:10px;" />
                @endif

                @if ($jogadores2->suspensoVermelho == '1')
                    <img src="{{ $sumula['vermelho'] }}" width="10" height="10" style="margin-left:10px;" />
                @endif

                @if ($jogadores2->suspensoPunicao == '1')
                    <img src="{{ $sumula['suspensao'] }}" width="10" height="10" style="margin-left:10px;" />
                @endif


                </td>
                <td width="90"> {{ $jogadores2->rg }}
                </td>
                <td></td>
            </tr>
        @empty

            <tr>
                <td class="borderCima" style="text-align:center;" width="25">
                </td>
                <td class="borderCima" width="170"></td>
                <td width="90">
                </td>
                <td></td>
            </tr>
        @endforelse

        @foreach ($sumula['vagasInscricoes2'] ?? '' as $data)
            <tr>
                <td class="borderCima" style="text-align:center;" width="25">
                </td>
                <td class="borderCima" width="170"></td>
                <td width="90">
                </td>
                <td></td>
            </tr>
        @endforeach

        <tr>
            <td colspan="4"
                style="background-color:  whitesmoke; text-transform: uppercase; text-align:center; font-weight:bold;">
                COMISSÃO TÉCNICA</td>
        </tr>

        <tr>
            <td class="borderCima" style="text-align:left;" colspan="2" width="190">
                <b> Técnico : </b>
                @if (isset($sumula['team_2']->treinador))
                    {{ $sumula['team_2']->treinador->first_name }}
                    {{ $sumula['team_2']->treinador->last_name }}
                @endif

            </td>
            <td width="90">
                @if (isset($sumula['team_2']->treinador))
                    {{ $sumula['team_2']->treinador->rg }}
                @endif
            </td>
            <td></td>
        </tr>

        <tr>
            <td class="borderCima" style="text-align:left;" colspan="2" width="190">
                <b> Aux. Técnico : </b>
                @if (isset($sumula['team_2']->auxiliar21))
                    {{ $sumula['team_2']->auxiliar21->first_name }}
                    {{ $sumula['team_2']->auxiliar21->last_name }}
                @endif
            </td>
            <td width="90">
                @if (isset($sumula['team_2']->auxiliar21))
                    {{ $sumula['team_2']->auxiliar21->rg }}
                @endif
            </td>
            <td></td>
        </tr>

        <tr>
            <td class="borderCima" style="text-align:left;" colspan="2" width="190">
                <b> Aux. Técnico : </b>
                @if (isset($sumula['team_2']->auxiliar22))
                    {{ $sumula['team_2']->auxiliar22->first_name }}
                    {{ $sumula['team_2']->auxiliar22->last_name }}
                @endif
            </td>
            <td width="90">
                @if (isset($sumula['team_2']->auxiliar22))
                    {{ $sumula['team_2']->auxiliar22->rg }}
                @endif

            </td>
            <td></td>
        </tr>

        <tr>
            <td class="borderCima" style="text-align:justify; padding: 5px;" colspan="4" width="190">
                CA (cart&atilde;o amarelo); CV (cart&atilde;o vermelho); 2&ordm; CA (segundo cart&atilde;o
                amarelo); CVD (cart&atilde;o vermelho direto). Situa&ccedil;&otilde;es poss&iacute;veis (colocar
                &quot;x&quot; nos espa&ccedil;os correspondentes): a) somente cart&atilde;o amarelo =
                &quot;x&rsquo; em CA; b) expuls&atilde;o por 2&ordm; CA = &quot;x&quot; em CA e &quot;x&quot; em
                2&ordm; CA;c) expuls&atilde;o direta = &quot;x&quot; em CVD; e d) cart&atilde;o amarelo seguido
                de expuls&atilde;o direta = &quot;x&quot; em CA e &quot;x&quot; em CVD.
            </td>
        </tr>
    </table>


</body>

</html>
