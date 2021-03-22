<?php
require_once("cnx/swgc-mysql.php");
require_once("cls/cls-sistema.php");


$clSistema = new clSis();
session_start();
$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bDelete'];

?>
<script>
function detalles(eCodCliente)
    {
        window.location="?tCodSeccion=cata-cli-det&eCodCliente="+eCodCliente;
    }
function exportar()
    {
        window.location="gene-cli-xls.php";
    }
</script>
<div class="row">
                            <div class="col-lg-12">
                                
                                
                                    <table class="display" id="cliTable" width="100%">
                                        <thead>
                                            
                                            <tr>
                                                <th>C&oacute;digo</th>
												<th>E</th>
												<th>Nombre</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?
											$select = "	SELECT cc.*, ce.tIcono estatus FROM CatCamionetas cc INNER JOIN CatEstatus ce ON ce.tCodEstatus=cc.tCodEstatus ORDER BY cc.eCodCamioneta ASC ";
											$rsPublicaciones = mysql_query($select);
											while($rPublicacion = mysql_fetch_array($rsPublicaciones))
											{
                                                
												?>
											<tr>
                                                <td><? menuEmergente($rPublicacion{'eCodCamioneta'}); ?></td>
                                                <td><i class="<?=$rPublicacion{'estatus'}?>"></i></td>
                                                <td><?=utf8_decode($rPublicacion{'tNombre'})?></td>
                                            </tr>
											<?
											}
											?>
                                        </tbody>
                                    </table>
                                
                            </div>
                        </div>