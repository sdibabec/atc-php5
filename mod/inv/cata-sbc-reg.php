<?php
require_once("cnx/swgc-mysql.php");
require_once("cls/cls-sistema.php");
$clSistema = new clSis();
session_start();

$select = "	SELECT 
	ci.*
FROM
	CatSubClasificacionesInventarios ci
WHERE ci.eCodSubclasificacion = ".$_GET['v1'];
//echo $select;
$rsPublicacion = mysql_query($select);
$rPublicacion = mysql_fetch_array($rsPublicacion);

?>
<?
if($_POST)
{
    $res = $clSistema -> registrarInventario();
    
    if($res)
    {
        ?>
            <div class="alert alert-success" role="alert">
                El producto se guard&oacute; correctamente!
            </div>
<script>
setTimeout(function(){
    window.location="?tCodSeccion=cata-inv-con";
},2500);
</script>
<?
    }
    else
    {
  ?>
            <div class="alert alert-danger" role="alert">
                Error al procesar la solicitud!
            </div>
<?
    }
}
?>

    
<div class="row">
    <div class="col-lg-12">
    <form id="datos" name="datos" action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
        <input type="hidden" id="eCodSubclasificacion" name="eCodSubclasificacion" value="<?=$_GET['v1']?>">
        <input type="hidden" name="eAccion" id="eAccion">
                            <div class="col-lg-12">
								
                                <div class="card col-lg-12">
                                    
                                    <div class="card-body card-block">
                                        <!--campos-->
           
		                                    <div class="form-group">
                                               <label>Tipo de Inventario</label>
                                               <select class="form-control" id="eCodTipoInventario" name="eCodTipoInventario">
                                                <option value="">Seleccione...</option>
                                                   <? $select = "SELECT * FROM CatTiposInventario ORDER BY ePosicion ASC";
                                                        $rsTipos = mysql_query($select);
                                                        while($rTipo = mysql_fetch_array($rsTipos)) {?>
                                                   <option value="<?=$rTipo{'eCodTipoInventario'};?>" <?=(($rTipo{'eCodTipoInventario'}==$rPublicacion{'eCodTipoInventario'}) ? 'selected="selected"' : '' );?>><?=$rTipo{'tNombre'};?></option>
                                                   <? } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                               <label>Nombre</label>
                                               <input type="text" class="form-control" name="tNombre" id="tNombre" placeholder="Nombre" value="<?=($rPublicacion{'tNombre'})?>" >
                                            </div>
                                            <div class="form-group">
                                               <label>Posici&oacute;n</label>
                                               <input type="text" class="form-control" name="ePosicion" id="ePosicion" placeholder="Posición" value="<?=($rPublicacion{'ePosicion'})?>" >
                                            </div>
           
                                        <!--campos-->
                                    </div>
                                </div>
                            </div>
    </form>
    </div>
                        </div>