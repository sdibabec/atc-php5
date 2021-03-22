<?php
require_once("cnx/swgc-mysql.php");
require_once("cls/cls-sistema.php");
$clSistema = new clSis();
session_start();
$select = "SELECT * FROM CatClientes WHERE eCodCliente = ".$_GET['v1'];
$rsCliente = mysql_query($select);
$rCliente = mysql_fetch_array($rsCliente);
?>
<div class="row">
                            <div class="col-lg-12">
                                
                                <div class="col-md-6">
                                <div class="form-group">
                                    
                                    <label>Nombre(s)</label>
              <?=$rCliente{'tNombres'}?>
                                    </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                    <label>Apellido(s)</label>
              <?=$rCliente{'tApellidos'}?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                <div class="form-group">
                                    <label>E-mail</label>
              <?=$rCliente{'tCorreo'}?>
                                </div>
                                    </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                    
                                    <label>Teléfono Fijo</label>
              <?=$rCliente{'tTelefonoFijo'}?>
                                    </div>
                                </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                    <label>Teléfono Móvil</label>
              <?=$rCliente{'tTelefonoMovil'}?>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                <div class="form-group">
                                    <label>Comentarios</label>
              <?=$rCliente{'tComentarios'}?>
                                </div>
                                    </div>
                            </div>
    
    
                            <div class="col-lg-12">
                                
                                    <div class="card card-body card-block">
                                    <table class="table table-responsive table-borderless table-top-campaign" id="table" width="100%">
                                        <thead>
                                            
                                            <tr>
                                                <th></th>
                                                <th>Evento</th>
												<th># Conceptos</th>
                                                <th>Fecha del evento</th>
                                                <th>Detalles</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?
                                            $i = 0;
											$select = "	SELECT be.eCodEvento, be.fhFechaEvento, (SELECT COUNT(*) FROM RelEventosPaquetes WHERE eCodEvento = be.eCodEvento) as Conceptos, ce.tIcono FROM BitEventos be INNER JOIN CatEstatus ce ON ce.eCodEstatus = be.eCodEstatus WHERE be.eCodCliente = ".$_GET['eCodCliente']." ORDER BY be.eCodEvento DESC";
											$rsPublicaciones = mysql_query($select);
                                            
											while($rPublicacion = mysql_fetch_array($rsPublicaciones))
											{
												?>
											<tr>
                                                <td align="center"><i class="<?=$rPublicacion{'tIcono'}?>"></i></td>
                                                <td valign="top"><?=sprintf("%07d",$rPublicacion{'eCodEvento'})?></td>
                                                <td>
                                                  <?=$rPublicacion{'Conceptos'}?> conceptos totales
                                                </td>
                                                <td align="center" valign="top">
                                                    <?=date('d/m/Y',strtotime($rPublicacion{'fhFechaEvento'}))?>
                                                </td>
                                                <td>
                                                    <a href="?tCodSeccion=cata-eve-det&eCodEvento=<?=$rPublicacion{'eCodEvento'}?>" target="_blank" class="btn btn-info">Ver Detalles</a>
                                                </td>
                                            </tr>
											<?
											$i++;
											}
												?>
                                        </tbody>
                                    </table>
      
                                    </div>
                                </div>
                        </div>