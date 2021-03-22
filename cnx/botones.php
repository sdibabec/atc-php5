<?
include("swgc-mysql.php");

mysql_query("DELETE FROM SisSeccionesBotones WHERE tCodpadre = 'sis-dash-con' AND tFuncion like '%verFecha%'");

$insert = "INSERT INTO `SisSeccionesBotones` (`eCodRegistro`, `tCodPadre`, `tCodSeccion`, `tCodBoton`, `tFuncion`, `tEtiqueta`, `ePosicion`) VALUES (NULL, 'sis-dash-con', 'sis-dash-con', 'CO', 'verFecha(\'inv\');', 'Disponibilidad de Inventario', '3'), (NULL, 'sis-dash-con', 'sis-dash-con', 'CO', 'verFecha(\'paq\');', 'Disponibilidad de Paquetes', '4');";
$rs = mysql_query($insert);
echo $rs ? 'Exito' : 'Error';
?>