<?php 
	include 'funciones.php';
	$agente = $_REQUEST['agente'];
	$supervisor = $_REQUEST['supervisor'];
	$campana = $_REQUEST['idcampana'];
	$prueba = "Registros asignados";

	//Limpiar base y Asignar base
	if ($campana == "176") {
		$SQLlimpiar = "UPDATE marcador_manual.basecliente SET nagente = '3733', nsuper = '2898' WHERE nagente = '{$agente}' and ultimoestatus = 'nuevo' and idcampania = '176'";
		$SQLAsignacion = "UPDATE marcador_manual.basecliente SET nagente = '{$agente}', nsuper = '{$supervisor}' WHERE id in (";
		$losID = "SELECT id from marcador_manual.basecliente where nagente = '3733' and nsuper = '2898' and ultimoestatus = 'nuevo' and idcampania = '176' ORDER BY rand() limit 25";
		$idquery = mysql_query($losID,$conexion40);
		while ($idres = mysql_fetch_assoc($idquery)) {
			$SQLAsignacion .= "'".$idres['id']."',";
		}
		$SQLAsignacion = substr($SQLAsignacion,0,-1);
		$SQLAsignacion .= ")";


	}elseif ($campana == "22") {
		$SQLlimpiar = "UPDATE marcador_manual.basecliente SET nagente = '3710', nsuper = '2898' WHERE nagente = '{$agente}' and ultimoestatus = 'nuevo' and idcampania = '22'";
		$SQLAsignacion = "UPDATE marcador_manual.basecliente SET nagente = '{$agente}', nsuper = '{$supervisor}' WHERE id in (";
		$losID = "SELECT id from marcador_manual.basecliente where nagente = '3710' and nsuper = '411' and ultimoestatus = 'nuevo' and idcampania = '22' ORDER BY rand() limit 30";
		$idquery = mysql_query($losID,$conexion40);
		while ($idres = mysql_fetch_assoc($idquery)) {
			$SQLAsignacion .= "'".$idres['id']."',";
		}
		$SQLAsignacion = substr($SQLAsignacion,0,-1);
		$SQLAsignacion .= ")";
	}elseif ($campana == "211") {
		$SQLlimpiar = "UPDATE marcador_manual.basecliente SET nagente = '3710', nsuper = '2898' WHERE nagente = '{$agente}' and ultimoestatus = 'nuevo' and idcampania = '211'";
		$SQLAsignacion = "UPDATE marcador_manual.basecliente SET nagente = '{$agente}', nsuper = '{$supervisor}' WHERE id in (";
		$losID = "SELECT id from marcador_manual.basecliente where nagente = '3710' and nsuper = '411' and ultimoestatus = 'nuevo' and idcampania = '211' ORDER BY rand() limit 30";
		$idquery = mysql_query($losID,$conexion40);
		while ($idres = mysql_fetch_assoc($idquery)) {
			$SQLAsignacion .= "'".$idres['id']."',";
		}
		$SQLAsignacion = substr($SQLAsignacion,0,-1);
		$SQLAsignacion .= ")";

	}elseif ($campana == "220") {
		$SQLlimpiar = "UPDATE marcador_manual.basecliente SET nagente = '3710', nsuper = '2898' WHERE nagente = '{$agente}' and ultimoestatus = 'nuevo' and idcampania = '220'";
		$SQLAsignacion = "UPDATE marcador_manual.basecliente SET nagente = '{$agente}', nsuper = '{$supervisor}' WHERE id in (";
		$losID = "SELECT id from marcador_manual.basecliente where nagente = '3710' and nsuper = '411' and ultimoestatus = 'nuevo' and idcampania = '220' ORDER BY rand() limit 30";
		$idquery = mysql_query($losID,$conexion40);
		while ($idres = mysql_fetch_assoc($idquery)) {
			$SQLAsignacion .= "'".$idres['id']."',";
		}
		$SQLAsignacion = substr($SQLAsignacion,0,-1);
		$SQLAsignacion .= ")";
	}else{
		$prueba = "Hubo un Problema";
	}

	// if(mysql_errno($idquery)){
	// 	$prueba = "Hubo un problema con la consulta". mysql_error($idquery);
	// }
	mysql_query($SQLlimpiar,$conexion40);
	mysql_query($SQLAsignacion, $conexion40);


	echo json_encode($prueba);
	mysql_close($conexion40);
 ?> 
