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
        
        $eCodCliente            = $data->eCodCliente ? $data->eCodCliente : false;
        
        $tNombre                = $data->tNombre ? "'".utf8_encode($data->tNombre)."'" : false;
        $tApellidos             = $data->tApellidos ? "'".utf8_encode($data->tApellidos)."'" : false;
        $tCorreo                = $data->tCorreo ? "'".$data->tCorreo."'" : false;
        $tTelefonoFijo          = $data->tTelefonoFijo ? "'".$data->tTelefonoFijo."'" : false;
        $tTelefonoMovil         = $data->tTelefonoMovil ? "'".$data->tTelefonoMovil."'" : false;
        $tComentarios           = $data->tComentarios ? "'".$data->tComentarios."'" : "'Sin comentarios'";
		$eCodUsuario            = $_SESSION['sessionAdmin']['eCodUsuario'];
		$fhFechaCreacion        = "'".date('Y-m-d H:i')."'";
		
		$bFrecuente            = $data->bFrecuente ? 1 : 0;

        if(!$tNombre)
            $errores[] = 'El nombre es obligatorio';

        if(!$tApellidos)
            $errores[] = 'Los Apellidos es obligatorio';

        if(!$tCorreo)
            $errores[] = 'El e-mail es obligatorio';

        if(!$tTelefonoFijo)
            $errores[] = 'El telefono fijo es obligatorio';

        if(!$tTelefonoMovil)
            $errores[] = 'El telefono movil es obligatorio';

        
        if(!sizeof($errores))
        {
    if(!$eCodCliente)
        {
            $insert = " INSERT INTO CatClientes
            (
            tNombres,
            tApellidos,
            tCorreo,
            tTelefonoFijo,
            tTelefonoMovil,
            eCodUsuario,
            fhFechaCreacion,
			eCodEstatus,
            tComentarios,
            bFrecuente
			)
            VALUES
            (
            $tNombre,
            $tApellidos,
            $tCorreo,
            $tTelefonoFijo,
            $tTelefonoMovil,
            $eCodUsuario,
            $fhFechaCreacion,
			3,
            $tComentarios,
            $bFrecuente
            )";
            
            $bTipo = 1;
        }
        else
        {
            $insert = "UPDATE 
                            CatClientes
                        SET
                            tNombres= $tNombre,
                            tApellidos= $tApellidos,
                            tCorreo= $tCorreo,
                            tTelefonoFijo= $tTelefonoFijo,
                            tTelefonoMovil= $tTelefonoMovil,
                            tComentarios = $tComentarios,
                            bFrecuente = $bFrecuente
                            WHERE
                            eCodCliente = ".$eCodCliente;
                            
                            $bTipo = 2;
        }
}
        
        
        $rs = mysql_query($insert);
        
        $eCodCliente = $eCodCliente ? $eCodCliente : mysql_insert_id();

        if(!$rs)
        {
            $errores[] = 'Error de insercion/actualizacion del cliente '.mysql_error();
        }

if(!sizeof($errores))
{
    $tDescripcion = "Se ha ".(($bTipo==1) ? 'insertado' : 'actualizado')." el cliente ".sprintf("%07d",$eCodCliente);
    $tDescripcion = "'".$tDescripcion."'";
    $fecha = "'".date('Y-m-d H:i:s')."'";
    $eCodUsuario = $_SESSION['sessionAdmin']['eCodUsuario'];
    mysql_query("INSERT INTO SisLogs (eCodUsuario, fhFecha, tDescripcion) VALUES ($eCodUsuario, $fecha, $tDescripcion)");
}

echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores));

?>