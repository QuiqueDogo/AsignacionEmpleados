<?php
include 'funciones.php';
$agente = $_REQUEST['agente'];
$supervisor = $_REQUEST['supervisor'];
$fecha = date('Y-m-d h:i:s');
$campa = $_REQUEST["campania"];
$actualiza = "UPDATE
basecliente
SET
nagente = '".$agente."',
nsuper = '".$supervisor."',
ultimoestatus = 'nuevo',
ultimocomentario = NULL,
fecha_asignacion = '{$fecha}'
WHERE
idcampania = {$campa}
AND ultimoestatus = 'reciclado'
and nagente = '1'
ORDER BY RAND() LIMIT 30";

# DATE_ADD(CURDATE(), INTERVAL -1 DAY)

if ($sql = mysql_query($actualiza, $conexion40)or die(mysql_error())) {
  echo "Registros revalidados asignados correctamente";
} else {
  echo "Hubo un error al reciclar los registros";
}


mysql_close($conexion40);

?>
