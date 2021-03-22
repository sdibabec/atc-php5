<?php
require_once("cnx/swgc-mysql.php");
require_once("cls/cls-sistema.php");


$clSistema = new clSis();
session_start();
$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bDelete'];

if($_GET['eCodEvento'])
{
    mysql_query("UPDATE BitEventos SET eCodEstatus = ".$_GET['eAccion']." WHERE eCodEvento =".$_GET['eCodEvento']);
    
        $fhFecha = "'".date('Y-m-d H:i:s')."'";
        $tDescripcion = "Se ha ".(($_GET['eAccion']==4) ? 'CANCELADO' : 'FINALIZADO')." el evento ".sprintf("%07d",$_GET['eCodEvento']);
        $tDescripcion = "'".$tDescripcion."'";
        $eCodUsuario = $_SESSION['sessionAdmin']['eCodUsuario'];
        mysql_query("INSERT INTO SisLogs (eCodUsuario, fhFecha, tDescripcion) VALUES ($eCodUsuario, $fhFecha, $tDescripcion)");
    
    echo '<script>window.location="?tCodSeccion=cata-eve-con";</script>';
              
}

$select = "SELECT * FROM SisMaximosRegistros ORDER BY eRegistros ASC";
$rsMaximos = mysql_query($select);
        
$select = "SELECT DISTINCT
	ce.tNombre tEstatus,
	ce.eCodEstatus 
FROM
	CatEstatus ce
	INNER JOIN BitEventos be ON be.eCodEstatus = ce.eCodEstatus
    WHERE 1=1 ".
    ($_SESSION['sessionAdmin']['bAll'] ? "" : " AND eCodEstatus<>4").
" ORDER BY
	ce.tNombre ASC";
$rsEstatus = mysql_query($select);

?>
<script>
function detalles(codigo)
    {
        window.location="?tCodSeccion=cata-eve-det&eCodEvento="+codigo;
    }
function cancelar(codigo)
    {
        window.location="?tCodSeccion=cata-eve-con&eAccion=4&eCodEvento="+codigo;
    }
function finalizar(codigo)
    {
        window.location="?tCodSeccion=cata-eve-con&eAccion=8&eCodEvento="+codigo;
    }
function ruta(codigo)
    {
        window.location="?tCodSeccion=cata-eve-det&eCodEvento="+codigo+"&bRuta=1";
    }
    
$(document).ready(function() {
             filtrar();
    
              //$('#fhFechaConsulta1, #fhFechaConsulta2').datepicker();
    
        $("#fhFechaConsulta1").datepicker({
            dateFormat: "dd/mm/yy",
    onSelect: function(selectedDate) {
        // Set the minDate of 'to' as the selectedDate of 'from'
        $("#fhFechaConsulta2").datepicker("option", "minDate", selectedDate);
    }
});
    
$("#fhFechaConsulta2").datepicker({
    dateFormat: "dd/mm/yy",
    onSelect: function(selectedDate) {
        // Set the minDate of 'to' as the selectedDate of 'from'
        $("#fhFechaConsulta1").datepicker("option", "maxDate", selectedDate);
    }
});
          
          });
    

</script>
<div class="row">
                            <div class="col-lg-12">
                                
                                
                                <!--filtros-->
                                <div class="col-md-12">
                                    <div id="eRegistros" style="font-size:16px; font-weight:bold;"></div>
                                    <div style="text-align:right;">
                                        <button class="btn btn-info" onclick="mostrarFiltros()">
                                            <i class="zmdi zmdi-filter-list"></i>Filtros</button>
                                        <button class="btn btn-info" onclick="filtrar()">
                                            <i class="zmdi zmdi-search"></i>Consultar</button>
                                    </div>
                                </div>
                                
                                <div class="clearfix"></div>
                                
                                <div id="divFiltros" style="display:none;" class="card card-body table-responsive">
                                <form id="Datos" name="Datos">
                                    <input type="hidden" name="tAccion" id="tAccion" value="">
                                    <input type="hidden" name="eAccion" id="eAccion" value="">
                                    <table width="100%" cellpadding="10" class="table">
                                    <tr hidden>
                                        <td width="25%"></td>
                                        <td width="25%"></td>
                                        <td width="25%"></td>
                                        <td width="25%"></td>
                                    </tr>
<tr>
    <td><label><input type="radio" name="rdOrden" value="eCodEvento" checked="checked"> C&oacute;digo</label></td>
    <td>
        <input type="text" class="form-control" name="eCodEvento" id="eCodEvento">
    </td>
    <td><label><input type="radio" name="rdOrden" value="eCodCliente"> Cliente</label></td>
    <td>
        <input type="hidden" name="eCodCliente" id="eCodCliente">
        <input type="text" class="form-control" id="tCliente" placeholder="Cliente"  onkeyup="buscarClientes()" onkeypress="buscarClientes()">
    </td>
</tr>
<tr>
    <td><label><input type="radio" name="rdOrden" value="eCodEstatus"> Estatus</label></td>
    <td>
        <select id="eCodEstatus" name="eCodEstatus" >
        <option value="">Seleccione...</option>
        <? while($rEstatus = mysql_fetch_array($rsEstatus)) { ?>
            <option value="<?=$rEstatus{'eCodEstatus'};?>"><?=$rEstatus{'tEstatus'};?></option>
        <? } ?>
        </select>
    </td>
    <td><label><input type="radio" name="rdOrden" value="fhFechaEvento"> Fecha</label></td>
    <td>
        <div class="input-group date">
                    <input type="text" class="input-sm form-control" name="fhFechaConsulta1" id="fhFechaConsulta1" value="<?=date('d/m/Y',strtotime("-5 days"));?>" style="position: relative; z-index: 9999;">
            <span class="input-group-addon">-</span>
             <input type="text" class="input-sm form-control" name="fhFechaConsulta2" id="fhFechaConsulta2" value="<?=date('d/m/Y',strtotime("+5 days"));?>" style="position: relative; z-index: 9999;">
                </div>
    </td>
</tr>
<tr>
    <td>Mostrar</td>
    <td>
        <select id="eMaxRegistros" name="eMaxRegistros" >
        <? while($rRegistro = mysql_fetch_array($rsMaximos)) { ?>
            <option value="<?=$rRegistro{'eRegistros'};?>"><?=$rRegistro{'eRegistros'};?> registros</option>
        <? } ?>
        </select>
    </td>
    <td>Orden</td>
    <td>
        <select id="rOrden" name="rOrden" >
        <option value="DESC">Descendente</option>
        <option value="ASC">Ascendente</option>
        </select>
    </td>
</tr>
</table>
                                    </form>
                                </div>
                                
                                <div class="clearfix" style="padding:10px;"><img src="/images/separador.jpg" class="img-responsive" style="width:100%;"></div>
                                <!--filtros-->
                                
                                <!--tabla-->
                                <div class="card card-body table-responsive table-responsive-data2" id="divXHR" style="min-height:350px;">
                                </div>
                                <!--tabla-->
                                
                            </div>
                        </div>