<?php
	$conexion40 = mysql_connect("172.30.27.40","root","4LC0M");
	mysql_set_charset('utf8',$conexion40);

	$fecha1="";
	$fecha2="";
	if (isset($_REQUEST["f1"])) {
		$fecha1=$_REQUEST["f1"];
	}else{
		$fecha1 = date("Y-m-d");
	}

	if (isset($_REQUEST["f2"])) {
		$fecha2=$_REQUEST["f2"];
	}else{
		$fecha2 = date("Y-m-d");
	}


	
	if (mysql_errno()) {
			die("No se pudo conectar a la base de datos".mysql_error());
		
		}else{
			$consultaSQL = "
			SELECT 
			fechaventaoriginal,
			foliocliente,
			idcampania,
			contacto,
			telefono,
			nagente,
			nsuper
			FROM 
			marcador_manual.basecliente
			where
			fechaventaoriginal between '($fecha1)' and '($fecha2)' and idcampania in('22','176')";

			$consulta = mysql_query($consultaSQL,$conexion40) or die(mysql_error());

			if ($consulta) {
				$lista_canceladas = mysql_fetch_array($consulta);
			}

		}


		
		while ($lista_canceladas = mysql_fetch_array($consulta)) {
			echo "<tr>";	
				echo "<td>". $lista_canceladas['fechaventaoriginal'] ."</td> ";
				echo "<td>". $lista_canceladas['foliocliente']."</td>";
				echo "<td>". $lista_canceladas['idcampania']."</td>";
				echo "<td>".$lista_canceladas['contacto']."</td>";
			echo "</tr>";
		}
	

		?>