<?php
require("../cnx/swgc-mysql.php");

date_default_timezone_set('America/Mexico_City');

$hoy = "'".date('Y-m-d H:i:s')."'";

$select = "SELECT eCodEvento, TIMESTAMPDIFF(HOUR,$hoy,fhFechaEvento) Diferencia,TIMESTAMPDIFF(HOUR,fhFecha,fhFechaEvento) Generacion FROM BitEventos WHERE fhFechaEvento > $hoy and eCodEstatus=1 and fhfecha < $hoy";

echo $select.'<br><br>';

$pf = fopen("logCancelaciones.txt","a");
fwrite($pf,"Ejecucion: ".date('d/m/Y H:i:s')."\n");
fclose($pf);

$rsEventos = mysql_query($select);
while($rEvento = mysql_fetch_array($rsEventos))
{
    $eCodEstatus =4;
    if($rEvento{'Generacion'}>72 && $rEvento{'Diferencia'}<=72)
    {
    $update = "UPDATE BitEventos SET eCodEstatus=4 WHERE eCodEvento = ".$rEvento{'eCodEvento'};
    echo $update.'<br><br>';
    mysql_query($update);
    }
    
    if($rEvento{'Generacion'}<72 && $rEvento{'Generacion'}>24 && $rEvento{'Diferencia'}<=24)
    {
    $update = "UPDATE BitEventos SET eCodEstatus=4 WHERE eCodEvento = ".$rEvento{'eCodEvento'};
    echo $update.'<br><br>';
    mysql_query($update);
    }
    
    if($rEvento{'Generacion'}<24 && $rEvento{'Diferencia'}<=12)
    {
    $update = "UPDATE BitEventos SET eCodEstatus=4 WHERE eCodEvento = ".$rEvento{'eCodEvento'};
    echo $update.'<br><br>';
    mysql_query($update);
    }
}

?>