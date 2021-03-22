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
        
        $eCodCamioneta            = $data->eCodCamioneta ? $data->eCodCamioneta : false;
        $tNombre                = $data->tNombre ? "'".utf8_encode($data->tNombre)."'" : ($data->tApellidos ? "'".utf8_encode($data->tApellidos)."'" : false);
        $tCodEstatus             = $data->tCodEstatus ? "'".utf8_encode($data->tCodEstatus)."'" : false;
        
		$eCodUsuario            = $_SESSION['sessionAdmin']['eCodUsuario'];
		

    if(!$eCodCamioneta)
        {
            $insert = " INSERT INTO CatCamionetas
            (
            tNombre,
            tCodEstatus
			)
            VALUES
            (
            $tNombre,
            $tCodEstatus
            )";
        }
        else
        {
            $insert = "UPDATE 
                            CatCamionetas
                        SET
                            tNombre= $tNombre ,
                            tCodEstatus= $tCodEstatus
                            WHERE
                            eCodCamioneta = ".$eCodCamioneta;
            
            
        }

        $pf = fopen("log.txt","w");
            fwrite($pf,$insert);
            fclose($pf);
        
        $rs = mysql_query($insert);
        
        $eCodCamioneta = $eCodCamioneta ? $eCodCamioneta : mysql_insert_id();

        if(!$rs)
        {
            $errores[] = 'Error de insercion/actualizacion del vehiculo '.mysql_error();
        }

if(!sizeof($errores))
{
    $tDescripcion = "Se ha insertado/actualizado el vehiculo ".sprintf("%07d",$eCodCamioneta);
    $tDescripcion = "'".$tDescripcion."'";
    $fecha = "'".date('Y-m-d H:i:s')."'";
    $eCodUsuario = $_SESSION['sessionAdmin']['eCodUsuario'];
    mysql_query("INSERT INTO SisLogs (eCodUsuario, fhFecha, tDescripcion) VALUES ($eCodUsuario, $fecha, $tDescripcion)");
}

echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores));

?>