<?

require_once("../cnx/swgc-mysql.php");
require_once("../cls/cls-sistema.php");
include("../inc/fun-ini.php");
include("../inc/cot-clc.php");


$clSistema = new clSis();
session_start();

$response = array();

if($_POST['search'] || $_GET['search']){
    $search = $_POST['search'] ? $_POST['search'] : $_GET['search'];
    
    $terms = explode(" ",$search);
    
    $termino = "";
    
    for($i=0;$i<sizeof($terms);$i++)
    {
        $termino .= " AND ss.tTitulo like '%".$terms[$i]."%' ";
    }
    
    $select = "	SELECT DISTINCT
						ss.tCodSeccion,
						ss.tTitulo,
						ss.tIcono,
                        ss.ePosicion
					FROM SisSecciones ss".
					($_SESSION['sessionAdmin']['bAll'] ? "" : " INNER JOIN SisSeccionesPerfiles ssp ON ssp.tCodSeccion = ss.tCodSeccion").
					" WHERE
					ss.eCodEstatus = 3 ".
					($_SESSION['sessionAdmin']['bAll'] ? "" :
					" AND
					ssp.eCodPerfil = ".$_SESSION['sessionAdmin']['eCodPerfil']).
                    " AND ss.bPublico IS NULL".
                    $termino.
                    " ORDER BY ss.tCodPadre ASC, ss.ePosicion ASC";

    
            $result = mysql_query($select);
    
    while($row = mysql_fetch_array($result)){
        
        $tURL = generarUrl($row{'tCodSeccion'},true);
        
        $response[] = array(
                            "value"=>$url = $tURL,
                            "label"=>$row{'tTitulo'}
                            );
    }

    echo json_encode($response);
}
 
//30 puff

?>