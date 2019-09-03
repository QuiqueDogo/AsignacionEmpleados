<?php 
include "funciones.php";
$superPOP = $_REQUEST["superP"];
$idcampania = $_REQUEST["campaniaid"];
$tipoCon = $_REQUEST["tipoCon"];
$sql_traerdatos = "";
$sql_empleados = "";
$pa = 0;
switch($tipoCon){
	case "1":
	$pa = 1;
	$sql_empleados = "select emp_Nroemp, emp_nombrecompleto from adcom.empleados where emp_jefe = '{$superPOP}' and emp_fchbaja is null";
	break;
	case "2":
	$pa = 2;
	$sql_empleados = "select emp_Nroemp, emp_nombrecompleto from adcom.empleados where emp_jefe = '{$superPOP}' and emp_fchbaja is not null";
	break;
}


# sacamos los empleados y buscaremos si le pertenecen al super y si formaron/forman parte de la campaña
$res_empleados = mysql_query($sql_empleados, $conexion40);
$agentesNRO = array();
$agentesNOM = array();
$agentesCom = array();
while ($fila_empleados = mysql_fetch_assoc($res_empleados)) {
	array_push($agentesNRO, $fila_empleados["emp_Nroemp"]);
	array_push($agentesNOM, $fila_empleados["emp_nombrecompleto"]);
	array_push($agentesCom, $fila_empleados);
}
# vamos a sacar de esos agentes quienes estan en la campaña con ese super y sus registros
$agenteslistado = implode(", ", $agentesNRO);


# en dado caso de haber pasado por los de baja me falta comprobar que sean agentes de ventas. 
$sqlagentesCampa = "select nagente from marcador_manual3.basecliente where nagente in ({$agenteslistado}) and idcampania = '{$idcampania}' and ultimoestatus in ('nuevo', 'llamar mas tarde') group by nagente";

$sql_registros = "select 	
nagente,
sum( if( ultimoestatus = 'nuevo' and DATE_FORMAT(fecha_carga, '%Y-%m-%d') = curdate(), 1, 0 )) as 'nuevoshoy',
sum( if( ultimoestatus = 'nuevo' and DATE_FORMAT(fecha_carga, '%Y-%m-%d') != curdate(), 1, 0 )) as 'nuevosotros',
sum( if( ultimoestatus = 'nuevo', 1, 0 )) as 'nuevostotales',
sum( if( ultimoestatus = 'llamar mas tarde', 1, 0 )) as 'agenda' 
from marcador_manual.basecliente 
where 
nagente in ({$agenteslistado}) and 
ultimoestatus in ('nuevo', 'llamar mas tarde')  
group by nagente";
$res_registros = mysql_query($sql_registros, $conexion40);
$reg_agentes = array();
while ($fila_empleados = @mysql_fetch_assoc($res_registros)) {
	array_push($reg_agentes, $fila_empleados);
}
?>
<table class="tablaform">
	<thead>
		<?php 
		if($tipoCon == 1){
			?>
			<tr>
				<th></th>
				<th></th>
				<th colspan="2">Nuevos</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
			<tr>
				<th>emp nro</th>
				<th>Nombre</th>
				<th>hoy</th>
				<th>otros</th>
				<th>totales</th>
				<th>agendados</th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
			<?php
		}elseif($tipoCon == 2){
			?>
			<tr>
				<th>emp nro</th>
				<th>nombre</th>
				<th>nuevos</th>
				<th>agendados</th>
				<th></th>
			</tr>
			<?php
		}
		?>
	</thead>
	<tbody>
		
		<?php
		foreach ($agentesCom as $fila_empleados) {
			$nru = 0;
			$nro_emp_act = 0;
			$agenteActual = "0";
			$nuevoshoy = "0";
			$nuevosotros = "0";
			$nuevostotales = "0";
			$agenda = "0";
			foreach ($fila_empleados as $key => $value) {
				if($nru == 0){
					$nro_emp_act = $value;
					$nru++;
				}
				$agenteActual = $value;
			}
			$pasop = 0;
			for ($q=0; $q < count($reg_agentes); $q++) {
				if($nro_emp_act == $reg_agentes[$q]["nagente"]){
					$pasop = 1;
					$nuevoshoy = $reg_agentes[$q]["nuevoshoy"];
					$nuevosotros = $reg_agentes[$q]["nuevosotros"];
					$nuevostotales = $reg_agentes[$q]["nuevostotales"];
					$agenda = $reg_agentes[$q]["agenda"];
				}
			}

			if($tipoCon == 1){
				?>
				<tr>
					<td><?php echo $nro_emp_act; ?></td>
					<td><?php echo $agenteActual; ?></td>
					<td><?php echo $nuevoshoy; ?></td>
					<td><?php echo $nuevosotros; ?></td>
					<td><?php echo $nuevostotales; ?></td>
					<td><?php echo $agenda; ?></td>
					<td><button>Asignar nuevos</button></td>
					<td><button>Asignar</button></td>
					<td><button>Desasignar</button></td>
				</tr>
				<?php
			}elseif($tipoCon == 2){
				if($nuevostotales != 0 || $agenda != 0){
					?>
					<tr>
						<td><?php echo $nro_emp_act; ?></td>
						<td><?php echo $agenteActual; ?></td>
						<td><?php echo $nuevostotales; ?></td>
						<td><?php echo $agenda; ?></td>
						<td><button onclick="desasignarBaja('<?php echo $nro_emp_act; ?>');">Desasignar Todos</button></td>
					</tr>
					<?php
				}
			}
		}


		mysql_close($conexion40);
		?>
	</tbody>
</table>