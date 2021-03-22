<?php
require_once("cnx/swgc-mysql.php");
require_once("cls/cls-sistema.php");

$clSistema = new clSis();
session_start();

$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bDelete'];

?>

<div class="row">
                            <div class="col-lg-9">
                                <h2 class="title-1 m-b-25">Perfiles</h2>
                                <div class="table-responsive table--no-card m-b-40">
                                    <table class="table table-borderless table-striped table-earning">
                                        <thead>
                                            <tr>
                                                <th class="text-right"></th>
                                                <th>Perfil</th>
                                               
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
											<?
											$select = "	SELECT * FROM SisPerfiles";
											$rsPublicaciones = mysql_query($select);
											while($rPublicacion = mysql_fetch_array($rsPublicaciones))
											{
												?>
											<tr>
                                                <td><? menuEmergente($rPublicacion{'eCodPerfil'}); ?></td>
                                                <td><?=utf8_decode($rPublicacion{'tNombre'})?></td>
                                            </tr>
											<?
											}
											?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                
                                <div class="au-card au-card--bg-blue au-card-top-countries m-b-40">
                                    <div class="au-card-inner">
                                        <div class="table-responsive">
                                            <table class="table table-top-countries">
                                                <tbody>
													<tr>
														<td>Codigo</td>
														<td class="text-right">Fecha / hora</td>
													</tr>
													<?
													$select = "SELECT * FROM BitTransacciones ORDER BY ecodTransaccion DESC LIMIT 0,15";
													$rsTransacciones = mysql_query($select);
													while($rTransaccion = mysql_fetch_array($rsTransacciones))
													{
														?>
													<tr>
                                                        <td><?=sprintf("%07d",$rTransaccion{'eCodTransaccion'})?></td>
                                                        <td class="text-right"><?=date('d/m/Y H:i',strtotime($rTransaccion{'fhFecha'}))?></td>
                                                    </tr>
													<?
													}
													?>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>