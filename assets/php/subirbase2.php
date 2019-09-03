<?php 
include "funciones.php";

function subirBaseNuevo($archivot, $peticiont){
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
		
		$sql_inicial = "INSERT INTO marcador_manual.basecliente (fecha_carga,foliocliente,telefono,contacto,nagente,nsuper,fecha_asignacion,idcampania,ultimoestatus, lotenombre)VALUES";
		$sql_opcional = "INSERT INTO marcador_manual.campos_adicionales(idfolio_externo,idcampania,nombre_campo,valor_campo, lotenombre, tipocampo)VALUES";
		$cabeceras = array();

		$agenteconjefelista = array();

		$agenteslistabruto = $_REQUEST['agentes_separados_txt'];

		$sql_agentes_jefe = "select emp_Nroemp, emp_jefe from adcom.empleados where emp_Nroemp in ({$agenteslistabruto}) and emp_fchbaja is null";
		$res_agentes_jefe = mysql_query($sql_agentes_jefe, $GLOBALS['conexion40']);
		$contado = 0;
		while ($fetch_agentes_jefe = mysql_fetch_array($res_agentes_jefe)) {
			$agenteconjefelista[$contado][0] = $fetch_agentes_jefe['emp_Nroemp'];
			$agenteconjefelista[$contado][1] = $fetch_agentes_jefe['emp_jefe'];
			$contado++;
		}
		$conteoagentes = count($agenteconjefelista);
		$agenteActual = 0;
		$campaniaid = $peticiont['campania_txt'];
		$lotenombre = getNombreCampania($campaniaid)."__".date("Ymd_His");


		$nuevo_arreglo_folios = "";
		// juntamos los folios para consultarlos en la base cliente
		for ($gg=1; $gg < count($csv); $gg++) { 
			$nuevo_arreglo_folios .= "'".$csv[$gg][2]."',";
		}
		// le quitamos la ultima coma que concateno
		$nuevo_arreglo_folios = substr($nuevo_arreglo_folios, 0, -1);

		$sql_select_folios = "select foliocliente from marcador_manual.basecliente where idcampania = '{$campaniaid}' and foliocliente in ({$nuevo_arreglo_folios})";
		$res_select_folios = mysql_query($sql_select_folios, $GLOBALS['conexion40']);

		// metemos los folios que ya estan en un arreglo
		$folios_que_ya_estan = array();
		while ($fetch_select_folios = mysql_fetch_array($res_select_folios)) {
			array_push($folios_que_ya_estan, $fetch_select_folios['foliocliente']);
		}
		// vamos a hacer un arreglo con solo los folios que se pueden subir

		$csv_nuevo = array();
		$conteorepetidos = 0;
		$conteo = count($csv_nuevo);

		for ($ikl=0; $ikl < count($csv); $ikl++) { 
			if(!in_array($csv[$ikl][2], $folios_que_ya_estan)){
				array_push($csv_nuevo, $csv[$ikl]);
			}else{
				$conteorepetidos++;
			}
		}
		$pasopor = false;
		for ($a=0; $a < $conteo; $a++) {
			$pasopor = true;
			$datos = $csv_nuevo[$a];
			if($a == 0){
				$cabeceras = $datos;
			}else{
				$fechacarga = date("Y-m-d H:i:s");

				$telefono = limpiarstring($datos[0]);
				$contacto = limpiarstring($datos[1]);
				$foliocliente = limpiarstring($datos[2]);

				$conteo_camposfaltantes = count($datos);
				$conteo_interno = 3;
				$nagente = $agenteconjefelista[$agenteActual][0];
				$nsuper = $agenteconjefelista[$agenteActual][1];
				$sql_inicial .= "('{$fechacarga}', '{$foliocliente}' ,'{$telefono}', '{$contacto}', '{$nagente}', '{$nsuper}', '{$fechacarga}', '{$campaniaid}', 'Nuevo', '{$lotenombre}')";
				while($conteo_interno < $conteo_camposfaltantes){
					$trimmed = limpiarstring($datos[$conteo_interno]);
					$sql_opcional .= "('{$foliocliente}','{$campaniaid}','{$cabeceras[$conteo_interno]}','{$trimmed}', '{$lotenombre}', 'cliente')";
					$conteo_interno++;
					if($conteo_interno != $conteo_camposfaltantes){
						$sql_opcional .= ",";
					}
				}
				if($conteo != ($a+1)){
					$sql_inicial .= ",";
					$sql_opcional .= ",";
				}
				if($agenteActual == ($conteoagentes - 1)){
					$agenteActual = 0;
				}else{
					$agenteActual++;
				}

			}
		}
		print_r($csv_nuevo);
		if($pasopor){
			echo $sql_inicial;
			// mysql_query($sql_inicial, $GLOBALS['conexion40'])or die("error1: ".mysql_error());
			// mysql_query($sql_opcional, $GLOBALS['conexion40'])or die("error2: ".mysql_error());
		}else{
			echo $sql_inicial;
		}
		return "listo. Duplicados encontrados: ".$conteorepetidos;
	}	
}








$archivo = $_FILES['archivo_txt'];
$peticion = $_REQUEST;
$msg = subirBaseNuevo($archivo, $peticion);
// header('location: ../../subir_nuevo.php?msg='.$msg);

?>