<table>
<tr>
<td>C&oacute;digo</td>
<td>Nombre</td>
<td>Productos</td>
</tr>
<?php
include("./cnx/swgc-mysql.php");

$select = "select cp.eCodServicio as codigoPaquete, cp.tNombre, (SELECT COUNT(*) FROM RelServiciosInventario WHERE eCodServicio = cp.eCodServicio) eInventario FROM CatServicios cp ORDER BY cp.tNombre ASC";
$rsPaquetes = mysql_query($select);
while($rPaquete = mysql_fetch_array($rsPaquetes))
{
    print '<tr>';
    print '<td>'.sprintf("%07d",$rPaquete{'codigoPaquete'}).'</td>';
    print '<td>'.$rPaquete{'tNombre'}.'</td>';
    print '<td>'.$rPaquete{'eInventario'}.'</td>';
    print '</tr>';
}
?>
</table>