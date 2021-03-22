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
require_once("../cls/cls-sistema.php");

$clSistema = new clSis();
session_start();

$bAll = $clSistema->validarPermiso($_GET['tCodSeccion']);


date_default_timezone_set('America/Mexico_City');

session_start();

$data = json_decode( file_get_contents('php://input') );

$eCodEvento = $data->eCodEvento ? $data->eCodEvento : $_GET['eCodEvento'];



      $select = "SELECT be.*, (cc.tNombres + ' ' + cc.tApellidos) as tNombre FROM BitEventos be INNER JOIN CatClientes cc ON cc.eCodCliente = be.eCodCliente WHERE be.eCodEvento = ".$eCodEvento;
$rsPublicacion = mysql_query($select);
$rPublicacion = mysql_fetch_array($rsPublicacion);

    $select = "SELECT cc.* FROM CatCamionetas cc INNER JOIN BitEventos be ON be.eCodCamioneta=cc.eCodCamioneta WHERE be.eCodEvento = ".$eCodEvento;
$rCamioneta = mysql_fetch_array(mysql_query($select));


       $detalle = '<table class="table table-borderless " width="100%">';
        $detalle .= '<tr><td>Veh&iacute;culo; '.(($rCamioneta{'eCodCamioneta'}) ? 'No Asignada - NO CARGAR' : $rCamioneta{'tNombre'}).' <input type="hidden" id="eCodCamioneta" name="eCodCamioneta" value="'.$rCamioneta{'eCodCamioneta'}.'"><br>
        Responsable Entrega: '.($rPublicacion{'tOperadorEntrega'} ? $rPublicacion{'tOperadorEntrega'} : 'Pendiente').'<br>
        Responsable Recolecci&oacute;n: '.($rPublicacion{'tOperadorRecoleccion'} ? $rPublicacion{'tOperadorRecoleccion'} : 'Pendiente').'
        </td></tr>';
      
                            
											
                                            $i = 0;
											$select = "	SELECT DISTINCT
															cs.tNombre,
                                                            cs.dPrecioVenta,
                                                            rep.eCodServicio,
                                                            rep.eCantidad,
                                                            cs.eCodServicio,
                                                            rep.dMonto
                                                        FROM CatServicios cs
                                                        INNER JOIN RelEventosPaquetes rep ON rep.eCodServicio = cs.eCodServicio and rep.eCodTipo = 1
                                                        WHERE rep.eCodEvento = ".$eCodEvento;
											$rsPaquetes = mysql_query($select);
                                            $dTotalEvento = 0;
											while($rPaquete = mysql_fetch_array($rsPaquetes))
											{
												
											$detalle .='<tr>
                <td>
                    <b>'.$rPaquete{'eCantidad'}.'</b> - '.utf8_decode($rPaquete{'tNombre'}).'<br>';
                    
                        $select = "SELECT 
															cti.tNombre as tipo, 
															ci.*,
															rti.ePiezas as unidad
														FROM
															CatInventario ci
															INNER JOIN CatTiposInventario cti ON cti.eCodTipoInventario = ci.eCodTipoInventario
															INNER JOIN RelServiciosInventario rti ON rti.eCodInventario=ci.eCodInventario
															WHERE
                                                             rti.eCodServicio = ".$rPaquete{'eCodServicio'}."
															ORDER BY ci.tNombre ASC";
                                                $rsDetalle = mysql_query($select);
                                                
                                                if(mysql_num_rows($rsDetalle))
                                                {
                                                    $detalle .= '<ul style="margin-left:15px;">';
                                                    while($rDetalle = mysql_fetch_array($rsDetalle))
                                                    { 
                                                         $detalle .='<li style="margin-left:15px;"><input type="checkbox" id="eCodInventario'.$i.'" name="inventario['.$i.'][eCodInventario]" value="'.$rDetalle{'eCodInventario'}.'" onclick="validarCarga()"> 
                                                         <input type="hidden" id="inventario['.$i.'][eCantidad]" name="inventario['.$i.'][eCantidad]" value="'.$rDetalle{'unidad'}.'">
                                                         <b>x'.$rDetalle{'unidad'}.'</b> - '.($rDetalle{'tNombre'}).'</li>';
                                                        $i++;
                                                    }
                                                    $detalle .= '</ul>';
                                                }
                                                    $detalle .='</td></tr>';
											
											$i++;
                                                $dTotalEvento = $dTotalEvento + ($rPublicacion{'dMonto'});
											 
                                            }
    
                                            $select = "	SELECT DISTINCT
															cs.tNombre,
                                                            cs.dPrecioVenta,
                                                            rep.eCodServicio,
                                                            rep.eCantidad,
                                                            rep.dMonto,
                                                            cs.eCodInventario
                                                        FROM CatInventario cs
                                                        INNER JOIN RelEventosPaquetes rep ON rep.eCodServicio = cs.eCodInventario and rep.eCodTipo = 2
                                                        WHERE rep.eCodEvento = ".$eCodEvento;
											$rsInventario = mysql_query($select);
                                            
    if(mysql_num_rows($rsInventario))
    {
       while($rInventario = mysql_fetch_array($rsInventario))
											{ 
											$detalle .='<tr>
                                                <td>
                                                    <input type="checkbox" id="eCodInventario'.$i.'" name="inventario['.$i.'][eCodInventario]" value="'.$rInventario{'eCodInventario'}.'" onclick="validarCarga()">
                                                    <input type="hidden" id="inventario['.$i.'][eCantidad]" name="inventario['.$i.'][eCantidad]" value="'.$rInventario{'eCantidad'}.'">
                                                    <b>'.$rInventario{'eCantidad'}.'</b> - '.utf8_decode($rInventario{'tNombre'}).'
                                                </td>
                                            </tr>';
           $i++;
											 }  
    }
											
            
        $detalle .='</table>';
                                                
                                            





echo json_encode(array('detalle'=>$detalle));

?>