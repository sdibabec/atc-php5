<?

require_once("../cnx/swgc-mysql.php");
require_once("../cls/cls-sistema.php");
include("../inc/fun-ini.php");


$clSistema = new clSis();
session_start();

$bAll = $_SESSION['bAll'];
$bDelete = $_SESSION['bDelete'];

$response = array();

if($_POST['search'] || $_GET['search']){
    $search = $_POST['search'] ? $_POST['search'] : $_GET['search'];

    $select =   "	SELECT * FROM ( ".
			" 	SELECT  ".
			" 	cc.eCodCliente,  ".
			" 	CONCAT(cc.tNombres, ' ', cc.tApellidos) tCliente,  ".
			" 	bLibre,  ".
			" 	su.tNombre as promotor ".
			" FROM ".
			" 	CatClientes cc ".
			" LEFT JOIN SisUsuarios su ON su.eCodUsuario = cc.eCodUsuario".
            " WHERE 1=1 ".
			($bAll ? "" : " AND cc.eCodUsuario = ".$_SESSION['sessionAdmin']['eCodUsuario']).
            " )N1 ".
            " WHERE 1=1 ".
            " AND N1.tCliente like '".$search."%'".
			" ORDER BY N1.eCodCliente ASC";
    
            $result = mysql_query($select);
    
    while($row = mysql_fetch_array($result)){
        $response[] = array("value"=>$row['eCodCliente'],"label"=>$row['tCliente'],"bFrecuente"=>(($row['bFrecuente']) ? 1 : 0),"bLibre"=>(($row['bLibre']) ? 1 : 2));
    }

    echo json_encode($response);
}
 
?>