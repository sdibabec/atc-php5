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
include("../inc/cot-clc.php");
require_once("../cls/cls-sistema.php");

$clSistema = new clSis();
session_start();

$bAll = $clSistema->validarPermiso($_GET['tCodSeccion']);


date_default_timezone_set('America/Mexico_City');

session_start();

$data = json_decode( file_get_contents('php://input') );

$eCodServicio = $data->eCodPaquete ? $data->eCodPaquete : false;
$fhFecha      = $data->fhFechaEvento ? explode("/",$data->fhFechaEvento) : false;

$fhFechaConsulta = $fhFecha[2].'-'.$fhFecha[1].'-'.$fhFecha[0];

$select = " SELECT * FROM CatServicios WHERE eCodServicio = $eCodServicio";
$rsServicio = mysql_query($select);
$rServicio = mysql_fetch_array($rsServicio);

$tHTML = '<table><tr><td colspan="3">'.$rServicio{'tNombre'}.'</td></tr>';
$tHTML .= '<tr><td colspan="3">Disponibles: <b>'.calcularPaquete($eCodServicio,$fhFechaConsulta).'</b></td></tr>';
$tHTML .= '<tr><td colspan="3" height="20"></td></tr>';

            $tHTML .= '<tr>';
            $tHTML .= '<td>Producto</td>';
            $tHTML .= '<td>Piezas Paq.</td>';
            $tHTML .= '<td>Piezas Disp.</td>';
            $tHTMl .= '</tr>';


$select = 	" SELECT  ".
					" 	rsi.ePiezas ePiezasPaquete,  ".
					" 	ci.ePiezas ePiezasInventario,  ".
					" 	ci.eCodInventario,  ".
					" 	ci.tNombre  ".
					" FROM  ".
					" 	RelServiciosInventario rsi  ".
					" INNER JOIN CatInventario ci ON ci.eCodInventario=rsi.eCodInventario  ".
					" WHERE rsi.eCodServicio = $eCodServicio";
		
		$rsProductos = mysql_query($select);
		while($rProducto = mysql_fetch_array($rsProductos))
		{
            $eDisponibles = calcularInventario($rProducto{'eCodInventario'},$fhFechaConsulta);
            
            $clase = ($eDisponibles < $rProducto{'ePiezasPaquete'}) ? 'class="status--denied"' :  '';
            
            $tHTML .= '<tr>';
            $tHTML .= '<td>'.$rProducto{'tNombre'}.'</td>';
            $tHTML .= '<td>'.$rProducto{'ePiezasPaquete'}.'</td>';
            $tHTML .= '<td '.$clase.'>'.$eDisponibles.'</td>';
            $tHTMl .= '</tr>';
            
		}

$tHTML .= '</table>';


echo json_encode(array('html'=>$tHTML));

?>