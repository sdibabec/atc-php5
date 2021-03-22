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

$valores = '<option value="">Seleccione...</option>';


$data = json_decode( file_get_contents('php://input') );

/*Preparacion de variables*/
 
		$eCodTipoInventario = $data->eCodTipoInventario;

$select = "SELECT eCodSubclasificacion,tNombre FROM CatSubClasificacionesInventarios WHERE eCodTipoInventario=$eCodTipoInventario";
$rsSubclasificaciones = mysql_query($select);

while($rSubclasificacion = mysql_fetch_array($rsSubclasificaciones))
{
   $valores .= '<option value="'.$rSubclasificacion{'eCodSubclasificacion'}.'">'.utf8_encode($rSubclasificacion{'tNombre'}).'</option>'; 
}


echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 0),'valores'=>$valores, 'errores'=>$errores));

?>