<!DOCTYPE <!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gerar PDF com PHP</title>
    <style type ="tetx/css">
        #cabecalho{
            background-color: #E7E7E9;

        }

        #img{
            height: 80px;
            width: 208px;
        }

        #nome_lab{
            color:#000000;
            width: 100%;
            text-align: center;
        }

        #dados_lab{
            height: 5%;
            color:#FFFFFF;
            background-color:#003A5F;
            text-align: center;
        }

        #linha{
            width:100%;
            height:5px;
            background-color:#F7B500;
        }

        #leg{
            width:30%;
            height: 50px;
            font-weight: bold;
            text-align: center;
            background-color: #E7E7E9;
        }

        #cont{
            width:70%;
            height: 50px;
            padding-left:20px;
            white-space: nowrap;
            background-color:#F9F9FB;
        }

        #leg2{
            width:30%;
            height: 160px;
            font-weight: bold;
            text-align: center;
            background-color: #E7E7E9;
        }

        #cont2{
            width:70%;
            height: 140px;
            padding-left:20px;
            background-color:#F9F9FB;
        }

        #img_banner{
            width:100%;
            height:250px;
            margin-top: 10px;
        }

    </style>
</head>
<body>
    <div id="cabecalho">
        <div id="logo">
            <img id="img" src="logo_uesc360.png"/>
        </div>
        <div id="nome_lab">
            <h1>Laboratório de Biologia Molecular</h1>
        </div>
    </div>
    <div id="dados_lab">
         <h2>Dados do Laboratório</h2>
    </div>

    <table id="linha_coordenador" style="width:100%">
        <tr>
          <td id="leg">Coordenador</td>
          <td id="cont">Fabianne florence Lucienne Michele</td>
        </tr>
    </table>

    <div id="linha"></div>

    <table id="linha_ramal" style="width:100%">
        <tr>
          <td id="leg">Ramal</td>
          <td id="cont">(73)3680-5427</td>
        </tr>
    </table>

    <div id="linha"></div>

    <table id="linha_site" style="width:100%">
        <tr>
          <td id="leg">Site</td>
          <td id="cont">nbcgib.uesc.br/genetica</td>
        </tr>
    </table>

    <div id="linha"></div>

    <table id="linha_descricao" style="width:100%">
        <tr>
          <td id="leg2">Descricão</td>
          <td id="cont2">Embrapa CNPQF, Embrapa, Cenargen , Ambrapa CPATU, Ceplac-BA, UEFS, UESB, IAC, UFGRBS. UNICAMP</td>
        </tr>
    </table>

  <div id="linha"></div>

    <table id="linha_atividades_realizadas" style="width:100%">
        <tr>
          <td id="leg">Atividades Realizadas</td>
          <td id="cont">Embrapa CNPQF, Embrapa, Cenargen</td>
        </tr>
    </table>

    <div id="linha"></div>

    <table id="linha_areas_atendidas" style="width:100%">
        <tr>
          <td id="leg">Áreas atendidas</td>
          <td id="cont">Pós-Graduação em Genética e Biologia Molecular</td>
        </tr>
    </table>

    <div id="linha"></div>

    <table id="linha_localizacao" style="width:100%">
        <tr>
          <td id="leg">Localização</td>
          <td id="cont">CBG - Centro de Biotecnologia e Genética</td>
        </tr>
    </table>

    <img id="img_banner" src="banner_uesc3603.png"/>

</body>
</html>
