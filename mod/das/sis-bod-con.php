<?php
require_once("cnx/swgc-mysql.php");
require_once("cls/cls-sistema.php");

$clSistema = new clSis();
session_start();

$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bDelete'];

$fhFechaInicio = $_POST['fhFechaConsulta'] ? date('Y-m-d',strtotime($_POST['fhFechaConsulta'])).' 00:00:00' : date('Y-m-d').' 00:00:00';
$fhFechaTermino = $_POST['fhFechaConsulta'] ? date('Y-m-d',strtotime($_POST['fhFechaConsulta'])).' 23:59:59' : date('Y-m-d').' 23:59:59';

$fhFechaConsulta = $_POST['fhFechaConsulta'] ? date('Y-m-d',strtotime($_POST['fhFechaConsulta'])).' 00:00:00' : date('Y-m-d').' 00:00:00';

$fhFechaInicio = "'".$fhFechaInicio."'";
$fhFechaTermino = "'".$fhFechaTermino."'";


?>

<div class="row">
<!--calendario-->
    <div class="col-lg-12   au-card--no-pad m-b-40" >
        <center>
            <form id="consDetalle" name="consDetalle">
            <input type="hidden" name="eCodEvento" id="eCodEvento">
            </form>
            <form id="frmCalendario" method="post" action="#"><input type="hidden" id="nvaFecha" name="nvaFecha" value=""></form>
            <div id="calendario"></div>
        <form id="Datos" name="Datos" method="post" action="<?=$_SERVER['REQUEST_URI']?>">
            <!--<input type="text" id="datepicker" onchange="obtenerFecha()" value="<?=($_POST['fhFechaConsulta'] ? date('m/d/Y',strtotime("+1 month",strtotime($_POST['fhFechaConsulta']))) : '')?>" placeholder="Fecha a Consultar">-->
            <input type="hidden" name="fhFechaConsulta" id="fhFechaConsulta" value="<?=date('d/m/Y');?>">
            <input type="hidden" name="bAll" id="bAll" value="<?=$bAll;?>">
            <div id="tFechaConsulta"><?=date('d/m/Y');?></div>
    <input type="submit" class="btn btn-info" value="Consultar" style="display:none;">
    </form>
        </center>
    </div>
<!--calendario-->
<!--Listado de eventos de ese día-->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">
                    <i class="zmdi zmdi-account-calendar"></i> Eventos del d&iacute;a <img src="/res/loading.gif" id="imgEventos" style="display:none; max-width:20px;">
                </strong>
            </div>
            <div class="card-body" id="eventos">
                
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">
                    <i class="zmdi zmdi-account-calendar"></i> Rentas del d&iacute;a <img src="/res/loading.gif" id="imgRentas" style="display:none; max-width:20px;">
                </strong>
            </div>
            <div class="card-body" id="rentas">
                
            </div>
        </div>
    </div>
   
                            
<!--Listado de eventos de ese día-->

</div>


<script>

    
    
function mostrar(indice)
    {
        document.getElementById('mtrDet'+indice).style.display='none';
        document.getElementById('ocuDet'+indice).style.display='inline';
        document.getElementById('detalle'+indice).style.display='inline';
    }
    
function ocultar(indice)
    {
        document.getElementById('mtrDet'+indice).style.display='inline';
        document.getElementById('ocuDet'+indice).style.display='none';
        document.getElementById('detalle'+indice).style.display='none';
    }


    
   // $('#datepicker').datepicker();
</script>