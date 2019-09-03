<?php 
header('Content-Type: application/json');
include "funciones.php";
$data = array();
if(isset($_REQUEST['campaniaid'])){

	$_campania = $_REQUEST['campaniaid'];
	$sqlstatus = "SELECT ultimoestatus, COUNT(*) AS conteo FROM marcador_manual.basecliente WHERE idcampania = {$_campania} and ultimoestatus not in ('venta', 'llamar mas tarde', 'tomado', 'nuevo', 'bloqueado', 'el cliente ya cancelo el servicio') GROUP BY ultimoestatus";
	$resstatus = mysql_query($sqlstatus, $conexion40);
	while ($fil = mysql_fetch_array($resstatus)) {
		$temporal = array();
		array_push($temporal, $fil['ultimoestatus']);
		array_push($temporal, $fil['conteo']);
		array_push($data, $temporal);
	}
}
echo json_encode($data);
?>