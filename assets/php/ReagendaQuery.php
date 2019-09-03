<?php

include 'funciones.php';
$queryUP = "";

$conexion40 = mysql_connect("172.30.27.40", "root", "4LC0M");

mysql_select_db("marcador_manual", $conexion40);

if ($_GET['queryUP'] != "") {
    $queryUP = $_GET['queryUP'];
}
//echo $queryUP;
mysql_query($queryUP, $conexion40) or die("error al actualizar");
echo "Actualizacion Exitosa";

mysql_close($conexion40);
