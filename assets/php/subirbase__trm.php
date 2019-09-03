<?php 

function limpiarstring($cadena){
	$cadena = str_replace("select", "", $cadena);
	$cadena = str_replace("drop", "", $cadena);
	$cadena = str_replace("delete", "", $cadena);
	$cadena = str_replace("update", "", $cadena);
	$cadena = str_replace("truncate", "", $cadena);
	$cadena = str_replace("check", "", $cadena);
	$cadena = str_replace("repair", "", $cadena);
	$cadena = str_replace("insert", "", $cadena);
	$cadena = str_replace("\"", "", $cadena);
	$cadena = str_replace("'", "", $cadena);
	$cadena = str_replace(",", "", $cadena);
	$limpiostring = $cadena;
	return utf8_encode($limpiostring);
}

$conexion3 = mysql_connect("172.30.27.3", "root", "4lc0mAdm.3");
$archivot = $_FILES['archivo_txt'];
if($archivot["error"] == 4){
	echo "no adjuntaste el archivo";
}else{
	$tmp_name = $archivot["tmp_name"];
	$csv = array();
	$lines = file($tmp_name, FILE_IGNORE_NEW_LINES);
	foreach ($lines as $key => $value){
		$csv[$key] = str_getcsv(utf8_encode($value));
	}
	$i = 0;
	$conteo = count($csv);
	// $sql_inicial = "INSERT INTO marcador_manual. (fecha_carga,foliocliente,telefono,contacto,nagente,nsuper,fecha_asignacion,idcampania,ultimoestatus, lotenombre)VALUES";
	$sql_inicial = "INSERT INTO trm.base(telefono, contacto, tipo, idcamp, pnn, idlote) VALUES";
	// $sql_opcional = "INSERT INTO marcador_manual.campos_adicionales(idfolio_externo,idcampania,nombre_campo,valor_campo, lotenombre, tipocampo)VALUES";
	$cabeceras = array();
	// $agenteslista = $_REQUEST['agentestxt'];
	// $jefeslista = array();
	// foreach ($agenteslista as $key => $value) {
	// 	array_push($jefeslista, getJefe($value));
	// }
	// $conteoagentes = count($agenteslista);
	// $agenteActual = 0;
	// $campaniaid = $peticiont['campania_txt'];
	// $lotenombre = getNombreCampania($campaniaid)."__".date("Ymd_His");
	

	$fechacarga = date("Y-m-d H:i:s");
	for ($a=0; $a < $conteo; $a++) {
		$datos = $csv[$a];
		if($a == 0){
			$cabeceras = $datos;
		}else{
			$telefono = limpiarstring($datos[0]);
			$contacto = limpiarstring($datos[1]);
			$tipo = limpiarstring($datos[2]);
			$idcamp = limpiarstring($datos[3]);
			$pnn = limpiarstring($datos[4]);
			$idlote = limpiarstring($datos[5]);
			// $foliocliente = limpiarstring($datos[2]);
			// $conteo_camposfaltantes = count($datos);
			// $conteo_interno = 3;
			// $nagente = $agenteslista[$agenteActual];
			// $nsuper = $jefeslista[$agenteActual];

  			#$sql_inicial .= "('{$fechacarga}', '{$foliocliente}' ,'{$telefono}', '{$contacto}', '{$nagente}', '{$nsuper}', '{$fechacarga}', '{$campaniaid}', 'Nuevo', '{$lotenombre}')";
			$sql_inicial .= "({$telefono},{$contacto},{$tipo},{$idcamp},{$pnn},{$idlote})";
			// while($conteo_interno < $conteo_camposfaltantes){
			// 	$trimmed = limpiarstring($datos[$conteo_interno]);
			// 	$sql_opcional .= "('{$foliocliente}','{$campaniaid}','{$cabeceras[$conteo_interno]}','{$trimmed}', '{$lotenombre}', 'cliente')";
			// 	$conteo_interno++;
			// 	if($conteo_interno != $conteo_camposfaltantes){
			// 		$sql_opcional .= ",";
			// 	}
			// }
			if($conteo != ($a+1)){
				$sql_inicial .= ",";
				// $sql_opcional .= ",";
			}
			// if($agenteActual == ($conteoagentes - 1)){
			// 	$agenteActual = 0;
			// }else{
			// 	$agenteActual++;
			// }
		}
	}
	echo $sql_inicial;
	#mysql_query($sql_inicial, $GLOBALS['conexion40'])or die("error1: ".mysql_error());
	#mysql_query($sql_opcional, $GLOBALS['conexion40'])or die("error2: ".mysql_error());
	echo "listo :)";
}




?>