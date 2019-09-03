<?php
session_start();

// if($_SERVER['REMOTE_ADDR'] == "::1"){
// 	$conexion40 = @mysql_connect('localhost', 'root', '');
// }else{
$conexion40 = mysql_connect("172.30.27.40", "root", "4LC0M");
// }
mysql_select_db("marcador_manual",$conexion40);
date_default_timezone_set('America/Mexico_City');
mysql_query("
	SET character_set_results = 'utf8',
	character_set_client = 'utf8',
	character_set_connection = 'utf8',
	character_set_database = 'utf8',
	character_set_server = 'utf8'", $conexion40);
if(!isset($_SESSION['idEmpleado'])){
	header('location: /sialcom');
}
if(!isset($_SESSION['campania_id_selected'])){
	$_SESSION['campania_id_selected'] = 0;
}

function fotorealPersona(){
	// $foto = "http://172.30.27.254/Gestion/fotos/".$_SESSION["idEmpleado"].".jpg";
	// // $foto = "https://avatars2.githubusercontent.com/u/7528423?s=460&v=4";
	// $file_headers = @get_headers($foto);
	// $fotoreal;

	// if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
	$fotoreal = "assets/img/user.jpg";
	// }else {
	// 	$fotoreal = $foto;
	// }
	return $fotoreal;
}
function getCampanias(){
	$sql_campanias = "SELECT id, nombre FROM audios_listado.campanias WHERE statuscamp = 1 || statuscamp = 3";
	$res_campanias = mysql_query($sql_campanias, $GLOBALS["conexion40"]);
	$datos = array();
	while ($fila = mysql_fetch_assoc($res_campanias)) {
		$tempo = array();
		foreach ($fila as $key => $value) {
			array_push($tempo, $value);
		}
		array_push($datos, $tempo);
	}
	return $datos;
}

function menuSuperusuario(){
	return "<li>
	<a href='reportedatos.php'>
	<span class='menu_icon'>
	<svg style='width:24px;height:24px' viewBox='0 0 24 24'>
	<path fill='#000000' d='M7,13H21V11H7M7,19H21V17H7M7,7H21V5H7M2,11H3.8L2,13.1V14H5V13H3.2L5,10.9V10H2M3,8H4V4H2V5H3M2,17H4V17.5H3V18.5H4V19H2V20H5V16H2V17Z'></path>
	</svg>
	</span>
	Reporte diario upsell
	</a>
	</li>
	
	<li>
	<a href='reporteMarcaciones_optimi.php'>
	<span class='menu_icon'>
	<svg style='width:24px;height:24px' viewBox='0 0 24 24'>
	<path fill='#000000' d='M7,13H21V11H7M7,19H21V17H7M7,7H21V5H7M2,11H3.8L2,13.1V14H5V13H3.2L5,10.9V10H2M3,8H4V4H2V5H3M2,17H4V17.5H3V18.5H4V19H2V20H5V16H2V17Z'></path>
	</svg>
	</span>
	Reporte marcaciones
	</a>
	</li>
	<li>
	<a href='total_efectivas.php'>
	<span class='menu_icon'>
	<svg style='width:24px;height:24px' viewBox='0 0 24 24'>
	<path fill='#000000' d='M7,13H21V11H7M7,19H21V17H7M7,7H21V5H7M2,11H3.8L2,13.1V14H5V13H3.2L5,10.9V10H2M3,8H4V4H2V5H3M2,17H4V17.5H3V18.5H4V19H2V20H5V16H2V17Z'></path>
	</svg>
	</span>
	Reporte efectivas upsell
	</a>
	</li>
	
	
	<li>
	<a href='reagenda_manual.php'>
	<span class='menu_icon'>
	<svg style='width:24px;height:24px' viewBox='0 0 24 24'>
	<path fill='#000000' d='M7,13H21V11H7M7,19H21V17H7M7,7H21V5H7M2,11H3.8L2,13.1V14H5V13H3.2L5,10.9V10H2M3,8H4V4H2V5H3M2,17H4V17.5H3V18.5H4V19H2V20H5V16H2V17Z'></path>
	</svg>
	</span>
	Reagenda manual
	</a>
	</li>";

}

function 	menuGenerico(){
	// return "<li>
	// <a href='reporteVentas_2.php'>
	// <span class='menu_icon'>
	// <svg style='width:24px;height:24px' viewBox='0 0 24 24'>
	// <path fill='#000000' d='M14,10H2V12H14V10M14,6H2V8H14V6M2,16H10V14H2V16M21.5,11.5L23,13L16,20L11.5,15.5L13,14L16,17L21.5,11.5Z' />
	// </svg>
	// </span>
	// Reporte Ventas Upsell
	// </a>
	// </li>
	// <li>
	// <a href='reporteVentas_upgrade.php'>
	// <span class='menu_icon'>
	// <svg style='width:24px;height:24px' viewBox='0 0 24 24'>
	// <path fill='#000000' d='M14,10H2V12H14V10M14,6H2V8H14V6M2,16H10V14H2V16M21.5,11.5L23,13L16,20L11.5,15.5L13,14L16,17L21.5,11.5Z' />
	// </svg>
	// </span>
	// Reporte Ventas Upgrade
	// </a>
	// </li>
	// <li>
	// <a href='reporteConversion.php'>
	// <span class='menu_icon'>
	// <svg style='width:24px;height:24px' viewBox='0 0 24 24'>
	// <path fill='#000000' d='M7,13H21V11H7M7,19H21V17H7M7,7H21V5H7M2,11H3.8L2,13.1V14H5V13H3.2L5,10.9V10H2M3,8H4V4H2V5H3M2,17H4V17.5H3V18.5H4V19H2V20H5V16H2V17Z' />
	// </svg>
	// </span>
	// Reporte de Conversion
	// </a>
	// </li>
	// <li>
	// <a href='buscarNumero.php'>
	// <span class='menu_icon'>
	// <svg style='width:24px;height:24px' viewBox='0 0 24 24'>
	// <path fill='#000000' d='M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z' />
	// </svg>
	// </span>
	// Buscar numero
	// </a>
	// </li>
	// <li>
	// <a href='buscarpornombre.php'>
	// <span class='menu_icon'>
	// <svg style='width:24px;height:24px' viewBox='0 0 24 24'>
	// <path fill='#000000' d='M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z' />
	// </svg>
	// </span>
	// Buscar por nombre
	// </a>
	// </li>
	// <li>
	// <a href='buscarNumeroFolio.php'>
	// <span class='menu_icon'>
	// <svg style='width:24px;height:24px' viewBox='0 0 24 24'>
	// <path fill='#000000' d='M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z' />
	// </svg>
	// </span>
	// Buscar Folio
	// </a>
	// </li>
	// <li>
	// <a href='reporteIncremento.php'>
	// <span class='menu_icon'>
	// <svg style='width:24px;height:24px' viewBox='0 0 24 24'>
	// <path fill='#000000' d='M7,13H21V11H7M7,19H21V17H7M7,7H21V5H7M2,11H3.8L2,13.1V14H5V13H3.2L5,10.9V10H2M3,8H4V4H2V5H3M2,17H4V17.5H3V18.5H4V19H2V20H5V16H2V17Z'></path>
	// </svg>
	// </span>
	// Reporte incrementos
	// </a>
	// </li>";


	return "<li>
	<a href='reporteVentas_2.php'>
	<span class='menu_icon'>
	<svg style='width:24px;height:24px' viewBox='0 0 24 24'>
	<path fill='#000000' d='M14,10H2V12H14V10M14,6H2V8H14V6M2,16H10V14H2V16M21.5,11.5L23,13L16,20L11.5,15.5L13,14L16,17L21.5,11.5Z' />
	</svg>
	</span>
	Reporte Ventas Upsell
	</a>
	</li>
	
	<li>
	<a href='buscarNumero.php'>
	<span class='menu_icon'>
	<svg style='width:24px;height:24px' viewBox='0 0 24 24'>
	<path fill='#000000' d='M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z' />
	</svg>
	</span>
	Buscar numero
	</a>
	</li>
	<li>
	<a href='buscarpornombre.php'>
	<span class='menu_icon'>
	<svg style='width:24px;height:24px' viewBox='0 0 24 24'>
	<path fill='#000000' d='M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z' />
	</svg>
	</span>
	Buscar por nombre
	</a>
	</li>
	<li>
	<a href='buscarNumeroFolio.php'>
	<span class='menu_icon'>
	<svg style='width:24px;height:24px' viewBox='0 0 24 24'>
	<path fill='#000000' d='M9.5,3A6.5,6.5 0 0,1 16,9.5C16,11.11 15.41,12.59 14.44,13.73L14.71,14H15.5L20.5,19L19,20.5L14,15.5V14.71L13.73,14.44C12.59,15.41 11.11,16 9.5,16A6.5,6.5 0 0,1 3,9.5A6.5,6.5 0 0,1 9.5,3M9.5,5C7,5 5,7 5,9.5C5,12 7,14 9.5,14C12,14 14,12 14,9.5C14,7 12,5 9.5,5Z' />
	</svg>
	</span>
	Buscar Folio
	</a>
	</li>
	<li>
	<a href='reporteIncremento.php'>
	<span class='menu_icon'>
	<svg style='width:24px;height:24px' viewBox='0 0 24 24'>
	<path fill='#000000' d='M7,13H21V11H7M7,19H21V17H7M7,7H21V5H7M2,11H3.8L2,13.1V14H5V13H3.2L5,10.9V10H2M3,8H4V4H2V5H3M2,17H4V17.5H3V18.5H4V19H2V20H5V16H2V17Z'></path>
	</svg>
	</span>
	Reporte incrementos
	</a>
	</li>";


}
function getNombre($idEmpleado){
	$sqlld = "SELECT emp_nombrecompleto as nombre FROM adcom.empleados WHERE emp_Nroemp = {$idEmpleado}";
	$resultado = mysql_query($sqlld, $GLOBALS['conexion40'])or die(mysql_error());
	$fila = mysql_fetch_array($resultado);
	return $fila['nombre'];
}
function getCampaniasActivas(){
	$sql_campanias = "SELECT id, nombre FROM audios_listado.campanias WHERE id IN (SELECT idcampania FROM marcador_manual.basecliente GROUP BY idcampania)";
	$res_campanias = mysql_query($sql_campanias, $GLOBALS["conexion40"]);
	$datos = array();
	while ($fila = mysql_fetch_assoc($res_campanias)) {
		$tempo = array();
		foreach ($fila as $key => $value) {
			array_push($tempo, $value);
		}
		array_push($datos, $tempo);
	}
	return $datos;
}
function getNombreCampania($idCampania){
	$sql_campanias = "SELECT alias FROM audios_listado.campanias WHERE id = {$idCampania}";
	$res_campanias = mysql_query($sql_campanias, $GLOBALS["conexion40"]);
	$fila = mysql_fetch_assoc($res_campanias);
	return $fila['alias'];
}
function getJefe($emp_nro){
	$sqljefe = "SELECT emp_jefe FROM adcom.empleados WHERE emp_Nroemp = '{$emp_nro}'";
	$res_jefes = mysql_query($sqljefe, $GLOBALS["conexion40"]);
	$fila = mysql_fetch_assoc($res_jefes);
	if(isset($fila['emp_jefe'])){
		return $fila['emp_jefe'];
	}else{
		return '0';
	}

}
function subirBase($archivot, $peticiont){
	$tipo = $archivot['type'];
	$tamanio = $archivot['size'];
	$archivotmp = $archivot['tmp_name'];
	$lineas = file($archivotmp);
	$i = 0;
	$conteo = count($lineas);
	$sql_inicial = "INSERT INTO marcador_manual.basecliente (fecha_carga,foliocliente,telefono,contacto,nagente,nsuper,fecha_asignacion,idcampania,ultimoestatus, lotenombre)VALUES";
	$sql_opcional = "INSERT INTO marcador_manual.campos_adicionales(idfolio_externo,idcampania,nombre_campo,valor_campo, lotenombre, tipocampo)VALUES";
	$cabeceras = array();
	$agenteslista = $_REQUEST['agentestxt'];
	$jefeslista = array();
	foreach ($agenteslista as $key => $value) {
		array_push($jefeslista, getJefe($value));
	}
	$conteoagentes = count($agenteslista);
	$agenteActual = 0;
	foreach ($lineas as $linea_num => $linea){
		$datos = explode(",",$linea);
		if($i != 0){
			if(isset($datos[2])){
				$fechacarga = date("Y-m-d H:i:s");
				$foliocliente = $datos[2];
				$telefono = $datos[0];
				$contacto = utf8_encode($datos[1]);
				$campaniaid = $peticiont['campania_txt'];
				$conteo_camposfaltantes = count($datos);
				$conteo_interno = 3;
				$nagente = $agenteslista[$agenteActual];
				$nsuper = $jefeslista[$agenteActual];

				$lotenombre = getNombreCampania($campaniaid)."__".date("Ymd_His");
				$sql_inicial .= "('{$fechacarga}', {$foliocliente} ,'{$telefono}', '{$contacto}', '{$nagente}', '{$nsuper}', '{$fechacarga}', '{$campaniaid}', 'Nuevo', '{$lotenombre}')";
				while($conteo_interno < $conteo_camposfaltantes){
					$trimmed = $datos[$conteo_interno];
					$sql_opcional .= "('{$foliocliente}','{$campaniaid}','{$cabeceras[$conteo_interno]}','{$trimmed}', '{$lotenombre}', 'cliente')";
					$conteo_interno++;
					if($conteo_interno != $conteo_camposfaltantes){
						$sql_opcional .= ",";
					}
				}
				if($conteo != ($i+1)){
					$sql_inicial
					.= ",";
					$sql_opcional .= ",";
				}
			}
		}else{
			foreach ($datos as $key => $value) {
				array_push($cabeceras , $value);
			}
		}
		$i++;

		if($agenteActual == ($conteoagentes - 1)){
			$agenteActual = 0;
		}else{
			$agenteActual++;
		}
	}
	mysql_query($sql_inicial, $GLOBALS['conexion40'])or die("error20: ".mysql_error());
	mysql_query($sql_opcional, $GLOBALS['conexion40'])or die("error21: ".mysql_error());
	return "listo :)";
}
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
function subirBase1($archivot, $peticiont){
	if($archivot["error"] == 4){
		echo "no adjuntaste el archivo";
	}else{
		// echo "<br>"."hola2"."<br>";
		$tmp_name = $archivot['tmp_name'];
		$csv = array();
		$lines = file($tmp_name, FILE_IGNORE_NEW_LINES);
		foreach ($lines as $key => $value){
			$csv[$key] = str_getcsv(utf8_encode($value));
		}
		$i = 0;
		$conteo = count($csv);
		$sql_inicial = "INSERT INTO marcador_manual.basecliente (fecha_carga,foliocliente,telefono,contacto,nagente,nsuper,fecha_asignacion,idcampania,ultimoestatus,foliooriginallimpio,lotenombre)VALUES";
		$sql_opcional = "INSERT INTO marcador_manual.campos_adicionales(idfolio_externo,idcampania,nombre_campo,valor_campo, lotenombre, tipocampo)VALUES";
		$cabeceras = array();
		$agenteslista = $_REQUEST['agentestxt'];
		$jefeslista = array();
		foreach ($agenteslista as $key => $value) {
			array_push($jefeslista, getJefe($value));
		}
		$conteoagentes = count($agenteslista);
		$agenteActual = 0;
		$campaniaid = $peticiont['campania_txt'];
		$lotenombre = getNombreCampania($campaniaid)."__".date("Ymd_His");
		

	for ($a=0; $a < $conteo; $a++) {
			$datos = $csv[$a];
			if($a == 0){
				$cabeceras = $datos;
			}else{
				$fechacarga = date("Y-m-d H:i:s");

				$telefono = limpiarstring($datos[0]);
				$contacto = limpiarstring($datos[1]);
				$foliocliente = limpiarstring($datos[2]);
				$foliolimpio = limpiarstring($datos[3]);

				$conteo_camposfaltantes = count($datos);
				$conteo_interno = 4;
				$nagente = $agenteslista[$agenteActual];
				$nsuper = $jefeslista[$agenteActual];

				$sql_inicial .= "('{$fechacarga}', '{$foliocliente}' ,'{$telefono}', '{$contacto}', '{$nagente}', '{$nsuper}', '{$fechacarga}', '{$campaniaid}', 'Nuevo', '{$foliolimpio}' , '{$lotenombre}')";
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
		mysql_query($sql_inicial, $GLOBALS['conexion40'])or die("error1: ".mysql_error());
		mysql_query($sql_opcional, $GLOBALS['conexion40'])or die("error2: ".mysql_error());
		 // print_r($sql_inicial);
		 // print_r($sql_opcional);


		return "listo :)";
	}
	// echo "hola";
}






function getRegistrospendientes(){


	$sql = "SELECT COUNT(*) AS conteo FROM basecliente WHERE idcampania = {$_SESSION['campania_id_selected']} AND nagente = {$_SESSION['idEmpleado']} AND fecha_reagenda < NOW() UNION ALL SELECT COUNT(*) AS conteo FROM basecliente WHERE idcampania = {$_SESSION['campania_id_selected']} AND nagente = {$_SESSION['idEmpleado']} AND ultimoestatus = 'nuevo'";


	$resss = mysql_query($sql, $GLOBALS['conexion40']);
	$fila = mysql_fetch_array($resss);
	return $fila['conteo'];
}
function getRegistroMarcador(){
	//comprobar la existencia de un registro tomado por el agente
	$sqltoma = "SELECT id, contacto, foliocliente, idcampania, lotenombre, nsuper, ultimoestatus, ultimocomentario FROM marcador_manual.basecliente WHERE ultimoestatus = 'tomado' AND nagente = '{$_SESSION['idEmpleado']}' and idcampania = '{$_SESSION['campania_id_selected']}' limit 1";
	$restom = mysql_query($sqltoma, $GLOBALS['conexion40']);
	$filatom = mysql_fetch_assoc($restom);
	$idregistro;
	$arreglofinal = array();
	$arreglode = array();
	if (isset($filatom['id'])) {
		$idregistro = $filatom['id'];
		$arreglode = $filatom;
	}else{
		$sqll = "SELECT id, contacto, foliocliente, idcampania, lotenombre, nsuper, ultimoestatus, ultimocomentario, fecha_asignacion, fecha_reagenda FROM basecliente WHERE idcampania = {$_SESSION['campania_id_selected']} AND nagente = {$_SESSION['idEmpleado']} AND fecha_reagenda < NOW() AND ultimoestatus = 'Llamar más tarde' UNION ALL SELECT id, contacto, foliocliente, idcampania, lotenombre, nsuper, ultimoestatus, ultimocomentario, fecha_asignacion, fecha_reagenda FROM basecliente WHERE idcampania = {$_SESSION['campania_id_selected']} AND nagente = {$_SESSION['idEmpleado']} AND ultimoestatus = 'nuevo' order by fecha_reagenda desc LIMIT 1";

		$res = mysql_query($sqll, $GLOBALS['conexion40'])or die("error1: ".mysql_error());
		$arreglode = mysql_fetch_assoc($res);
		$idregistro = $arreglode['id'];

		// actualizar el estatus a tomado de la base cliente
		// insertar marcacion con estatus marcado
		if($arreglode['nsuper'] != ""){
			$sqlupdst = "UPDATE marcador_manual.basecliente SET ultimoestatus = 'tomado' WHERE id = '{$idregistro}'";
			mysql_query($sqlupdst, $GLOBALS['conexion40']);
			$sqlinmar = "INSERT INTO marcador_manual.marcaciones(idbasecliente, agente, supervisor, status)VALUES('{$idregistro}','{$_SESSION['idEmpleado']}','{$arreglode['nsuper']}', 'tomado')";
			mysql_query($sqlinmar, $GLOBALS['conexion40']);
		}
	}
	if(isset($idregistro)){
		$sqll1 = "SELECT nombre_campo, valor_campo FROM marcador_manual.campos_adicionales WHERE idfolio_externo = '{$arreglode['foliocliente']}' AND lotenombre = '{$arreglode['lotenombre']}' AND idcampania = '{$arreglode['idcampania']}' and tipocampo = 'cliente' and nombre_campo not like '%contacto%'";
		$res1 = mysql_query($sqll1, $GLOBALS['conexion40']);
		$adicional = "0";
		while($arreglode1 = mysql_fetch_array($res1)){

			if($arreglode1['nombre_campo'] == 'RENTA ACTUAL'){
				$adicional = $arreglode1['valor_campo'];
			}
			$arreglode[$arreglode1['nombre_campo']] = $arreglode1['valor_campo'];
		}

		$sql_telefonosamarcar = "SELECT telefono FROM basecliente WHERE id = {$idregistro} AND foliocliente = '{$arreglode['foliocliente']}' and idcampania = '{$arreglode['idcampania']}' and lotenombre = '{$arreglode['lotenombre']}' UNION ALL  SELECT valor_campo FROM campos_adicionales WHERE nombre_campo LIKE '%contacto%' AND idfolio_externo = '{$arreglode['foliocliente']}' and idcampania = '{$arreglode['idcampania']}' and lotenombre = '{$arreglode['lotenombre']}'";
		$arregloTelefonos = array();
		$resultad3 = mysql_query($sql_telefonosamarcar, $GLOBALS['conexion40'])or die("error2: ".mysql_error());
		while ($fila = mysql_fetch_assoc($resultad3)) {
			array_push($arregloTelefonos, $fila['telefono']);
		}
		// datos del registro
		array_push($arreglofinal, $arreglode);
		// calltypes de esa campania
		array_push($arreglofinal, getCalltypes($arreglode['idcampania'], 'interno'));
		// registros pendientes para ese usuario
		$arreglofinal[2]['registrospendientes'] = getRegistrospendientes();
		array_push($arreglofinal, getCamposRequeridos($arreglode['idcampania'], $adicional));
		$arreglofinal[4]['telefonosparamarcar'] = $arregloTelefonos;
		// aqui agregaremos los telefonos a marcar
		echo __json_encode($arreglofinal);
	}else{
		echo "0";
	}
}
function getCamposRequeridos($idCampania, $adicional){
	$sqll = "SELECT upper(nombrecampo) as nombrecampo, tipocampo, grupocampo FROM marcador_manual.campos_requeridos WHERE idcampania = '{$idCampania}' and nivel = 1 and activo = 1";
	$res_sl = mysql_query($sqll, $GLOBALS['conexion40']);
	$resultado = array();
	while ($fila = mysql_fetch_array($res_sl)) {
		$resultado1 = array();
		array_push($resultado1, $fila['nombrecampo']);
		array_push($resultado1, $fila['tipocampo']);
		array_push($resultado1, $fila['grupocampo']);
		if($fila['tipocampo'] == 'select'){
			$arreglopersonal = getOpcionesCampo($fila['tipocampo'], $fila['grupocampo'], $idCampania, $adicional);
			array_push($resultado1, $arreglopersonal);
		}elseif($fila['tipocampo'] == "grupo_checkbox"){
			$arreglopersonal = getOpcionesCampo($fila['tipocampo'], $fila['grupocampo'], $idCampania, $adicional);
			array_push($resultado1, $arreglopersonal);
		}elseif($fila['tipocampo'] == "grupo_radio"){
			$arreglopersonal = getOpcionesCampo($fila['tipocampo'], $fila['grupocampo'], $idCampania, $adicional);
			array_push($resultado1, $arreglopersonal);
		}elseif($fila['tipocampo'] == "enlace"){
			$arreglopersonal = getOpcionesCampo($fila['tipocampo'], $fila['grupocampo'], $idCampania, $adicional);
			array_push($resultado1, $arreglopersonal);
		}
		array_push($resultado, $resultado1);
	}
	return $resultado;
}
function getCalltypes($campania, $tipo){
	$sqlcamp = "SELECT COUNT(*) AS conteo FROM status  WHERE idcampania = {$campania}";
	$resp = mysql_query($sqlcamp, $GLOBALS['conexion40'])or die("error3: ".mysql_error());
	$filaresp = mysql_fetch_array($resp);
	$campaniaa = 0;
	if($filaresp['conteo'] != "0"){
		$campaniaa = $campania;
	}
	$sql = "SELECT status FROM marcador_manual.status WHERE tipo = '{$tipo}' AND idcampania = '{$campaniaa}' and activo = 1";
	$res_query = mysql_query($sql, $GLOBALS['conexion40'])or die("error4: ".mysql_error());
	$arrer = array();
	while ($fila = mysql_fetch_array($res_query)) {
		array_push($arrer, $fila['status']);
	}
	return $arrer;
}

function registrarMarcacion($peticion)
{

	$campania = $peticion['input_campania'];


	$idregistro        = $peticion['idregistro_txt'];
	$calendarioAgenda  = $peticion['calendarioagenda_txt'];
	$horaAgenda        = $peticion['horaagenda_txt'];
	$cajaComentario    = $peticion['cajacomentario_txt'];
	$statusMarcacion   = $peticion['statusmarcacion_txt'];
	$idempleado        = $_SESSION['idEmpleado'];
	$supervisor        = getJefe($_SESSION['idEmpleado']);
	$telefono_select   = $peticion['telefonoamarcar_txt'];
	$habloconeltitular = '';
	if (isset($_REQUEST['llamadacontitular_txt'])) {
		$habloconeltitular = $_REQUEST['llamadacontitular_txt'];
	}

	if (isset($peticion['idvalidador_txt'])) {
		$validador = $peticion['idvalidador_txt'];
		if ($validador == "1000") {
			$statusMarcacion = "sinvalidar";
		}
	}

	$sqlmm = "UPDATE marcador_manual.basecliente SET marcado=marcado+1, ultimoestatus = '{$statusMarcacion}', nsuper = '{$supervisor}', FechaUltimoStatus = current_timestamp ,AgenteUltimoStatus ='{$_SESSION['idEmpleado']}',recuperador ='{$telefono_select}' ";
	if (isset($cajaComentario)) {
		if (strlen($cajaComentario) != 0) {
			$sqlmm .= " , ultimocomentario = '{$cajaComentario}' ";
			$sqlcomentario = "INSERT INTO marcador_manual.comentarios (idregistro, comentario, idempleado) VALUES ('{$idregistro}','{$cajaComentario}','{$idempleado}')";
			mysql_query($sqlcomentario, $GLOBALS['conexion40']) or die("error5: " . mysql_error());
		}
	}
	if (isset($calendarioAgenda)) {
		if (strlen($calendarioAgenda) != 0) {
			$sqlmm .= " , fecha_reagenda = '{$calendarioAgenda} {$horaAgenda}' ";
		}
	}

	if ($statusMarcacion == 'Venta' || $statusMarcacion == 'sinvalidar') {
        // registramos la oferta que se le hizo
		$planofrecido = "";
        // if ($peticion['oferta_realizada'] == 0 || $peticion['oferta_realizada'] == '') {
        //     $planofrecido = '0';
        // } else {
        //     $planofrecido = $peticion['oferta_realizada'];
        // }

		if($campania == 22){
			$planofrecido 	=	 $peticion['input_paquete_bo'];
			$nombreplan  	=	 $peticion['input_nombrepaquete_bo'];
		}else{
			$planofrecido 	= 	$peticion['oferta_realizada'];
			$nombreplan  	=	'';
		}

		$sqlcaptura = "INSERT INTO marcador_manual.campos_adicionales(idfolio_externo, nombre_campo, valor_campo, tipocampo)VALUES('{$idregistro}', 'oferta_realizada','{$planofrecido}', 'venta')";
		mysql_query($sqlcaptura, $GLOBALS['conexion40']) or die("error6: " . mysql_error());
        // registramos fecha de instalacion
		$fechainstalacion = $peticion['fecha_instalacion'];
		$sqlcaptura       = "INSERT INTO marcador_manual.campos_adicionales(idfolio_externo, nombre_campo, valor_campo, tipocampo)VALUES('{$idregistro}', 'fecha_instalacion','{$fechainstalacion}', 'venta')";
		mysql_query($sqlcaptura, $GLOBALS['conexion40']) or die("error7: " . mysql_error());

        // registramos el internet crecelo
		if ($peticion['internet_crecelo'] != '' || $peticion['input_internet_bo'] != '') {
			if ($campania == '22') {
				$valor      = $peticion['input_internet_bo'];
			}else{
				$valor      = $peticion['internet_crecelo'];
			}
			$sqlcaptura = "INSERT INTO marcador_manual.campos_adicionales(idfolio_externo, nombre_campo, valor_campo, tipocampo)VALUES('{$idregistro}', 'internet_crecelo','{$valor}', 'venta')";
			mysql_query($sqlcaptura, $GLOBALS['conexion40']) or die("error8: " . mysql_error());
		}
        // registramos el wifi extender
		if (isset($peticion['wifi_extender']) || isset($peticion['adicional__bo_23_0'])) {
			if ($campania == '22') {
				$valor 		= $peticion['adicional__bo_23_0'];
			}else{
				$numero     = $peticion['wifi_extender'][0];
				$valor      = $peticion[$numero . "_valor"];		
			}
			$sqlcaptura = "INSERT INTO marcador_manual.campos_adicionales(idfolio_externo, nombre_campo, valor_campo, tipocampo)VALUES('{$idregistro}', 'wifi_extender','{$valor}', 'venta')";
			mysql_query($sqlcaptura, $GLOBALS['conexion40']) or die("error9: " . mysql_error());
		}
        // tv 4k
		if (isset($peticion['servicio_tv_4k'])) {
			$numero     = $peticion['servicio_tv_4k'][0];
			$valor      = $peticion[$numero . "_valor"];
			$sqlcaptura = "INSERT INTO marcador_manual.campos_adicionales(idfolio_externo, nombre_campo, valor_campo, tipocampo)VALUES('{$idregistro}', 'servicio_tv_4k','{$valor}', 'venta')";
			mysql_query($sqlcaptura, $GLOBALS['conexion40']) or die("error10: " . mysql_error());
		}
        // tv adicional
		if (isset($peticion['servicio_tv_adicional']) || isset($peticion['adicional__bo_27_0'])) {
			if ($campania =='22') {
				$valor 	=$peticion['adicional__bo_27_0'];
			}else{
				$numero     = $peticion['servicio_tv_adicional'][0];
				$valor      = $peticion[$numero . "_valor"];
			}
			$sqlcaptura = "INSERT INTO marcador_manual.campos_adicionales(idfolio_externo, nombre_campo, valor_campo, tipocampo)VALUES('{$idregistro}', 'servicio_tv_adicional','{$valor}', 'venta')";
			mysql_query($sqlcaptura, $GLOBALS['conexion40']) or die("error11: " . mysql_error());
		}

        // modulos de television

		if(isset($peticion['38_bo'])){
			$sql38_bo = "INSERT INTO marcador_manual.campos_adicionales(idfolio_externo, nombre_campo, valor_campo, tipocampo)VALUES";
			$sql38_bo .= "('{$idregistro}', 'modulos_tv','{$peticion['38_bo']}', 'venta')";
			mysql_query($sql38_bo, $GLOBALS['conexion40']) or die("error sql38_bo: " . mysql_error());	
		}
		if(isset($peticion['42_bo'])){
			$sql42_bo = "INSERT INTO marcador_manual.campos_adicionales(idfolio_externo, nombre_campo, valor_campo, tipocampo)VALUES";
			$sql42_bo .= "('{$idregistro}', 'modulos_tv','{$peticion['42_bo']}', 'venta')";
			mysql_query($sql42_bo, $GLOBALS['conexion40']) or die("error sql42_bo: " . mysql_error());
		}
		if(isset($peticion['45_bo'])){
			$sql45_bo = "INSERT INTO marcador_manual.campos_adicionales(idfolio_externo, nombre_campo, valor_campo, tipocampo)VALUES";
			$sql45_bo .= "('{$idregistro}', 'modulos_tv','{$peticion['45_bo']}', 'venta')";
			mysql_query($sql45_bo, $GLOBALS['conexion40']) or die("error sql45_bo: " . mysql_error());
		}
		if(isset($peticion['46_bo'])){
			$sql46_bo = "INSERT INTO marcador_manual.campos_adicionales(idfolio_externo, nombre_campo, valor_campo, tipocampo)VALUES";
			$sql46_bo .= "('{$idregistro}', 'modulos_tv','{$peticion['46_bo']}', 'venta')";
			mysql_query($sql46_bo, $GLOBALS['conexion40']) or die("error sql46_bo: " . mysql_error());
		}
		if(isset($peticion['47_bo'])){
			$sql47_bo = "INSERT INTO marcador_manual.campos_adicionales(idfolio_externo, nombre_campo, valor_campo, tipocampo)VALUES";
			$sql47_bo .= "('{$idregistro}', 'modulos_tv','{$peticion['47_bo']}', 'venta')";
			mysql_query($sql47_bo, $GLOBALS['conexion40']) or die("error sql47_bo: " . mysql_error());
		}
		if(isset($peticion['306_bo'])){
			$sql306_bo = "INSERT INTO marcador_manual.campos_adicionales(idfolio_externo, nombre_campo, valor_campo, tipocampo)VALUES";
			$sql306_bo .= "('{$idregistro}', 'modulos_tv','{$peticion['306_bo']}', 'venta')";
			mysql_query($sql306_bo, $GLOBALS['conexion40']) or die("error sql306_bo: " . mysql_error());
		} 
		if(isset($peticion['310_bo'])){
			$sql310_bo = "INSERT INTO marcador_manual.campos_adicionales(idfolio_externo, nombre_campo, valor_campo, tipocampo)VALUES";
			$sql310_bo .= "('{$idregistro}', 'modulos_tv','{$peticion['310_bo']}', 'venta')";
			mysql_query($sql310_bo, $GLOBALS['conexion40']) or die("error sql310_bo: " . mysql_error());
		}

		if (isset($peticion['modulos_tv'])) {
			if ($campania ==22) {
			}else{
				$sqlcaptura = "INSERT INTO marcador_manual.campos_adicionales(idfolio_externo, nombre_campo, valor_campo, tipocampo)VALUES";
				$conteoaa   = count($peticion['modulos_tv']);
				$iad        = 0;
				foreach ($peticion['modulos_tv'] as $key => $value) {
					$sqlcaptura .= "('{$idregistro}', 'modulos_tv','{$value}', 'venta')";
					$iad++;
					if ($iad != count($peticion['modulos_tv'])) {
						$sqlcaptura .= ",";
					}
				}
				mysql_query($sqlcaptura, $GLOBALS['conexion40']) or die("error12: " . mysql_error());
			}		
		}


		if(isset($peticion['adicional_servicios_adicionales'])){
			$sqlcaptura = "INSERT INTO marcador_manual.campos_adicionales(idfolio_externo, nombre_campo, valor_campo, tipocampo)VALUES";
			$conteoaa   = count($peticion['adicional_servicios_adicionales']);
			$iad        = 0;
			foreach ($peticion['adicional_servicios_adicionales'] as $key => $value) {
				$sqlcaptura .= "('{$idregistro}', 'adicional_servicios_adicionales','{$value}', 'venta')";
				$iad++;
				if ($iad != count($peticion['adicional_servicios_adicionales'])) {
					$sqlcaptura .= ",";
				}
			}
			mysql_query($sqlcaptura, $GLOBALS['conexion40']) or die("error13: " . mysql_error());
		}


               // gamefly
		if (isset($peticion['gamefly_plan']) || isset($peticion['input_gamefly_bo'])) {
			if (strlen($peticion['gamefly_plan']) != 0 || isset($peticion['input_gamefly_bo'])) {
				if ($campania =='22') {
					$valor      = $peticion['input_gamefly_bo'];
				}else{
					$valor      = $peticion['gamefly_plan'];
				}
				$sqlcaptura = "INSERT INTO marcador_manual.campos_adicionales(idfolio_externo, nombre_campo, valor_campo, tipocampo)VALUES('{$idregistro}', 'gamefly_plan','{$valor}', 'venta')";
				mysql_query($sqlcaptura, $GLOBALS['conexion40']) or die("error13: " . mysql_error());
			}
		}

        // gamepads

		if (isset($peticion['gamepad'])|| isset($peticion['adicional__bo_34_0'])) {
			if ($campania =='22') {
				$valor 		= $peticion['adicional__bo_34_0'];
			}else{
				$numero     = $peticion['gamepad'][0];
				$valor      = $peticion[$numero . '_valor'];
			}
			$sqlcaptura = "INSERT INTO marcador_manual.campos_adicionales(idfolio_externo, nombre_campo, valor_campo, tipocampo)VALUES('{$idregistro}', 'gamepad','{$valor}', 'venta')";
			mysql_query($sqlcaptura, $GLOBALS['conexion40']) or die("error14: " . mysql_error());
		}

        // linea o extension extra

		if (isset($peticion['telefonia'])) {
			if ($campania =='22' ) {
			}else{	
				$sqlcaptura = "INSERT INTO marcador_manual.campos_adicionales(idfolio_externo, nombre_campo, valor_campo, tipocampo)VALUES";
				$conteoaa   = count($peticion['telefonia']);
				$iad        = 0;
				foreach ($peticion['telefonia'] as $key => $value) {

					$sqlcaptura .= "('{$idregistro}', '{$value}', {$peticion[$value . '_valor']},'venta')";
					$iad++;
					if ($iad != count($peticion['telefonia'])) {
						$sqlcaptura .= ",";
					}
				}
				mysql_query($sqlcaptura, $GLOBALS['conexion40']) or die("error15: " . mysql_error());
			}
		}

		// telefonia campaña 22

		if(isset($peticion['adicional__bo_49_0'])){
			$sqlcaptura = "INSERT INTO marcador_manual.campos_adicionales(idfolio_externo, nombre_campo, valor_campo, tipocampo)VALUES";
			$sqlcaptura .= "('{$idregistro}', '49', {$peticion['adicional__bo_50_0']},'venta')";
			mysql_query($sqlcaptura, $GLOBALS['conexion40']) or die("error bo 49: " . mysql_error());
		}

		if(isset($peticion['adicional__bo_50_0'])){
			$sqlcaptura = "INSERT INTO marcador_manual.campos_adicionales(idfolio_externo, nombre_campo, valor_campo, tipocampo)VALUES";
			$sqlcaptura .= "('{$idregistro}', '50', {$peticion['adicional__bo_50_0']},'venta')";
			mysql_query($sqlcaptura, $GLOBALS['conexion40']) or die("error bo50: " . mysql_error());
		}
		if(isset($peticion['input_paquetetv_bo'])){
			$sqlcaptura = "INSERT INTO marcador_manual.campos_adicionales(idfolio_externo, nombre_campo, valor_campo, tipocampo)VALUES";
			$sqlcaptura .= "('{$idregistro}', 'adicional__bo_adicional_paqueteTelevision','{$peticion['input_paquetetv_bo']}','venta')";
			mysql_query($sqlcaptura, $GLOBALS['conexion40']) or die("error  paquetebo tv: " . mysql_error());
		}


		$valor = $peticion['idvalidador_txt'];
		if (isset($valor)) {
            // registrar la persona que validado
			$sqlcaptura = "INSERT INTO marcador_manual.campos_adicionales(idfolio_externo, nombre_campo, valor_campo, tipocampo)VALUES('{$idregistro}', 'validador','{$valor}', 'venta')";
			mysql_query($sqlcaptura, $GLOBALS['conexion40']) or die("error16: " . mysql_error());
		}

	}

	$sql_adicional = "INSERT INTO campos_adicionales(idfolio_externo, nombre_campo, valor_campo, tipocampo)VALUES";
	$conteouu      = 0;
	foreach ($peticion as $key => $value) {
		if (strpos($key, 'adicional_') !== false) {
			$conteouu++;
		}
	}

	$iqe = 0;
	foreach ($peticion as $key => $value) {
		if (strpos($key, 'adicional_') !== false) {
			if($key != 'adicional_servicios_adicionales'){
				$sql_adicional .= "('{$peticion['idregistro_txt']}', '{$key}', '{$value}', 'venta')";
				if (($iqe + 1) != $conteouu) {
					$sql_adicional .= ",";
				}
			}
			$iqe++;
		}
	}
	if ($conteouu != 0) {
		mysql_query($sql_adicional, $GLOBALS['conexion40']);
	}

	if ((isset($_REQUEST['input_total']) && isset($_REQUEST['input_diferencia'])) || isset($_REQUEST['input_total_bo'])) {
		$fechaventaoriginal = date('Y-m-d');
		if ($campania == '22') {
			$montoactual 		= $_REQUEST['input_diferencia'];
			$montovistaagente 	= $_REQUEST['input_total'];
			$montovistabo		= $_REQUEST['input_total_bo'];

			$U_diferencia 		= $montovistabo;
			$U_montoagente 		= $montovistaagente; 
			$U_montobo			= ($montovistaagente == $montovistabo)?0:($montovistabo - $montovistaagente);
			$U_montonuevo		= ($montoactual + $montovistabo);

			$sql                = "
			UPDATE 
			basecliente
			SET diferencia = '{$U_diferencia}',
			incremento_agente = '{$U_montoagente}',
			incremento_bo ='{$U_montobo}',
			montonuevo = '{$U_montonuevo}',
			MontoActual = '{$montoactual}',
			fechaventaoriginal = '{$fechaventaoriginal}',
			nsuper = '{$supervisor}' 
			WHERE id = '{$idregistro}'";
			mysql_query($sql, $GLOBALS['conexion40']) or die("error al registrar el total y diferencia: " . mysql_error());
		}else{
			$montoNuevo         = $_REQUEST['input_total'] + $_REQUEST['input_diferencia'];
			$montoactual 		= $_REQUEST['input_diferencia'];
			$incrementoagente   = $_REQUEST['input_total'];
			$sql                = "
			UPDATE
			 basecliente
			  SET
			   diferencia = '{$incrementoagente}',
			   incremento_agente = '{$incrementoagente}',
			   montonuevo = '{$montoNuevo}',
			   MontoActual = '{$montoactual}',
			   fechaventaoriginal = '{$fechaventaoriginal}',
			   nsuper = '{$supervisor}'
			    WHERE id = '{$idregistro}'";
			mysql_query($sql, $GLOBALS['conexion40']) or die("error al registrar el total y diferencia: " . mysql_error());
		}

	}



	$sqlmarc = "INSERT INTO marcador_manual.marcaciones (idbasecliente, agente, supervisor, STATUS, habloconeltitular) VALUES('{$idregistro}','{$idempleado}','{$supervisor}','{$statusMarcacion}', '{$habloconeltitular}')";
	mysql_query($sqlmarc, $GLOBALS['conexion40']) or die("error17: " . mysql_error());
	$idmarcacion = mysql_insert_id();
	$sqlmm .= " , idmarcacionlast = '{$idmarcacion}' ";
	$sqlmm .= " WHERE id = '{$idregistro}'";
	mysql_query($sqlmm, $GLOBALS['conexion40']) or die("error18: " . mysql_error());

	// registrar tabla de abelardo
	$campos = updatebaselotes($peticion['idregistro_txt']);
	
	if(isset($campos['marcacion'])){
		$SqlBaseLotes ="
		UPDATE 
		marcador_manual.bases_lotes SET 
		plan_vendido = '{$nombreplan}',
		valor_plan_vendido = '{$planofrecido}',
		telefono_venta ='{$telefono_select}',
		{$campos['marcacion']} = '{$idmarcacion}',
		{$campos['fecha']} = CURRENT_TIMESTAMP()
		where cuenta =	(select foliocliente from marcador_manual.basecliente where id ='{$idregistro}');";
		mysql_query($SqlBaseLotes, $GLOBALS['conexion40']) or die("error18: " . mysql_error());
	}

	if ($statusMarcacion == "sinvalidar") {
		echo "Su folio de validacion es : " . $idregistro;
		?>
		<br>
		<a href="/sialcom/system/marcadormanual/marcador.php?recargame=<?php echo rand(5, 15); ?>">Regresar</a>
		<?php
	} else {
		if($_SESSION['idEmpleado'] != "2898"){
			header('location: ../../marcador.php?recargame=' . rand(5, 15));
		}
	}


}


function __json_encode( $data ) {           
	if( is_array($data) || is_object($data) ) {
		$islist = is_array($data) && ( empty($data) || array_keys($data) === range(0,count($data)-1) );

		if( $islist ) {
			$json = '[' . implode(',', array_map('__json_encode', $data) ) . ']';
		} else {
			$items = Array();
			foreach( $data as $key => $value ) {
				$items[] = __json_encode("$key") . ':' . __json_encode($value);
			}
			$json = '{' . implode(',', $items) . '}';
		}
	} elseif( is_string($data) ) {
        # Escape non-printable or Non-ASCII characters.
        # I also put the \\ character first, as suggested in comments on the 'addclashes' page.
		$string = '"' . addcslashes($data, "\\\"\n\r\t/" . chr(8) . chr(12)) . '"';
		$json    = '';
		$len    = strlen($string);
        # Convert UTF-8 to Hexadecimal Codepoints.
		for( $i = 0; $i < $len; $i++ ) {

			$char = $string[$i];
			$c1 = ord($char);

            # Single byte;
			if( $c1 <128 ) {
				$json .= ($c1 > 31) ? $char : sprintf("\\u%04x", $c1);
				continue;
			}

            # Double byte
			$c2 = ord($string[++$i]);
			if ( ($c1 & 32) === 0 ) {
				$json .= sprintf("\\u%04x", ($c1 - 192) * 64 + $c2 - 128);
				continue;
			}

            # Triple
			$c3 = ord($string[++$i]);
			if( ($c1 & 16) === 0 ) {
				$json .= sprintf("\\u%04x", (($c1 - 224) <<12) + (($c2 - 128) << 6) + ($c3 - 128));
				continue;
			}

            # Quadruple
			$c4 = ord($string[++$i]);
			if( ($c1 & 8 ) === 0 ) {
				$u = (($c1 & 15) << 2) + (($c2>>4) & 3) - 1;

				$w1 = (54<<10) + ($u<<6) + (($c2 & 15) << 2) + (($c3>>4) & 3);
				$w2 = (55<<10) + (($c3 & 15)<<6) + ($c4-128);
				$json .= sprintf("\\u%04x\\u%04x", $w1, $w2);
			}
		}
	} else {
        # int, floats, bools, null
		$json = strtolower(var_export( $data, true ));
	}
	return $json;
} 

function getCampaniasTodo(){
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
	echo __json_encode($datos);
}
function getOpcionesCampo($tipocampo, $grupocampo, $idcampania, $adicional){
	$sqlll = "SELECT nombrecampo, id, valorcampo, cantidad FROM marcador_manual.campos_requeridos WHERE tipocampo != '{$tipocampo}' AND grupocampo = '{$grupocampo}' AND idcampania = '{$idcampania}' and activo = 1";
	/*if($grupocampo == "oferta_realizada"){
		$sqlll .= " and valorcampo > {$adicional}";
	}*/
	$res_opccampos = mysql_query($sqlll, $GLOBALS['conexion40'])or die("error19: -".$sqlll."-".mysql_error());
	$datos = array();
	while ($fila = mysql_fetch_array($res_opccampos)) {
		$arre = array();
		array_push($arre, $fila[0]);
		array_push($arre, $fila[1]);
		array_push($arre, $fila[2]);
		array_push($arre, $fila[3]);
		array_push($datos, $arre);
	}
	return $datos;
}
function obtenerRuta(){
	$rutapa = explode('/',$_SERVER["SCRIPT_NAME"]);
	return $rutapa[count($rutapa)-1];
}
function getNumeroValidacion($contra_txt){
	$sql = "SELECT COUNT(*) as conteo, idEmpleado FROM validadores WHERE contrasenia = MD5('{$contra_txt}') and esvalidador = '1'";
	$res_sql = mysql_query($sql, $GLOBALS['conexion40']);
	$fila_sql = mysql_fetch_assoc($res_sql);
	echo __json_encode($fila_sql);
}
function getStatus(){
	$sqlp = "SELECT ultimoestatus, COUNT(id) AS conteo FROM basecliente WHERE nagente = '{$_SESSION['idEmpleado']}' and idcampania = '{$_SESSION['campania_id_selected']}' GROUP BY ultimoestatus";
	$resp = mysql_query($sqlp, $GLOBALS['conexion40']);
	$datos = array();
	while ($fila = mysql_fetch_array($resp)) {
		$temporal = array();
		$temporal['status'] = $fila['ultimoestatus'];
		$temporal['conteo'] = $fila['conteo'];
		array_push($datos, $temporal);
	}
	return $datos;
}
function getTipoUsuario(){
	if($_SESSION['cc'] == "TICS"){
		return "sistemas";
	}elseif($_SESSION['cc'] == "totalplay"){
		return "totalplay";
	}else{
		$idEmpleado = $_SESSION["idEmpleado"];
		$sxq = "SELECT COUNT(*) AS cuantos, essuper, esvalidador, esBO FROM validadores WHERE idEmpleado = '{$idEmpleado}' and estatus = 1";
		$res_sxq = mysql_query($sxq, $GLOBALS['conexion40']);
		$fila_sxq = mysql_fetch_array($res_sxq);
		if($fila_sxq['cuantos'] != '0'){
			if($fila_sxq['essuper'] == '2' && $fila_sxq['esvalidador'] == '1'){
				return "superuser";
			}else{
				if($fila_sxq['essuper'] == '1'){
					return "supervisor";
				}elseif($fila_sxq['esvalidador'] == '1'){
					return "validador";
				}elseif($fila_sxq['esBO'] == '1'){
					return "bo";
				}else{
					return "normal";
				}
			}
		}else{
			return "normal";
		}
	}

}
function getRegistrosAgendados(){
	$sqltime = "SELECT a.id, a.contacto, b.nombre, a.fecha_reagenda FROM marcador_manual.basecliente AS a INNER JOIN audios_listado.campanias b ON a.idcampania = b.id  WHERE a.nagente = '{$_SESSION['idEmpleado']}' AND a.ultimoestatus = 'Llamar más tarde' AND DATE_SUB(NOW(), INTERVAL 5 MINUTE) >= DATE_SUB(a.fecha_reagenda, INTERVAL 5 MINUTE)";
	$resultado = mysql_query($sqltime, $GLOBALS['conexion40']);
	$datos = array();
	while($fila = mysql_fetch_array($resultado)){
		array_push($datos, $fila);
	}
	return $datos;
}
function updatebaselotes($cuenta){
	$SqlGetIndices 
	="
	SELECT 
	case
	when fecha_asignacion_toque_1 = '0' || date_format(fecha_asignacion_toque_1,'%Y-%m-%d')= curdate()  then 'fecha_asignacion_toque_1,idmarcacionlast_1'
	when fecha_asignacion_toque_2 = '0' || date_format(fecha_asignacion_toque_2,'%Y-%m-%d')= curdate()  then 'fecha_asignacion_toque_2,idmarcacionlast_2'
	when fecha_asignacion_toque_3 = '0' || date_format(fecha_asignacion_toque_3,'%Y-%m-%d')= curdate()  then 'fecha_asignacion_toque_3,idmarcacionlast_3'
	else 'fecha_asignacion_toque_3,idmarcacionlast_3'
	end as upd
	from marcador_manual.bases_lotes where cuenta =	(select foliocliente from marcador_manual.basecliente where id ={$cuenta});";

	$ResultIndices = mysql_query($SqlGetIndices,$GLOBALS['conexion40'])or die(mysql_error());
	$ResultIndices = mysql_fetch_array($ResultIndices);
	$indices = split(',',$ResultIndices['upd']);
	$result['fecha'] = $indices[0];
	$result['marcacion'] = $indices[1];

	return $result;
}
?>
