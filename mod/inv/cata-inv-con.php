<?php
require_once("cnx/swgc-mysql.php");
require_once("cls/cls-sistema.php");
$clSistema = new clSis();
session_start();

$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bDelete'];

if($_GET['eCodInventario'])
{
    mysql_query("DELETE FROM CatInventario WHERE eCodInventario =".$_GET['eCodInventario']);
    echo '<script>window.location="?tCodSeccion=cata-inv-con";</script>';
}

$select = "SELECT * FROM CatTiposInventario";
$rsTiposInventario = mysql_query($select);

$select = "SELECT * FROM SisMaximosRegistros ORDER BY eRegistros ASC";
$rsMaximos = mysql_query($select);

//$bAll = $clSistema->validarPermiso(obtenerScript());
//$bDelete = $clSistema->validarEliminacion(obtenerScript());

?>

<script>

function detalles(eCodCliente)
    {
        window.location="?tCodSeccion=cata-inv-det&eCodInventario="+eCodCliente;
    }
function eliminar(eCodInventario)
    {
        window.location="?tCodSeccion=cata-inv-con&eCodInventario="+eCodInventario;
    }
    
$(document).ready(function() {
             filtrar();
    
});
    
</script>
<div class="row">
                            <div class="col-lg-12">
                                
                                
                                     <!--filtros-->
                                <div class="table-data__tool">
                                    <div class="table-data__tool-left" id="eRegistros" style="font-size:16px; font-weight:bold;"></div>
                                    <div style="text-align:right;">
                                        <button class="btn btn-info" onclick="mostrarFiltros()">
                                            <i class="zmdi zmdi-filter-list"></i>Filtros</button>
                                        <button class="btn btn-info" onclick="filtrar()">
                                            <i class="zmdi zmdi-search"></i>Consultar</button>
                                    </div>
                                </div>
                                
                                <div id="divFiltros" style="display:none;" class="card card-body table-responsive">
                                <form id="Datos" name="Datos">
                                    <input type="hidden" name="tAccion" id="tAccion" value="">
                                    <input type="hidden" name="eAccion" id="eAccion" value="">
                                    <table width="100%" cellpadding="10" class="table table-bordered">
                                    <tr>
                                        <td width="25%"></td>
                                        <td width="25%"></td>
                                        <td width="25%"></td>
                                        <td width="25%"></td>
                                    </tr>
<tr>
    <td><label><input type="radio" name="rdOrden" value="eCodInventario" checked="checked"> C&oacute;digo</label></td>
    <td>
        <input type="text" class="form-control" name="eCodInventario" id="eCodInventario">
    </td>
    <td colspan="2">
    </td>
</tr>
<tr>
    <td><label><input type="radio" name="rdOrden" value="tNombre"> Nombre</label></td>
    <td>
        
        <input type="text" class="form-control" id="tNombre" name="tNombre" placeholder="">
    </td>
    <td><label> Tipo Inventario</label></td>
    <td>
        <select id="eCodTipoInventario" name="eCodTipoInventario">
        <option value="">Seleccione...</option>
            <? while($rTipoInventario = mysql_fetch_array($rsTiposInventario)){ ?>
            <option value="<?=$rTipoInventario{'eCodTipoInventario'};?>"><?=utf8_encode($rTipoInventario{'tNombre'});?></option>
            <? } ?>
        </select>
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
                                <div class="table-responsive table-responsive-data2" id="divXHR" style="min-height:350px;">
                                </div>
                                <!--tabla-->
                                
                            </div>
                        </div>