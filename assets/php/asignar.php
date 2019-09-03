<?php
  include 'funciones.php';
  $cantidad = $_REQUEST['cantidad'];
  $agente = $_REQUEST['agente'];
  $supervisor = $_REQUEST['supervisor'];
  $fecha = date('Y-m-d h:i:s');
$campa = $_REQUEST["campania"];
  $actualiza = "UPDATE
    basecliente
  SET
  	nagente = '".$agente."',
  	nsuper = '".$supervisor."',
  	ultimoestatus = 'Nuevo',
    ultimocomentario = NULL,
    fecha_asignacion = '".$fecha."'
  WHERE
    idcampania = {$campa}
    AND nagente = ''
  	AND ultimoestatus = 'Nuevo'
  	AND nsuper = '".$supervisor."' LIMIT ".$cantidad."";

  if ($sql = mysql_query($actualiza, $conexion40)or die(mysql_error())) {
    echo "Registros asignados correctamente";
  } else {
    echo "Hubo un error al asignar los registros";
  }
  mysql_close($conexion40);
?>
