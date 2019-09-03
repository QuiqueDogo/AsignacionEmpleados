<?php 
include "funciones.php";
$superPOP = $_REQUEST["superP"];
$idcampania = $_REQUEST["campaniaid"];
$tipoCon = $_REQUEST["tipoCon"];
$sql_traerdatos = "";
if($tipoCon == "1"){
	$sql_traerdatos = "SELECT 

	a.nagente as 'nro emp',
	b.emp_nombrecompleto as 'nombre del agente', 
	SUM(IF(a.ultimoestatus = 'nuevo' and date_format(a.fecha_carga, '%Y-%m-%d') = curdate(),1,0)) AS 'hoy', 
	SUM(IF(a.ultimoestatus = 'nuevo' and date_format(a.fecha_carga, '%Y-%m-%d') != curdate(),1,0)) AS 'otros', 
	SUM(IF(a.ultimoestatus = 'llamar mas tarde',1,0)) AS 'agendado', 
	COUNT(a.id) AS totales

	FROM marcador_manual.basecliente a inner join adcom.empleados b on a.nagente = b.emp_Nroemp
	WHERE a.nsuper = '{$superPOP}' AND a.idcampania = '{$idcampania}' AND a.ultimoestatus IN ('nuevo', 'llamar mas tarde') AND a.nagente != ''
	GROUP BY a.nagente";
}elseif($tipoCon == "2"){
	$sql_agentes = "select emp_Nroemp, emp_nombrecompleto from adcom.empleados where emp_jefe = '{$superPOP}' and emp_fchbaja is not null";
	$res_agentes = mysql_query($sql_agentes, $conexion40);
	$agentesArr1 = array();
	$agentesArr2 = array();
	while ($fila_traeragentes = @mysql_fetch_assoc($res_agentes)) {
		array_push($agentesArr1, $fila_traeragentes["emp_Nroemp"]);
		array_push($agentesArr2, $fila_traeragentes["emp_nombrecompleto"]);
	}
	$agentesPop = implode(",", $agentesArr1);

	$sql_traerdatos = "SELECT 

	a.nagente as 'nro emp',
	b.emp_nombrecompleto as 'nombre del agente', 
	SUM(IF(a.ultimoestatus = 'nuevo' and date_format(a.fecha_carga, '%Y-%m-%d') = curdate(),1,0)) AS 'hoy', 
	SUM(IF(a.ultimoestatus = 'nuevo' and date_format(a.fecha_carga, '%Y-%m-%d') != curdate(),1,0)) AS 'otros', 
	SUM(IF(a.ultimoestatus = 'llamar mas tarde',1,0)) AS 'agendado', 
	COUNT(a.id) AS totales

	FROM marcador_manual.basecliente a inner join adcom.empleados b on a.nagente = b.emp_Nroemp
	WHERE a.nagente in ({$agentesPop}) AND a.idcampania = '{$idcampania}' AND a.ultimoestatus IN ('nuevo', 'llamar mas tarde') AND a.nagente != ''
	GROUP BY a.nagente";
}

$res_sql = mysql_query($sql_traerdatos, $conexion40);
$conta = 0;

if($conta == 0){
	?>
	<table class="tablaform">
		<thead>
			<tr>
				<th></th>
				<th></th>
				<th colspan="2">nuevos</th>
				<th></th>
				<th></th>
				<th colspan="3"></th>
			</tr>
			<tr>
				<th></th>
				<th></th>
				<th>Hoy</th>
				<th>Otros</th>
				<th>Agendado</th>
				<th>Total</th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
		}


		while ($fila_traerdatos = @mysql_fetch_assoc($res_sql)) {
			?>
			<tr>
				<?php 
				foreach ($fila_traerdatos as $key => $value) {
					?>
					<td><?php echo $value; ?></td>
					<?php
				}	
				?>
				<td><button>Asignar nuevos</button></td>
				<td><button>Asignar reciclados</button></td>
				<td><button>Desasignar</button></td>
			</tr>
			<?php
			$conta++;
		}

		if($conta == 0){
			for($kk = 0; $kk < count($agentesArr1); $kk++) {
				?>
				<tr>
					<td><?php echo $agentesArr1[$kk]; ?></td>
					<td><?php echo $agentesArr2[$kk]; ?></td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td>0</td>
					<td><button>Asignar nuevos</button></td>
					<td><button>Asignar reciclados</button></td>
					<td><button>Desasignar</button></td>
				</tr>
				<?php
				$conta++;
			}			
		}

		if($conta != 0){
			?>
		</tbody>
	</table>
	<?php
}else{
	?>
	<h3>No se encontraron registros</h3>
	<?php
}
mysql_close($conexion40);

?>