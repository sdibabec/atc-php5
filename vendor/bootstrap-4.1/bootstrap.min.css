<?php
require_once("../../cnx/swgc-mysql.php");
require_once("../../cls/cls-sistema.php");
$clSistema = new clSis();
session_start();

$select = "SELECT be.*, (cc.tNombres + ' ' + cc.tApellidos) as tNombre,su.tNombre as promotor FROM BitEventos be INNER JOIN CatClientes cc ON cc.eCodCliente = be.eCodCliente LEFT JOIN SisUsuarios su ON su.eCodUsuario = be.eCodUsuario WHERE be.eCodEvento = ".($_GET['v1'] ? $_GET['v1'] : $_GET['eCodEvento']);
$rsCotizacion = mysql_query($select);
$rCotizacion = mysql_fetch_array($rsCotizacion);

$bIVA = $rCotizacion{'bIVA'} ? $rCotizacion{'bIVA'} : false;


//clientes
$select = "	SELECT 
															cc.*, 
											
															su.tNombre as promotor
														FROM
															CatClientes cc
														
														LEFT JOIN SisUsuarios su ON su.eCodUsuario = cc.eCodUsuario
                                                        WHERE cc.eCodCliente = ".$rCotizacion{'eCodCliente'};
$rsClientes = mysql_query($select);
$rCliente = mysql_fetch_array($rsClientes);

$arrProductos = array();

$select = "	SELECT DISTINCT
				cs.tNombre,
                 cs.dPrecioVenta,
                 rep.eCodServicio,
                 rep.eCantidad,
                 cs.eCodServicio,
                 rep.dMonto,
                 cs.dHoraExtra
             FROM CatServicios cs
             INNER JOIN RelEventosPaquetes rep ON rep.eCodServicio = cs.eCodServicio and rep.eCodTipo = 1
             WHERE rep.eCodEvento = ".$rCotizacion['eCodEvento'];
$rsPaquetes = mysql_query($select);
$dTotalEvento = 0;
while($rPaquete = mysql_fetch_array($rsPaquetes))
{
   $arrProductos[] = array(
   'prefijo'=>'PQ',
   'nombre'=>$rPaquete{'tNombre'},
   'cantidad'=>$rPaquete{'eCantidad'}); 
    
    $eCantidad = $rPaquete{'eCantidad'};
    $dTotalEvento = $dTotalEvento + $rPaquete{'dMonto'};
    
    $select = "SELECT ci.tNombre, cti.ePosicion, cst.ePosicion, rsi.ePiezas FROM CatInventario ci 
    INNER JOIN CatTiposInventario cti ON cti.eCodTipoInventario=ci.eCodTipoInventario
    LEFT JOIN CatSubClasificacionesInventarios cst ON cst.eCodTipoInventario=cti.eCodTipoInventario
    INNER JOIN RelServiciosInventario rsi ON rsi.eCodInventario=ci.eCodInventario 
    WHERE rsi.eCodServicio = ".$rPaquete{'eCodServicio'}." ORDER BY cti.ePosicion ASC, cst.ePosicion ASC";
    $rsDesglose = mysql_query($select);
    while($rDesglose = mysql_fetch_array($rsDesglose))
    {
        $arrProductos[] = array(
   'prefijo'=>' ('.($rDesglose{'ePiezas'}*$eCantidad).')',
   'nombre'=>$rDesglose{'tNombre'},
   'cantidad'=>false); 
    }
}

$select = "	SELECT DISTINCT
	cs.tNombre,
    cs.dPrecioVenta,
    rep.eCodServicio,
    rep.eCantidad,
    rep.dMonto
FROM CatInventario cs
INNER JOIN RelEventosPaquetes rep ON rep.eCodServicio = cs.eCodInventario and rep.eCodTipo = 2
WHERE rep.eCodEvento = ".$rCotizacion['eCodEvento'];
$rsInventario = mysql_query($select);
while($rInventario = mysql_fetch_array($rsInventario))
{
   $arrProductos[] = array(
   'prefijo'=>'IN',
   'nombre'=>$rInventario{'tNombre'},
   'cantidad'=>$rInventario{'eCantidad'}); 
     $dTotalEvento = $dTotalEvento + $rInventario{'dMonto'};
}

$select = "	SELECT *
          FROM RelEventosExtras
          WHERE eCodEvento = ".$_GET['eCodEvento'].
          " ORDER BY bSuma ASC, tDescripcion ASC";
$rsExtras = mysql_query($select);
while($rExtra = mysql_fetch_array($rsExtras))
{
 $arrProductos[] = array(
   'prefijo'=>'EX',
   'nombre'=>$rExtra{'tNombre'},
   'cantidad'=>false); 
     $dTotalEvento = $dTotalEvento + (($rExtra{'bSuma'}!=1) ? $rExtra{'dImporte'} : 0); 
}

$dSubtotal = $dTotalEvento;
$dIVA = $dSubtotal * 0.16;
$dTotal = $bIVA ? ($dSubtotal+$dIVA) : $dSubtotal;

$select = "SELECT bt.eCodTransaccion, bt.eCodTipoPago, bt.eCodEvento, bt.fhFecha, bt.dMonto, ctp.tNombre FROM BitTransacciones bt INNER JOIN CatTiposPagos ctp ON ctp.eCodTipoPago = bt.eCodTipoPago WHERE bt.tCodEstatus = 'AC' AND bt.eCodEvento = ".$rCotizacion['eCodEvento'];
$rsTransacciones = mysql_query($select);
$i = 1;
$dPagado = 0;
while($rTransaccion = mysql_fetch_array($rsTransacciones))
{ $dPagado = $dPagado + $rTransaccion{'dMonto'}; }

$dRestante = $dTotal - $dPagado;

$tEstatus = ($dPagado>=$dTotal) ? 'Estatus: Pagado' : 'Restan: '.number_format($dRestante,2);
?>
<html>
<head>
    <title>SGE - Hoja Maestra</title>
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
    <style type="text/css">
        .invoice-title h2,
        .invoice-title h3 {
            display: inline-block;
        }
        
        .table > tbody > tr > .no-line {
            border-top: none;
        }
        
        .table > thead > tr > .no-line {
            border-bottom: none;
        }
        
        .table > tbody > tr > .thick-line {
            border-top: 2px solid;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="invoice-title">
                    <h3>Cliente:<b>
                        <?=$rCliente{'tNombres'}.' '.$rCliente{'tApellidos'}?>
                        </b></h3>
                </div>
                <hr>
                <table width="100%">
                    <tr hidden>
                    <td width="50%"></td>
                    <td width="50%"></td>
                    </tr>
                <tr>
                <td>
                        <address>
    				<strong>Fecha Evento</strong><br>
    					<?=date('d/m/Y H:i',strtotime($rCotizacion{'fhFechaEvento'}))?><br>
                     <strong>Hora Montaje</strong><br>
    					<?=$rCotizacion{'tmHoraMontaje'}?><br>       
    				</address>
                    </td>
                    <td align="right">
                        <address>
        			<strong>Direcci&oacute;n</strong><br>
    					<?=nl2br(base64_decode(utf8_decode($rCotizacion{'tDireccion'})))?>
    				</address>
                    </td>
                    </tr>
                    <tr>
                    <td colspan="2" height="20"></td>
                    </tr>
                    <tr>
                <td>
                        <address>
    					<strong>Observaciones:</strong><br>
    					<?=nl2br(base64_decode(utf8_decode($rCotizacion{'tObservaciones'})))?>
    				</address>
                     </td>
                    <td align="right">
                        <address>
    					<strong>Personal de</strong><br>
    					Entrega: <?=(($rCotizacion{'tOperadorEntrega'}) ? $rCotizacion{'tOperadorEntrega'} : 'Pendiente');?><br>
    					Recolecci&oacute;n: <?=(($rCotizacion{'tOperadorRecoleccion'}) ? $rCotizacion{'tOperadorRecoleccion'} : 'Pendiente');?><br><br>
    				</address>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong><?=$tEstatus;?></strong></h3>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed" width="100%">
                                <thead>
                                    <tr>
                                        <td width="90%"><strong>Art&iacute;culos</strong></td>
                                        <td class="text-center" width="10%"><strong>Cantidad</strong></td>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- foreach ($order->lineItems as $line) or some such thing here -->
                                    <? for($i=0;$i<sizeof($arrProductos);$i++)
                                    { ?>
                                    <? $producto = $arrProductos[$i]; ?>
                                    <tr>
                                        <td>
                                            <b><?=$producto['prefijo'];?></b>
                                        <?=($producto['nombre']);?>
                                        </td>
                                        
                                        <td class="text-center"><?=($producto['cantidad'] ? $producto['cantidad'] : '');?></td>
                                    </tr>
                                    <? } ?>
                                    <tr>
                                        <td class="thick-line text-right" colspan="2"><strong>Promotor: </strong><?=$rCotizacion{'promotor'};?></td>
                                        
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>