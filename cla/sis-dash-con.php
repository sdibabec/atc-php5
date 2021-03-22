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


session_start();

require_once("../cnx/swgc-mysql.php");
include("../inc/fun-ini.php");
require_once("../cls/cls-sistema.php");

$clSistema = new clSis();
session_start();

$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bDelete'];

date_default_timezone_set('America/Mexico_City');

$errores = array();

$eventos = array();
$rentas = array();

$hoy = "'".date('Y-m-d H:i:s')."'";

$data = json_decode( file_get_contents('php://input') );

//$url = 'window.location=\''.obtenerURL().'ser/cata-eve-det/detalles-catalogo-eventos/v1/'.sprintf("%07d",$datos{'eCodEvento'});

function generarMenuEmergente($datos)
{
    $tHTML = '<div class="btn-group" style="width:100%;">'.
                '<button type="button" class="btn btn-secondary dropdown-toggle form-control" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones...</button>'.
                '<div class="dropdown-menu">'.
                '<a class="dropdown-item" href="#" onclick="consultarDetalle('.$datos{'eCodEvento'}.')"><i class="fa fa-eye"></i> Detalles</a>'.
                '<a class="dropdown-item" href="#" onclick="generarPDF(\''.sprintf("%07d",$datos{'eCodEvento'}).'\')"><i class="far fa-file-pdf"></i> PDF</a>'.
                '<a class="dropdown-item" href="#" onclick="agregarTransaccion('.$datos{'eCodEvento'}.')" data-toggle="modal" data-target="#myModal"><i class="fas fa-dollar-sign"></i> Nueva Transacci&oacute;n</a>'.
                ($datos['activa'] ? '<div class="dropdown-divider"></div>' : '').
                ($datos['activa'] ? '<a class="dropdown-item" href="#" onclick="agregarOperador('.$datos{'eCodEvento'}.')" data-toggle="modal" data-target="#myModalOperador" '.$datos['activa'].'><i class="fas fa-cog"></i> Configurar</a>' : '').
                ($datos['activa'] ? '<a class="dropdown-item" href="#" onclick="generarMaestra(\''.sprintf("%07d",$datos{'eCodEvento'}).'\')"'.$datos['activa'].'><i class="far fa-file-pdf"></i> Descargar Maestra</a>' : '').
                '</div>'.
                '</div>';
    
    return $tHTML;
}

function generarCuadro($datos)
{
    $html = '<div class="col-md-12">
                                <div class="card border border-primary" '.$datos['tColor'].'>
                                    <div class="card-header">
                                        <strong class="card-title">
                                         <i class="'.$datos{'tIcono'}.'"></i> '.$datos{'nombreCliente'}.' '.$datos{'apellidosCliente'}.'
                                        </strong>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text"><b>Promotor: '.$datos{'promotor'}.'</b></p>
                                        <p class="card-text">
                                            Direcci&oacute;n: '.base64_decode($datos{'tDireccion'}).'<br>
                                            Estatus: <i class="'.$datos{'tIcono'}.'"></i> '.$datos{'Estatus'}.'<br>
                                            Fecha: '.date('d/m/Y H:i',strtotime($datos{'fhFechaEvento'})).'<br>
                                           
                                        </p>
                                        <table width="100%">
                                        <tr>
                                            <td align="center"> <i class="fas fa-dollar-sign"></i></td>
                                            <td align="center"><i class="fas fa-shipping-fast"></i></td>
                                        </tr>
                                        <tr>
                                            <td align="center">'.(($datos['dImporte']>0) ? '<i class="fas fa-check-double"></i>' : '').'</td>
                                            <td align="center">'.(($datos['bExpress']>0) ? '<i class="fas fa-check-double"></i>' : '').'</td>
                                        </tr>
                                        </table>
                                        
                                        <br>
                                        '.(($datos{'eCodEstatus'}!=4) ? generarMenuEmergente($datos): '').'
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix" style="height:15px;"></div>';
    
    return $html;
}

function consultarMovimientos($eCodEvento)
{
    $select = "SELECT 
                (SELECT SUM(dMonto) 
                FROM BitTransacciones 
                WHERE eCodEvento = $eCodEvento) Transacciones,
                (SELECT SUM(dMonto) FROM RelEventosPaquetes WHERE eCodEvento = $eCodEvento) Importe,
                (SELECT SUM(dImporte) FROM RelEventosExtras WHERE eCodEvento = $eCodEvento) ImporteExtras,
                be.bIVA
                FROM
                BitEventos be
                WHERE be.eCodEvento = $eCodEvento";
    $rsEvento = mysql_query($select);
    $rEvento = mysql_fetch_array($rsEvento);
    
    $dTotal = ($rEvento{'bIVA'}) ? (($rEvento{'Importe'} + ($rEvento{'ImporteExtras'} ? $rEvento{'ImporteExtras'} : 0))*1.16) : ($rEvento{'Importe'} + ($rEvento{'ImporteExtras'} ? $rEvento{'ImporteExtras'} : 0));
    
    if(($dTotal-$rEvento{'Transacciones'})<1)
    {
        return true;
    }
    else
    {
        return false;
    }
}

$fhFechaConsulta = $data->fhFechaConsulta ? explode("/",$data->fhFechaConsulta) : false;

$fhFecha = $fhFechaConsulta[2].'-'.$fhFechaConsulta[1].'-'.$fhFechaConsulta[0];

//Fechas
$fhFechaInicio = $data->fhFechaConsulta ? date('Y-m-d',strtotime($fhFecha)).' 00:00:00' : date('Y-m-d').' 00:00:00';
$fhFechaTermino = $data->fhFechaConsulta ? date('Y-m-d',strtotime($fhFecha)).' 23:59:59' : date('Y-m-d').' 23:59:59';

//consulta eventos
$select = "SELECT be.*, cc.tNombres nombreCliente, cc.tApellidos apellidosCliente,
															su.tNombre as promotor, ce.tNombre Estatus, ce.tIcono, ce.tColor, TIMESTAMPDIFF(HOUR,$hoy,be.fhFechaEvento) Diferencia,
                                                            (SELECT SUM(dMonto) FROM BitTransacciones WHERE ecodEvento = be.eCodEvento) dImporte
                                                            FROM BitEventos be INNER JOIN CatClientes cc ON cc.eCodCliente = be.eCodCliente
															INNER JOIN CatEstatus ce ON ce.eCodEstatus = be.eCodEstatus
														LEFT JOIN SisUsuarios su ON su.eCodUsuario = be.eCodUsuario
                                                        WHERE
                                                        be.fhFechaEvento >= '$fhFechaInicio' AND be.fhFechaEvento<='$fhFechaTermino'".
                                                        //" AND be.eCodEstatus<>4".
                                                        " AND be.eCodTipoDocumento=1".
                                                        " AND cc.eCodCliente <> 1".
												        ($bAll ? "" : " AND cc.eCodUsuario = ".$_SESSION['sessionAdmin']['eCodUsuario']).
														" ORDER BY be.fhFechaEvento DESC";





$rsEventos = mysql_query($select);
while($rEvento = mysql_fetch_array($rsEventos))
                                                    {
                                                    
                                                    $tColor='';
    
                                                     if($rEvento{'bExpress'}>0) { $tColor = 'style="background:#ffcc5f;"';}
    
                                                    if(consultarMovimientos($rEvento{'eCodEvento'})) { $tColor = 'style="background:#ffC0cb;"';}
                                                    if($rEvento{'eCodEstatus'}==1 && $rEvento{'Diferencia'}<=168) { $tColor = 'style="background:#eb8f34;"';}
                                                    if($rEvento{'eCodEstatus'}==2) { $tColor = 'style="background:'.$rEvento{'tColor'}.';"';}
    
                                                    if($rEvento{'eCodEstatus'}==4) { $tColor = 'style="background:#3b3b3b; color:#FFFFFF;"';}
    
                                                        $activa = $_SESSION['sessionAdmin']['bAll'] ? true : false;
                                                       
     $datos = array(
                    'eCodEstatus'=>$rEvento{'eCodEstatus'},
                    'tColor'=>$tColor,
                    'tIcono'=>$rEvento{'tIcono'},
                    'nombreCliente'=>$rEvento{'nombreCliente'},
                    'apellidosCliente'=>$rEvento{'apellidosCliente'},
                    'promotor'=>$rEvento{'promotor'},
                    'tDireccion'=>$rEvento{'tDireccion'},
                    'Estatus'=>$rEvento{'Estatus'},
                    'fhFechaEvento'=>$rEvento{'fhFechaEvento'},
                    'eCodEvento'=>$rEvento{'eCodEvento'},
                    'dImporte'=>$rEvento{'dImporte'},
                    'bExpress'=>$rEvento{'bExpress'},
                    'activa'=>$activa
                    );
    
                                        $eventos[] = generarCuadro($datos);
                                                    }

//consulta rentas
$select = "SELECT be.*, cc.tNombres nombreCliente, cc.tApellidos apellidosCliente,
															su.tNombre as promotor, ce.tNombre Estatus, ce.tIcono , ce.tColor, TIMESTAMPDIFF(HOUR,$hoy,be.fhFechaEvento) Diferencia,
                                                            (SELECT SUM(dMonto) FROM BitTransacciones WHERE ecodEvento = be.eCodEvento) dImporte
                                                            FROM BitEventos be INNER JOIN CatClientes cc ON cc.eCodCliente = be.eCodCliente
															INNER JOIN CatEstatus ce ON ce.eCodEstatus = be.eCodEstatus
														LEFT JOIN SisUsuarios su ON su.eCodUsuario = be.eCodUsuario
                                                        WHERE
                                                        be.fhFechaEvento >= '$fhFechaInicio' AND be.fhFechaEvento<='$fhFechaTermino'".
                                                        //" AND be.eCodEstatus<>4".
                                                        " AND be.eCodTipoDocumento=2".
                                                        " AND cc.eCodCliente <> 1".
												        ($bAll ? "" : " AND cc.eCodUsuario = ".$_SESSION['sessionAdmin']['eCodUsuario']).
														" ORDER BY be.fhFechaEvento DESC";



$rsEventos = mysql_query($select);
while($rEvento = mysql_fetch_array($rsEventos))
                                                    {
                                                        $activa = $_SESSION['sessionAdmin']['bAll'] ? true : false;
                                                        
                                                        $tColor='';
                                                         if($rEvento{'bExpress'}>0) { $tColor = 'style="background:#ffcc5f;"';}
    
                                                    if(consultarMovimientos($rEvento{'eCodEvento'})) { $tColor = 'style="background:#ffC0cb;"';}
                                                    if($rEvento{'eCodEstatus'}==1 && $rEvento{'Diferencia'}<=168) { $tColor = 'style="background:#eb8f34;"';}
                                                    if($rEvento{'eCodEstatus'}==2) { $tColor = 'style="background:'.$rEvento{'tColor'}.';"';}
    
                                                    if($rEvento{'eCodEstatus'}==4) { $tColor = 'style="background:#3b3b3b; color:#FFFFFF;"';}
    
    
     $datos = array(
                    'eCodEstatus'=>$rEvento{'eCodEstatus'},
                    'tColor'=>$tColor,
                    'tIcono'=>$rEvento{'tIcono'},
                    'nombreCliente'=>$rEvento{'nombreCliente'},
                    'apellidosCliente'=>$rEvento{'apellidosCliente'},
                    'promotor'=>$rEvento{'promotor'},
                    'tDireccion'=>$rEvento{'tDireccion'},
                    'Estatus'=>$rEvento{'Estatus'},
                    'fhFechaEvento'=>$rEvento{'fhFechaEvento'},
                    'eCodEvento'=>$rEvento{'eCodEvento'},
                    'dImporte'=>$rEvento{'dImporte'},
                    'bExpress'=>$rEvento{'bExpress'},
                    'activa'=>$activa
                    );
                                                       
                                        $rentas[] = generarCuadro($datos);
                                                    }

echo json_encode(array('eventos'=>$eventos,'rentas'=>$rentas));

?>