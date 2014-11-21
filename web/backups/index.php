<html>
<head>
<link href="../css/base.css" rel="stylesheet" type="text/css" />
<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<script src="../bootstrap/js/jquery.js"></script>
<script src="../bootstrap/js/bootstrap.js"></script>
<script src="../bootstrap/js/twitter-bootstrap-hover-dropdown.min.js"></script>
</head>
</html>
<?php
// variables
$dbhost = 'localhost';
$dbname = 'symfony';
$dbuser = 'root';
$dbpass = '';
$pathActual = getcwd() . '/'; //trae el path actual 
 
$backup_file = $pathActual . 'GestionAulas' . date("Y-m-d-H-i-s") . '.sql';
$NombreBackup =  'GestionAulas' . date("Y-m-d-H-i-s") . '.sql';

//Comando a ejecutar
$command = "mysqldump -u $dbuser -p $dbpass $dbname > $backup_file";

system($command,$output);


if ($output == '0'){  //Si se creó con exito el BackUp
					echo "<div id='mensaje' class='alert alert-success' style='margin-top:auto; margin-bottom:auto'>
						  				<h3>La base de datos fue exportada con &eacute;xito</h3> </br> <b>Ruta:</b> " . $pathActual . "</br> <b>Nombre del backup:</b> " . $NombreBackup . 
						  "
						  <center> <input type='button' class='btn btn-default botonTabla' value='Aceptar' onclick='window.close()'/></center>
						  </div>
						  ";
				  }				
else { //Si no se creó el BackUp
		echo '<div id="mensaje" class="alert alert-danger"> <h3>ERROR!</h3> </br> La base de datos no pudo ser creada, contacte al administrador. 
		<center><input type="button" class="btn btn-default botonTabla" value="Aceptar" onclick="window.close()" /></center>
		</div>';
	 }



?>