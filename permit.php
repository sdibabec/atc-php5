<?php
// Comenzamos desde el directorio donde se ejecuta este script
$dir = "./";
$dirModes = 0755;
$fileModes = 0644;
$d = new RecursiveDirectoryIterator( $dir );
foreach (new RecursiveIteratorIterator($d, 1) as $path) {
    if ($path->isDir()) {
        chmod($path, $dirModes);
		echo $path.'->Read write succesful<br>';
    } else if (is_file($path)) {
        chmod($path, $fileModes);
		echo $path.'->Read write succesful<br>';
    }
}
?>