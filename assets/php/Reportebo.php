<table>
	<th>Fecha Venta</th>
	<th>Folio Cliente</th>
	<th>ID Campania</th>
	<th>Contacto</th>
	<th>Telefeno</th>
	<th>Agente</th>
	<th>Supervisor</th>
	
	<tbody>
		
			<?php 
			
			$con40 = mysql_connect("172.30.27.40", "root", "4LC0M");
			mysql_set_charset('utf8', $con40);
			if (mysql_errno()) { 
			    die("No se puede conectar a la base de datos:" . mysql_error());

			}else{
			       
			    $sql = "SELECT
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
				idcampania in("22","176") and fecha BETWEEN '{$fecha1}' and '{$fecha2}'";

			    $ejecuta_sentencia = mysql_query($sql, $con40) or die (mysql_error());

			    if ($ejecuta_sentencia) {
			        $lista_reporte = mysql_fetch_array($ejecuta_sentencia);
			    }   
			}
			
			// fechas del reporte
		# fecha 1
		$fecha1 = "";
		$fecha2 = "";
		if(isset($_REQUEST["fecha1"])){ 
			$fecha1 = $_REQUEST["fecha1"]; 
		}else{ 
			$fecha1 = date("Y-m-d"); 
		}
		# fecha 2
		if(isset($_REQUEST["fecha2"])){ 
			$fecha2 = $_REQUEST["fecha2"]; 
		}else{ 
			$fecha2 = date("Y-m-d"); 
		}


			while ($lista_reporte = mysql_fetch_array($ejecuta_sentencia)) {
				# code...
				echo "<tr class = 'even' >";
					 echo "<td>".$lista_reporte['fechaventaoriginal']."</td>";
				echo "</tr>";
				

			}

			



	?>
	</tbody>
</table>




		