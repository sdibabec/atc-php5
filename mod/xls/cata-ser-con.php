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

$select = "SELECT * FROM CatServicios WHERE 1=1 ". 
            ($_GET['v1'] ? " AND eCodServicio = ".$_GET['v1'] : "");

$rsPaquetes = mysql_query($select);


$row = array('Código','Nombre','Descripción','Precio Venta','Hora Extra');
 $writer->writeSheetRow('Sheet1', $row);

while($rPaquete = mysql_fetch_array($rsPaquetes))
{
    
    $row = array(sprintf("%07d",$rPaquete{'eCodServicio'}),utf8_encode($rPaquete{'tNombre'}),base64_decode($rPaquete{'tDescripcion'}),$rPaquete{'dPrecioVenta'},$rPaquete{'dHoraExtra'});
    
    $writer->writeSheetRow('Sheet1', $row);
    
   
    $select = "	SELECT 
					cti.tNombre as tipo, 
					ci.*,
					rti.ePiezas as unidad
				FROM
					CatInventario ci
					INNER JOIN CatTiposInventario cti ON cti.eCodTipoInventario = ci.eCodTipoInventario
					INNER JOIN RelServiciosInventario rti ON rti.eCodInventario=ci.eCodInventario
					WHERE
					 rti.eCodServicio = ".$rPaquete{'eCodServicio'}."
					ORDER BY cti.ePosicion ASC, ci.tNombre ASC";
    $rsDesgloses = mysql_query($select);
    while($rDesglose = mysql_fetch_array($rsDesgloses))
    {
        $desglose = array('*',$rDesglose{'unidad'},utf8_decode($rDesglose{'tipo'}),($rDesglose{'tNombre'}),utf8_decode($rDesglose{'tMarca'}));
        $writer->writeSheetRow('Sheet1', $desglose);
    } 
    
    $row = array('*****','*****','*****','*****','*****');
    
    $writer->writeSheetRow('Sheet1', $row);
}


$writer->writeToStdOut();
//$writer->writeToFile('example.xlsx');
//echo $writer->writeToString();
exit(0);

?>
