<?php
require_once("cnx/swgc-mysql.php");
require_once("cls/cls-sistema.php");
$clSistema = new clSis();
session_start();
$bAll = $_SESSION['bAll'];
$select = "SELECT be.*, (cc.tNombres + ' ' + cc.tApellidos) as tNombre FROM BitEventos be INNER JOIN CatClientes cc ON cc.eCodCliente = be.eCodCliente WHERE be.eCodEvento = ".$_GET['v1'];
$rsPublicacion = mysql_query($select);
$rPublicacion = mysql_fetch_array($rsPublicacion);

$bIVA = $rPublicacion{'bIVA'} ? 1 : 0;

//clientes
$select = "	SELECT 
															cc.*, 
											
															su.tNombre as promotor
														FROM
															CatClientes cc
														
														LEFT JOIN SisUsuarios su ON su.eCodUsuario = cc.eCodUsuario".
												($bAll ? "" : " WHERE cc.eCodUsuario = ".$_SESSION['sessionAdmin']['eCodUsuario']).
														" ORDER BY cc.eCodCliente ASC";
$rsClientes = mysql_query($select);

?>



 

    <form id="datos" name="datos" action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="eCodEvento" value="<?=$_GET['v1']?>">
        <input type="hidden" name="eAccion" id="eAccion">
        <div class="row">
        <div class="col-md-8">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Datos Principales</h5>
                        <div>
                            <? if($rPublicacion{'eCodUsuarioCancelacion'}){ ?>
            <?
            $select = "	SELECT su.tNombre as Usuario, su.tApellidos as Apellidos FROM SisUsuarios su WHERe su.eCodUsuario = ".$rPublicacion{'eCodUsuarioCancelacion'};
             $rUsuario = mysql_fetch_array(mysql_query($select));
            ?>
           <div class="form-group">
              <label>Estatus</label>
              <b>CANCELADO</b>
           </div>
           <div class="form-group">
              <label>Usuario Cancelaci&oacute;n</label>
              <?=utf8_encode($rUsuario{'Usuario'}.' '.$rUsuario{'tApellidos'});?>
           </div>
           <div class="form-group">
              <label>Fecha Cancelaci&oacute;n</label>
              <?=date('d/m/Y H:i',strtotime($rPublicacion{'fhFechaCancelacion'}))?>
           </div>
         <? } ?>
           <div class="form-group">
              <label>Cliente</label>
              
                                                        <?
     while($rPaquete = mysql_fetch_array($rsClientes))
{
         ?>
                  <?=($rPublicacion{'eCodCliente'}==$rPaquete{'eCodCliente'}) ? $rPaquete{'tNombres'}.' '.$rPaquete{'tApellidos'}.' ('.$rPaquete{'tCorreo'}.')' : ''?>
                  <?
}
    ?>
      
              
               
           </div>
           <div class="form-group">
              <label>Fecha del Evento</label>
              <?=date('d/m/Y H:i',strtotime($rPublicacion{'fhFechaEvento'}))?>
           </div>
           <div class="form-group">
              <label>Hora de Montaje</label>
              <?=date('H:i',strtotime($rPublicacion{'tmHoraMontaje'}))?>
           </div>
           <div class="form-group">
              <label>Direcci&oacute;n</label>
              <?=nl2br(base64_decode(utf8_decode($rPublicacion{'tDireccion'})))?>
           </div>
           <div class="form-group">
              <label>Observaciones</label>
              <?=nl2br(base64_decode(utf8_decode($rPublicacion{'tObservaciones'})))?>
           </div>
                        </div>
                    </div>
                </div>
                
            </div>
        <div class="col-md-4">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Transacciones</h5>
                        <div>
                            <table class="table table-responsive table-borderless table-top-campaign">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>#</th>
												<th>Fecha</th>
												<th>Monto</th>
												<th>Forma</th>
                                            </tr>
                                        </thead>
										<tbody>
											<?
											$select = "SELECT bt.eCodTransaccion, bt.eCodTipoPago, bt.eCodEvento, bt.fhFecha, bt.dMonto, ctp.tNombre FROM BitTransacciones bt INNER JOIN CatTiposPagos ctp ON ctp.eCodTipoPago = bt.eCodTipoPago WHERE bt.tCodEstatus = 'AC' AND bt.eCodEvento = ".$_GET['v1'];
											$rsTransacciones = mysql_query($select);
											$i = 1;
											while($rTransaccion = mysql_fetch_array($rsTransacciones))
											{
												?>
											<tr>
                                                <td>
                                                    <? if($_SESSION['sessionAdmin']['bAll']) { ?>
                                                    <i class="far fa-trash-alt" onclick="nuevaTransaccion(<?=$rTransaccion{'eCodEvento'};?>,<?=$rTransaccion{'eCodTransaccion'};?>,<?=$rTransaccion{'eCodTipoPago'};?>,<?=$rTransaccion{'dMonto'}?>,1);"></i>
                                                    <? } ?>
                                                    <? if($rPublicacion{'eCodEstatus'}!=4) { ?>
                                                    <i class="fas fa-pencil-alt" onclick="nuevaTransaccion(<?=$rTransaccion{'eCodEvento'};?>,<?=$rTransaccion{'eCodTransaccion'};?>,<?=$rTransaccion{'eCodTipoPago'};?>,<?=$rTransaccion{'dMonto'}?>);"></i>
                                                    <? } ?>
                                                </td>
												<td><?=$i?></td>
												<td><?=date('d/m/Y',strtotime($rTransaccion{'fhFecha'}))?></td>
												<td>$<?=$rTransaccion{'dMonto'}?><input type="hidden" id="abono<?=$i?>" value="<?=$rTransaccion{'dMonto'}?>"></td>
												<td><?=utf8_encode($rTransaccion{'tNombre'});?></td>
											</tr>
											<?
                                                $i++;
											}
											?>
											<tr>
											<td colspan="3" align="right">Total abonado:</td>
												<td id="totAbono"></td>
											</tr>
											<tr>
											<td colspan="3" align="right">Restante:</td>
												<td id="totRestante"></td>
											</tr>
										</tbody>
                                    </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
        <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-body">
                        <h5 class="card-title">Art&iacute;culos</h5>
                        <div>
                            <table class="table table-responsive table-borderless table-top-campaign" width="100%">
                                        <thead>
                                            
                                            <tr>
                                                <th></th>
												<th width="85%">Paquete</th>
                                                <th>Cantidad</th>
                                                <th>Precio</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?
                                            $i = 0;
											$select = "	SELECT DISTINCT
															cs.tNombre,
                                                            cs.dPrecioVenta,
                                                            rep.eCodServicio,
                                                            rep.eCantidad,
                                                            rep.dMonto
                                                        FROM CatServicios cs
                                                        INNER JOIN RelEventosPaquetes rep ON rep.eCodServicio = cs.eCodServicio and rep.eCodTipo = 1
                                                        WHERE rep.eCodEvento = ".$_GET['v1'];
											$rsPublicaciones = mysql_query($select);
                                            
											while($rPublicacion = mysql_fetch_array($rsPublicaciones))
											{
												?>
											<tr id="paq<?=$i?>">
                                                <td><b>PQ</b></td>
                                                <td align="left">
                                                    <?=$rPublicacion{'tNombre'}?>
                                                    <input type="hidden" name="eCodServicio<?=$i?>" id="eCodServicio<?=$i?>" value="<?=$rPublicacion{'eCodServicio'}?>">
                                                    <input type="hidden" name="eCantidad<?=$i?>" id="eCantidad<?=$i?>" value="<?=$rPublicacion{'eCantidad'}?>">
                                                    <input type="hidden" name="eCodTipo<?=$i?>" id="eCodTipo<?=$i?>" value="<?=$rPublicacion{'eCodTipo'}?>">
                                                </td>
                                                <td align="center">
                                                    <?=$rPublicacion{'eCantidad'}?>
                                                </td>
												<td>$<?=number_format($rPublicacion{'dMonto'},2)?><input type="hidden" id="totalServ<?=$i?>" value="<?=($rPublicacion{'dMonto'})?>"></td>
                                            </tr>
											<?
											$i++;
											}
                                            $select = "	SELECT DISTINCT
															cs.tNombre,
                                                            cs.dPrecioVenta,
                                                            rep.eCodServicio,
                                                            rep.eCantidad,
                                                            rep.dMonto
                                                        FROM CatInventario cs
                                                        INNER JOIN RelEventosPaquetes rep ON rep.eCodServicio = cs.eCodInventario and rep.eCodTipo = 2
                                                        WHERE rep.eCodEvento = ".$_GET['v1'];
											$rsPublicaciones = mysql_query($select);
                                            
											while($rPublicacion = mysql_fetch_array($rsPublicaciones))
											{
												?>
											<tr id="paq<?=$i?>">
                                                <td><b>PR</b></td>
                                                <td align="left">
                                                    <?=$rPublicacion{'tNombre'}?>
                                                    <input type="hidden" name="eCodServicio<?=$i?>" id="eCodServicio<?=$i?>" value="<?=$rPublicacion{'eCodServicio'}?>">
                                                    <input type="hidden" name="eCantidad<?=$i?>" id="eCantidad<?=$i?>" value="<?=$rPublicacion{'eCantidad'}?>">
                                                    <input type="hidden" name="eCodTipo<?=$i?>" id="eCodTipo<?=$i?>" value="<?=$rPublicacion{'eCodTipo'}?>">
                                                </td>
                                                <td align="center">
                                                    <?=$rPublicacion{'eCantidad'}?>
                                                </td>
												<td>$<?=number_format($rPublicacion{'dMonto'},2)?><input type="hidden" id="totalServ<?=$i?>" value="<?=($rPublicacion{'dMonto'})?>"></td>
                                            </tr>
											<?
											$i++;
											}
											?>
                                            <!--extras-->
                                            <?
                                            //$i = 0;
											$select = "	SELECT *
                                                        FROM RelEventosExtras
                                                        WHERE eCodEvento = ".$_GET['v1'].
                                                " ORDER BY bSuma ASC, tDescripcion DESC";
											$rsPublicaciones = mysql_query($select);
                                            
											while($rPublicacion = mysql_fetch_array($rsPublicaciones))
											{
												?>
											<tr id="ext<?=$i?>">
                                                <td><b>EX</b></td>
                                                <td align="left">
                                                    <?=$rPublicacion{'tDescripcion'}?>
                                                </td>
                                                <td></td>
                                                <td align="left">
                                                    $<?=number_format($rPublicacion{'dImporte'},2)?><input type="hidden" id="totalServ<?=$i?>" value="<?=($rPublicacion{'dSuma'}!=1 ? $rPublicacion{'dImporte'} : 0)?>">
                                                </td>
												
                                            </tr>
                                            <? $i++; ?>
                                            <? } ?>
                                            
                                            <!--desglose-->
                                            <tr>
												<td> <input type="hidden" id="totEvento" value="0"></td>
											<td colspan="3" align="right" i/**
 * Faroese translation for bootstrap-datepicker
 * Theodor Johannesen <http://github.com/theodorjohannesen>
 */
;(function($){
	$.fn.datepicker.dates['fo'] = {
		days: ["Sunnudagur", "Mánadagur", "Týsdagur", "Mikudagur", "Hósdagur", "Fríggjadagur", "Leygardagur"],
		daysShort: ["Sun", "Mán", "Týs", "Mik", "Hós", "Frí", "Ley"],
		daysMin: ["Su", "Má", "Tý", "Mi", "Hó", "Fr", "Le"],
		months: ["Januar", "Februar", "Marts", "Apríl", "Mei", "Juni", "Juli", "August", "Septembur", "Oktobur", "Novembur", "Desembur"],
		monthsShort: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Des"],
		today: "Í Dag",
		clear: "Reinsa"
	};
}(jQuery));
