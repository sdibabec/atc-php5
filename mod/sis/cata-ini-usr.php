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
                                
                                    <table class="display" id="tblLogs" width="100%">
                                        <thead>
                                            
                                            <tr>
                                                <td>#</td>
												<th>Fecha</th>
												<th>Usuario</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?
											$select = "	SELECT sl.*,su.tNombre as Usuario FROM SisUsuariosAccesos sl INNER JOIN SisUsuarios su ON su.eCodUsuario = sl.eCodUsuario ORDER BY sl.eCodRegistro DESC";
											$rsPublicaciones = mysql_query($select);
											while($rPublicacion = mysql_fetch_array($rsPublicaciones))
											{
												?>
											<tr>
                                                <td><?=utf8_decode($rPublicacion{'eCodRegistro'})?></td>
                                                <td><?=date('d/m/Y H:i:s',strtotime($rPublicacion{'fhFecha'}))?></td>
                                                <td><?=utf8_decode($rPublicacion{'Usuario'})?></td>
												
                                            </tr>
											<?
											}
											?>
                                        </tbody>
                                    </table>
                                
                            </div>
                        </div>