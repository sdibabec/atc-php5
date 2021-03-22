<?php
require_once("../../cnx/swgc-mysql.php");
include_once("../../cls/xlsxwriter.class.php");
//ini_set('display_errors', 0);
//ini_set('log_errors', 1);
//error_reporting(E_ALL & ~E_NOTICE);

$filename = "ATC-".date('Y-m-d').".xlsx";
header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');

$rows = array();
$rows[] = array('Nombre','Apellidos','E-mail','Tel.','Cel.');

$select = "SELECT DISTINCT cc.* FROM CatClientes cc WHERE cc.eCodCliente IN (SELECT eCodCliente FROM BitEventos WHERE eCodEstatus=8 AND MONTH(fhFechaEvento) = ".$_POST['eMes'].")";
$rsClientes = mysql_query($select);
while($rCliente = mysql_fetch_array($rsClientes))
{
    $rows[] = array($rCliente{'tNombres'},$rCliente{'tApellidos'},$rCliente{'tCorreo'},$rCliente{'tTelefonoFijo'},$rCliente{'tTelefonoMovil'});
}

$writer = new XLSXWriter();
$writer->setAuthor('Antro en tu Casa'); 
foreach($rows as $row)
	$writer->writeSheetRow('Sheet1', $row);
$writer->writeToStdOut();
//$writer->writeToFile('example.xlsx');
//echo $writer->writeToString();
exit(0);


