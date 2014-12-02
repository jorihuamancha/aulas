<?php
// variables
$dbhost = 'localhost';
$dbname = 'nombre-base-datos';
$dbuser = 'usuario-base-datos';
$dbpass = 'contraseña-base-datos';
 
$backup_file = $dbname . date("Y-m-d-H-i-s") . '.gz';
 
// comandos a ejecutar
$command = "mysqldump --opt -h $dbhost -u $dbuser -p$dbpass $dbname | gzip > $backup_file";
 
// ejecución y salida de éxito o errores
system($command,$output);
echo $output;
?>