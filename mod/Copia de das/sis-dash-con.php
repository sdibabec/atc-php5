<?php
require_once("cnx/swgc-mysql.php");
require_once("cls/cls-sistema.php");
require_once("lstTiposDocumentos.php");


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
    <div class="col-lg-12   au-card--no-pad m-b-40">
        <center>
          <form id="consDetalle"   name="consDetalle">
             <input type="hidden" name="eCodEvento" id="eCodEvento">
         </form>  
        <form id="Datos" name="Datos" method="post" action="<?=$_SERVER['REQUEST_URI']?>" style="position: relative; z-index: 9999;">
            <div class="form-group col-md-6">
                <div class="input-group date">
                    <input type="text" class="form-control" name="fhFechaConsulta" id="fhFechaConsulta" value="<?=date('d/m/Y');?>" data-date-format="mm/dd/yyyy" style="position: relative; z-index: 9999;" onclick="toogleInput()">
                    <div class="btn btn-primary" onclick="toogleInput(); consultarFecha();">
                        <span><i class="fas fa-search"></i></span>
                    </div>
                </div>
            </div>
    </form>
        </center>
    </div>
<!--calendario-->
<!--Listado de eventos de ese día-->
    <div class="col-md-6" id="divConsulta0">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">
                    <i class="zmdi zmdi-account-calendar"></i> Eventos del d&iacute;a
                </strong>
            </div>
            <div class="card-body" id="eventos">
                
            </div>
        </div>
    </div>
    
    <div class="col-md-6" id="divConsulta1">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">
                    <i class="zmdi zmdi-account-calendar"></i> Rentas del d&iacute;a
                </strong>
            </div>
            <div class="card-body" id="rentas">
                
            </div>
        </div>
    </div>
   
                            
<!--Listado de eventos de ese día-->

</div>


<script>

    $(document).ready(function() {
 consultarFecha();   
          });
 
    
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