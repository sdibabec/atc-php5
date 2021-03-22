function validarUsuario()
{
	var passwdOperaciones = document.getElementById('tPasswordOperaciones'),
		passwdVerificador = document.getElementById('tPasswordVerificador'),
		btnGuardar = document.getElementById('btnGuardar'),
		btnValidar = document.getElementById('btnValidar');
	
	if(passwdOperaciones.value == passwdVerificador.value)
		{
			btnGuardar.disabled = false;
            passwdOperaciones.style.display = 'none';
            btnValidar.style.display = 'none';
		}
}

function fnRedireccionar(seccion)
{
	window.location = seccion;
}

function cerrarSesion()
{
	if(confirm("Realmente deseas salir?"))
		{
			window.location="/logout/";
		}
}

function activarValidacion()
{
    document.getElementById('tPasswordOperaciones').style.display = 'inline';
    
    document.getElementById('tPasswordOperaciones').focus();
}

function consultarFecha()
{
	var formulario = document.getElementById('datos');
    
			formulario.submit();
	
}



function consultarDetalle(codigo)
      {
          document.getElementById('eCodEvento').value=codigo;
          
          var obj = $('#consDetalle').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
           $('#resDetalle').modal('show'); 
          
          $.ajax({
              type: "POST",
              url: "/cla/cons-deta.php",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  
                  
                 
                  document.getElementById('detalleEvento').innerHTML = data.detalle;
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });    
          
      }

      
      function cargarTransporte(codigo)
      {
          document.getElementById('eCodEvento').value=codigo;
          document.getElementById('eCodEventoCarga').value=codigo;
          
          document.getElementById('eCodCamioneta').value="";
          
          var obj = $('#consDetalle').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
           $('#detCarga').modal('show'); 
          
          $.ajax({
              type: "POST",
              url: "/cla/deta-reg.php",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  
                  
                 
                  document.getElementById('detalleCarga').innerHTML = data.detalle;
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });
             
          
      }
    
      function nvaTran()
      {
          var obj = $('#nvaTran').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
          $.ajax({
              type: "POST",
              url: "/cla/nva-tran.php",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  if(data.exito==1)
                  {
                      $('#resExito').modal('show');
                      setTimeout(function(){ $('#resExito').modal('hide'); }, 3000);
                  }
                  else
                      {
                          var mensaje="";
                          for(var i=0;i<data.errores.length;i++)
                     {
                         mensaje += "-"+data.errores[i]+"\n";
                     }
                          alert("Error al procesar la solicitud.\n<-Valide la siguiente informacion->\n\n"+mensaje);
                         
                      }
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });
          
      }
            
      function nvaOper()
      {
          var obj = $('#nvaOperador').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
          $.ajax({
              type: "POST",
              url: "/cla/nva-oper.php",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  if(data.exito==1)
                  {
                      $('#resExito').modal('show');
                      setTimeout(function(){ $('#resExito').modal('hide'); }, 3000);
                  }
                  else
                      {
                          var mensaje="";
                          for(var i=0;i<data.errores.length;i++)
                     {
                         mensaje += "-"+data.errores[i]+"\n";
                     }
                          alert("Error al procesar la solicitud.\n<-Valide la siguiente informacion->\n\n"+mensaje);
                         
                      }
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });
          
      }

/*Asignaciones*/
      function asignarParametro(codigo,nombre)
      {
          document.getElementById('eCodCliente').value = codigo;
          document.getElementById('tNombreCliente').value = nombre;
          document.getElementById('tNombreCliente').style.display = 'inline';
          document.getElementById('asignarCliente').style.display = 'inline';
          document.getElementById('cot1').style.display = 'inline';
          document.getElementById('cot2').style.display = 'inline';
          document.getElementById('cot3').style.display = 'inline';
          var tblClientes = document.getElementById('mostrarTabla');
          if(tblClientes)
          {
          tblClientes.style.display='none';
          }
      }
      
      function verMisClientes()
      {
          $('#misClientes').modal({
                show: 'false'
            });
      }
      
      function agregarTransaccion(codigo)
      {
          document.getElementById('eCodEventoTransaccion').value = codigo;
      }
            
      function nuevaTransaccion(codigo)
      {
          document.getElementById('eCodEventoTransaccion').value = codigo;
          $('#myModal').modal('show');
      }
      
      function agregarOperador(codigo)
      {
          document.getElementById('eCodEventoOperador').value = codigo;
      }
            
    function asignarFecha(fecha,etiqueta)
      {
          document.getElementById('fhFechaConsulta').value=fecha;
          document.getElementById('tFechaConsulta').innerHTML = '<br><h2>'+etiqueta+'</h2>';
          consultarFecha();
      }
            
    function cambiarFechaEvento(mes,anio)
      {
          document.getElementById('nvaFecha').value=mes+'-'+anio;
          
          var obj = $('#datos').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
          $.ajax({
              type: "POST",
              url: "/inc/cal-cot.php",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  document.getElementById('calendario').innerHTML = data.calendario;
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });
          
      }
            
    function asignarFechaEvento(fecha,etiqueta,codigo)
      {
          document.getElementById('fhFechaEvento').value=fecha;
          document.getElementById('tFechaConsulta').innerHTML = '<br><h2>'+etiqueta+'</h2>';
      }
            
    function validarCarga()
      {
          var cmbTotal = document.querySelectorAll("[id^=eCodInventario]"),
              eCodCamioneta = document.getElementById('eCodCamioneta'),
              clickeado = 0;
          
          cmbTotal.forEach(function(nodo){
            if(nodo.checked==true)
                { clickeado++;}
        });
          
          if(clickeado==cmbTotal.length && eCodCamioneta.value>0)
              { document.getElementById('guardarCarga').style.display = 'inline'; }
          else
              { document.getElementById('guardarCarga').style.display = 'none'; }
      }
            
    function registrarCarga()
        {
            $('#detCarga').modal('hide');
            
            var obj = $('#carga').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
          $.ajax({
              type: "POST",
              url: "/cla/reg-carga-eve.php",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  if(data.exito==1)
                  {
                      
                      $('#resExito').modal('show');
                      setTimeout(function(){ $('#resExito').modal('hide'); consultarFecha(); }, 3000);
                      
                  }
                  else
                      {
                          $('#detCarga').modal('show');
                          var mensaje="";
                          for(var i=0;i<data.errores.length;i++)
                     {
                         mensaje += "-"+data.errores[i]+"\n";
                     }
                          alert("Error al procesar la solicitud.\n<-Valide la siguiente informacion->\n\n"+mensaje);
                         
                      }
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });    
        }
        
         function buscarSubclasificacion()
        {
          var obj = $('#datos').serializeJSON();
          var jsonString = JSON.stringify(obj);
          
          $.ajax({
              type: "POST",
              url: "/que/buscar-subclasificaciones.php",
              data: jsonString,
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              success: function(data){
                  document.getElementById('eCodSubclasificacion').innerHTML = data.valores;
              },
              failure: function(errMsg) {
                  alert('Error al enviar los datos.');
              }
          });    
        }

//eliminaciones
function deleteRow(rowid,tabla)  {   
    var row = document.getElementById(rowid);
    row.parentNode.removeChild(row);
        
        if(tabla=="extras")
            {
               var x = document.getElementById("extras").rows.length;
                if(x<2)
                    {
                        agregarFilaExtra(0);
                    }
            }
        
        calcular();
}


// para cotizaciones
function validarPiezas(prefijo)
{
    var eMaxPiezas  =   document.getElementById(prefijo+'-eMaxPiezas'),
        ePiezas     =   document.getElementById(prefijo+'-ePiezas');
    
    if(parseInt(ePiezas.value)>parseInt(eMaxPiezas.value))
        { 
            alert("El máximo permitido es de "+eMaxPiezas.value+" unidades"); 
            ePiezas.value="";
        }
}

function validarExtra(indice)
    {
        var tDescripcion    =   document.getElementById('extra'+indice+'-tDescripcion'),
            dImporte        =   document.getElementById('extra'+indice+'-dImporte'),
            nIndice         =   parseInt(indice)+1;
        
        if(tDescripcion.value && dImporte.value)
            {
                agregarFilaExtra(nIndice);    
            }
    }
    
function agregarFilaExtra(indice)
    {
        var x = document.getElementById("extras").rows.length;
        
        var tExtra = document.getElementById('extra'+indice+'-tDescripcion');
        if(typeof tExtra != "undefined")  
        {
           
    var table = document.getElementById("extras");
    var row = table.insertRow(x);
    row.id="ext"+(indice);
    row.innerHTML = '<td><i class="far fa-trash-alt" onclick="deleteRow(\'ext'+indice+'\',\'extras\')"></i></td>';
    row.innerHTML += '<td><input type="checkbox" id="extra'+indice+'-bSuma" name="extra['+indice+'][bSuma]" value="1" onclick="calcular();"></td><td><input type="text" class="form-control" id="extra'+indice+'-tDescripcion" name="extra['+indice+'][tDescripcion]" onkeyup="validarExtra('+indice+')"></td>';
    row.innerHTML += '<td><input type="text" class="form-control" id="extra'+indice+'-dImporte" name="extra['+indice+'][dImporte]" onkeyup="validarExtra('+indice+')"></td>';
        }
        
    calcular();
        
    }

//inventario

function calcularTotalInventario(indice)
{
   var eCodInventario    =   document.getElementById('inventario'+indice+'-eCodInventario'),
            ePiezas        =   document.getElementById('inventario'+indice+'-ePiezas'),
            dImporte = document.getElementById('inventario'+indice+'-dImporte'),
            dMonto = document.getElementById('inventario'+indice+'-dMonto');
        
        if(eCodInventario.value && ePiezas.value)
            {
                dMonto.value = parseInt(ePiezas.value)*parseInt(dImporte.value);   
            } 
}

function validarInventario(indice)
    {
        var eCodInventario    =   document.getElementById('inventario'+indice+'-eCodInventario'),
            ePiezas        =   document.getElementById('inventario'+indice+'-ePiezas'),
            dImporte = document.getElementById('inventario'+indice+'-dImporte'),
            dMonto = document.getElementById('inventario'+indice+'-dMonto'),
            nIndice         =   parseInt(indice)+1;
        
        if(eCodInventario.value && ePiezas.value)
            {
                dMonto.value = parseInt(ePiezas.value)*parseInt(dImporte.value);
                agregarFilaInventarioCotizacion(nIndice);    
            }
    }
    
function agregarFilaInventarioCotizacion(indice)
    {
        var x = document.getElementById("invs").rows.length;
        
        
        var tExtra = document.getElementById('inventario'+indice+'-eCodInventario');
        if(tExtra)
            {}
        else
        {
           
    var table = document.getElementById("invs");
    var row = table.insertRow(x);
    row.id="inv"+(indice);
    row.innerHTML = '<td><i class="far fa-trash-alt" onclick="deleteRow(\'inv'+indice+'\',\'invs\')"></i></td>';
    row.innerHTML += '<td><input type="checkbox" id="inventario'+indice+'-bSuma" name="inventario['+indice+'][bSuma]" value="1" onclick="calcular();"></td><td><input type="hidden" id="inventario'+indice+'-eCodInventario" name="inventario['+indice+'][eCodInventario]"><input type="text" class="form-control" id="tInventario'+indice+'" name="tInventario'+indice+'" onkeyup="agregarInventario('+indice+')" onkeypress="agregarInventario('+indice+')" onblur="validarInventario('+indice+')"></td>';
    row.innerHTML += '<td><input type="hidden" id="inventario'+indice+'-eMaxPiezas"><input type="hidden" id="inventario'+indice+'-dImporte" name="inventario['+indice+'][dImporte]"><input type="text" class="form-control" id="inventario'+indice+'-ePiezas" name="inventario['+indice+'][ePiezas]" onkeyup="validarPiezas(\'inventario'+indice+'\'); validarInventario('+indice+')" onblur="validarInventario('+indice+')"></td><td><input type="text"  id="inventario'+indice+'-dMonto" name="inventario['+indice+'][dMonto]" readonly></td>';
        }
        
    calcular();
        
    }

//paquetes
function calcularTotalPaquete(indice)
    {
        var eCodServicio    =   document.getElementById('paquete'+indice+'-eCodServicio'),
            ePiezas        =   document.getElementById('paquete'+indice+'-ePiezas'),
            dImporte = document.getElementById('paquete'+indice+'-dImporte'),
            dMonto = document.getElementById('paquete'+indice+'-dMonto');
        
        if(eCodServicio.value && ePiezas.value)
            {
                dMonto.value = parseInt(ePiezas.value)*parseInt(dImporte.value);
            }
    }

function calcularFilaPaquete(indice)
    {
        var eHorasExtra = document.getElementById('paquete'+indice+'-eHorasExtra'),
            dHoraExtra = document.getElementById('paquete'+indice+'-dHoraExtra'),
            dImporte = document.getElementById('paquete'+indice+'-dImporte'),
            ePiezas = document.getElementById('paquete'+indice+'-ePiezas'),
            dMonto = document.getElementById('paquete'+indice+'-dMonto');
        
        if(eHorasExtra.value && eHorasExtra.value>0)
            {
                dMonto.value = (parseInt(ePiezas.value)*parseInt(dImporte.value)) + (parseInt(eHorasExtra)*parseInt(dHoraExtra));
            }
    }

function validarPaquete(indice)
    {
        var eCodServicio    =   document.getElementById('paquete'+indice+'-eCodServicio'),
            ePiezas        =   document.getElementById('paquete'+indice+'-ePiezas'),
            dImporte = document.getElementById('paquete'+indice+'-dImporte'),
            dMonto = document.getElementById('paquete'+indice+'-dMonto'),
            nIndice         =   parseInt(indice)+1;
        
        if(eCodServicio.value && ePiezas.value)
            {
                dMonto.value = parseInt(ePiezas.value)*parseInt(dImporte.value);
                agregarFilaPaqueteCotizacion(nIndice);    
            }
    }
    
function agregarFilaPaqueteCotizacion(indice)
    {
        var x = document.getElementById("paquetes").rows.length;
        
        
        var tExtra = document.getElementById('paquete'+indice+'-eCodServicio');
        if(tExtra)
            {}
        else
        {
           
    var table = document.getElementById("paquetes");
    var row = table.insertRow(x);
    row.id="paq"+(indice);
    row.innerHTML = '<td><i class="far fa-trash-alt" onclick="deleteRow(\'paq'+indice+'\',\'paquetes\')"></i></td>';
    row.innerHTML += '<td><input type="checkbox" id="paquete'+indice+'-bSuma" name="paquete['+indice+'][bSuma]" value="1" onclick="calcular();"><i class="fas fa-info-circle" onclick="asignarPaquete('+indice+')"></i></td><td><input type="hidden" id="paquete'+indice+'-eCodServicio" name="paquete['+indice+'][eCodServicio]"><input type="text" class="form-control" id="tPaquete'+indice+'" name="tPaquete'+indice+'" onkeyup="agregarPaquete('+indice+')" onkeypress="agregarPaquete('+indice+')" onblur="validarPaquete('+indice+')"></td>';
    row.innerHTML += '<td><input type="text" class="form-control" id="paquete'+indice+'-ePiezas" name="paquete['+indice+'][ePiezas]" onkeyup="validarPiezas(\'paquete'+indice+'\'); validarpaquete('+indice+')" onblur="validarPaquete('+indice+')"></td>';
    row.innerHTML += '<td><input type="hidden" id="paquete'+indice+'-eMaxPiezas"><input type="hidden" id="paquete'+indice+'-dHoraExtra"><input type="hidden" id="paquete'+indice+'-dImporte" name="paquete['+indice+'][dImporte]"><input type="text" class="form-control" id="paquete'+indice+'-eHorasExtra" name="paquete['+indice+'][eHorasExtra]" onkeyup="calcularTotalPaquete('+indice+'); calcular();" onblur="calcularTotalPaquete('+indice+'); calcular();"></td><td><input type="text" id="paquete'+indice+'-dMonto" name="paquete['+indice+'][dMonto]" readonly></td>';
        }
        
    calcular();
        
    }