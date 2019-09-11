<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once("../../cnx/swgc-mysql.php");
require_once("../../cls/cls-sistema.php");
include("../../inc/fun-ini.php");
$url = obtenerURL()."mod/dip/light-dip-gen.php?eCodRegistro=".$_GET['v1'];

//echo $url; 
//die();

$html=file_get_contents($url);

$fichero = sprintf("%07d",$_GET['v1']).".html";

unlink ("./".fichero);

$pf = fopen($fichero,"w");
fwrite($pf,$html);
fclose($pf);
//echo '<textarea>'.file_get_contents($url).'</textarea>';

//$html=str_replace('font-size:14px;','font-size:12px;',$html);

$url = obtenerURL()."mod/dip/".$fichero;
$html=file_get_contents($url);
//echo $html; 

//die();



//==============================================================
//==============================================================
//==============================================================


include("../../mpdf/mpdf-2.php");
$mpdf=new mPDF('c'); 

$mpdf->mirrorMargins = true;

$mpdf->SetDisplayMode('fullpage','two');

$mpdf->WriteHTML($html);



$mpdf->Output();
exit;

//echo '<script>window.location="/das/inicio/consultar-sistema-dashboard/";</script>';
//==============================================================
//==============================================================
//==============================================================
//==============================================================
//==============================================================


?>