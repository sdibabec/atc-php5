<?php
require_once("cnx/swgc-mysql.php");
require_once("cls/cls-sistema.php");
$clSistema = new clSis();
session_start();
if($_POST)
{
	$eCodPerfil = $_POST['eCodPerfil'] ? $_POST['eCodPerfil'] : false;
    if(!$eCodPerfil)
    {
        $tNombre = "'".$_POST['tNombre']."'";
        $insert = "INSERT INTO SisPerfiles (tNombre) VALUES($tNombre)";
        $rsNuevo = mysql_query($insert);
        $eCodPerfil = mysqli_insert_id();
    }
    
    mysql_query("DELETE FROM SisSeccionesPerfilesInicio WHERE eCodPerfil = $eCodPerfil");
    mysql_query("INSERT INTO SisSeccionesPerfilesInicio (eCodPerfil, tCodSeccion) VALUES ($eCodPerfil,'".$_POST['tCodSeccionInicio']."')");
    
	mysql_query("DELETE FROM SisSeccionesPerfiles WHERE eCodPerfil = $eCodPerfil");
	foreach($_POST['tCodSeccion'] as $key => $tCodSeccion)
	{
		$tCodSeccion = "'".$tCodSeccion."'";
		$bAll = $_POST['bAll'][$key];
        $bDelete = $_POST['bDelete'][$key];
		mysql_query("INSERT INTO SisSeccionesPerfiles (eCodPerfil, tCodSeccion, bAll, bDelete) VALUES ($eCodPerfil, $tCodSeccion, $bAll, $bDelete)");
	}
	echo '<script>window.location="?tCodSeccion=cata-per-sis";</script>';
}

$select = mysql_query("SELECT * FROM SisSeccionesPerfiles WHERE tCodSeccion = 'sis-dash-con' AND eCodPerfil = ".($_GET{'v1'} ? $_GET{'v1'} : 1));
$rDashboard = mysql_num_rows($select) ? 'checked="checked"' : '';
$rPerDash = mysql_fetch_array($select);


?>

<script>
funcion validar()
    {
        guardar();
    }
</script>
<form action="?tCodSeccion=<?=$_GET['tCodSeccion']?>" method="post" id="datos">
	<input type="hidden" name="eAccion" id="eAccion" value="">
<div class="row">
                            <div class="col-lg-4">
                                
                                <div class="table-responsive table--no-card m-b-40">
                                    <table class="table table-borderless table-striped table-earning">
                                        <tr>
											<td>Perfil</td>
											<td>
													<?
														$select = "SELECT * FROM SisPerfiles WHERE eCodPerfil = ".$_GET['v1']." ORDER BY tNombre ASC";
	  													$rsPerfiles = mysql_query($select);
	  													$rPerfil = mysql_fetch_array($rsPerfiles);
													?>
												<input type="hidden" name="eCodPerfil" id="eCodPerfil" value="<?=$_GET['v1']?>">
												<input type="text" class="form-control" name="tNombre" id="tNombre" value="<?=$rPerfil['tNombre']?>" <?=$_GET['v1'] ? 'readonly' : ''?>>
											</td>
										</tr>
                                        <tr>
											<td>Seccion de Inicio</td>
											<td><select name="tCodSeccionInicio" id="tCodSeccionInicio">
											    <?
											    $rSeccion = mysql_fetch_array(mysql_query("SELECT * FROM SisSeccionesPerfilesInicio WHERE eCodPerfil = ".($_GET{'val'} ? $_GET{'val'} : 1)));
											    ?>
											    <option value="sis-dash-con" <?=($rSeccion{'tCodSeccion'}=="sis-dash-con") ? 'selected' : ''?>>Dashboard</option>
													<?
														$select = "SELECT * FROM SisSecciones WHERE tCodPadre = 'sis-dash-con' ORDER BY ePosicion ASC";
	  													$rsPerfiles = mysql_query($select);
	  													while($rPerfil = mysql_fetch_array($rsPerfiles))
                                                        {
                                                            ?><option value="<?=$rPerfil{'tCodSeccion'}?>" <?=($rPerfil{'tCodSeccion'}==$rSeccion{'tCodSeccion'}) ? 'selected' : ''?>><?=$rPerfil{'tTitulo'}?></option><?
                                                        }
													?>
												</select>
											</td>
										</tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <h2 class="title-1 m-b-25">Secciones</h2>
                                <div class="table-responsive table--no-card m-b-40">
                                    <div class="au-card-inner">
                                        <div class="table-responsive">
                                            <table class="table table-borderless table-striped">
                                                <tbody>
                                                    <tr id="trFilaPerfil0">
                                                        <td width="16"><input type="checkbox" id="secciones[0][tCodSeccion]" name="secciones[0][tCodSeccion]" value="sis-dash-con" <?=(($rPerDash{'tCodSeccion'}) ? 'checked="checked"': '' );?> onclick="seleccionarFila(0)"></td>
                                                        <td colspan="2">Dashboard</td>
														<td align="right">
															<label>A <input type="checkbox" id="bAll0" name="secciones[0][bAll]" value="1" <?=$rPerDash{'bAll'} ? 'checked' : ''?>  onclick="seleccionarSeccion(0)"></label>
                                                        </td>
                                                        <td align="right">
															<label>D <input type="checkbox" id="bDelete0" name="secciones[0][bDelete]" value="1" <?=$rPerDash{'bDelete'} ? 'checked' : ''?>  onclick="seleccionarSeccion(0)"></label>
                                                        </td>
														
                                                    </tr>
													<?
													$select = "SELECT * FROM SisSecciones WHERE tCodPadre = 'sis-dash-con' ORDER BY ePosicion ASC";
													$rsSecciones = mysql_query($select);
													$b=1;
													while($rSeccion = mysql_fetch_array($rsSecciones))
													{
                                                        
                                                        $seccion = "SELECT * FROM SisSeccionesPerfiles WHERE eCodPerfil = ".$_GET['v1']." AND tCodSeccion = '".$rSeccion{'tCodSeccion'}."'";
                                                        $rsSeccionPerfil = mysql_query($seccion);
                                                        $bSeccion = mysql_num_rows($rsSeccionPerfil) ? true : false;
                                                        $rSeccionPerfil = mysql_fetch_array($rsSeccionPerfil);
														?>
													<tr id="trFilaPerfil<?=$b;?>">
                                                        <td width="16"><input type="checkbox" id="tCodSeccion<?=$b?>" name="secciones[<?=$b?>][tCodSeccion]" value="<?=$rSeccion{'tCodSeccion'}?>" <?=$bSeccion || !$rSeccion{'tCodPadre'} ? 'checked' : ''?> onclick="seleccionarFila(<?=$b;?>)"></td>
                                                        <td colspan="2"><?=$rSeccion{'tTitulo'}?></td>
														
															<td align="right"><label>A <input type="checkbox" id="bAll<?=$b?>" name="secciones[<?=$b?>][bAll]" value="1" <?=$rSeccionPerfil{'bAll'} ? 'checked' : ''?>   onclick="seleccionarSeccion(<?=$b;?>)"></label></td>
															
                                                        <td align="right"><label>D <input type="checkbox" id="bDelete<?=$b;?>" name="secciones[<?=$b?>][bDelete]" value="1" <?=$rSeccionPerfil{'bDelete'} ? 'checked' : ''?>  onclick="seleccionarSeccion(<?=$b;?>)"></label></td>
                                                    </tr>
													
													<?
													$b++;
														
													$select2 = "SELECT * FROM SisSecciones WHERE tCodPadre = '".$rSeccion{'tCodSeccion'}."' ORDER BY ePosicion ASC";
													$rsSecciones2 = mysql_query($select2);
													while($rSeccion2 = mysql_fetch_array($rsSecciones2))
														{
                                                        
                                                        $seccion2 = "SELECT * FROM SisSeccionesPerfiles WHERE eCodPerfil = ".$_GET['v1']." AND tCodSeccion = '".$rSeccion2{'tCodSeccion'}."'";
                                                        $rsSeccionPerfil2 = mysql_query($seccion2);
                                                        $rSeccionPerfil2 = mysql_fetch_array($rsSeccionPerfil2);
                                                        $bSeccion2 = mysql_num_rows($rsSeccionPerfil2) ? true : false;
														?>
															<tr>
															<td></td>
                                                    	    <td width="16"><input type="checkbox" id="tCodSeccion<?=$b?>"  name="secciones[<?=$b?>][tCodSeccion]" value="<?=$rSeccion2{'tCodSeccion'}?>" <?=$bSeccion2 ? 'checked' : ''?> onclick="seleccionarFila(<?=$b;?>)"></td>
                                                    	    <td><?=$rSeccion2{'tTitulo'}?></td>
                                                                
                                                                <!--permisos-->
                                                               
														
															<td align="right"><label>A <input type="checkbox" id="bAll<?=$b?>" name="secciones[<?=$b?>][bAll]" value="1" <?=$rSeccionPerfil2{'bAll'} ? 'checked' : ''?>   onclick="seleccionarSeccion(<?=$b;?>)"></label></td>
															
                                                        <td align="right"><label>D <input type="checkbox" id="bDelete<?=$b?>" name="secciones[<?=$b?>][bDelete]" value="1" <?=$rSeccionPerfil2{'bDelete'} ? 'checked' : ''?>  onclick="seleccionarSeccion(<?=$b;?>)"></label></td>
                                                                <!--permisos-->
															
                                                    	</tr>
														<?
															$b++;
														}
													
													}
													?>
                                                    
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
	
	</form>
<script>
function seleccionarFila(indice)
    {
        var tCodSeccion = document.getElementById('tCodSeccion'+indice),
            bAll = document.getElementById('bAll'+indice),
            bDelete = document.getElementById('bDelete'+indice);
        
        bAll.checked    = (tCodSeccion.checked==true) ? true : false;
        bDelete.checked = (tCodSeccion.checked==true) ? true : false;
    }

function seleccionarSeccion(indice)
    {
        var tCodSeccion = document.getElementById('tCodSeccion'+indice),
            bAll = document.getElementById('bAll'+indice),
            bDelete = document.getElementById('bDelete'+indice);
        
        tCodSeccion.checked = ((bAll.checked==true && bDelete.checked==false) || (bAll.checked==false && bDelete.checked==true) || (bAll.checked==true && bDelete.checked==true)) ? true : false;
    }
</script>