<?php
$filename = "swgc-mysql.php";
$content = "<?php
$conexion = mysql_connect(\"".$_POST['hostname']."\",\"".$_POST['username']."\",\"B@".$_POST['password']."\");
mysql_select_db(\"".$_POST['database']."\");
?>";

fopen("../cnx/".$filename,"w");
fwrite($pf,$content);
fclose($pf);

fopen("../cls/".$filename,"w");
fwrite($pf,$content);
fclose($pf);

function parseScript($script) {

  $result = array();
  $delimiter = ';';
  while(strlen($script) && preg_match('/((DELIMITER)[ ]+([^\n\r])|[' . $delimiter . ']|$)/is', $script, $matches, PREG_OFFSET_CAPTURE)) {
    if (count($matches) > 2) {
      $delimiter = $matches[3][0];
      $script = substr($script, $matches[3][1] + 1);
    } else {
      if (strlen($statement = trim(substr($script, 0, $matches[0][1])))) {
        $result[] = $statement;
      }
      $script = substr($script, $matches[0][1] + 1);
    }
  }

  return $result;

}

function executeScriptFile($fileName, $dbConnection) {
  $script = file_get_contents($scriptFleName);
  $statements = parseScript($script);
  foreach($statements as $statement) {
    mysqli_query($dbConnection, $statement);
  }
}

$hostName = $_POST['hostname'];
$userName = $_POST['username'];
$password = $_POST['password'];
$dataBaseName = $_POST['database'];
$fileName = 'script.sql';

if ($connection = @mysqli_connect($hostName, $userName, $password, $dataBaseName)) {
  executeScriptFile($fileName, $connection);
} else {
  die('No se pudo establecer la conexión con el servidor de MySQL');
}
?>