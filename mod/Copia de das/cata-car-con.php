<?php
require_once("cnx/swgc-mysql.php");
require_once("cls/cls-sistema.php");


$clSistema = new clSis();
session_start();
$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bDelete'];

if($_GET['eCodEvento'])
{
    mysql_query("UPDATE BitEventos SET eCodEstatus = ".$_GET['eAccion']." WHERE eCodEvento =".$_GET['eCodEvento']);
    
        $fhFecha = "'".date('Y-m-d H:i:s')."'";
        $tDescripcion = "Se ha ".(($_GET['eAccion']==4) ? 'CANCELADO' : 'FINALIZADO')." el evento ".sprintf("%07d",$_GET['eCodEvento']);
        $tDescripcion = "'".$tDescripcion."'";
        $eCodUsuario = $_SESSION['sessionAdmin']['eCodUsuario'];
        mysql_query("INSERT INTO SisLogs (eCodUsuario, fhFecha, tDescripcion) VALUES ($eCodUsuario, $fhFecha, $tDescripcion)");
    
    echo '<script>window.location="?tCodSeccion=cata-eve-con";</script>';
              
}

?>
<script>
function detalles(codigo)
    {
        window.location="?tCodSeccion=cata-eve-det&eCodEvento="+codigo;
    }
function cancelar(codigo)
    {
        window.location="?tCodSeccion=cata-eve-con&eAccion=4&eCodEvento="+codigo;
    }
function finalizar(codigo)
    {
        window.location="?tCodSeccion=cata-eve-con&eAccion=8&eCodEvento="+codigo;
    }
function ruta(codigo)
    {
        window.location="?tCodSeccion=cata-eve-det&eCodEvento="+codigo+"&bRuta=1";
    }
</script>
<div class="row">
                            <div class="col-lg-12">
                                
                                
                                    <table class="display" id="table" width="100%">
                                        <thead>
                                            
                                            <tr>
                                                <th class="text-right">Registro</th>
                                                <th class="text-right">Evento</th>
                                                <th class="text-right">Usuario</th>
												<th class="text-right">Fecha</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?
											$select = "SELECT sec.*, su.tNombre, su.tApellidos FROM SisRegistrosCargas sec INNER JOIN SisUsuarios su ON su.eCodUsuario=sec.eCodUsuario ORDER BY sec.eCodRegistro DESC";
											
											//echo $select;
											$rsPublicaciones = mysql_query($select);
											
//echo $select;

while($rPublicacion = mysql_fetch_array($rsPublicaciones))
											{
    $edicion = ($clSistema->validarEnlace('oper-eve-reg'))  ? '' : 'style="display:none;" disabled';
    $detalle = ($clSistema->validarEnlace('cata-eve-det'))  ? '' : 'style="display:none;" disabled';
    $ruta    = ($_SESSION['sessionAdmin']['bAll'])       ? '' : 'style="display:none;" disabled';
    $bloqueo = $bAll ? '' : 'style="display:none;" disabled';
    
    $bCargado = (mysql_num_rows(mysql_query("SELECT * FROM SisRegistrosCargas WHERE eCodEvento = ".$rPublicacion{'eCodEvento'}))) ? true : false;
    
												?>
											<tr>
                                                <td><?=sprintf("%07d",$rPublicacion{'eCodRegistro'});?></td>
                                                <td><? menuEmergente($rPublicacion{'eCodEvento'}); ?></td>
												<td><?=utf8_decode($rPublicacion{'tNombre'}.' '.$rPublicacion{'tApellidos'})?></td>
												<td><?=date('d/m/Y H:i', strtotime($rPublicacion{'fhFecha'}))?></td>
                                            </tr>
											<?
											}
											?>
                                        </tbody>
                                    </table>
                                
                            </div>
                        </div>