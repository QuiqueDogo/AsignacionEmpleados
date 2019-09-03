<?php
$conexion_pdo= new pdo('mysql:dbname=marcador_manual;host=172.30.27.40:3306','root','4LC0M');
$conexion_pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
$sql_avance="SELECT
(SELECT emp_nombrecompleto FROM adcom.empleados WHERE emp_Nroemp=AgenteAlcom)AS AgenteAlcom,
SUM(IF(StatusAlcom='validado',1,IF(StatusAlcom='instalado',1,0)))AS Recuperado,
SUM(IF(StatusAlcom='cancelado',1,0))AS Cancelado,
SUM(IF(StatusAlcom='NO contesta',1,0)) AS NoContesta,
SUM(IF(StatusAlcom='Reagendado',1,0))AS Reagendado,
SUM(IF(StatusAlcom='no se encuentra tt',1,0)) AS Noseencuestra,
SUM(IF(StatusAlcom='Cerrada',1,0)) AS Cerrada,
SUM(IF(StatusAlcom='Seguimiento',1,0)) AS Seguimiento
FROM 
`marcador_manual`.`retro_cliente_2` GROUP BY AgenteAlcom

";
try{
	echo " 
	<table class='tablaform' id='tablaform2'>
	<thead>
	<tr>
	<th>Agente</th>
	<th>Seguimiento</th>
	<th>Recuperada</th>
	<th>Cancelado</th>
	<th>No Contesta</th>
	<th>Reagendado</th>
	<th>No se encuestra</th>
	<th>Cerrado</th>
	<th>Total</th>
	<tr>
	</thead>
	<tbody>
	";
	foreach ($conexion_pdo -> query($sql_avance) as $key => $arreglo_avance) {
		$contador = $key;
		$total = $arreglo_avance['Recuperado']+$arreglo_avance['Cancelado']+$arreglo_avance['NoContesta']+$arreglo_avance['Reagendado']+$arreglo_avance['Noseencuestra'];
		echo "<tr><td>".$arreglo_avance['AgenteAlcom']."</td>";
		echo "<td>".$arreglo_avance['Seguimiento']."</td>";
		echo "<td>".$arreglo_avance['Recuperado']."</td>";
		echo "<td>".$arreglo_avance['Cancelado']."</td>";
		echo "<td>".$arreglo_avance['NoContesta']."</td>";
		echo "<td>".$arreglo_avance['Reagendado']."</td>";
		echo "<td>".$arreglo_avance['Noseencuestra']."</td>";
		echo "<td>".$arreglo_avance['Cerrada']."</td>";
		echo "<td>".$total."</td></tr>";
	}
	if (isset($contador)) {
	}else{
		echo "<td>No Tienes Registros</td>";
		echo "<td>No Tienes Registros</td>";
	}
	echo "</tbody></table>";

}catch(PDOException $e){
	echo $sql_avance."<br>".$e;
}

$conexion_pdo = 0;
?>