<?php
require_once("cnx/swgc-mysql.php");
require_once("cls/cls-sistema.php");
$clSistema = new clSis();
session_start();

$select = "SELECT * FROM CatServicios WHERE eCodServicio = ".$_GET['v1'];
$rsPublicacion = mysql_query($select);
$rPublicacion = mysql_fetch_array($rsPublicacion);

?>

<script>
function validar()
{
var bandera = false;
var mensaje = "";
var tNombre = document.getElementById("tNombre");
var tDescripcion = document.getElementById("tDescripcion");
var dPrecio = document.getElementById("dPrecio");
var eHoras = document.getElementById("eHoras");

    if(!tNombre.value)
    {
        mensaje += "* Nombre\n";
        bandera = true;
    };
    if(!tDescripcion.value)
    {
        mensaje += "* Descripcion\n";
        bandera = true;
    };
    if(!dPrecio.value)
    {
        mensaje += "* Precio\n";
        bandera = true;
    };
    if(!eHoras.value)
    {
        mensaje += "* Horas\n";
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
    
    function validaNumero(value)
{
    if(value)
        {
            var regex = /[0-9]/;
            if( !regex.test(value) )
            {alert("Error, solo se admiten numeros enteros");}
        }
}
    
    //autocomplete
    function agregarInventario(indice)
        {
             $( function() {
  
        $( "#tInventario"+indice ).autocomplete({
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
                $('#tInventario'+indice).val(ui.item.label); // display the selected text
                $('#eCodInventario'+indice).val(ui.item.value); // save selected id to input
                return false;
            }
        });

       
        }); 
        }
   
</script>
    
<div class="row">
    <div class="col-lg-12">
    <form id="datos" name="datos" action="<?=$_SERVER['REQUEST_URI']?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="eCodServicio" id="eCodServicio" value="<?=$_GET['v1']?>">
        <input type="hidden" name="eAccion" id="eAccion">
                            <div class="col-lg-12">
								
                                <div class="card col-lg-12">
                                    
                                    <div class="card-body card-block">
                                        <!--campos-->
                                        <div class="form-group">
              
           </div>
           <div class="form-group">
              <label>Nombre</label>
              <input type="text" class="form-control" name="tNombre" id="tNombre" placeholder="Nombre" value="<?=utf8_encode($rPublicacion{'tNombre'})?>" >
           </div>
           <div class="form-group">
              <label>Descripci&oacute;n</label>
              <textarea class="form-control" name="tDescripcion" id="tDescripcion" placeholder="Descripci&oacute;n" rows="5" style="resize:none;"><?=base64_decode($rPublicacion{'tDescripcion'})?></textarea>
           </div>
           <div class="form-group">
              <label>Horas de Servicio</label>
              <input type="text" class="form-control" name="eHoras" id="eHoras" placeholder="Horas de Servicio" value="<?=($rPublicacion{'eHoras'})?>" >
			   <div><sup>Solo números. Ej. 5</sup></div>
           </div>
           <div class="form-group">
              <label>Precio Hora Extra</label>
              <input type="text" class="form-control" name="dHoraExtra" id="dHoraExtra" placeholder="Precio Hora Extra" value="<?=($rPublicacion{'dHoraExtra'})?>" >
			   <div><sup>Solo números. Ej. 1200.00</sup></div>
           </div>
           <div class="form-group">
              <label>Precio de Venta</label>
              <input type="text" class="form-control" name="dPrecio" id="dPrecio" placeholder="Precio de Venta" value="<?=($rPublicacion{'dPrecioVenta'})?>" >
			   <div><sup>Solo números. Ej. 1200.00</sup></div>
           </div>
           
           
                                        <!--campos-->
                                    </div>
                                </div>
                            </div>
        
        <!--tabs-->
        
        <div class="" style="padding-top:10px;">
            <table id="tbInventario">
                                        <thead>
                                            <tr>
				   <th width="2%"></th>
			   <th width="93%">Inventario</th>
				   <th width="2%">Piezas</th>
			   </tr>
                                        </thead>
                                        <tbody>
											<?
											$select = "	SELECT 
															cti.ePiezas, 
															ci.tNombre,
                                                            ci.eCodInventario
														FROM
															CatInventario ci
															INNER JOIN RelServiciosInventario cti ON cti.eCodInventario = ci.eCodInventario AND cti.eCodServicio = ".$_GET['v1'];
											$rsPublicaciones = mysql_query($select);
		   									$b = 0;
											while($rPublicacion = mysql_fetch_array($rsPublicaciones))
											{
												?>
											<tr id="inv<?=$b;?>">
                                                <td style="padding:5px;"><i class="far fa-trash-alt" onclick="eliminarFilaInventario(<?=$b;?>)"></i><input type="hidden" name="inventario[<?=$b;?>][eCodInventario]" id="eCodInventario<?=$b;?>" value="<?=$rPublicacion{'eCodInventario'}?>"></td>
                                                <td><input type="text" class="form-control" id="tInventario<?=$b;?>" name="tInventario<?=$b;?>" onchange="agregarFilaInventario(<?=$b;?>)" value="<?=$rPublicacion{'tNombre'}?>" onkeyup="agregarInventario(<?=$b;?>)" onkeypress="agregarInventario(<?=$b;?>)"></td>
                                                <td><input type="text" class="form-control" name="inventario[<?=$b;?>][ePiezas]" id="ePiezas<?=$b;?>" onblur="validaNumero(this.value);" value="<?=$rPublicacion{'ePiezas'}?>"></td>
                                            </tr>
											<?
													$b++;
											}
											?>
                                            <tr id="inv<?=$b;?>">
                                                <td style="padding:5px;">
                                                    <i class="far fa-trash-alt" onclick="eliminarFilaInventario(<?=$b;?>)"></i><input type="hidden" name="inventario[<?=$b;?>][eCodInventario]" id="eCodInventario<?=$b;?>">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" id="tInventario<?=$b;?>" name="tInventario<?=$b;?>" onchange="agregarFilaInventario(<?=$b;?>)"  onkeyup="agregarInventario(<?=$b;?>)" onkeypress="agregarInventario(<?=$b;?>)">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="inventario[<?=$b;?>][ePiezas]" id="ePiezas<?=$b;?>" onblur="validaNumero(this.value);">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
        
        </div>
        <!--tabs-->
		
		
		 		
    </form>
    </div>
                        </div>