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
    <!--transacciones-->
    <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
          <form action="?tCodSeccion=<?=$_GET['tCodSeccion']?>" method="post" id="nvaTran">
              <input type="hidden" name="eCodTransaccion" id="eCodTransaccion">
              <input type="hidden" id="eCodEventoTransaccion" name="eCodEventoTransaccion">
              <input type="hidden" id="tCodEstatusTransaccion" name="tCodEstatusTransaccion">
            <label>Monto: $<input type="text" class="form-control" name="dMonto" id="dMonto" required></label><br>
            <label>Forma de pago: 
              <select name="eCodTipoPago" id="eCodTipoPago">
                <?
    $select = "SELECT * FROM CatTiposPagos ORDER BY tNombre ASC";
                                        $rsTiposPagos = mysql_query($select);
                                        while($rTipoPago = mysql_fetch_array($rsTiposPagos))
                                        {
                                            ?>
                  <option value="<?=$rTipoPago{'eCodTipoPago'}?>"><?=utf8_encode($rTipoPago{'tNombre'});?></option>
                  <?
                                        }
    ?>
                </select>
              </label><br>
              <textarea name="tMotivoCancelacion" id="tMotivoCancelacion" placeholder="Motivo de cancelación" style="display:none; resize:none;" class="form-control"></textarea>
              <br>
              <input type="button" onclick="nvaTran();" value="Guardar" name="operador" class="btn btn-info">
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
      
    </div>
  </div>
    
    <!--modal de responsable-->
    <div class="modal fade" id="myModalOperador" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body">
          <form action="?tCodSeccion=<?=$_GET['tCodSeccion']?>" method="post" id="nvaOperador">
              
              <input type="hidden" id="eCodEventoOperador" name="eCodEventoOperador">
              <label><input type="radio" value="tOperadorEntrega" name="tCampo"> A la Entrega </label><br>
            <label><input type="radio" value="tOperadorRecoleccion" name="tCampo"> A la Recolecci&oacute;n </label><br>
               <label>Veh&iacute;culo</label>
         <select class="form-control" id="eCodCamioneta" name="eCodCamioneta">
              <option value="">Seleccione...</option>
             <?php 
                $select = "SELECT * FROM CatCamionetas WHERE tCodEstatus = 'AC' ORDER BY eCodCamioneta ASC";
                $rsCamionetas = mysql_query($select);
                while($rCamioneta = mysql_fetch_array($rsCamionetas)) { ?>
             <option value="<?=$rCamioneta{'eCodCamioneta'};?>"><?=$rCamioneta{'tNombre'};?></option>
             <? } ?>
              </select>
             <br><br> 
            
            <label>Responsable: 
              <input type="text" class="form-control" name="tResponsable" id="tResponsable" required>
              </label><br>
              <input type="button" onclick="nvaOper();" value="Guardar" name="operador" class="btn btn-info">
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
      
    </div>
  </div>
        
   <!--modal de paquete-->
    <div class="modal fade" id="myModalPaquete" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          
        </div>
        <div class="modal-body" id="detPaquete">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
      
    </div>
  </div>
        
        <!-- Modal -->
  <div class="modal fade" id="resProceso" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body">
          <center>
            <img style="width:75px; height:75px;" src="/res/loading.gif"><br>
            <h3>Procesando...</h3>
            </center>
        </div>
      </div>
      
    </div>
  </div>
        <!-- Modal -->
  <div class="modal fade" id="resExito" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <!--<div class="modal-content">
        <div class="modal-body">
          <center>
            <img src="/res/ok.png" style="width:75px; height:75px;"><br>
              <h3>Registro Guardado Exitosamente</h3><br>
            </center>
        </div>
      </div>-->
       <div class="alert alert-success">
  <strong>&Eacute;xito!</strong> Registro Guardado Exitosamente
</div>
      
    </div>
  </div>
        <!-- Modal -->
  <div class="modal fade" id="resConsulta" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body">
          <center>
            <img src="/res/loading.gif" style="width:75px; height:75px;"><br>
              <h3>Consultando fecha</h3><br>
            </center>
        </div>
          
      </div>
      
    </div>
  </div>
      <!-- Modal -->
  <div class="modal fade" id="resDetalle" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body" id="detalleEvento">
         
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
      
    </div>
  </div>
      <!-- Modal -->
  <div class="modal fade" id="detCarga" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
          <form id="carga" name="carga">
              <input type="hidden" id="eCodEventoCarga" name="eCodEventoCarga">
            <div class="modal-body">
                <div class="modal-body" id="detalleCarga" >
         
                </div>
            </div>    
        
              <div class="modal-body" style="text-align:center;">
         <button type="button" id="guardarCarga" class="btn btn-info" style="display:none;" onclick="registrarCarga();">Guardar</button>
        </div>
            </form>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
      
    </div>
  </div>
        <!-- Modal -->
  <div class="modal fade" id="resError" role="dialog">
    <div class="modal-dialog" id="divErrores">
    
      <!-- Modal content-->
      <!--<div class="modal-content">
        <div class="modal-body">
          <center>
            <img src="/res/error.png" style="width:75px; height:75px;"><br>
              <h3>Error al procesar la solicitud</h3><br>
            </center>
            <div id="divErrores" name="divErrores"></div>
        </div>
      </div>-->
        <div class="alert alert-danger">
            <strong>Error!</strong> Favor de validar la siguiente informaci&oacute;n
        </div>
      
    </div>
  </div>
    
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
        
     <!-- Modal guardar cambios -->
<div class="modal fade" id="modGuardar" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <table width="100%">
                    <tr>
                        <td colspan="2" align="center">¿Confirmas que deseas guardar los cambios?</td>
                    </tr>
                    <tr>
                        <td align="center">
                            <button type="button" class="form-control btn btn-success" onclick="serializar()">Guardar</button>
                        </td>
                        <td align="center">
                            <button type="button" class="form-control btn btn-default" data-dismiss="modal">Cerrar</button>
                        </td>
                    </tr>
                </table>
            </div>

        </div>

    </div>
</div>
 