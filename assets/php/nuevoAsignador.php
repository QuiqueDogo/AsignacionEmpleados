<?php 
	include 'funciones.php';
	$supervisor = $_REQUEST['super'];
	$campana = $_REQUEST['campa'];
	$Empleados = array();

	//consultar los agentes del super
	$req_estatus = "SELECT emp_Nroemp, emp_nombrecompleto FROM adcom.empleados WHERE emp_jefe = '{$supervisor}' AND emp_fchbaja IS NULL and emp_Nroemp not in (1679,3505,2741,3064,2262) ;";
	$sql_estatus = mysql_query($req_estatus, $conexion40);
	//consultar los que quedan en la base
	
	$restantes_base = "SELECT count(*) as conteo from marcador_manual.basecliente where nagente = '3710' and idcampania = '22' and ultimoestatus = 'nuevo' group by ultimoestatus ";
	
	$restantes_base2 = "SELECT count(*) as conteo from marcador_manual.basecliente where nagente = '3733' and idcampania = '176' and ultimoestatus = 'nuevo' group by ultimoestatus ";
	$restantes_base3 = "SELECT count(*) as conteo from marcador_manual.basecliente where nagente = '3710' and idcampania = '211' and ultimoestatus = 'nuevo' group by ultimoestatus ";
	$restantes_base4 = "SELECT count(*) as conteo from marcador_manual.basecliente where nagente = '3710' and idcampania = '220' and ultimoestatus = 'nuevo' group by ultimoestatus ";
	
	

	$query_conteo = mysql_query($restantes_base, $conexion40);
	$conteo_base = mysql_fetch_assoc($query_conteo);
	$query_conteo2 = mysql_query($restantes_base2, $conexion40);
	$conteo_base2 = mysql_fetch_assoc($query_conteo2);
	$query_conteo3 = mysql_query($restantes_base3, $conexion40);
	$conteo_base3 = mysql_fetch_assoc($query_conteo3);
	$query_conteo4 = mysql_query($restantes_base4, $conexion40);
	$conteo_base4 = mysql_fetch_assoc($query_conteo4);
	array_push($Empleados, $conteo_base['conteo']);
	array_push($Empleados, $conteo_base2['conteo']);
	array_push($Empleados, $conteo_base3['conteo']);
	array_push($Empleados, $conteo_base4['conteo']);

	//agregarles su cantidad de registros
	while ($empleados = mysql_fetch_assoc($sql_estatus)) { 
		$req_llamar = "SELECT count(id) FROM basecliente WHERE nagente = '{$empleados['emp_Nroemp']}' and idcampania = '{$campana}' AND ultimoestatus = 'Nuevo'  GROUP BY idcampania";
				$sql_llamar = mysql_query($req_llamar, $conexion40);
				$res_llamar = mysql_fetch_array($sql_llamar);
		

		$Empleados[] = [$empleados['emp_Nroemp'],$empleados['emp_nombrecompleto'],$res_llamar[0]];

	}



	echo json_encode($Empleados);
	mysql_close($conexion40);
 ?> 
