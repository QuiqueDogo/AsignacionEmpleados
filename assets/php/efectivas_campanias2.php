<?php 
	include 'funciones.php';
	$inicioF = $_REQUEST['fechaI'];
	$finalF = $_REQUEST['fechaF'];
	$lote = $_REQUEST['option'];
	$segmento = $_REQUEST['segmento'];

	$todo = array();
	array_push($todo, $lote, $segmento);
	

	if ($segmento == '0') {
			$sqlCuentas = "SELECT cuenta from marcador_manual.bases_lotes where lote = '{$lote}'";
			$queryCuentas = mysql_query($sqlCuentas, $conexion40);
			//echo $sqlCuentas;

			$consultaManual = "SELECT count(*) as conteo  from marcador_manual.basecliente where DATE_FORMAT(FechaUltimoStatus, '%Y-%m-%d') between '{$inicioF}' and '{$finalF}' and ultimoestatus = 'Venta' and foliocliente in (";
			
			$idbasecliente = "SELECT id from marcador_manual.basecliente where DATE_FORMAT(FechaUltimoStatus, '%Y-%m-%d') between '{$inicioF}' and '{$finalF}' and foliocliente in(";

				while ($resul = mysql_fetch_array($queryCuentas)) {
					 $consultaManual .= "'".$resul['cuenta']."',";
					 $idbasecliente .= "'".$resul['cuenta']."',";
				}

			$consultaManual = substr($consultaManual, 0,-1);
			$consultaManual .= ') group by ultimoestatus';

			$idbasecliente = substr($idbasecliente, 0,-1);
			$idbasecliente .= ')';
			$queryIDMarc = mysql_query($idbasecliente,$conexion40);

			//Marciones para el total de llamadas
			$MarcacionesporID = "SELECT idbasecliente from marcador_manual.marcaciones where DATE_FORMAT(dt, '%Y-%m-%d') between '{$inicioF}' and '{$finalF}' and idbasecliente != '0' and status not in ('tomado') and idbasecliente in (";

			//Para las realizadas 

			$LasRealizadas = "SELECT idbasecliente from marcador_manual.marcaciones where DATE_FORMAT(dt, '%Y-%m-%d') between '{$inicioF}' and '{$finalF}' and idbasecliente != '0' and status not in ('tomado') and habloconeltitular = 'SI' and idbasecliente in (";

			//===============================================================

			while ($resul2 = mysql_fetch_assoc($queryIDMarc)) {
				$MarcacionesporID .= "'".$resul2['id']."',";
				$LasRealizadas .= "'".$resul2['id']."',";
			}

			$MarcacionesporID = substr($MarcacionesporID, 0, -1);
			$MarcacionesporID .= ")";
			
			$queryMarcaciones = mysql_query($MarcacionesporID,$conexion40);
			$total = mysql_num_rows($queryMarcaciones);
			//total de llamadas 
			array_push($todo, $total);

			//===========================================================


			$LasRealizadas = substr($LasRealizadas, 0, -1);
			$LasRealizadas .= ")";
			
			$queryRealizadas = mysql_query($LasRealizadas,$conexion40);
			$totalRealizadas = mysql_num_rows($queryRealizadas);
			//Realizadas con el titular
			array_push($todo, $totalRealizadas);
			
			
			$queryManual = mysql_query($consultaManual,$conexion40) or die(mysql_error());
			$EfectVentas = mysql_fetch_assoc($queryManual);
			//las ventas
			array_push($todo, $EfectVentas['conteo']);
	}else{
	 	//Para cuando hay un segmento seleecionado


		$sqlCuentas = "SELECT cuenta from marcador_manual.bases_lotes where lote = '{$lote}' and base_segmento = '{$segmento}'";
			$queryCuentas = mysql_query($sqlCuentas, $conexion40) or die('No hay Segmento en esta base');

			$consultaManual = "SELECT count(*) as conteo  from marcador_manual.basecliente where DATE_FORMAT(FechaUltimoStatus, '%Y-%m-%d') between '{$inicioF}' and '{$finalF}' and ultimoestatus = 'Venta' and foliocliente in (";
			
			$idbasecliente = "SELECT id from marcador_manual.basecliente where DATE_FORMAT(FechaUltimoStatus, '%Y-%m-%d') between '{$inicioF}' and '{$finalF}' and foliocliente in(";

				while ($resul = mysql_fetch_array($queryCuentas)) {
					 $consultaManual .= "'".$resul['cuenta']."',";
					 $idbasecliente .= "'".$resul['cuenta']."',";
				}

			$consultaManual = substr($consultaManual, 0,-1);
			$consultaManual .= ') group by ultimoestatus';

			$idbasecliente = substr($idbasecliente, 0,-1);
			$idbasecliente .= ')';
			$queryIDMarc = mysql_query($idbasecliente,$conexion40);

			//Marciones para el total de llamadas
			$MarcacionesporID = "SELECT idbasecliente from marcador_manual.marcaciones where DATE_FORMAT(dt, '%Y-%m-%d') between '{$inicioF}' and '{$finalF}' and idbasecliente != '0' and status not in ('tomado') and idbasecliente in (";

			//Para las realizadas 

			$LasRealizadas = "SELECT idbasecliente from marcador_manual.marcaciones where DATE_FORMAT(dt, '%Y-%m-%d') between '{$inicioF}' and '{$finalF}' and idbasecliente != '0' and status not in ('tomado') and habloconeltitular = 'SI' and idbasecliente in (";

			//===============================================================

			while ($resul2 = mysql_fetch_assoc($queryIDMarc)) {
				$MarcacionesporID .= "'".$resul2['id']."',";
				$LasRealizadas .= "'".$resul2['id']."',";
			}

			$MarcacionesporID = substr($MarcacionesporID, 0, -1);
			$MarcacionesporID .= ")";
			
			$queryMarcaciones = mysql_query($MarcacionesporID,$conexion40);
			$total = mysql_num_rows($queryMarcaciones);
			//Total llamadas
			array_push($todo, $total);

			//===========================================================


			$LasRealizadas = substr($LasRealizadas, 0, -1);
			$LasRealizadas .= ")";
			
			$queryRealizadas = mysql_query($LasRealizadas,$conexion40);
			$totalRealizadas = mysql_num_rows($queryRealizadas);
			//Realizadas con el titular
			array_push($todo, $totalRealizadas);


			
			$queryManual = mysql_query($consultaManual,$conexion40) or die('No hay segmentos en esta Base');
			$EfectVentas = mysql_fetch_assoc($queryManual);
			//las ventas
			array_push($todo, $EfectVentas['conteo']);
		
	}


	
	echo json_encode($todo);
 ?>

<?php mysql_close($conexion40); ?>