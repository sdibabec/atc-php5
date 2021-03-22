<?php
require_once("cnx/swgc-mysql.php");
require_once("cls/cls-sistema.php");


$clSistema = new clSis();
session_start();

$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bDelete'];

if($_GET['bEliminar']==1)
{
    
        $update = "DELETE FROM CatServicios WHERE eCodServicio = ".$_GET['eCodServicio'];
    
    mysql_query($update);
    echo '<script>window.location="?tCodSeccion='.$_GET['tCodSeccion'].'";</script>';
}

$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bAll'];

$select = "SELECT * FROM SisMaximosRegistros ORDER BY eRegistros ASC";
$rsMaximos = mysql_query($select);

?>
 
<script>
function detalles(eCodCliente)
    {
        window.location="?tCodSeccion=cata-ser-det&eCodServicio="+eCodCliente;
    }
    
    //autocomplete
    function buscarInventarioConsulta()
        {
            var eCodInventario = document.getElementById('eCodInventario'),
                tInventario = document.getElementById('tInventario');
            
            if(!tInventario.value || tInventario.value=="")
                { eCodInventario.value=""; }
             $( function() {
  
        $( "#tInventario" ).autocomplete({
            source: function( request, response ) {
                
                $.ajax({
                    url: "/que/json-inventario.php",
                    type: 'get',
                    dataType: "json",
                    data: {
                        search: request.term
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {
                $('#tInventario').val(ui.item.label); // display the selected text
                $('#eCodInventario').val(ui.item.value); // save selected id to input
                return false;
            }
        });

       
        }); 
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
    <td><label><input type="radio" name="rdOrden" value="eCodServicio" checked="checked"> C&oacute;digo</label></td>
    <td>
        <input type="text" class="form-control" name="eCodServicio" id="eCodServicio">
    </td>
    <td colspan="2">
    </td>
</tr>
<tr>
    <td><label><input type="radio" name="rdOrden" value="tNombre"> Nombre</label></td>
    <td>
        
        <input type="text" class="form-control" id="tNombre" name="tNombre" placeholder="">
    </td>
    <td><label> Inventario</label></td>
    <td>
        <input type="hidden" name="eCodInventario" id="eCodInventario">
        <input type="text" class="form-control" id="tInventario" placeholder="Inventario" onkeyup="buscarInventarioConsulta()" onkeypress="buscarInventarioConsulta()">
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