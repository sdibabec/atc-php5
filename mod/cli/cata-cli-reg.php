<?php
require_once("cnx/swgc-mysql.php");
require_once("cls/cls-sistema.php");
$clSistema = new clSis();
session_start();

$select = "SELECT * FROM CatClientes WHERE eCodCliente = ".$_GET['v1'];
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
var bandera = false;
var mensaje = "";
var tNombre = document.getElementById("tNombre");
var tApellidos = document.getElementById("tApellidos");
var tCorreo = document.getElementById("tCorreo");
var tTelefonoFijo = document.getElementById("tTelefonoFijo");
var tTelefonoMovil = document.getElementById("tTelefonoMovil");

    if(!tNombre.value)
    {
        mensaje += "* Nombre\n";
        bandera = true;
    };
    if(!tApellidos.value)
    {
        mensaje += "* Apellidos\n";
        bandera = true;
    };
    if(!tCorreo.value)
    {
        mensaje += "* E-mail\n";
        bandera = true;
    };
    if(!tTelefonoFijo.value)
    {
        mensaje += "* Telefono Fijo\n";
        bandera = true;
    };
    if(!tTelefonoMovil.value)
    {
        mensaje += "* Telefono Movil\n";
        bandera = true;
    };
    
    
    if(!bandera)
    {
        guardar();
    }
    else
    {
        alert("<- Favor de revisar la siguiente información ->\n"+mensaje)
    }
}
   
</script>
    
<div class="row">
    <div class="col-lg-12">
    <form id="datos" name="datos" action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="eCodCliente" id="eCodCliente" value="<?=$_GET['v1']?>">
        <input type="hidden" name="eAccion" id="eAccion">
                            <div class="col-lg-12">
								
                                <div class="card col-lg-12">
                                    
                                    <div class="card-body card-block">
                                        <!--campos-->
                                        <div class="form-group">
              
           </div>
           <div class="form-group">
              <label>Nombre</label>
              <input type="text" class="form-control" name="tNombre" id="tNombre" placeholder="Nombre" value="<?=utf8_decode($rPublicacion{'tNombres'})?>" >
           </div>
           <div class="form-group">
              <label>Apellidos</label>
              <input type="text" class="form-control" name="tApellidos" id="tApellidos" placeholder="Apellidos" value="<?=utf8_decode($rPublicacion{'tApellidos'})?>" >
           </div>
           <div class="form-group">
              <label>E-mail</label>
              <input type="email" class="form-control" name="tCorreo" id="tCorreo" placeholder="E-mail" value="<?=utf8_decode($rPublicacion{'tCorreo'})?>" >
           </div>
           <div class="form-group">
              <label>Tel&eacute;fono Fijo</label>
              <input type="text" class="form-control" name="tTelefonoFijo" id="tTelefonoFijo" placeholder="Tel&eacute;fono Fijo" value="<?=utf8_decode($rPublicacion{'tTelefonoFijo'})?>" >
           </div>
           <div class="form-group">
              <label>Tel&eacute;fono M&oacute;vil</label>
              <input type="text" class="form-control" name="tTelefonoMovil" id="tTelefonoMovil" placeholder="Tel&eacute;fono M&oacute;vil" value="<?=utf8_decode($rPublicacion{'tTelefonoMovil'})?>" >
           </div>
            <div class="form-group">
              <label>Comentarios</label>

              <textarea rows="5" class="form-control" name="tComentarios" id="tComentarios" ><?=utf8_decode($rPublicacion{'tComentarios'})?></textarea>

           </div>
           <div class="form-group">
              <label><input type="checkbox" id="bFrecuente" name="bFrecuente" value="1" <?=($rPublicacion{'bFrecuente'} ? 'checked="checked"' : '')?>>Cliente Frecuente</label>
              
           </div>
                                        <!--campos-->
                                    </div>
                                </div>
                            </div>
    </form>
    </div>
                        </div>