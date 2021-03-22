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

$pf = fopen("jsonInventarioPaquete.txt","w");
fwrite($pf,date('Y-m-d H:i:s')."\n");
fwrite($pf,json_encode($data)."\n\n");
fclose($pf);

/*Preparacion de variables*/
        
        $eCodServicio = $data->eCodServicio ? $data->eCodServicio : false;
        $tNombre = "'".utf8_encode($data->tNombre)."'";
        $tDescripcion = "'".base64_encode($data->tDescripcion)."'";
        $dPrecio = $data->dPrecio;
        $eHoras = $data->eHoras ? $data->eHoras : false;
        $dHoraExtra = $data->dHoraExtra ? $data->dHoraExtra : "NULL";

if(!trim($data->tNombre))
{
    $errores[] = 'El nombre es obligatorio';
}

if(!trim($data->tDescripcion))
{
    $errores[] = 'La descripcion es obligatorio';
}

if(!trim($data->dPrecio))
{
    $errores[] = 'El precio es obligaorio';
}

if(!$eHoras)
{
    $errores[] = 'Las horas de servicio son obligatorias';
}

 foreach($data->inventario as $inventario)
	       {  
	       	$eCodInventario   =   $inventario->eCodInventario ? $inventario->eCodInventario : false;
	       	$ePiezas          =   $inventario->ePiezas;
            
                if($eCodInventario && !(int)$ePiezas)
                       {
                           $errores[] = 'Las piezas deben ser enteras';
                       } 
            
                  
	       }
        
if(!sizeof($errores))
    {
    //mysql_query("START TRANSACTION");
    
        if(!$eCodServicio)
        {
            $insert = " INSERT INTO CatServicios
            (
            tNombre,
            tDescripcion,
            dPrecioVenta,
            dHoraExtra,
            eHoras
			)
            VALUES
            (
            $tNombre,
            $tDescripcion,
            $dPrecio,
            $dHoraExtra,
            $eHoras
            )";
            
            $bTipo = 1;
        }
        else
        {
            $insert = "UPDATE 
                            CatServicios
                        SET
                            tNombre= $tNombre,
                            tDescripcion= $tDescripcion,
                            dPrecioVenta= $dPrecio,
                            dHoraExtra = $dHoraExtra,
                            eHoras = $eHoras
                            WHERE
                            eCodServicio = ".$eCodServicio;
            
            $bTipo = 2;
        }
    
    
        $pf = fopen("logEdicionPaquete.txt","a");
fwrite($pf,$insert."\n");
fclose($pf);
        
        $rs = mysql_query($insert);

        if(!$rs)
        {
            $errores[] = 'Error de '.(($bTipo==1) ? 'inserción' : 'actualizacion').' del paquete '.mysql_error();
        }
        else
        {
        $select = "SELECT MAX(eCodServicio) eCodServicio FROM CatServicios";
        $rServicio = mysql_fetch_array(mysql_query($select));
		
		$eCodServicio = $eCodServicio ? $eCodServicio : $rServicio{'eCodServicio'};
		
		mysql_query("DELETE FROM RelServiciosInventario WHERE eCodServicio = $eCodServicio");
    
            $inventario = $data->inventario;
            
            
	       
            foreach($data->inventario as $inventario)
	       {
                
                
                
	       	$eCodInventario   =   $inventario->eCodInventario ? $inventario->eCodInventario : false;
	       	$ePiezas          =   $inventario->ePiezas;
                
                if($eCodInventario && $ePiezas && (int)$ePiezas)
                {
                   $rs = "INSERT INTO RelServiciosInventario (eCodServicio, eCodInventario, ePiezas) VALUES ($eCodServicio, $eCodInventario, $ePiezas)";
                   
                   $pf = fopen("logEdicionPaquete.txt","a");
                    fwrite($pf,$rs."\n");
                    fclose($pf);
                
	       	       if(!mysql_query($rs))
                        {
                            $errores[] = 'Error al agregar producto de inventario al paquete';
                        } 
                }
                
                
	       }
            
            $pf = fopen("logEdicionPaquete.txt","a");
fwrite($pf,"\n\n");
fclose($pf);
        }
    }

//mysql_query((!sizeof($errores)) ? "COMMIT TRANSACTION" : "ROLLBACK TRANSACTION");

if(!sizeof($errores))
{
    $tDescripcion = "Se ha ".(($bTipo==1) ? 'insertado' : 'actualizado')." el paquete ".sprintf("%07d",$eCodServicio);
    $tDescripcion = "'".$tDescripcion."'";
    $fecha = "'".date('Y-m-d H:i:s')."'";
    $eCodUsuario = $_SESSION['sessionAdmin']['eCodUsuario'];
    mysql_query("INSERT INTO SisLogs (eCodUsuario, fhFecha, tDescripcion) VALUES ($eCodUsuario, $fecha, $tDescripcion)");
}

echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 2), "errores"=>$errores));

?>