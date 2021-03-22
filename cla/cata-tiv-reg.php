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

/*Preparacion de variables*/
        
        $eCodTipoInventario     = $data->eCodTipoInventario ? $data->eCodTipoInventario : false;
        $ePosicion              = $data->ePosicion          ? $data->ePosicion          : false;
        $tNombre                = $data->tNombre ? "'".utf8_encode($data->tNombre)."'" : false;
		$eCodUsuario            = $_SESSION['sessionAdmin']['eCodUsuario'];
		$fhFechaCreacion        = "'".date('Y-m-d H:i')."'";

        if(!$tNombre)
            $errores[] = 'El nombre es obligatorio';

        if(!$ePosicion)
            $errores[] = 'La posición es obligatoria';


        

        
        if(!sizeof($errores))
        {
    if(!$eCodTipoInventario)
        {
            $insert = " INSERT INTO CatTiposInventario
            (
            tNombre,
            ePosicion
			)
            VALUES
            (
            $tNombre,
            $ePosicion
            )";
        }
        else
        {
            $insert = "UPDATE 
                            CatTiposInventario
                        SET
                            tNombre= $tNombre,
                            ePosicion=$ePosicion
                            WHERE
                            eCodTipoInventario = ".$eCodTipoInventario;
        }
}
        
        
        $rs = mysql_query($insert);
        
        $eCodTipoInventario = $eCodTipoInventario ? $eCodTipoInventario : mysql_insert_id();

        if(!$rs)
        {
            $errores[] = 'Error de insercion/actualizacion del cliente '.mysql_error();
        }

if(!sizeof($errores))
{
    $tDescripcion = "Se ha insertado/actualizado el tipo de inventario ".sprintf("%07d",$eCodCliente);
    $tDescripcion = "'".$tDescripcion."'";
    $fecha = "'".date('Y-m-d H:i:s')."'";
    $eCodUsuario = $_SESSION['sessionAdmin']['eCodUsuario'];
    mysql_query("INSERT INTO SisLogs (eCodUsuario, fhFecha, tDescripcion) VALUES ($eCodUsuario, $fecha, $tDescripcion)");
}

echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores));

?>