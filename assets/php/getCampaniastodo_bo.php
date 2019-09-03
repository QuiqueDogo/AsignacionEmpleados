<?php 
header("content-type:application/json");
include "funciones.php";
function getDatosBO(){
	$datos = array();
	$sql_campanias = "SELECT a.id, nombre, alias, COUNT(b.idcampania) AS totalregistros FROM audios_listado.campanias a INNER JOIN marcador_manual.basecliente b ON a.id = b.idcampania WHERE b.nagente = '{$_SESSION['idEmpleado']}' GROUP BY idcampania";
	$res_campanias = mysql_query($sql_campanias, $GLOBALS['conexion40']);
	$total_campanias = mysql_num_rows($res_campanias);
	$datos['totalCampanias'] = $total_campanias;
	while ($fila_campanias = mysql_fetch_array($res_campanias	)) {
		$arregloCampania = array();
		$arregloCampania['idcampania'] = $fila_campanias['id'];
		$arregloCampania['nombre'] = $fila_campanias['nombre'];
		$arregloCampania['alias'] = $fila_campanias['alias'];
		$arregloStatus = array();
		$sqlstatus = "SELECT ultimoestatus as nuevos, COUNT(*) as total  FROM marcador_manual.basecliente WHERE nagente = '{$_SESSION['idEmpleado']}' AND idcampania = '{$fila_campanias['id']}' GROUP BY ultimoestatus";
		$res_status = mysql_query($sqlstatus, $GLOBALS['conexion40']);
		while($fil = mysql_fetch_assoc($res_status)){
			$arregloStatus[$fil['nuevos']] = $fil['total'];
		}

		$arregloCampania['status'] = $arregloStatus;
		array_push($datos, $arregloCampania);
	}
	return json_encode($datos);
}

echo getDatosBO();
?>