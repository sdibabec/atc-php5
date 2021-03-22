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

$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bDelete'];

function detalle($eCodEvento)
{
      $select = "SELECT be.*, (cc.tNombres + ' ' + cc.tApellidos) as tNombre FROM BitEventos be INNER JOIN CatClientes cc ON cc.eCodCliente = be.eCodCliente WHERE be.eCodEvento = ".$eCodEvento;
$rsPublicacion = mysql_query($select);
$rPublicacion = mysql_fetch_array($rsPublicacion);

//clientes
$select = "	SELECT 
				cc.*, 
				su.tNombre as promotor
			FROM
				CatClientes cc
			
			LEFT JOIN SisUsuarios su ON su.eCodUsuario = cc.eCodUsuario
            ORDER BY cc.eCodCliente ASC";
    
$rsClientes = mysql_query($select);

       $detalle = '<table class="table table-responsive table-borderless table-top-campaign">
            <tr>
                <td>
                                Evento # '.sprintf("%07d",$rEvento{'eCodEvento'}).'<br>
                                Fecha: '.date('d/m/Y H:i',strtotime($rPublicacion{'fhFechaEvento'})).'<br>
                                Hora de Montaje: '.($rPublicacion{'tmHoraMontaje'}).' <br>
                                Responsable Entrega: '.($rPublicacion{'tOperadorEntrega'} ? $rPublicacion{'tOperadorEntrega'} : 'Pendiente').'<br>
                                Responsable Recolecci&oacute;n: '.($rPublicacion{'tOperadorRecoleccion'} ? $rPublicacion{'tOperadorRecoleccion'} : 'Pendiente').'
                </td>
            </tr>
            <tr>
                <td>  ';
                                 
     while($rPaquete = mysql_fetch_array($rsClientes))
{ 
                  $detalle .=(($rPublicacion{'eCodCliente'}==$rPaquete{'eCodCliente'}) ? $rPaquete{'tNombres'}.' '.$rPaquete{'tApellidos'}.' <br>'.$rPaquete{'tCorreo'}.'<br>Tel.'.$rPaquete{'tTelefonoFijo'}.'<br>Cel.'.$rPaquete{'tTelefonoMovil'} : '');
                  
} 
                            $detalle .='</td>
            </tr>
            <tr>
                            <td>
                                '.nl2br(base64_decode(utf8_decode($rPublicacion{'tDireccion'}))).'
                            </td>
            </tr>
            <tr>
                <td>
                    Descripci&oacute;n
                </td>
            </tr>';
											
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
                                                    while($rDetalle = mysql_fetch_array($rsDetalle))
                                                    { 
                                                         $detalle .='<b>x'.$rDetalle{'unidad'}.'</b> - '.($rDetalle{'tNombre'}).'<br>';
                                                    }
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
                                                            rep.dMonto
                                                        FROM CatInventario cs
                                                        INNER JOIN RelEventosPaquetes rep ON rep.eCodServicio = cs.eCodInventario and rep.eCodTipo = 2
                                                        WHERE rep.eCodEvento = ".$eCodEvento;
											$rsInventario = mysql_query($select);
                                            
    if($mysql_num_rows($rsInventario))
    {
       while($rInventario = mysql_fetch_array($rsInventario))
											{ 
											$detalle .='<tr>
                                                <td>
                                                    <b>'.$rInventario{'eCantidad'}.'</b> - '.utf8_decode($rInventario{'tNombre'}).'
                                                </td>
                                            </tr>';
											 }  
    }
											
            
        $detalle .='</table>';
                                                
                                            


    return $detalle;
}

function cargado($eCodEvento)
{
    $select = "SELECT * FROM SisRegistrosCargas src INNER JOIN RelRegistrosCargasInventario rrec ON rrec.eCodRegistro=src.eCodRegistro WHERE src.eCodEvento=$eCodEvento";
    $rsBusqueda = mysql_query($select);
    
    return mysql_num_rows($rsBusqueda) ? true : false;
}

date_default_timezone_set('America/Mexico_City');

session_start();

$errores = array();

$eventos = array();
$rentas = array();

$b = 0;

$data = json_decode( file_get_contents('php://input') );

$fhFechaConsulta = $data->fhFechaConsulta ? explode("/",$data->fhFechaConsulta) : false;

$fhFecha = $fhFechaConsulta[2].'-'.$fhFechaConsulta[1].'-'.$fhFechaConsulta[0];

//Fechas
$fhFechaInicio = $data->fhFechaConsulta ? date('Y-m-d',strtotime($fhFecha)).' 00:00:00' : date('Y-m-d').' 00:00:00';
$fhFechaTermino = $data->fhFechaConsulta ? date('Y-m-d',strtotime($fhFecha)).' 23:59:59' : date('Y-m-d').' 23:59:59';

//consulta eventos
$select = "SELECT be.*, cc.tNombres nombreCliente, cc.tApellidos apellidosCliente,
															su.tNombre as promotor, ce.tNombre Estatus, ce.tIcono FROM BitEventos be INNER JOIN CatClientes cc ON cc.eCodCliente = be.eCodCliente
															INNER JOIN CatEstatus ce ON ce.eCodEstatus = be.eCodEstatus
														LEFT JOIN SisUsuarios su ON su.eCodUsuario = be.eCodUsuario
                                                        WHERE
                                                        be.fhFechaEvento >= '$fhFechaInicio' AND be.fhFechaEvento<='$fhFechaTermino'".
                                                        " AND be.eCodEstatus<>4".
                                                        " AND be.eCodTipoDocumento=1".
                                                        " AND cc.eCodCliente <> 1".
												        //($bAll ? "" : " AND cc.eCodUsuario = ".$_SESSION['sessionAdmin']['eCodUsuario']).
														" ORDER BY be.fhFechaEvento DESC";


$rsEventos = mysql_query($select);
while($rEvento = mysql_fetch_array($rsEventos))
                                                    {
    
    $disabled = cargado($rEvento{'eCodEvento'}) ? 'disabled' : '';
    
                                                        $activa = $_SESSION['sessionAdmin']['bAll'] ? '' : 'disabled';
                                                       
                                        $eventos[] = '<div class="col-md-12">
                                <div class="card border border-primary">
                                    <div class="card-header">
                                        <strong class="card-title">
                                         <i class="'.$rEvento{'tIcono'}.'"></i> '.$rEvento{'nombreCliente'}.' '.$rEvento{'apellidosCliente'}.'
                                        </strong>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text"><b>Promotor: '.$rEvento{'promotor'}.'</b></p>
                                        <p class="card-text">
                                            Direcci&oacute;n: '.base64_decode($rEvento{'tDireccion'}).'<br>
                                            Estatus: <i class="'.$rEvento{'tIcono'}.'"></i> '.$rEvento{'Estatus'}.'<br>
                                            Fecha: '.date('d/m/Y H:i',strtotime($rEvento{'fhFechaEvento'})).'<br>
                                           
                                        </p>
                                        <br>
                                        
                                        <table width="100%">
                                        <tr>
                                            <td align="center">
                                            <button class="btn btn-light" onclick="consultarDetalle('.$rEvento{'eCodEvento'}.')"><i class="fa fa-eye"></i> [+] Detalles </button>
                                            </td><td>
                                            <button class="btn btn-light" onclick="cargarTransporte('.$rEvento{'eCodEvento'}.')" '.$disabled.'><i class="fas fa-truck-loading"></i> [+] Cargar</button>
                                            </td>
                                            
                                            </tr>
                                        </table>
                                        
                                      
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>';
    $b++;
                                                    }

//consulta rentas
$select = "SELECT be.*, cc.tNombres nombreCliente, cc.tApellidos apellidosCliente,
															su.tNombre as promotor, ce.tNombre Estatus, ce.tIcono FROM BitEventos be INNER JOIN CatClientes cc ON cc.eCodCliente = be.eCodCliente
															INNER JOIN CatEstatus ce ON ce.eCodEstatus = be.eCodEstatus
														LEFT JOIN SisUsuarios su ON su.eCodUsuario = be.eCodUsuario
                                                        WHERE
                                                        be.fhFechaEvento >= '$fhFechaInicio' AND be.fhFechaEvento<='$fhFechaTermino'".
                                                        " AND be.eCodEstatus<>4".
                                                        " AND be.eCodTipoDocumento=2".
                                                        " AND cc.eCodCliente <> 1".
												        //($bAll ? "" : " AND cc.eCodUsuario = ".$_SESSION['sessionAdmin']['eCodUsuario']).
														" ORDER BY be.fhFechaEvento DESC";

$rsEventos = mysql_query($select);
while($rEvento = mysql_fetch_array($rsEventos))
                                                    {
                                                        $activa = $_SESSION['sessionAdmin']['bAll'] ? '' : 'disabled';
    
                        $disabled = cargado($rEvento{'eCodEvento'}) ? 'disabled' : '';
                                                       
                                        $rentas[] = '<div class="col-md-12">
                                <div class="card border border-primary">
                                    <div class="card-header">
                                        <strong class="card-title">
                                         <i class="'.$rEvento{'tIcono'}.'"></i> '.$rEvento{'nombreCliente'}.' '.$rEvento{'apellidosCliente'}.'
                                        </strong>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text"><b>Promotor: '.$rEvento{'promotor'}.'</b></p>
                                        <p class="card-text">
                                            Direcci&oacute;n: '.base64_decode($rEvento{'tDireccion'}).'<br>
                                            Estatus: <i class="'.$rEvento{'tIcono'}.'"></i> '.$rEvento{'Estatus'}.'<br>
                                            Fecha: '.date('d/m/Y H:i',strtotime($rEvento{'fhFechaEvento'})).'<br>
                                           
                                        </p>
                                        <br>
                                        
                                        <table width="100%">
                                        <tr>
                                            <td align="center">
                                            <button class="btn btn-light" onclick="consultarDetalle('.$rEvento{'eCodEvento'}.')"><i class="fa fa-eye"></i> [+] Detalles </button>
                                            </td><td>
                                            <button class="btn btn-light" onclick="cargarTransporte('.$rEvento{'eCodEvento'}.')"  '.$disabled.'><i class="fas fa-truck-loading"></i> [+] Cargar</button>
                                            </td>
                                            
                                            </tr>
                                        </table>
                                        
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix" style="height:15px;"></div>';
    $b++;
                                                    }

echo json_encode(array('eventos'=>$eventos,'rentas'=>$rentas));

?>