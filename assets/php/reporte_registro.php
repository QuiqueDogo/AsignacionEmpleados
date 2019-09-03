<table>
	<thead>
		<th>Nombre Agente</th>
		<th>Supervisor</th>
		<th>Venta</th>
		<th>No Venta</th>
		<th>Total</th>
	</thead>
	<tbody>
		
		<?php 
		include 'conexionPDO.php';
		$sql_getinfo= "
		SELECT
		(select emp_nombrecompleto from adcom.empleados where emp_Nroemp=agente)as nombre_agente,
		(select emp_nombrecompleto from adcom.empleados where emp_Nroemp=supervisor) as nombre_supervisor,
		sum(if(status = 'venta',1,0))as Venta,
		sum(if(status != 'venta',1,0))as NoVenta,
		sum(1)as registros_tomados
		from marcador_manual.marcaciones where 
		date_format(dt,'%Y-%m-%d')";

		if ($_REQUEST['date1']) {
			$sql_getinfo .="between  '".$_REQUEST['date1']."' and '".$_REQUEST['date2']."' 
			group by agente
			order by agente ; ";
		}else{
			$sql_getinfo .="between curdate() and curdate() 
			group by agente
			order by agente ; ";
		}
		try {
			foreach ($ConexionPDO -> query($sql_getinfo) as $key => $arregloingo) {
				?>
				<tr>
					<td><?php echo $arregloingo['nombre_agente']?></td>
					<td><?php echo $arregloingo['nombre_supervisor']?></td>
					<td><?php echo $arregloingo['Venta']?></td>
					<td><?php echo $arregloingo['NoVenta']?></td>
					<td><?php echo $arregloingo['registros_tomados']?></td>
				</tr>
				<?php	}
			} catch (PDOException $e) {
				echo $sql_getinfo." <br> ".$e;
			}

			$ConexionPDO = 0 ;
			?>
		</tbody>
	</table>