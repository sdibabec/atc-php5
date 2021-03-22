<?php
require_once("cnx/swgc-mysql.php");
require_once("cls/cls-sistema.php");
$clSistema = new clSis();
session_start();

$select = "SELECT * FROM CatCamionetas WHERE eCodCamioneta = ".$_GET['v1'];
$rsPublicacion = mysql_query($select);
$rPublicacion = mysql_fetch_array($rsPublicacion);

?>
<?
if($_POST)
{
    $res = $clSistema -> registrarCliente();
    
    if($res)
    {
        ?>
            <div class="alert alert-success" role="alert">
                El cliente se guard&oacute; correctamente!
            </div>
<script>
setTimeout(function(){
    window.location="?tCodSeccion=cata-cli-con";
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

<script>
function validar()
{

        guardar();
}
   
</script>
    
<div class="row">
    <div class="col-lg-12">
    <form id="datos" name="datos" action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="eCodCamioneta" id="eCodCamioneta" value="<?=$_GET['v1']?>">
        <input type="hidden" name="eAccion" id="eAccion">
                            <div class="col-lg-12">
								
                                <div class="card col-lg-12">
                                    
                                    <div class="card-body card-block">
                                        <!--campos-->
                                        <div class="form-group">
              
           </div>
           <div class="form-group">
              <label>Estatus</label>
              <select class="form-control" name="tCodEstatus" id="tCodEstatus">
                  <option value="">Seleccione...</option>
                  <? $select = "SELECT * FROM CatEstatus WHERE tCodEstatus IN ('AC','EL')"; ?>
                  <? $rsEstatus = mysql_query($select); ?>
                  <? while($rEstatus = mysql_fetch_array($rsEstatus)) { ?>
                  <option value="<?=$rEstatus{'tCodEstatus'}?>" <?=(($rEstatus{'tCodEstatus'}==$rPublicacion{'tCodEstatus'}) ? 'selected="selected"' : '')?>><?=$rEstatus{'tNombre'}?></option>
                  <? } ?>
               </select>
           </div>
           <div class="form-group">
              <label>Nombre</label>
              <input type="text" class="form-control" name="tApellidos" id="tNombre" placeholder="Nombre" value="<?=utf8_decode($rPublicacion{'tNombre'})?>" >
           </div>
          
                                        <!--campos-->
                                    </div>
                                </div>
                            </div>
    </form>
    </div>
                        </div>