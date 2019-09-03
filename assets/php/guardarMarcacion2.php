<?php 
include "funciones.php";

function vacioOno($dato){
	return ($dato != '0' && $dato != '');
}

function registrarMarcacion2($peticion){
	$idregistro = $peticion['idregistro_txt'];
	$calendarioAgenda = $peticion['calendarioagenda_txt'];
	$horaAgenda = $peticion['horaagenda_txt'];
	$cajaComentario = $peticion['cajacomentario_txt'];
	$statusMarcacion = $peticion['statusmarcacion_txt'];
	$idempleado = $_SESSION['idEmpleado'];
	$supervisor = $_SESSION['jefe'];
	$validador = "";
	$habloconeltitular = "";

	// llamada con el titular
	if(isset($peticion['llamadacontitular_txt'])){
		$habloconeltitular = $peticion['llamadacontitular_txt'];
	}
	// id validador
	if(isset($peticion['idvalidador_txt'])){
		$validador = $peticion['idvalidador_txt'];
		if($validador == "1000"){
			$statusMarcacion = "sinvalidar";
		}
	}
	// actualizar el estatus de marcacion y el numero de marcaciones
	$sqlmm = "UPDATE marcador_manual.basecliente SET marcado=marcado+1, ultimoestatus = '{$statusMarcacion}' ";
	if(isset($cajaComentario)){
		if(strlen($cajaComentario) != 0){
			$sqlmm .= " , ultimocomentario = '{$cajaComentario}' ";
			$sqlcomentario = "INSERT INTO marcador_manual.comentarios (idregistro, comentario, idempleado) VALUES ('{$idregistro}','{$cajaComentario}','{$idempleado}')";
			mysql_query($sqlcomentario, $GLOBALS['conexion40'])or die("error5: ".mysql_error());
		}
	}
	// actualizar en caso de haber fecha de reagenda
	if(isset($calendarioAgenda)){
		if(strlen($calendarioAgenda) != 0){
			$sqlmm .= " , fecha_reagenda = '{$calendarioAgenda} {$horaAgenda}' ";
		}
	}
	// aqui solo entraremos en caso de que sea una venta o una captura que pasara sin validar
	if($statusMarcacion == 'Venta' || $statusMarcacion == 'sinvalidar'){	
		$campanias = array(22, 176);
		if(in_array($campania_id_selected, $campanias)){
		// registramos la oferta que se le hizo
			$planofrecido_agente = "";
			$planofrecido_bo = "";

			$sqlcaptura = "INSERT INTO marcador_manual.campos_adicionales(idfolio_externo, nombre_campo, valor_campo, tipocampo)VALUES";
		# -----
		// este es la oferta que se quedo en la validacion
			if(vacioOno($peticion['oferta_realizada__bo'])){
				$planofrecido_bo = '0';
			}else{
				$planofrecido_bo = $peticion["oferta_realizada__bo"];
			}
		// esta es la oferta que se quedo por el agente
			if(vacioOno($peticion['oferta_realizada'])){
				$planofrecido_agente = '0';
			}else{
				$planofrecido_agente = $peticion["oferta_realizada"];
			}

		// concatenamos el valor de las ofertas realizadas
			$sqlcaptura .= "('{$idregistro}', 'oferta_realizada_final','{$planofrecido_bo}', 'venta'),";
			$sqlcaptura .= "('{$idregistro}', 'oferta_realizada_agente','{$planofrecido_agente}', 'venta')";
		# -----
		// registramos la fecha de instalacion
			$fechainstalacion = $peticion['fecha_instalacion'];
			if(vacioOno($fechainstalacion)){
				$sqlcaptura .= "('{$idregistro}', 'fecha_instalacion','{$fechainstalacion}', 'venta'),";
			}
		# -----
		// registramos internet crecelo
			$internet_crecelo  = $peticion['internet_crecelo '];
			$internet_crecelo_bo = $peticion['internet_crecelo_bo'];
			if(vacioOno($internet_crecelo_bo)){
				$sqlcaptura .= "('{$idregistro}', 'internet_crecelo_final','{$internet_crecelo_bo}', 'venta'),";
			}
			if(vacioOno($internet_crecelo)){
				$sqlcaptura .= "('{$idregistro}', 'internet_crecelo_agente','{$internet_crecelo}', 'venta'),";
			}
		# -----
		// registramos el wifi extender
			if(isset($peticion['wifi_extender'])){
				$numero = $peticion['wifi_extender'][0];
				$valor = $peticion[$numero."_valor"];
				$sqlcaptura .= "('{$idregistro}', 'wifi_extender_agente','{$valor}', 'venta'),";
			}
			if($peticion['wifiExtender_bo'] == 'on'){
				$wifiExtenderBO = $peticion['select_wifiExtender_bo'];
				$sqlcaptura .= "('{$idregistro}', 'wifi_extender_bo','{$wifiExtenderBO}', 'venta'),";
			}
		# -----
		// registramos el servicio de tv 4k
			if(isset($peticion['servicio_tv_4k'])){
				$numero = $peticion['servicio_tv_4k'][0];
				$valor = $peticion[$numero."_valor"];
				$sqlcaptura .= "('{$idregistro}', 'servicio_tv_4k_agente','{$valor}', 'venta')";
			}

			if($peticion['tv_4k_bo'] == 'on'){
				$wifiExtenderBO = $peticion['select_tv_4k_bo'];
				$sqlcaptura .= "('{$idregistro}', 'servicio_tv_4k_bo','{$wifiExtenderBO}', 'venta'),";
			}
		# -----
		




		}
	}
}


registrarMarcacion2($_REQUEST);

?>