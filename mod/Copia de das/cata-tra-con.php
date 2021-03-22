<?php
require_once("cnx/swgc-mysql.php");
require_once("cls/cls-sistema.php");


$clSistema = new clSis();
session_start();

$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bDelete'];

?>

<div class="row">
                            <div class="col-lg-12">
                                
                                
                                    <table class="display" id="table" width="100%">
                                        <thead>
                                            <tr>
												<th>C&oacute;digo</th>
												<th>Cotizacion</th>
                                                <th>Fecha</th>
                                                <th>Cliente</th>
                                                <th>Usuario</th>
                                                <th>Forma de Pago</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?
											$select = "SELECT bt.eCodTransaccion,bt.eCodEvento, bt.fhFecha, bt.eCodEvento, cc.tNombres as nombreCliente, cc.tApellidos as apellidosCliente, bt.dMonto, ctp.tNombre, (su.tNombre) as nombreUsuario, su.tApellidos as apellidosUsuario FROM BitTransacciones bt INNER JOIN CatTiposPagos ctp ON ctp.eCodTipoPago = bt.eCodTipoPago INNER JOIN BitEventos be ON be.eCodEvento = bt.eCodEvento INNER JOIN CatClientes cc ON cc.eCodCliente = be.eCodCliente INNER JOIN SisUsuarios su ON su.eCodUsuario = bt.eCodUsuario ORDER BY bt.eCodTransaccion DESC LIMIT 0,25";
                                            
                                           
                                            
											$rsPublicaciones = mysql_query($select);
											while($rPublicacion = mysql_fetch_array($rsPublicaciones))
											{
												?>
											<tr>
											    <td align="center"><?=sprintf("%07d",$rPublicacion{'eCodTransaccion'});?></td>
											    <td><? menuEmergente($rPublicacion{'eCodEvento'}); ?></td>
                                                
                                                <td><?=date('d/m/Y',strtotime($rPublicacion{'fhFecha'}))?></td>
												<td><?=utf8_decode($rPublicacion{'nombreCliente'} . ' '.$rPublicacion{'apellidosCliente'})?></td>
                                                <td><?=utf8_decode($rPublicacion{'nombreUsuario'}.' '.$rPublicacion{'apellidosUsuario'})?></td>
												<td><?=utf8_decode($rPublicacion{'tNombre'})?></td>
                                            </tr>
											<?
											}
											?>
                                        </tbody>
                                    </table>
                                
                            </div>
                            
                        </div>

