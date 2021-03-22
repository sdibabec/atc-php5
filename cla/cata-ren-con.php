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

$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bDelete'];

$errores = array();

$data = json_decode( file_get_contents('php://input') );

/*Preparacion de variables*/

$codigo = $data->eCodAccion ? $data->eCodAccion : $data->eAccion;
$accion = $data->tCodAccion ? $data->tCodAccion : $data->tAccion;

$eCodEvento = $data->eCodEvento ? $data->eCodEvento : false;
$eCodCliente = $data->eCodCliente ? $data->eCodCliente : false;
$eCodEstatus = $data->eCodEstatus ? $data->eCodEstatus : false;
$fhFechaInicio = $data->fhFechaConsulta1 ? explode("/",$data->fhFechaConsulta1) : false;
$fhFechaFin = $data->fhFechaConsulta2 ? explode("/",$data->fhFechaConsulta2) : $fhFechaInicio;

$fhFecha1 = $fhFechaInicio[2].'-'.$fhFechaInicio[1].'-'.$fhFechaInicio[0];
$fhFecha2 = $data->fhFechaConsulta2 ? $fhFechaFin[2].'-'.$fhFechaFin[1].'-'.$fhFechaFin[0] : $fhFecha1;

$eLimit = $data->eMaxRegistros;
$bOrden = $data->rOrden;
$rdOrden = $data->rdOrden ? $data->rdOrden : 'eCodEvento';

switch($accion)
{
    case 'D':
        $insert = "UPDATE BitEventos SET eCodEstatus = 4 WHERE eCodEvento = ".$codigo;
        break;
    case 'F':
        $insert = "UPDATE BitEventos SET eCodEstatus = 8 WHERE eCodEvento = ".$codigo;
        break;
    case 'C':
        $tHTML =  '<table class="table table-hover" width="100%">'.
        '<thead>'.
        '<tr>'.
        '<th class="text-right">Codigo</th>'.
        '<th class="text-right">E</th>'.
        '<th class="text-right">C</th>'.
		'<th class="text-right">Cliente</th>'.
		'<th class="text-right">Fecha Evento (Hora de montaje)</th>'.
		'<th class="text-right">Promotor</th>'.                   
        '</tr>'.
        '</thead>'.
        '<tbody>';
        /* hacemos select */
        $select = "SELECT * FROM (SELECT 
        be.*, cc.tNombres nombreCliente, cc.tApellidos apellidosCliente,
        su.tNombre as promotor, ce.tIcono 
        FROM BitEventos be 
        INNER JOIN CatClientes cc ON cc.eCodCliente = be.eCodCliente
        INNER JOIN CatEstatus ce ON ce.eCodEstatus = be.eCodEstatus
		LEFT JOIN SisUsuarios su ON su.eCodUsuario = be.eCodUsuario".
        " WHERE be.eCodTipoDocumento=2 ".
		($bAll ? "" : " AND cc.eCodUsuario = ".$_SESSION['sessionAdmin']['eCodUsuario']).
        //($bAll ? "" : " AND be.eCodEstatus<>4").
        ($eCodEvento ? " AND be.eCodEvento = $eCodEvento" : "").
        ($eCodCliente ? " AND be.eCodCliente = $eCodCliente" : "").
        ($eCodEstatus ? " AND be.eCodEstatus = $eCodEstatus" : "").
        ($data->fhFechaConsulta1 ? " AND DATE(be.fhFechaEvento) BETWEEN  '$fhFecha1' AND '$fhFecha2'" : "").
        " LIMIT 0, $eLimit ".
		")N0 ORDER BY $rdOrden $bOrden";
		
        $rsConsulta = mysql_query($select);
        while($rConsulta=mysql_fetch_array($rsConsulta)){
         /* validamos si está cargado */
            $bCargado = (mysql_num_rows(mysql_query("SELECT * FROM SisRegistrosCargas WHERE eCodEvento = ".$rConsulta{'eCodEvento'}))) ? true : false;
            
            $arrEstados = array();
            $arrEstados[0] = true;
            $arrEstados[1] = ($rConsulta{'eCodEstatus'}==1 || $rConsulta{'eCodEstatus'}==2) ? true : false;
            $arrEstados[2] = true;
            $arrEstados[3] = ($rConsulta{'eCodEstatus'}==1 || $rConsulta{'eCodEstatus'}==2) ? true : false;
            $arrEstados[4] = ($rConsulta{'eCodEstatus'}==1 || $rConsulta{'eCodEstatus'}==2) ? true : false;
            $arrEstados[5] = ($rConsulta{'eCodEstatus'}==1 || $rConsulta{'eCodEstatus'}==2) ? true : false;
            
            //imprimimos
       $tHTML .=    '<tr>'.
                    '<td>'.menuEmergenteJSON($rConsulta{'eCodEvento'},'cata-ren-con',$arrEstados).'</td>'.
                    '<td align="center"><i class="'.$rConsulta{'tIcono'}.'"></i></td>'.
                    '<td align="center"><i class="fas fa-truck-moving" '.((!$bCargado) ? 'style="display:none;"' : '').'></i></td>'.
			        '<td>'.utf8_decode($rConsulta{'nombreCliente'}.' '.$rConsulta{'apellidosCliente'}).'</td>'.
			        '<td>'.date('d/m/Y H:i', strtotime($rConsulta{'fhFechaEvento'})).'</td>'.
			        '<td>'.utf8_decode($rConsulta{'promotor'}).'</td>'.
                    '</tr>';
            //imprimimos
        }
        /* hacemos select */
        $tHTML .= '</tbody>'.
            '</table>';
        break;
}
        
if($accion=="D" || $accion=="F")
{
    $rs = mysql_query($insert);

    if(!$rs)
    {
        $errores[] = 'Error al efectuar la operacion '.mysql_error();
    }

    if(!sizeof($errores))
    {
        $tDescripcion = "Se ha ".(($accion=="D") ? 'Eliminado' : 'Finalizado')." la renta código ".sprintf("%07d",$codigo);
        $tDescripcion = "'".utf8_encode($tDescripcion)."'";
        $fecha = "'".date('Y-m-d H:i:s')."'";
        $eCodUsuario = $_SESSION['sessionAdmin']['eCodUsuario'];
        mysql_query("INSERT INTO SisLogs (eCodUsuario, fhFecha, tDescripcion) VALUES ($eCodUsuario, $fecha, $tDescripcion)");
    }
    
    echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores));
    
}

echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores,'registros'=>(int)mysql_num_rows($rsConsulta),"consulta"=>$tHTML));

?>