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

function base64toImage($datos)
{
    $fname = "../inv/".uniqid().'.jpg';
        $datos1 = explode(',', base64_decode($datos));
        $content = base64_decode($datos1[1]);
        //$img = filter_input(INPUT_POST, "image");
        //$img = str_replace(array('data:image/png;base64,','data:image/jpg;base64,'), '', base64_decode($data));
        //$img = str_replace(' ', '+', $img);
        //$img = base64_decode($img);
        
        //file_put_contents($fname, $img);
        
        $pf = fopen($fname,"w");
        fwrite($pf,$content);
        fclose($pf);
        
        return $fname;
}

$data = json_decode( file_get_contents('php://input') );

/*Preparacion de variables*/
        
        $eCodInventario = $data->eCodInventario ? $data->eCodInventario : false;
		$eCodTipoInventario = $data->eCodTipoInventario;
		$eCodSubclasificacion = $data->eCodSubclasificacion;
        $tNombre = "'".$data->tNombre."'";
        $tMarca = "'".$data->tMarca."'";
        $tDescripcion = "'".$data->tDescripcion."'";
        $dPrecioInterno = $data->dPrecioInterno;
        $dPrecioVenta = $data->dPrecioVenta;
        $ePiezas = $data->ePiezas;
        $eStock = $data->eStock;
        $tImagen = $data->bFichero ? "'".$data->tFichero."'" : ($data->tImagen ? "'".base64toImage(base64_encode($data->tImagen))."'" : "NULL");

if(!$eCodTipoInventario)
   $errores[] = 'El tipo de producto es obligatorio'; 

if(!$eCodSubclasificacion)
   $errores[] = 'La subclasificacion es obligatoria'; 

if(!$tNombre)
   $errores[] = 'El nombre de producto es obligatorio'; 

if(!$tMarca)
   $errores[] = 'La marca de producto es obligatorio'; 

if(!$tDescripcion)
   $errores[] = 'La descripcion de producto es obligatorio'; 

if(!$dPrecioInterno)
   $errores[] = 'El precio interno de producto es obligatorio'; 

if(!$dPrecioVenta)
   $errores[] = 'El precio de venta de producto es obligatorio'; 

if(!$ePiezas)
   $errores[] = 'Las piezas de producto son obligatorias'; 

if(!$eStock)
   $errores[] = 'El stock es obligatorio'; 


        
if(!sizeof($errores))
{
        if(!$eCodInventario)
        {
            $insert = " INSERT INTO CatInventario
            (
			eCodTipoInventario,
			eCodSubclasificacion,
            tNombre,
            tMarca,
            tDescripcion,
            dPrecioVenta,
			dPrecioInterno,
			tImagen,
			ePiezas,
			eStock
			)
            VALUES
            (
            $eCodTipoInventario,
            $eCodSubclasificacion,
            $tNombre,
            $tMarca,
            $tDescripcion,
            $dPrecioVenta,
			$dPrecioInterno,
			$tImagen,
			$ePiezas,
			$eStock
            )";
        }
        else
        {
            $insert = "UPDATE 
                            CatInventario
                        SET
                            eCodTipoInventario=$eCodTipoInventario,
                            eCodSubclasificacion=$eCodSubclasificacion,
            				tNombre=$tNombre,
            				tMarca=$tMarca,
            				tDescripcion=$tDescripcion,
            				dPrecioVenta=$dPrecioVenta,
							dPrecioInterno=$dPrecioInterno,
							tImagen=$tImagen,
							ePiezas=$ePiezas,
							eStock=$eStock
                            WHERE
                            eCodInventario = ".$eCodInventario;
        }
}
        
        $rs = mysql_query($insert);

        if(!$rs)
        {
            $errores[] = 'Error de insercion/actualizacion del producto en inventario '.mysql_error();
        }
        
        $eCodInventario = $eCodInventario ? $eCodInventario : mysql_insert_id();

if(!sizeof($errores))
{
    $tDescripcion = "Se ha insertado/actualizado el producto ".sprintf("%07d",$eCodInventario);
    $tDescripcion = "'".$tDescripcion."'";
    $fecha = "'".date('Y-m-d H:i:s')."'";
    $eCodUsuario = $_SESSION['sessionAdmin'][0]['eCodUsuario'];
    mysql_query("INSERT INTO SisLogs (eCodUsuario, fhFecha, tDescripcion) VALUES ($eCodUsuario, $fecha, $tDescripcion)");
}

echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores));

?>