<?php
require_once("./cnx/swgc-mysql.php");
require_once("./cls/cls-sistema.php");
include("./inc/fun-ini.php");
$url = obtenerURL()."mod/ser/light-eve-det.php?eCodEvento=".$_GET['v1'];



$html=file_get_contents($url);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$html=str_replace('font-size:14px;','font-size:12px;',$html);


//echo $html; die();



//==============================================================
//==============================================================
//==============================================================


include("./mpdf/mpdf-2.php");
$mpdf=new mPDF('c'); 

$mpdf->mirrorMargins = true;

$mpdf->SetDisplayMode('fullpage','two');

$mpdf->WriteHTML($html);



$mpdf->Output();
exit;


//==============================================================
//==============================================================
//==============================================================
//==============================================================
//==============================================================


?>