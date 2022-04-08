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
    <table class="tabelaPrincipal" cellpadding="0" cellspacing="0">
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
                    RELAT&Oacute;RIO DA PARTIDA </b>
                    </strong></p>
            </td>
        </tr>
        <tr>
            <td class="borderCima" colspan="2"
                STYLE="BORDER-RIGHT:NONE; text-align: center; text-transform: uppercase;"><b>Equipe A :
                    {{ $sumula['team_1']->t_name }} </b></td>

            <td width="44" td colspan="5" style="text-align: center; text-transform: uppercase;">
                <b>Equipe B: {{ $sumula['team_2']->t_name }}
                </b>
            </td>

        </tr>


        <tr>
            <td class="borderCima"><b>Resultado final : </b></td>
            <td width="68" style="background-color:whitesmoke;">&nbsp;</td>
            <td width="34" style="font-size: 30px; text-align:center;">
                X
            </td>
            <td width="68" style="background-color:whitesmoke;">&nbsp;</td>
            <td colspan="3" style="FLOAT:LEFT;">
                <table style=" FLOAT:LEFT; width: 100%; border:1px white solid;">
                    <tr>
                        <TD style=" FLOAT:LEFT; width: 40%; text-align: center; "><b> Vencedor </b> :</TD>
                        <TD style=" FLOAT:LEFT; width: 30%;  text-align: center; text-transform: uppercase; ">
                            {{ $sumula['team_1']->t_initials }}
                        </TD>
                        <TD style=" FLOAT:LEFT; width: 30%;  text-align: center; text-transform: uppercase;">
                            {{ $sumula['team_2']->t_initials }}
                        </TD>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>&Aacute;rbitro:</td>
            <td colspan="6" style="background-color:#FFFAFA;">
                <div style="width:40%; float:left;"><b>&nbsp; </b></div>
                <div style="width:60%; float:left;">Ass.: </div>
            </td>
        </tr>

        <tr>
            <td>Assistente: </td>
            <td colspan="6" style="background-color:#F8F8FF;">
                <div style="width:40%; float:left;"><b>&nbsp; </b></div>
                <div style="width:60%; float:left;">Ass.: </div>
            </td>
        </tr>

        <tr>
            <td>Assistente: </td>
            <td colspan="6" style="background-color:#FFFAFA;">
                <div style="width:40%; float:left;"><b>&nbsp; </b></div>
                <div style="width:60%; float:left;">Ass.: </div>
            </td>
        </tr>



        <tr>
            <td>Mes&aacute;rio: </td>
            <td colspan="6" style="background-color:#FFFAFA;">
                <div style="width:40%; float:left;"><b>&nbsp;</b></div>
                <div style="width:60%; float:left;">Ass.: </div>
            </td>
        </tr>

        <tr>
            <td colspan="7" class="borderCimaFundo" style="height: 13px !important; padding: 5px;">
                <div align="center"><strong>RELA&Ccedil;&Atilde;O DE JOGADORES</strong></div>
            </td>
        </tr>

        <tr>
            <td colspan="7" style="text-align: justify; padding:2px;">
                <p>As equipes dever&atilde;o apresentar ao representante antes do inicio da partida, com a
                    rela&ccedil;&atilde;o dos respectivos jogadores , devidamente documentados com carteirinha de
                    identifica&ccedil;&atilde;o do campeonato ou documento de identidade expedido por
                    &oacute;rg&atilde;o
                    p&uacute;blico oficial. </p>
            </td>
        </tr>
        <tr>
            <td colspan="7" class="borderCimaFundo" style="height: 13px !important; padding: 5px;">
                <div align="center"><strong>GOLS (ORDEM CRONOL&Oacute;GICA)</strong></div>
            </td>
        </tr>
    </table>



    <table cellpadding="0" cellspacing="0" style="width: 740px;">
        <tr>
            <td width="20" style="text-align: center; font-weight: bold;">
                N&ordm;
            </td>
            <td>Jogador</td>
            <td width="30" style="text-align: center;">Min</td>
            <td width="25">
                1T/2T
            </td>
            <td width="20" style="text-align: center; font-weight: bold;">
                N&ordm;</div>
            </td>
            <td>Jogador</td>
            <td width="30" style="text-align: center;">Min</td>
            <td width="25">
                1T/2T
            </td>
        </tr>

        <tr>
            <td width="20" style="text-align: center; font-weight: bold;">

            </td>
            <td></td>
            <td width="30" style="text-align: center;"></td>
            <td width="25">

            </td>
            <td width="20" style="text-align: center; font-weight: bold;">
                </div>
            </td>
            <td></td>
            <td width="30" style="text-align: center;"></td>
            <td width="25">

            </td>
        </tr>


        <tr>
            <td width="20" style="text-align: center; font-weight: bold;">

            </td>
            <td></td>
            <td width="30" style="text-align: center;"></td>
            <td width="25">

            </td>
            <td width="20" style="text-align: center; font-weight: bold;">
                </div>
            </td>
            <td></td>
            <td width="30" style="text-align: center;"></td>
            <td width="25">

            </td>
        </tr>

        <tr>
            <td width="20" style="text-align: center; font-weight: bold;">

            </td>
            <td></td>
            <td width="30" style="text-align: center;"></td>
            <td width="25">

            </td>
            <td width="20" style="text-align: center; font-weight: bold;">
                </div>
            </td>
            <td></td>
            <td width="30" style="text-align: center;"></td>
            <td width="25">

            </td>
        </tr>


        <tr>
            <td width="20" style="text-align: center; font-weight: bold;">

            </td>
            <td></td>
            <td width="30" style="text-align: center;"></td>
            <td width="25">

            </td>
            <td width="20" style="text-align: center; font-weight: bold;">
                </div>
            </td>
            <td></td>
            <td width="30" style="text-align: center;"></td>
            <td width="25">

            </td>
        </tr>


        <tr>
            <td width="20" style="text-align: center; font-weight: bold;">

            </td>
            <td></td>
            <td width="30" style="text-align: center;"></td>
            <td width="25">

            </td>
            <td width="20" style="text-align: center; font-weight: bold;">
                </div>
            </td>
            <td></td>
            <td width="30" style="text-align: center;"></td>
            <td width="25">

            </td>
        </tr>


        <tr>
            <td width="20" style="text-align: center; font-weight: bold;">

            </td>
            <td></td>
            <td width="30" style="text-align: center;"></td>
            <td width="25">

            </td>
            <td width="20" style="text-align: center; font-weight: bold;">
                </div>
            </td>
            <td></td>
            <td width="30" style="text-align: center;"></td>
            <td width="25">

            </td>
        </tr>


        <tr>
            <td width="20" style="text-align: center; font-weight: bold;">

            </td>
            <td></td>
            <td width="30" style="text-align: center;"></td>
            <td width="25">

            </td>
            <td width="20" style="text-align: center; font-weight: bold;">
                </div>
            </td>
            <td></td>
            <td width="30" style="text-align: center;"></td>
            <td width="25">

            </td>
        </tr>


        <tr>
            <td width="20" style="text-align: center; font-weight: bold;">

            </td>
            <td></td>
            <td width="30" style="text-align: center;"></td>
            <td width="25">

            </td>
            <td width="20" style="text-align: center; font-weight: bold;">
                </div>
            </td>
            <td></td>
            <td width="30" style="text-align: center;"></td>
            <td width="25">

            </td>
        </tr>
    </table>

    <table cellpadding="0" cellspacing="0" style="width: 740px;">
        <tr>
            <td colspan="10" class="borderCimaFundo" style="height: 13px !important; padding: 5px;">
                <div align="center"><strong>JOGADORES ADVERTIDOS COM CART&Atilde;O AMARELO E VERMELHO (ORDEM
                        CRONOL&Oacute;GICA)</strong></div>
            </td>
        </tr>
    </table>

    <!TIME 1 ->
        <table cellpadding="0" cellspacing="0" style="width: 740px;">
            <tr>
                <td width="30" rowspan="8" style="text-align: center;">
                    <img style="width:40px;" src="{{ $sumula['team_1']->logo }}" />
                    <div style="width: 100%; text-transform: uppercase; padding-top:5px; font-weight: bold;">
                        {{ $sumula['team_1']->t_initials }} </div>
                </td>
                <td style="text-align:center;font-weight: bold;" width="20">N&ordm;</td>
                <td style="text-align:center;font-weight: bold;" width="20">
                    CA
                </td>
                <td style="text-align:center;font-weight: bold;" width="20">
                    CV / CVD
                </td>
                <td style="text-align:center;font-weight: bold;" width="20">Min</td>
                <td style="text-align:center;font-weight: bold;" width="20">1T / 2T</td>
                <td style="text-align:center; font-weight:bold;" width="120">Nome do Jogador</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>

        <!TIME 2 ->

            <table cellpadding="0" cellspacing="0" style="width: 740px;">
                <tr>
                    <td width="30" rowspan="8" style="text-align: center;">
                        <img style="width:40px;" src="{{ $sumula['team_2']->logo }}" />
                        <div style="width: 100%; text-transform: uppercase; padding-top:5px; font-weight: bold;">
                            {{ $sumula['team_2']->t_initials }} </div>
                    </td>
                    <td style="text-align:center;font-weight: bold;" width="20">N&ordm;</td>
                    <td style="text-align:center;font-weight: bold;" width="20">
                        CA
                    </td>
                    <td style="text-align:center;font-weight: bold;" width="20">
                        CV / CVD
                    </td>
                    <td style="text-align:center;font-weight: bold;" width="20">Min</td>
                    <td style="text-align:center;font-weight: bold;" width="20">1T / 2T</td>
                    <td style="text-align:center; font-weight:bold;" width="120">Nome do Jogador</td>
                </tr>


                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>

            <table cellpadding="0" cellspacing="0" style="width: 740px;">
                <tr>
                    <td style="height: 80px; text-align: center;  width: 80px; border-right: 1px whitesmoke solid;">
                        <img style="width:60px;" src="{{ $sumula['team_1']->logo }}" />
                    </td>

                    <td colspan="3" style="background-color:  whitesmoke;">
                        <div
                            style="width:90%; padding-left: 10px;  text-transform: uppercase; width:100%; font-size: 24px;">
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
                        <div
                            style="width:90%; padding-left: 10px;  text-transform: uppercase; width:100%; font-size: 24px;">
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
