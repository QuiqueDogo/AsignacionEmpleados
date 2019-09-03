<?php 
	include "funciones.php";
	$idre = $_REQUEST["idRegistro"];
	$sql_insert = "update marcador_manual.basecliente set nagente = '{$_SESSION['idEmpleado']}', ultimoestatus = 'tomado' where id = '{$idre}' and ultimoestatus not in ('venta', 'tomado');";
	mysql_query($sql_insert, $conexion40);
	echo mysql_affected_rows();
 ?>