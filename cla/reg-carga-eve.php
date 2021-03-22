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
session_start();

$errores = array();
$data = json_decode( file_get_contents('php://input') );

$eCodEvento = $data->eCodEventoCarga ? $data->eCodEventoCarga : "NULL";
$eCodUsuario = $_SESSION['sessionAdmin']['eCodUsuario'];
$fhFechaCarga = "'".date('Y-m-d H:i:s')."'";
$eCodCamioneta = $data->eCodCamioneta ? $data->eCodCamioneta : "NULL";

$insert = "INSERT INTO SisRegistrosCargas (eCodEvento, eCodUsuario, fhFechaCarga, eCodCamioneta) VALUES ($eCodEvento, $eCodUsuario, $fhFechaCarga, $eCodCamioneta)";

$rsInsert = mysql_query($insert);
if($rsInsert)
{
$rBusqueda = mysql_fetch_array(mysql_query("SELECT * FROM SisRegistrosCargas WHERE eCodEvento = $eCodEvento"));
$eCodRegistro = $rBusqueda{'eCodRegistro'};

    foreach($data->inventario as $inventario)
    {
        $eCodInventario = $inventario->eCodInventario ? $inventario->eCodInventario : "NULL";
        $eCantidad = $inventario->eCantidad ? $inventario->eCantidad : "NULL";
        $insert = "INSERT INTO RelRegistrosCargasInventario (eCodRegistro, eCodInventario, eCantidad) VALUES ($eCodRegistro, $eCodInventario, $eCantidad)";
        
        if(!mysql_query($insert))
        {
            $errores[] = "Error al guardar el producto en el evento de carga";
        }
    }
    
}
else
{
    $errores[] = "Error al guardar el registro de carga";
}

echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores));

?>