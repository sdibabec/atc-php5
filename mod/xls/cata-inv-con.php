<?php
require_once("../../cnx/swgc-mysql.php");
include_once("../../cls/xlsxwriter.class.php");
//ini_set('display_errors', 0);
//ini_set('log_errors', 1);
//error_reporting(E_ALL & ~E_NOTICE);

$filename = "ATC-Paquetes-".date('Y-m-d').".xlsx";
header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');

$writer = new XLSXWriter();
$writer->setAuthor('Antro en tu Casa'); 

$select = "SELECT ci.*, cti.tNombre tTipoInventario FROM CatInventario ci INNER JOIN CatTiposInventario cti ON cti.eCodTipoInventario=ci.eCodTipoInventario WHERE 1=1 ". 
            ($_GET['v1'] ? " AND ci.eCodInventario = ".$_GET['v1'] : "");

$rsPaquetes = mysql_query($select);


$row = array('Código','Tipo','Nombre','Marca','Descripción','Precio Interno','Precio Venta','Piezas');
 $writer->writeSheetRow('Sheet1', $row);

while($rPaquete = mysql_fetch_array($rsPaquetes))
{
    
    $row = array(
        sprintf("%07d",$rPaquete{'eCodInventario'}),
        utf8_encode($rPaquete{'tTipoInventario'}),
        utf8_decode($rPaquete{'tNombre'}),
        utf8_decode($rPaquete{'tMarca'}),
        utf8_decode($rPaquete{'tDescripcion'}),
        $rPaquete{'dPrecioInterno'},
        $rPaquete{'dPrecioVenta'},
        $rPaquete{'ePiezas'});
    
    $writer->writeSheetRow('Sheet1', $row);
   
}


$writer->writeToStdOut();
//$writer->writeToFile('example.xlsx');
//echo $writer->writeToString();
exit(0);

?>
