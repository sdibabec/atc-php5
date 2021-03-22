<?php
require_once("cnx/swgc-mysql.php");
require_once("cls/cls-sistema.php");


$clSistema = new clSis();
session_start();
$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bAll'];

if($_GET['bEliminar']==1)
{
    $select = "SELECT * FROM BitEventos WHERE eCodCliente = ".$_GET['eCodCliente'];
    $rs = mysql_query($select);
    
    if(mysql_num_rows($rs)>0)
    {
        $update = "UPDATE CatClientes SET eCodEstatus=7 WHERE eCodCliente = ".$_GET['eCodCliente'];
    }
    else
    {
        $update = "DELETE FROM CatClientes WHERE eCodCliente = ".$_GET['eCodCliente'];
    }
    mysql_query($update);
    echo '<script>window.location="?tCodSeccion='.$_GET['tCodSeccion'].'";</script>';
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
function detalles(eCodCliente)
    {
        window.location="?tCodSeccion=cata-cli-det&eCodCliente="+eCodCliente;
    }
function exportar()
    {
        window.location="gene-cli-xls.php";
    }
    
$(document).ready(function() {
             filtrar();
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
    <td><label><input type="radio" name="rdOrden" value="eCodCliente" checked="checked"> C&oacute;digo</label></td>
    <td>
        <input type="text" class="form-control" name="eCodCliente" id="eCodCliente">
    </td>
    <td></td>
    <td>
    </td>
</tr>
<tr>
    <td><label><input type="radio" name="rdOrden" value="tNombres" checked="checked"> Nombre(s)</label></td>
    <td>
        <input type="text" class="form-control" name="tNombres" id="tNombres">
    </td>
    <td><label><input type="radio" name="rdOrden" value="tApellidos" checked="checked"> Apellido(s)</label></td>
    <td>
        <input type="text" class="form-control" name="tApellidos" id="tApellidos">
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