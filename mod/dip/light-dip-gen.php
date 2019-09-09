<?php
require_once("../../cnx/swgc-mysql.php");
require_once("../../cls/cls-sistema.php");
$clSistema = new clSis();
session_start();

$select = "SELECT bc.*,brc.eCodRegistro, su.tTitulo, su.tNombre, su.tApellidos FROM BitCursos bc INNER JOIN BitRegistrosCursos brc ON brc.eCodCurso=bc.eCodCurso INNER JOIN SisUsuarios su ON su.eCodUsuario=brc.eCodUsuario = ".$_GET['eCodRegistro'];
$rsRegistro = mysql_query($select);
$rRegistro = mysql_fetch_array($rsRegistro);



?>
<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <title>Detalle del Evento</title>
    <script src="//use.edgefonts.net/dynalight.js"></script>
    <style>
    .estilo
        {
            font-family: dynalight, sans-serif;
        }
    </style>
</head>

<body class="estilo" style="margin:0; padding:0;">
    <table width="612" height="792" style="background-image:url('<?=obtenerURL()?>cla/<?=$rRegistro{'tArchivoDiploma'};?>');">
    <tr>
        <td height="464" colspan="2"></td>
    </tr>
    <tr>
        <td height="198" valign="middle" align="center" colspan="2"><h3><?=utf8_encode($rRegistro{'tTitulo'}.' '.$rRegistro{'tNombre'}.' '.$rRegistro{'tApellidos'})?></h3></td>
    </tr>
    </table>
</body>
</html>

