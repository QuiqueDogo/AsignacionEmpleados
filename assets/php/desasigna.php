<?php
include 'funciones.php';
$cantidad = $_REQUEST['cantidad'];
$agente = $_REQUEST['agente'];
$supervisor = $_REQUEST['supervisor'];
$campa = $_REQUEST["campania"];
$actualiza = "UPDATE
basecliente
SET
nagente = '',
nsuper = '$supervisor',
ultimoestatus = 'Nuevo',
ultimocomentario = NULL
WHERE
idcampania = {$campa}
AND nagente = '$agente'
AND ultimoestatus = 'nuevo' LIMIT ".$cantidad."";

if ($sql = mysql_query($actualiza, $conexion40)or die(mysql_error())) {
  echo "Registros deasignados correctamente";
} else {
  echo "Hubo un error al asignar los registros";
}

mysql_close($conexion40);
?>
