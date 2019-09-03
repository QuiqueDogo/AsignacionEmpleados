<?php
$conexion_pdo= new pdo('mysql:dbname=marcador_manual;host=172.30.27.40:3306','root','4LC0M');
$conexion_pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
$sql_avance="SELECT
COUNT(*) as total,
StatusAlcom
FROM 
`marcador_manual`.`retro_cliente_2` 
WHERE DATE_FORMAT(FechaAlcom,'%Y-%m-%d')
= CURDATE() AND  AgenteAlcom ='$_REQUEST[IdEmpleado]'
GROUP BY(StatusAlcom)
";
try{
	echo "<table class='tablaform'>
	<thead>
	<tr>
	<th>Cantidad</th>
	<th>Status</th>
	<tr>
	</thead>
	<tbody>
	";
	foreach ($conexion_pdo -> query($sql_avance) as $key => $arreglo_avance) {
		$contador = $key;
		echo "<tr><td>".$arreglo_avance['total']."</td>";
		echo "<td><button data-agente='$_REQUEST[IdEmpleado]' data-status='$arreglo_avance[StatusAlcom]' onclick='changeData_query(this)'>".$arreglo_avance['StatusAlcom']."</button></td></tr>";
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