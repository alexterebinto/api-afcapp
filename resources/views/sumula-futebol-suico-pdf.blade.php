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
    <div id="bodySumula"
        style=" background-color:white; width:1080px; height:720px; border:1px black  solid; padding-top:5px; ">

        <div id="cabecalhoSumula"
            style="background-color:white; width:191px; height:130px; float:left; text-align: center; ">
            <img style="width:90px;" src="{{ $sumula['team_1']->logo }}" />

        </div>

        <div id="cabecalhoSumula2" style="background-color:white; width:700px; height:130px; float:left; ">
            <table style="width: 100%; border: 1px black solid; border-radius: 0px;">
                <tr>
                    <td colspan="5"
                        style="background-color: white; font-size: 20px; font-weight:bold; text-align: center; text-transform: uppercase; ">
                        {{ $sumula['tournament']->name }} </td>

                </tr>

                <tr>
                    <td colspan="5"
                        style="background-color: lightgray; FONT-SIZE:20PX;  text-align: center;  text-transform: uppercase; ">
                        SUMULA
                        OFICIAL - {{ $sumula['match']->m_date }} {{ $sumula['match']->m_time }}</td>

                </tr>

                <tr>
                    <td style="text-transform: uppercase; background-color: white; border:1px black solid; text-align: center; font-size: 16px;  "
                        width="25%">
                        {{ $sumula['team_1']->t_initials }}</td>
                    <td style="background-color: white; border:1px black solid;" width="15%"></td>
                    <td style="background-color: white; text-align: center; font-size: 18px; font-weight:bold; border:1px black solid;"
                        width="10%">X</td>
                    <td style="background-color: white; border:1px black solid;" width="15%"></td>
                    <td style="text-transform: uppercase; background-color: white; border:1px black solid; text-align: center; font-size: 16px;  "
                        width="25%">
                        {{ $sumula['team_2']->t_initials }}</td>
                </tr>


            </table>
        </div>

        <div id="cabecalhoSumula3"
            style="background-color:white; width:189px; height:130px; float:right; text-align: center;">
            <img style="width:90px;" src="{{ $sumula['team_2']->logo }}" />
        </div>

        <div
            style="background-color:white; width:528px; height:607px; text-align: center; position:absolute; margin-top:100px; left:6px; top:10px;">
            <table class="editorDemoTable" style="width:350px; height: 147px;">
                <tbody>
                    <tr>
                        <td style="width: 200px;" colspan="2" rowspan="2"><strong>Coritibaa <br /></strong></td>
                        <td style="width: 60px; text-align: center;" colspan="2"><strong>Cart&otilde;es</strong></td>
                    </tr>
                    <tr>
                        <td style="width: 27.6667px;">AM</td>
                        <td style="width: 24.3333px;">VE</td>
                    </tr>
                    <tr>
                        <td style="width:100px;">Treinador:</td>
                        <td style="width: 177.483px;">&nbsp;</td>
                        <td style="width: 27.6667px;">&nbsp;</td>
                        <td style="width: 24.3333px;">&nbsp;</td>
                    </tr>

                    <tr>
                        <td style="width:100px;">&nbsp;Assinatura Capit&atilde;o</td>
                        <td style="width: 177.483px; text-align: right;">N:</td>
                        <td style="width: 60px;" colspan="2">&nbsp;</td>
                    </tr>
                </tbody>
            </table>

            <table style="height: 80px; width: 110px; position: absolute;  left:365px; top:10px;">
                <tbody>
                    <tr>
                        <td style="width: 35.4833px;">Data :</td>
                        <td style="width: 90.517px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="width: 35.4833px;">Hor&aacute;rio:</td>
                        <td style="width: 90.517px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="width: 35.4833px;">Local:</td>
                        <td style="width: 90.517px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="width: 35.4833px;">Competi&ccedil;&atilde;o:</td>
                        <td style="width: 90.517px;">&nbsp;</td>
                    </tr>
                </tbody>
            </table>





        </div>

        <div
            style="background-color:green; width:528px; height:607px; text-align: center; position:absolute; margin-top:100px; left:546px; top:10px;">

        </div>






    </div>





</body>

</html>
