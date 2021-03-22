d="totalVenta"></td>
											</tr>
											
											<tr <?=(($bIVA==1) ? '' : 'hidden');?>>
												<td><input type="hidden" id="bIVA" value="<?=$bIVA;?>"></td>
											<td colspan="3" align="right" id="totIVA"></td>
											</tr>
											
											<tr <?=(($bIVA==1) ? '' : 'hidden');?>>
												<td> </td>
											<td colspan="3" align="right" id="totTotal"></td>
											</tr>
                                            <!--desglose-->
                                        </tbody>
                                    </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </form>
   

<script> 

    function calcular()
    {
        var venta = 0, abono = 0;
        var cmbTotal = document.querySelectorAll("[id^=totalServ]");
        cmbTotal.forEach(function(nodo){
            
            venta = parseFloat(venta) + parseFloat(nodo.value);
            
        });
		
		var cmbAbono = document.querySelectorAll("[id^=abono]");
        cmbAbono.forEach(function(nodo){
            
            abono = parseFloat(abono) + parseFloat(nodo.value);
            
        });
        
        var bIVA = document.getElementById('bIVA').value;
        var total = venta;
        if(bIVA==1)
        {
            document.getElementById('totalVenta').innerHTML = "Subtotal: $"+venta.toFixed(2);
            var dIVA = (venta*0.16);
            var total = venta+dIVA;
            document.getElementById('totIVA').innerHTML = "IVA: $"+dIVA.toFixed(2);
            
            document.getElementById('totTotal').innerHTML = "Total: $"+total.toFixed(2);

        }
        else
        {
           document.getElementById('totalVenta').innerHTML = "Total: $"+venta.toFixed(2); 
        }
        
		document.getElementById('totAbono').innerHTML = "$"+abono.toFixed(2);
		document.getElementById('totRestante').innerHTML = "$"+(total-abono).toFixed(2); 
    }
	
	calcular();

		</script>