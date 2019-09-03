<?php 
	include 'funciones.php';
	$empleado = $_REQUEST['empleado'];	
	$super = $_REQUEST['super'];	
	$campana = $_REQUEST['campana'];


	if($campana == "22"){
		$consultaRegistros = "UPDATE marcador_manual.basecliente SET nagente = '{$empleado}', nsuper = '{$super}' WHERE nagente = '3710' and ultimoestatus = 'nuevo' and idcampania = '22' limit 30;";	
	}elseif ($campana == "176") {
		$consultaRegistros = "UPDATE marcador_manual.basecliente SET nagente = '{$empleado}', nsuper = '{$super}' WHERE nagente = '3733' and ultimoestatus = 'nuevo' and idcampania = '176' limit 25;";
	}elseif ($campana == "220") {
		$consultaRegistros = "UPDATE marcador_manual.basecliente SET nagente = '{$empleado}', nsuper = '{$super}' WHERE nagente = '3710' and ultimoestatus = 'nuevo' and idcampania = '220' limit 30;";
	}elseif ($campana == "211") {
		$consultaRegistros = "UPDATE marcador_manual.basecliente SET nagente = '{$empleado}', nsuper = '{$super}' WHERE nagente = '3710' and ultimoestatus = 'nuevo' and idcampania = '211' limit 30;";
	} else{
		$consultaRegistros = 0;
	}

	if($consultaRegistros == "0"){
		echo json_encode("Numero de Campaña invalida, Ingrese correctamente el numero de campaña");
	}else{
		// echo json_encode($consultaRegistros);
		mysql_query($consultaRegistros, $conexion40);
		echo json_encode("Registros asignados corretacmente en la campaña: ".$campana. " al agente: ".$empleado );
	}
	mysql_close($conexion40);
 ?> 
