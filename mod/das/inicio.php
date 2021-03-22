<?php
require_once("cnx/swgc-mysql.php");
require_once("cls/cls-sistema.php");
require_once("lstTiposDocumentos.php");
$clSistema = new clSis();
session_start();

$bAll = $_SESSION['bAll'];

$fhFechaInicio = $_POST['fhFechaConsulta'] ? date('Y-m-d',strtotime("+1 month",strtotime($_POST['fhFechaConsulta']))).' 00:00:00' : date('Y-m-d').' 00:00:00';
$fhFechaTermino = $_POST['fhFechaConsulta'] ? date('Y-m-d',strtotime("+1 month",strtotime($_POST['fhFechaConsulta']))).' 23:59:59' : date('Y-m-d').' 23:59:59';

$fhFechaConsulta = $_POST['fhFechaConsulta'] ? date('Y-m-d',strtotime("+1 month",strtotime($_POST['fhFechaConsulta']))).' 00:00:00' : date('Y-m-d').' 00:00:00';

$fhFechaInicio = "'".$fhFechaInicio."'";
$fhFechaTermino = "'".$fhFechaTermino."'";


?>

<div class="row">
<!--calendario-->
    <div class="col-lg-12 au-card au-card--no-shadow au-card--no-pad m-b-40" >
        <div id="datepicker" onclick="obtenerFecha()"></div>
        <center>
        <form id="Datos" method="post" action="<?=$_SERVER['PHP_SELF']?>?tCodSeccion=inicio">
    <input type="hidden" name="fhFechaConsulta" id="datepicker1">
    <input type="submit" class="btn btn-info" value="Consultar">
    </form>
        </center>
    </div>
<!--calendario-->
<!--Listado de eventos de ese día-->

    <?
    for($i=0;$i<sizeof($lstTiposDocumentos);$i++)
    {
    
    $eCodTipoDocumento =   $lstTiposDocumentos[$i]['eCodTipoDocumento'];  
    $tNombre =  $lstTiposDocumentos[$i]['tNombre'];  
    $tEnlace =  $lstTiposDocumentos[$i]['enlace']; 
    $tFondo =  $lstTiposDocumentos[$i]['fondo']; 
    $select = "SELECT be.*, cc.tNombres nombreCliente, cc.tApellidos apellidosCliente,
															su.tNombre as promotor, ce.tNombre Estatus, ce.tIcono FROM BitEventos be INNER JOIN CatClientes cc ON cc.eCodCliente = be.eCodCliente
															INNER JOIN CatEstatus ce ON ce.eCodEstatus = be.eCodEstatus
														LEFT JOIN SisUsuarios su ON su.eCodUsuario = be.eCodUsuario
                                                        WHERE
                                                        be.fhFechaEvento between $fhFechaInicio AND $fhFechaTermino".
                                                        " AND be.eCodEstatus<>4".
                                                        " AND be.eCodTipoDocumento=$eCodTipoDocumento".
												        ($bAll ? "" : " AND cc.eCodUsuario = ".$_SESSION['sessionAdmin']['eCodUsuario']).
														" ORDER BY be.fhFechaEvento DESC";
														
$rsEventos = mysql_query($select);
    ?>
    
    <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <strong class="card-title">
                                            <i class="zmdi zmdi-account-calendar"></i> <?=$tNombre?> del d&iacute;a
                                            
                                                <? if($clSistema->validarEnlace('oper-<?=$tEnlace?>-reg')) { ?>
	                                            | <button onclick="window.location='index.php?tCodSeccion=oper-<?=$tEnlace?>-reg'" alt="Nuevo Evento" style="margin-left:30px;"><i class="zmdi zmdi-plus"></i> Nuevo</button>
                                           <? } ?>
                                           
                                        </strong>
                                    </div>
                                    <div class="card-body">
                                        <?
                                                if(mysql_num_rows($rsEventos))
                                                {
                                                    while($rEvento = mysql_fetch_array($rsEventos))
                                                    {
                                                        $activa = $_SESSION['sessionAdmin']['bAll'] ? '' : 'disabled';
                                                        ?>
                                        <div class="col-md-12">
                                <div class="card border border-primary">
                                    <div class="card-header">
                                        <strong class="card-title">
                                         <i class="<?=$rEvento{'tIcono'}?>"></i> <?=$rEvento{'nombreCliente'}.' '.$rEvento{'apellidosCliente'}?>
                                        </strong>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text"><b>Promotor: <?=$rEvento{'promotor'}?></b></p>
                                        <p class="card-text">
                                            Direcci&oacute;n: <?=base64_decode($rEvento{'tDireccion'})?><br>
                                            Estatus: <i class="<?=$rEvento{'tIcono'}?>"></i> <?=$rEvento{'Estatus'}?><br>
                                            Fecha: <?=date('d/m/Y H:i',strtotime($rEvento{'fhFechaEvento'}))?><br>
                                           
                                        </p>
                                        <br>
                                        <table width="100%">
                                        <tr>
                                            <td align="center">
                                            <button onclick="window.location='?tCodSeccion=cata-eve-det&eCodEvento=<?=$rEvento{'eCodEvento'}?>'"><i class="fa fa-eye"></i> Detalles</button>
                                            </td>
                                            <td align="center">
                                            <button onclick="agregarTransaccion(<?=$rEvento{'eCodEvento'}?>)" data-toggle="modal" data-target="#myModal"><i class="fas fa-dollar-sign"></i> Nueva Transacci&oacute;n</button>
                                            </td>
                                            <td align="center">
                                                <button onclick="agregarOperador(<?=$rEvento{'eCodEvento'}?>)" data-toggle="modal" data-target="#myModalOperador" <?=$activa?>><i class="fas fa-truck"></i> Asignar Responsable</button>
                                            </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                                            <?
                                                    }
                                                }
                                                else
                                                {
                                                    echo '<h2>No se han encontrado eventos en la fecha seleccionada</h2>';
                                                }
                                            ?>
                                    </div>
                                </div>
                            </div>
    
                                
    <?
    }
    ?>
                            
<!--Listado de eventos de ese día-->

</div>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.0.8/angular.min.js"></script>
<script src="https://rawgithub.com/cletourneau/angular-bootstrap-datepicker/master/dist/angular-bootstrap-datepicker.js" charset="utf-8"></script>
<script>



function obtenerFecha()
{
var fecha = $("#datepicker").datepicker( 'getDate' );
var fhFecha = new Date(fecha);

var mes = fhFecha.getMonth();
mes = mes+1;
document.getElementById('datepicker1').value = fhFecha;
/*document.getElementById('datepicker1').value = fhFecha.getDate()+'-'+mes+'-'+fhFecha.getFullYear();*/
   window.location="?tCodSeccion=inicio&fhFechaConsulta="+document.getElementById('datepicker1').value;
}
    
    $('#datepicker').datepicker();
</script>