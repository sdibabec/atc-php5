<? header('Access-Control-Allow-Origin: *');  ?>
<? header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method"); ?>
<? header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE"); ?>
<? header("Allow: GET, POST, OPTIONS, PUT, DELETE"); ?>
<? header('Content-Type: application/json'); ?>
<?

if (isset($_SERVER{'HTTP_ORIGIN'})) {
        header("Access-Control-Allow-Origin: {$_SERVER{'HTTP_ORIGIN'}}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

require_once("../cnx/swgc-mysql.php");
include("../inc/fun-ini.php");

session_start();

$errores = array();

$data = json_decode( file_get_contents('php://input') );

/*Preparacion de variables*/

$codigo = $data->eCodAccion ? $data->eCodAccion : $data->eAccion;
$accion = $data->tCodAccion ? $data->tCodAccion : $data->tAccion;

$eCodServicio = $data->eCodServicio ? $data->eCodServicio : false;
$eCodInventario = $data->eCodInventario ? $data->eCodInventario : false;

    $terms = explode(" ",$data->tNombre);
    
    $termino = "";
    
    for($i=0;$i<sizeof($terms);$i++)
    {
        $termino .= " AND tNombre like '%".$terms[$i]."%' ";
    }


$eLimit = $data->eMaxRegistros;
$bOrden = $data->rOrden;
$rdOrden = $data->rdOrden ? $data->rdOrden : 'eCodServicio';


switch($accion)
{
    case 'D':
        $select = "SELECT COUNT(*) ePaquetes FROM RelEventosPaquetes WHERE eCodTipo = 1 AND eCodServicio = $codigo";
        $rContador = mysql_fetch_array(mysql_query($select));
        if($rContador{'ePaquetes'}>=1)
        {
            $errores[] = 'El paquete se encuentra en '.$rContador{'ePaquetes'}.' cotizacion(es). Imposible eliminar';
        }
        else
        {
        $insert = "DELETE FROM CatServicios WHERE eCodServicio = ".$codigo;
        }
        break;
    case 'F':
        $insert = "UPDATE CatServicios SET eCodEstatus = 8 WHERE eCodServicio = ".$codigo;
        break;
    case 'C':
        $tHTML =  '<table class="table table-hover" width="100%">'.
        '<thead>'.
        '<tr>'.
        '<th class="text-right">C&oacute;digo</th>'.
        '<th>Nombre</th>'.
        //'<th>Descripci&oacute;n</th>'.
        '<th>Productos</th>'.
        '<th class="text-right">Precio</th>'.                   
        '</tr>'.
        '</thead>'.
        '<tbody>';
        /* hacemos select */
        $select = "SELECT DISTINCT
        cs.*, (SELECT COUNT(*) FROM RelServiciosInventario WHERE eCodServicio=cs.eCodServicio) eProductos
        FROM
		  CatServicios cs
        LEFT JOIN RelServiciosInventario rs ON rs.eCodServicio=cs.eCodServicio
		 WHERE 1=1 ".
        ($eCodServicio ? " AND cs.eCodServicio = $eCodServicio" : "").
        ($eCodInventario ? " AND rs.eCodInventario = $eCodInventario" : "").
        ($data->tNombre ? $termino : "").
		" ORDER BY $rdOrden $bOrden LIMIT 0, $eLimit ";
        
        $rsConsulta = mysql_query($select);
        while($rConsulta=mysql_fetch_array($rsConsulta)){
         /* validamos si est√° cargado */
           
            
            //imprimimos
       $tHTML .=    '<tr>'.
                    '<td>'.menuEmergenteJSON($rConsulta{'eCodServicio'},'cata-ser-con').'</td>'.
			        '<td>'.($rConsulta{'tNombre'}).'</td>'.
			        //'<td>'.substr(base64_decode($rConsulta{'tDescripcion'}),0,50).'</td>'.
			        '<td>'.($rConsulta{'eProductos'}).'</td>'.
                    '<td>'.number_format($rConsulta{'dPrecioVenta'},2).'</td>'.
                    '</tr>';
            //imprimimos
        }
        /* hacemos select */
        $tHTML .= '</tbody>'.
            '</table>';
        
        
        
        break;
}
        
 if(!sizeof($errores) && ($accion=="D" || $accion=="F"))
{       
        $rs = mysql_query($insert);

        if(!$rs)
        {
            $errores[] = 'Error al efectuar la operacion '.mysql_error();
        }

     if(!sizeof($errores))
     {
         $tDescripcion = "Se ha ".(($accion=="D") ? 'Eliminado' : 'Finalizado')." el paquete c®Ædigo ".sprintf("%07d",$codigo);
         $tDescripcion = "'".utf8_encode($tDescripcion)."'";
         $fecha = "'".date('Y-m-d H:i:s')."'";
         $eCodUsuario = $_SESSION['sessionAdmin']['eCodUsuario'];
         mysql_query("INSERT INTO SisLogs (eCodUsuario, fhFecha, tDescripcion) VALUES ($eCodUsuario, $fecha, $tDescripcion)");
     }
}

echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores,'registros'=>(int)mysql_num_rows($rsConsulta),"consulta"=>$tHTML));

?>