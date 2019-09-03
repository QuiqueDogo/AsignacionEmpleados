<?php
include 'funciones.php';
$agente = $_REQUEST['agente'];
$supervisor = $_REQUEST['supervisor'];
$fecha = date('Y-m-d h:i:s');
$campa = $_REQUEST["campania"];
$supervisorNormal = "!=";
if($supervisor == "2262"){
	$supervisorNormal = "=";
}

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
AND ultimoestatus = 'No contesta'
AND nsuper {$supervisorNormal} '".$supervisor. "'
AND date_format(fecha_carga,'%Y-%m-%d') BETWEEN '2017-11-01' AND CURDATE()
ORDER BY RAND() LIMIT 40";

# DATE_ADD(CURDATE(), INTERVAL -1 DAY)

if ($sql = mysql_query($actualiza, $conexion40)or die(mysql_error())) {
  echo "Registros reciclados correctamente";
} else {
  echo "Hubo un error al reciclar los registros";
}

mysql_close($conexion40);

?>
