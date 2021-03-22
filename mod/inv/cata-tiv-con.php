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

?>

<div class="row">
                            <div class="col-lg-12">
                                
                                
                                    <table class="display" id="table" width="100%">
                                        <thead>
                                            
                                            <tr>
												<th class="text-right">C&oacute;digo</th>
                                                <th>Nombre</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?
											$select = "	SELECT 
															*
														FROM
															CatTiposInventario
														ORDER BY tNombre ASC";
											$rsPublicaciones = mysql_query($select);
											while($rPublicacion = mysql_fetch_array($rsPublicaciones))
											{
                                                
                                                $mostrar = (!$bDelete) ? 'style="display:none;"' : '';
												?>
											<tr>
                                                <td><? menuEmergente($rPublicacion{'eCodTipoInventario'}); ?></td>
												<td><?=utf8_decode($rPublicacion{'tNombre'})?></td>
                                            </tr>
											<?
											}
											?>
                                        </tbody>
                                    </table>
                                
                            </div>
                        </div>