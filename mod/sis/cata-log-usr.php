<?php
require_once("cnx/swgc-mysql.php");
require_once("cls/cls-sistema.php");
$clSistema = new clSis();
session_start();
$bAll = $_SESSION['bAll'];
?>


<div class="row">
                            <div class="col-lg-12">
                                
                                <div class="table-data__tool">
                                    <div class="table-data__tool-left">
                                        
                                        
                                    </div>
                                    <div class="table-data__tool-right">
                                       <input class="au-input" id='search' placeholder='Búsqueda rápida...'> 
                                    </div>
                                </div>
                                <div class="table-responsive table--no-card m-b-40" style="max-height:500px; overflow-y: scroll;">
                                    <table class="table table-borderless table-striped table-earning" id="table">
                                        <thead>
                                            
                                            <tr>
												<th>Fecha</th>
												<th>Usuario</th>
                                                <th>Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?
											$select = "	SELECT sl.*,su.tNombre as Usuario FROM SisLogs sl INNER JOIN SisUsuarios su ON su.eCodUsuario = sl.eCodUsuario ORDER BY sl.eCodEvento DESC";
											$rsPublicaciones = mysql_query($select);
											while($rPublicacion = mysql_fetch_array($rsPublicaciones))
											{
												?>
											<tr>
                                                <td><?=date('d/m/Y H:i',strtotime($rPublicacion{'fhFecha'}))?></td>
                                                <td><?=utf8_decode($rPublicacion{'Usuario'})?></td>
												<td><?=utf8_decode($rPublicacion{'tDescripcion'})?></td>
                                            </tr>
											<?
											}
											?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>