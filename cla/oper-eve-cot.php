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

$pf = fopen("logCotizacion.txt","a");
fwrite($pf,json_encode($data)."\n\n");
fclose($pf);

        $eCodEvento = $data->eCodEvento ? $data->eCodEvento : false;
        $eCodCliente = $data->eCodCliente ? $data->eCodCliente : "NULL";
        $eCodUsuario = $_SESSION['sessionAdmin']['eCodUsuario'];
        //
        $fhFechaConsulta = $data->fhFechaEvento ? explode("/",$data->fhFechaEvento) : false;

        $fhFechaEvento = $fhFechaConsulta[2].'-'.$fhFechaConsulta[1].'-'.$fhFechaConsulta[0];

        $fhFechaEvento = $data->fhFechaEvento ? "'".$fhFechaEvento." ".$data->tmHoraServicio."'" : "NULL";
        //
        $tmHoraMontaje = "'".date('H:i', strtotime('-2 hours', strtotime($data->tmHoraServicio)))."'";
        //$tmHoraMontaje = $data->tmHoraMontaje ? "'".$data->tmHoraMontaje."'" : "NULL";
        $tDireccion = $data->tDireccion ? "'".base64_encode($data->tDireccion)."'" : "NULL";
        $tObservaciones = $data->tObservaciones ? "'".base64_encode($data->tObservaciones)."'" : "NULL";
        $bHoraExtra = $data->bHoraExtra ? $data->bHoraExtra : "NULL";
        $dHoraExtra = $data->dHoraExtra ? $data->dHoraExtra : "NULL";
        $eCodEstatus = $data->bFrecuente ? 2 : ($data->bExpress ? 2 : 1);
        $eCodTipoDocumento = 1;
        $bIVA = $data->bIVA ? $data->bIVA : "NULL";

        $bExpress = $data->bExpress ? $data->bExpress : "NULL";
        
        
        $fhFecha = "'".date('Y-m-d H:i:s')."'";

    $tDescripcion = "";

    if(!$data->eCodCliente){ $errores[] = 'El cliente es obligatorio'; }
    if(!$data->fhFechaEvento){ $errores[] = 'La fecha del evento es obligatoria'; }
    if(!$data->tmHoraServicio){ $errores[] = 'La hora de servicio es obligatoria'; }
    if(!$data->tDireccion){ $errores[] = 'La dirección es obligatoria'; }
    if((sizeof($data->paquete)<1 || sizeof($data->inventario)<1) && sizeof($data->extra)<2){ $errores[] = 'Debe agregar al menos un item'; }

    if(!sizeof($errores))
    {
        //Si no hubo errores previos
        if(!$eCodEvento)
        {
            $query = "INSERT INTO BitEventos (
                            eCodUsuario,
							eCodEstatus,
                            eCodCliente,
                            fhFechaEvento,
                            tmHoraMontaje,
                            tDireccion,
                            tObservaciones,
                            eCodTipoDocumento,
                            bIVA,
                            fhFecha,
                            bExpress)
                            VALUES
                            (
                            $eCodUsuario,
							$eCodEstatus,
                            $eCodCliente,
                            $fhFechaEvento,
                            $tmHoraMontaje,
                            $tDireccion,
                            $tObservaciones,
                            $eCodTipoDocumento,
                            $bIVA,
                            $fhFecha,
                            $bExpress)";
            
            $eTipo = 1;
        }
        else
        {
            $query = "UPDATE BitEventos SET
                            fhFechaEvento = $fhFechaEvento,
                            tmHoraMontaje = $tmHoraMontaje,
                            tDireccion = $tDireccion,
                            tObservaciones = $tObservaciones,
                            bIVA = $bIVA,
                            bExpress = $bExpress
                            WHERE eCodEvento = $eCodEvento";
            
            $eTipo = 2;
        }
            
           $sentencias = $query." \n\n";
            
            $rsEvento = mysql_query($query);
            if($rsEvento)
            {
                /*buscamos en caso de no recibir el eCodEvento */
                $buscar = mysql_fetch_array(mysql_query("SELECT MAX(eCodEvento) as eCodEvento FROM BitEventos WHERE eCodCliente = $eCodCliente AND eCodUsuario = $eCodUsuario ORDER BY eCodEvento DESC"));
                
                /*asignamos ecodEvento*/
                $eCodEvento = $eCodEvento ? $eCodEvento : $buscar{'eCodEvento'};
                
                mysql_query("DELETE FROM RelEventosPaquetes WHERE eCodEvento = $eCodEvento");
                mysql_query("DELETE FROM RelEventosExtras WHERE eCodEvento = $eCodEvento");
                
                $paquetes  = $data->paquete;
                $inventarios  = $data->inventario;
                $extras = $data->extra;
                
                foreach($paquetes as $cotizacion)
                {
                    $eCodServicio = $cotizacion->eCodServicio;
                    $eCantidad = $cotizacion->ePiezas;
                    $eCodTipo = 1;
                    $dMonto = $cotizacion->dMonto ? $cotizacion->dMonto : 0;
                    $bSuma = $cotizacion->bSuma ? 1 : 0;
                    $eHorasExtra = $cotizacion->eHorasExtra ? $cotizacion->eHorasExtra : 0;
                    
                    if($cotizacion->eCodServicio && $cotizacion->ePiezas)
                    {
                    
                        $dMonto = ($bSuma!=1) ? $dMonto : 0;
                        
                        $insert = "INSERT INTO RelEventosPaquetes (eCodEvento, eCodServicio, eCantidad,eCodTipo,dMonto,bSuma,eHorasExtra) VALUES ($eCodEvento, $eCodServicio, $eCantidad, $eCodTipo, $dMonto,$bSuma,$eHorasExtra)";
                    
                        $sentencias .= $insert." \n";
                    
                        $rs = mysql_query($insert);

                        if(!$rs)
                        {
                            $errores[] = 'Error al insertar el paquete en la cotización';
                        }
                    }
                    
                }
                
                foreach($inventarios as $cotizacion)
                {
                    $eCodServicio = $cotizacion->eCodInventario;
                    $eCantidad = $cotizacion->ePiezas;
                    $eCodTipo = 2;
                    $dMonto = $cotizacion->dMonto ? $cotizacion->dMonto : 0;
                    $bSuma = $cotizacion->bSuma ? 1 : 0;
                    
                    if($cotizacion->eCodInventario && $cotizacion->ePiezas)
                    {
                        
                        $dMonto = ($bSuma!=1) ? $dMonto : 0;
                    
                        $insert = "INSERT INTO RelEventosPaquetes (eCodEvento, eCodServicio, eCantidad,eCodTipo,dMonto,bSuma) VALUES ($eCodEvento, $eCodServicio, $eCantidad, $eCodTipo, $dMonto,$bSuma)";
                    
                        $sentencias .= $insert." \n";
                    
                        $rs = mysql_query($insert);

                        if(!$rs)
                        {
                            $errores[] = 'Error al insertar el paquete en la cotización';
                        }
                    }
                    
                }
                
                foreach($extras as $extra)
                {
                    $tDescripcionExtra   = $extra->tDescripcion ? "'".$extra->tDescripcion."'" : false;
                    $dImporte       = $extra->dImporte;
                    $bSuma          = $extra->bSuma ? 1 : 0;
                    
                    if($tDescripcionExtra)
                    {
                    $insert = "INSERT INTO RelEventosExtras (eCodEvento, tDescripcion, dImporte,bSuma) VALUES ($eCodEvento, $tDescripcionExtra, $dImporte,$bSuma)";
                    
                   $sentencias .= $insert." \n";
                    
                    $rs = mysql_query($insert);

                    if(!$rs)
                    {
                        $errores[] = 'Error al insertar el extra en la cotización';
                    }
                    }
                    
                }
                
                $tDescripcion = "Se ha ".(($eTipo==1) ? 'registrado' : 'actualizado')." el evento ".sprintf("%07d",$eCodEvento);
                $tDescripcion = "'".$tDescripcion."'";
                mysql_query("INSERT INTO SisLogs (eCodUsuario, fhFecha, tDescripcion) VALUES ($eCodUsuario, $fhFecha, $tDescripcion)");
                
                $pf = fopen("logs/logCotizacion".sprintf("%07d",$eCodEvento).".txt","a");
                fwrite($pf,$sentencias."\n\n");
                fclose($pf);
                
            }
            else
            {
                        $errores[] = 'Error al '.(($eTipo==1) ? 'insertar' : 'actualizar').' la cotización del evento';
            }
    }
        

echo json_encode(array("exito"=>((!sizeof($errores)) ? 1 : 0), 'errores'=>$errores));

?>