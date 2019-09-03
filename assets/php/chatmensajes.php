<?php 
	$nroemp = $_REQUEST['nroemp'];
	$conexion = mysql_connect('172.30.27.40','root','4LC0M');
	// mysql_set_charset($conexion,256);
	$consulta = "SELECT mensaje, tipomensaje,nEmpEmisor, fechaEnvio from marcador_manual.mensajes_directos where id in (select max(id) from marcador_manual.mensajes_directos where nEmpReceptor = '{$nroemp}' group by tipomensaje) ";

	$consultaMensaje = mysql_query($consulta,$conexion);

	while ($mensaje = mysql_fetch_assoc($consultaMensaje)) {
		$datos[] =  [$mensaje['nEmpEmisor'],utf8_encode($mensaje['mensaje']), utf8_encode($mensaje['tipomensaje']),$mensaje['fechaEnvio']] ;
		}

	mysql_close($conexion);
	echo json_encode($datos);
 ?>
