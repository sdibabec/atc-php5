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



    $eCodEvento = $data->eCodEventoOperador;
    $eCodCamioneta = $data->eCodCamioneta;
    $tCampo = $data->tCampo;
    $tOperador = "'".$data->tResponsable."'";
    
   
        
    mysql_query("UPDATE BitEventos SET eCodCamioneta = $eCodCamioneta, $tCampo = $tOperador WHERE eCodEvento = ".$eCodEvento);

echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores));

?>