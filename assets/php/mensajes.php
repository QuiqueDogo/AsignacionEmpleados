<?php
include 'funciones.php';
$numeroempleado = $_REQUEST['empleado'];
$consulta = "SELECT mensaje ,tipomensaje from marcador_manual.mensajes_directos where nEmpReceptor = '{$numeroempleado}'  and id in (select max(id) from marcador_manual.mensajes_directos where nEmpReceptor = '{$numeroempleado}' group by tipomensaje) ";
// $consulta .= "and  FechaVisto >= CURRENT_TIMESTAMP();";

$query = mysql_query($consulta,$conexion40);

while($data = mysql_fetch_assoc($query)){
    $infoChat[] = [$data['tipomensaje'],$data['mensaje']];
}

mysql_close($conexion40);
echo json_encode($infoChat);
?>