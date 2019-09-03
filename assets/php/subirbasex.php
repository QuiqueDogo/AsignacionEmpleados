<?php 
include "funciones2.php";
$archivo = $_FILES['archivo_txt'];
$peticion = $_REQUEST;
$msg = subirBase1($archivo, $peticion);
header('location: ../../subir.php?msg='.$msg);

?>