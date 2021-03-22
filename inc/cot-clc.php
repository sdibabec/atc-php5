<?php
include("../cnx/swgc-mysql.php");


date_default_timezone_set('America/Mexico_City');


	function calcularInventario($eCodInventario,$fhFecha)
	{
		$ePiezas = 0;
		
		$select = "SELECT ePiezas FROM CatInventario WHERE eCodInventario = $eCodInventario";
		$rsInventario = mysql_query($select);
		$rInventario = mysql_fetch_array($rsInventario);
        
        if($fhFecha)
        {
            $select = "SELECT
                        ci.ePiezas,
                        (
                            SELECT SUM( eCantidad ) eCantidad 
                            FROM
                            (
                                SELECT
                                ( re.eCantidad* ri.ePiezas ) eCantidad 
                                FROM
                                RelEventosPaquetes re
                                INNER JOIN RelServiciosInventario ri ON ri.eCodServicio= re.eCodServicio 
                                AND re.eCodTipo = 1
                                INNER JOIN BitEventos be ON be.eCodEvento= re.eCodEvento 
                                WHERE
                                be.eCodCliente <> 1 
                                AND be.eCodEstatus IN ( 1, 2 ) 
                                AND DATE ( be.fhFechaEvento ) = '".$fhFecha."' 
                                AND ri.eCodInventario = $eCodInventario 
                            ) N0 
                        ) eOcupadosPaquetes,
                        (
                            SELECT SUM( eCantidad ) eCantidad 
                            FROM
                            (
                                SELECT
                                ( re.eCantidad ) eCantidad 
                                FROM
                                RelEventosPaquetes re
                                INNER JOIN BitEventos be ON be.eCodEvento= re.eCodEvento 
                                WHERE
                                be.eCodCliente <> 1 
                                AND re.eCodTipo = 2
                                AND be.eCodEstatus IN ( 1, 2 ) 
                                AND DATE ( be.fhFechaEvento ) = '".$fhFecha."' 
                                AND re.eCodServicio = $eCodInventario 
                            ) N0 
                        ) eOcupadosInventario
                        FROM
                        CatInventario ci 
                        WHERE
                        eCodInventario = ".$eCodInventario;
            
            $rsCalculado = mysql_query($select);
            $rCalculado = mysql_fetch_array($rsCalculado);
            
        }
		
		$ePiezas = (!$fhFecha) ? $rInventario{'ePiezas'} : ( (int)$rInventario{'ePiezas'} - ((int)$rCalculado{'eOcupadosPaquetes'} + (int)$rCalculado{'eOcupadosInventario'}));
		
		return $ePiezas;
	}
    
//floor(number) returns the nearest DOWN of a number

	function  calcularPaquete($eCodServicio,$fhFecha)
	{
		$eCantidad = 0;
		
		$eCantidades = array();
        
		$select = 	" SELECT  ".
					" 	rsi.ePiezas ePiezasPaquete,  ".
					" 	ci.ePiezas ePiezasInventario,  ".
					" 	ci.eCodInventario  ".
					" FROM  ".
					" 	RelServiciosInventario rsi  ".
					" INNER JOIN CatInventario ci ON ci.eCodInventario=rsi.eCodInventario  ".
					" WHERE rsi.eCodServicio = $eCodServicio";
		
		$rsProductos = mysql_query($select);
		while($rProducto = mysql_fetch_array($rsProductos))
		{
           
            $eTotal = ($fhFecha ? calcularInventario($rProducto{'eCodInventario'},$fhFecha) : (int)$rProducto{'ePiezasInventario'}) / (int)$rProducto{'ePiezasPaquete'};
            $eTotal = floor($eTotal);
			$eCantidades[] = $eTotal;
		}
        
		return min($eCantidades);
	}
?>