<?php

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include("./cnx/swgc-mysql.php");
require_once("./cls/cls-sistema.php");
include("./inc/fun-ini.php");
include("./inc/cot-clc.php");

$clSistema = new clSis();
session_start();

$bAll = $clSistema->validarPermiso($_GET['tCodSeccion']);
$bDelete = $clSistema->validarEliminacion($_GET['tCodSeccion']);


date_default_timezone_set('America/Mexico_City');

?>
    <!-- Modal -->
  <div class="modal fade" id="modClientes" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <form method="post" action="<?=obtenerURL();?>xls/<?=$_GET['tCodSeccion']?>/" target="_blank">
          <div class="modal-body">
              <label>Selecciona el mes</label>
         <select class="form-control" id="eMes" name="eMes">
              <option value="">Seleccione...</option>
             <option value="1">Enero</option>
             <option value="2">Febrero</option>
             <option value="3">Marzo</option>
             <option value="4">Abril</option>
             <option value="5">Mayo</option>
             <option value="6">Junio</option>
             <option value="7">Julio</option>
             <option value="8">Agosto</option>
             <option value="9">Septiembre</option>
             <option value="10">Octubre</option>
             <option value="11">Noviembre</option>
             <option value="12">Diciembre</option>
              </select>
              <br>
             <center> <input type="submit" class="btn btn-info" value="Generar XLS"> </center>
            </div>    
            <div class="modal-footer">
              <button type="button" class="form-control btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
         </form>
          
      </div>
      
    </div>
  </div>