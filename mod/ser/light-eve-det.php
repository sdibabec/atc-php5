<?php
require_once("../../cnx/swgc-mysql.php");
require_once("../../cls/cls-sistema.php");
$clSistema = new clSis();
session_start();

$select = "SELECT be.*, (cc.tNombres + ' ' + cc.tApellidos) as tNombre FROM BitEventos be INNER JOIN CatClientes cc ON cc.eCodCliente = be.eCodCliente WHERE be.eCodEvento = ".$_GET['eCodEvento'];
$rsCotizacion = mysql_query($select);
$rCotizacion = mysql_fetch_array($rsCotizacion);

$bIVA = $rCotizacion{'bIVA'};


//clientes
$select = "	SELECT 
															cc.*, 
											
															su.tNombre as promotor
														FROM
															CatClientes cc
														
														LEFT JOIN SisUsuarios su ON su.eCodUsuario = cc.eCodUsuario
                                                        ORDER BY cc.eCodCliente ASC";
$rsClientes = mysql_query($select);

$dHoraExtra = 0;

?>
<!doctype html>
<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <title>Detalle del Evento</title>
    
    <style>
    .invoice-box {
        max-width: 820px;
        width:720px;
        height:95vh;
        margin: auto;
        padding: 10px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <img src="../../images/icon/logo.png" style="max-width:100px;">
                            </td>
                            
                            <td>
                                Evento # <?=sprintf("%07d",$_GET['eCodEvento'])?><br>
                                Fecha de Elaboraci&oacute;n <?=date('d/m/Y H:i',strtotime($rCotizacion{'fhFecha'}))?><br>
                                Fecha Servicio: <?=date('d/m/Y H:i',strtotime($rCotizacion{'fhFechaEvento'}))?><br>
                                Hora de Montaje: <?=$rCotizacion{'tmHoraMontaje'}?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                 <?
     while($rCliente = mysql_fetch_array($rsClientes))
{
         ?>
                  <?=($rCotizacion{'eCodCliente'}==$rCliente{'eCodCliente'}) ? $rCliente{'tNombres'}.' '.$rCliente{'tApellidos'}.' <br>'.$rCliente{'tCorreo'}.'<br>Tel.'.$rCliente{'tTelefonoFijo'}.'<br>Cel.'.$rCliente{'tTelefonoMovil'} : ''?>
                  <?
}
    ?>
                            </td>
                            
                            <td>
                                <?=nl2br(base64_decode(utf8_decode($rCotizacion{'tDireccion'})))?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            
            
            <tr class="heading">
                <td>
                    Descripci&oacute;n
                </td>
                
                <td>
                    Precio
                </td>
            </tr>
            
            
											<?
                                            $i = 0;
											$select = "	SELECT DISTINCT
															cs.tNombre,
                                                            cs.dPrecioVenta,
                                                            rep.eCodServicio,
                                                            rep.eCantidad,
                                                            cs.eCodServicio,
                                                            rep.dMonto,
                                                            cs.dHoraExtra,
                                                            cs.eHoras,
                                                            rep.eHorasExtra
                                                        FROM CatServicios cs
                                                        INNER JOIN RelEventosPaquetes rep ON rep.eCodServicio = cs.eCodServicio and rep.eCodTipo = 1
                                                        WHERE rep.eCodEvento = ".$_GET['eCodEvento'];
											$rsPaquetes = mysql_query($select);
                                            $dTotalEvento = 0;
											while($rPaquete = mysql_fetch_array($rsPaquetes))
											{
                                                $eCantidad = $rPaquete{'eCantidad'};
                                                $dHoraExtra = $dHoraExtra + ($rPaquete{'dHoraExtra'}*$eCantidad);
												?>
											<tr class="item">
                <td>
                    <b>(<?=$eCantidad;?>) <?=utf8_encode($rPaquete{'tNombre'})?></b><br>
                    <small>Servicio por <?=$rPaquete{'eHoras'};?> horas <?=(((int)$rPaquete{'eHorasExtra'}>0) ? ' + '.(int)$rPaquete{'eHorasExtra'}.' horas extra' : '')?></small>
                </td>
                
                <td>
                    $<?=number_format($rPaquete{'dMonto'},2)?>
                </td>
            </tr>
            
            
            
            <!-- Desglose de paquete -->
                    <?
                       $select = "SELECT ci.tNombre, cti.ePosicion, cst.ePosicion, rsi.ePiezas FROM CatInventario ci 
                            INNER JOIN CatTiposInventario cti ON cti.eCodTipoInventario=ci.eCodTipoInventario
                            LEFT JOIN CatSubClasificacionesInventarios cst ON cst.eCodTipoInventario=cti.eCodTipoInventario
                            INNER JOIN RelServiciosInventario rsi ON rsi.eCodInventario=ci.eCodInventario 
                            WHERE rsi.eCodServicio = ".$rPaquete{'eCodServicio'}." ORDER BY cti.ePosicion ASC, cst.ePosicion ASC";
                                                $rsDesglose = mysql_query($select);
                                                while($rDesglose = mysql_fetch_array($rsDesglose))
                                                {
                                                    ?>
                    <tr class="item"><td colspan="2">(<?=($rDesglose{'ePiezas'}*$eCantidad)?>) <?=($rDesglose{'tNombre'})?></td></tr>
                    <?
                                                }
                    ?>
            <!-- Desglose de paquete -->
											<?
											$i++;
                                                $dTotalEvento = $dTotalEvento + ($rPaquete{'dMonto'});
											}
                                            $select = "	SELECT DISTINCT
															cs.tNombre,
                                                            cs.dPrecioVenta,
                                                            rep.eCodServicio,
                                                            rep.eCantidad,
                                                            rep.dMonto
                                                        FROM CatInventario cs
                                                        INNER JOIN RelEventosPaquetes rep ON rep.eCodServicio = cs.eCodInventario and rep.eCodTipo = 2
                                                        WHERE rep.eCodEvento = ".$_GET['eCodEvento'];
											$rsInventario = mysql_query($select);
                                            
											while($rInventario = mysql_fetch_array($rsInventario))
											{
												?>
											<tr class="item">
                <td>
                    <b><?=$rInventario{'eCantidad'};?></b> - <?=utf8_encode($rInventario{'tNombre'})?>
                </td>
                
                <td>
                    $<?=number_format($rInventario{'dMonto'},2)?>
                </td>
            </tr>
											<?
											$i++;
                                                $dTotalEvento = $dTotalEvento + ($rInventario{'dMonto'});
											}
											?>
            
            <!--extras-->
            <?
                                            $select = "	SELECT *
                                                        FROM RelEventosExtras
                                                        WHERE eCodEvento = ".$_GET['eCodEvento'].
                                                " ORDER BY bSuma ASC, tDescripcion ASC";
											$rsExtras = mysql_query($select);
                                            
											while($rExtra = mysql_fetch_array($rsExtras))
											{
												?>
											<tr class="item">
                <td>
                    <b>E</b> - <?=utf8_encode($rExtra{'tDescripcion'})?>
                </td>
                
                <td>
                    $<?=number_format($rExtra{'dImporte'},2)?>
                </td>
            </tr>
											<?
											$i++;
                                                $dTotalEvento = $dTotalEvento + (($rExtra{'bSuma'}!=1) ? $rExtra{'dImporte'} : 0);
											}
											?>
            <!--extras-->
            
            
            
            <tr class="total">
                <td></td>
                
                <td>
                   <?=$bIVA ? "Subtotal" : "Total"?>: $<?=number_format($dTotalEvento,2)?>
                </td>
            </tr>
            <?
    if($bIVA)
    {
        $dIVA = number_format(($dTotalEvento*0.16),2);
        
        $dTotal = number_format(($dTotalEvento*1.16),2);
    ?>
            <tr class="total">
                <td></td>
                
                <td>
                   I.V.A.: $<?=$dIVA?>
                </td>
            </tr>
            <tr class="total">
                <td></td>
                
                <td>
                   Total: $<?=$dTotal?>
                </td>
            </tr>
            <? } ?>
            <!-- Horas Extra -->
            <? if((int)$dHoraExtra>0){ ?>
            <tr>
                <td colspan="2">
                    <b><p style="font-size:10px">
                    Hora Extra: $<?=number_format($dHoraExtra,2,'.',',');?>
                        </p></b>
                </td>
            </tr>
            <? } ?>
            <!-- Horas Extra -->
            <tr>
                <td colspan="2">
                    <p style="font-size:8px">
                       
                Cl&aacute;usulas de contrataci&oacute;n:
                           
<br><br>
-En caso de requerir factura esta causara el 16% de I.V.A.<br>
-La entrega es en planta baja y no m&aacute;s de 50 metros a pie de cami&oacute;n<br>
-Las entregas se realizan en horario de montaje de 11:00 A.M.-5:00 P.M. cualquier cambio puede generar un cargo adicional<br>
- Al recibir el equipo deber&aacute; entregar una identificaci&oacute;n oficial vigente a nuestro personal, la cual ser&aacute; devuelta al momento de recoger el equipo<br>
-Esta cotizaci&oacute;n tiene una validez de 20 d&iacute;as <br>
-Las reservaciones tienen una duraci&oacute;n de 48 horas, si el evento es durante el transcurso de la misma semana de su elaboraci&oacute;n, y dos semanas si la fecha de reserva es mayor a un mes de esta cotizaci&oacute;n.<br>
<br>
Aviso de confidencialidad:<br><br>

Esta informaci&oacute;n est&aacute; avalada por la ley de protecci&oacute;n de datos, para mayor informaci&oacute;n consulte nuestro aviso de privacidad en la p&aacute;gina: https://www.antroentucasa.com.mx/
</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>

