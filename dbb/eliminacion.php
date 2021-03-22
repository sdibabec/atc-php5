<?
$conexion = mysql_connect("localhost","emicapac_root","B@surto91");
mysql_select_db("emicapac_sge");
mysql_query("DELETE FROM SisSeccionesBotones WHERE eCodRegistro = 47");
?>