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




$fhFecha      = $data->fhFechaConsulta ? explode("/",$data->fhFechaConsulta) : false;

$fhFechaConsulta = $fhFecha ? $fhFecha[2].'-'.$fhFecha[1].'-'.$fhFecha[0] : false;

$fhFecha = preg_match($regex,$fhFecha) ? $fhFecha : date('Y-m-d');

$tHTML = '<table class="table table-striped"><tr><td><b>Nombre</b></td><td>Piezas</td><td>Disponibles</td></tr>';

$select = " SELECT * FROM CatInventario ORDER BY tNombre ASC";
$rsProductos = mysql_query($select);

		while($rProducto = mysql_fetch_array($rsProductos))
		{
            $eDisponibles = calcularInventario($rProducto{'eCodInventario'},$fhFechaConsulta);
            
            $clase = ($rProducto{'ePiezas'}!=$eDisponibles) ? 'style="font-weight:bold;"' :  '';
            
            $tHTML .= '<tr>';
            $tHTML .= '<td '.$clase.'>'.$rProducto{'tNombre'}.'</td>';
            $tHTML .= '<td '.$clase.'>'.$rProducto{'ePiezas'}.'</td>';
            $tHTML .= '<td '.$clase.'>'.$eDisponibles.'</td>';
            $tHTMl .= '</tr>';
            
		}

$tHTML .= '</table>';


echo json_encode(array('html'=>$tHTML));

?>