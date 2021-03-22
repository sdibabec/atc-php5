<?
/* **************************** */
/* Modal de filtros de consulta */
/* **************************** */

require_once("../cnx/swgc-mysql.php");


date_default_timezone_set('America/Mexico_City');

session_start();

$select = "SELECT * FROM SisMaximosRegistros ORDER BY eRegistros ASC";
$rsMaximos = mysql_query($select);
        
$select = "SELECT DISTINCT
	ce.tNombre tEstatus,
	ce.tCodEstatus 
FROM
	CatEstatus
	INNER JOIN BitEventos be ON be.eCodEstatus= ce.eCodEstatus 
ORDER BY
	ce.tNombre ASC";
$rsEstatus = mysql_query($select);

?>
<div class="modal fade" id="modFiltros" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
             <table width="100%">
<tr>
    <td>Cliente</td>
    <td>
        <input type="hidden" name="eCodCliente" id="eCodCliente">
        <input type="text" class="form-control" id="tCliente" placeholder="Cliente" onblur="filtrar()">
    </td>
</tr>
<tr>
    <td>Estatus</td>
    <td>
        <select id="eCodEstatus" name="eCodEstatus" onblur="filtrar()">
        <? while($rEstatus = mysql_fetch_array($rsEstatus)) { ?>
            <option value="<?=$rEstatus{'eCodEstatus'};?>"><?=$rEstatus{'tEstatus'};?></option>
        <? } ?>
        </select>
    </td>
</tr>
<tr>
    <td>Fecha</td>
    <td id="input-daterange">
            <input type="text" class="input-sm" name="fhFechaEventoInicio" value="<?=date('m/d/Y');?>"/>
            <span class="input-group-addon">a</span>
            <input type="text" class="input-sm" name="fhFechaEventoTermino" value="<?=date('m/d/Y');?>"/>
    </td>
</tr>
<tr>
    <td>Mostrar</td>
    <td>
        <select id="eCodEstatus" name="eCodEstatus" onblur="filtrar()">
        <? while($rRegistro = mysql_fetch_array($rsMaximos)) { ?>
            <option value="<?=$rRegistro{'eRegistros'};?>"><?=$rRegistro{'eRegistros'};?> registros</option>
        <? } ?>
        </select>
    </td>
</tr>
<tr>
    <td>Orden</td>
    <td>
        <select id="rOrden" name="rOrden" onblur="filtrar()">
        <option value="ASC">Ascendente</option>
        <option value="ASC">Descendente</option>
        </select>
    </td>
</tr>
</table>
            </div>
            <div class="modal-footer">
              <button type="button" class="form-control btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>

        </div>

    </div>
</div>