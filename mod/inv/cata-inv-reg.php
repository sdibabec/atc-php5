<?php
require_once("cnx/swgc-mysql.php");
require_once("cls/cls-sistema.php");
$clSistema = new clSis();
session_start();

$select = "	SELECT 
	cti.tNombre as tipo,
	ci.*
FROM
	CatInventario ci
	INNER JOIN CatTiposInventario cti
WHERE ci.eCodInventario = ".$_GET['v1'];
//echo $select;
$rsPublicacion = mysql_query($select);
$rPublicacion = mysql_fetch_array($rsPublicacion);

?>
<!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0-alpha1/jquery.js"></script>-->
	<script type="text/javascript">
		function readURL(input,destino) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function (e) {
					$('#falseinput').attr('src', e.target.result);
					$('#base').val(e.target.result);
          document.getElementById(destino).value=e.target.result;
          //llenar();
				};
				reader.readAsDataURL(input.files[0]);
			}
		}
   
function validar()
{
var bandera = false;
var mensaje = "";
var tCodInventario = document.getElementById("tCodInventario");
var tNombre = document.getElementById("tNombre");
var eCodTipoInventario = document.getElementById("eCodTipoInventario");
var eCodSubclasificacion = document.getElementById("eCodSubclasificacion");
var tDescripcion = document.getElementById("tDescripcion");
var dPrecioInterno = document.getElementById("dPrecioInterno");
var dPrecioVenta = document.getElementById("dPrecioVenta");
var tImagen = document.getElementById("tImagen");
var ePiezas = document.getElementById("ePiezas");
var eStock = document.getElementById("eStock");

    if(!tCodInventario.value)
    {
        mensaje += "* Nombre Corto\n";
        bandera = true;
    };
    if(!tNombre.value)
    {
        mensaje += "* Nombre\n";
        bandera = true;
    };
	if(!eCodTipoInventario.value)
    {
        mensaje += "* Tipo\n";
        bandera = true;
    };
    if(!eCodSubclasificacion.value)
    {
        mensaje += "* Subclasificacion\n";
        bandera = true;
    };
    if(!tDescripcion.value)
    {
        mensaje += "* Descripcion\n";
        bandera = true;
    };
    if(!dPrecioInterno.value)
    {
        mensaje += "* Precio Interno\n";
        bandera = true;
    };
	if(!dPrecioVenta.value)
    {
        mensaje += "* Precio Público\n";
        bandera = true;
    };
	if(!tImagen.value)
    {
        mensaje += "* Imagen\n";
        bandera = true;
    };
	if(!ePiezas.value)
    {
        mensaje += "* Unidades\n";
        bandera = true;
    };
    if(!eStock.value)
    {
        mensaje += "* Stock\n";
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
        <input type="hidden" id="eCodInventario" name="eCodInventario" value="<?=$_GET['v1']?>">
        <input type="hidden" name="eAccion" id="eAccion">
                            <div class="col-lg-12">
								
                                <div class="card col-lg-12">
                                    
                                    <div class="card-body card-block">
                                        <!--campos-->
                                        <div class="form-group">
              
           </div>
           <div class="form-group">
              <label>Tipo</label>
              <select id="eCodTipoInventario" name="eCodTipoInventario" onchange="buscarSubclasificacion()">
			  <option value="">Seleccione...</option> 
				  <?
		$select = "SELECT * FROM CatTiposInventario order by tNombre ASC";
		$rsTipos = mysql_query($select);
		   while($rTipo = mysql_fetch_array($rsTipos))
		   {
			   ?>
				  <option value="<?=$rTipo{'eCodTipoInventario'}?>" <?=($rTipo{'eCodTipoInventario'}==$rPublicacion{'eCodTipoInventario'}) ? 'selected' : ''?>><?=$rTipo{'tNombre'}?></option>
				  <?
		   }
	?>
			  </select>
           </div>
           <div class="form-group">
              <label>Subclasificaci&oacute;</label>
              <select id="eCodSubclasificacion" name="eCodSubclasificacion">
			  <option value="">Seleccione...</option> 
				  <?
		$select = "SELECT * FROM CatSubClasificacionesInventarios order by tNombre ASC";
		$rsTipos = mysql_query($select);
		   while($rTipo = mysql_fetch_array($rsTipos))
		   {
			   ?>
				  <option value="<?=$rTipo{'eCodSubclasificacion'}?>" <?=($rTipo{'eCodSubclasificacion'}==$rPublicacion{'eCodSubclasificacion'}) ? 'selected' : ''?>><?=$rTipo{'tNombre'}?></option>
				  <?
		   }
	?>
			  </select>
           </div>
           <div class="form-group">
              <label>Nombre Corto</label>
              <input type="text" class="form-control" name="tCodInventario" id="tCodInventario" placeholder="Nombre Corto" maxlength="4" value="<?=($rPublicacion{'tCodInventario'})?>" <?=($rPublicacion{'tCodInventario'}) ? 'readonly="readonly"' : ''?> style="width:150px;">
           </div>
		   <div class="form-group">
              <label>Nombre</label>
              <input type="text" class="form-control" name="tNombre" id="tNombre" placeholder="Nombre" value="<?=($rPublicacion{'tNombre'})?>" >
           </div>
		   <div class="form-group">
              <label>Marca (opcional)</label>
              <input type="text" class="form-control" name="tMarca" id="tMarca" placeholder="Marca" value="<?=($rPublicacion{'tMarca'})?>" >
           </div>
           <div class="form-group">
              <label>Descripci&oacute;n</label>
              <textarea class="form-control" name="tDescripcion" id="tDescripcion" placeholder="Descripci&oacute;n"><?=($rPublicacion{'tDescripcion'})?></textarea>
           </div>
           <div class="form-group">
              <label>Precio Interno</label>
              <input type="text" class="form-control" name="dPrecioInterno" id="dPrecioInterno" placeholder="Precio Interno" value="<?=($rPublicacion{'dPrecioInterno'})?>" >
           </div>
           <div class="form-group">
              <label>Precio de Venta</label>
              <input type="text" class="form-control" name="dPrecioVenta" id="dPrecioVenta" placeholder="Precio de Venta" value="<?=($rPublicacion{'dPrecioVenta'})?>" >
           </div>
           <div class="form-group">
              <label>Unidades</label>
              <input type="text" class="form-control" name="ePiezas" id="ePiezas" placeholder="Unidades" value="<?=($rPublicacion{'ePiezas'})?>" >
           </div>
           <div class="form-group">
              <label>Stock (total)</label>
              <input type="text" class="form-control" name="eStock" id="eStock" placeholder="Stock (total)" value="<?=($rPublicacion{'eStock'})?>" >
           </div>
           <div class="form-group">
              <label>Imagen</label>
              <input type="file" class="form-control" name="tArchivo" id="tArchivo" onchange="readURL(this,'tImagen')">
			   <input type="hidden" id="tImagen" name="tImagen" value="<?=base64_decode($rPublicacion{'tImagen'})?>">
               <input type="hidden" id="tFichero" name="tFichero" value="<?=$rPublicacion{'tImagen'}?>">
               <input type="hidden" id="bFichero" name="bFichero" value="<?=$rPublicacion{'tImagen'} ? 1 : 0?>">
           </div>
           
                                        <!--campos-->
                                    </div>
                                </div>
                            </div>
    </form>
    </div>
                        </div>