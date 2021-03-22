<?php
require_once("cnx/swgc-mysql.php");
require_once("cls/cls-sistema.php");
$clSistema = new clSis();
session_start();
$select = "SELECT * FROM CatServicios WHERE eCodServicio = ".$_GET['v1'];
$rsPaquete = mysql_query($select);
$rPaquete = mysql_fetch_array($rsPaquete);
?>
<div class="row">
                            <div class="col-lg-12 card">
                                
                                
                                    <table class="table  table-striped" width="100%">
                                        <tr class="thead-dark">
                                            <td>Nombre</td>
                                        </tr>
                                            <tr>
                                            <td><?=utf8_encode($rPaquete{'tNombre'})?></td>
                                                </tr><tr>
                                            <td class="thead-dark">Descripci&oacute;n</td>
                                        </tr><tr>
                                            <td align="left"><div style="max-height:200px; overflow-y:scroll;"><?=nl2br(base64_decode($rPaquete{'tDescripcion'}));?></div></td>
                                        </tr>
                                        <tr class="thead-dark">
                                            <td>Precio de Venta</td>
                                        </tr><tr>
                                            <td colspan="4">$<?=$rPaquete{'dPrecioVenta'}?></td>
                                        </tr>
                                        
                                    </table>
                                
                            </div>
    
    <!--separador-->
    <div class="clearfix" style="padding:10px;"><img src="/images/separador.jpg" class="img-responsive" style="width:100%;"></div>
    <!--separador-->
	
							<div class="col-lg-12 card">
                                
                                 <!--tabs-->
        <?
                                
        $select = "SELECT
                        ci.tNombre tInventario,
                        ct.tNombre tTipoInventario,
                        ri.ePiezas
                    FROM
                        CatInventario ci
                    INNER JOIN CatTiposInventario ct ON ct.eCodTipoInventario=ci.eCodTipoInventario
                    INNER JOIN RelServiciosInventario ri ON ri.eCodInventario=ci.eCodInventario
                    WHERE ri.eCodServicio=".$rPaquete{'eCodServicio'}.
            " ORDER BY ct.ePosicion ASC";
        $rsInventario = mysql_query($select);
        $tInventario = "";
    ?>
        <table class="table table-hover" width="100%">
        <? while($rInventario = mysql_fetch_array($rsInventario)) { ?>
        <? if($tInventario!=$rInventario{'tTipoInventario'}) { ?>
        <tr>
            <td colspan="2"><b><?=utf8_encode($rInventario{'tTipoInventario'});?></b></td>
            </tr>
        <? $tInventario = $rInventario{'tTipoInventario'}; ?>
        <? } ?>
        <tr>
            <td><?=utf8_encode($rInventario{'tInventario'});?></td>
            <td><?=utf8_encode($rInventario{'ePiezas'});?> unidades</td>
            </tr>
        <? } ?>
        </table>
        
        
        <!--tabs-->
                                
                            </div>
    
   
    
                        </div>