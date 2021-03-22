<?php

include("./cnx/swgc-mysql.php");

$select = "SELECT eCodServicio, tDescripcion FROM CatServicios WHERE eCodServicio NOT IN (311,312)";
$rsPaquetes = mysql_query($select);
while($rPaquete = mysql_fetch_array($rsPaquetes))
{
    $tDescripcion = "'".base64_encode($rPaquete{'tDescripcion'})."'";
    
    mysql_query("UPDATE CatServicios SET tDescripcion = $tDescripcion WHERE eCodServicio = ".$rPaquete{'eCodServicio'});
}

?>