<?php 
include "funciones.php";
$fecha1 = $_REQUEST["fecha1"];
$fecha2 = $_REQUEST["fecha2"];
$idcampania = $_REQUEST["idcamp"];





$sql_traerdatos = "
select
ultimoestatus,
count(*) as conteo
from
marcador_manual.basecliente
where
idcampania = '{$idcampania}'
and date_format(fecha_carga, '%Y-%m-%d') between '{$fecha1}' and '{$fecha2}'
and ultimoestatus not in(
'nuevo',
'tomado',
'llamar mas tarde', 
'venta',
'Agente_Recuperacion'
)
group by
ultimoestatus
order by
count(*) desc";

$res_sql = mysql_query($sql_traerdatos, $conexion40);
$conta = 0;

while ($fila_traerdatos = mysql_fetch_assoc($res_sql)) {
	if($conta == 0){
		?>
		<table class="tablaform">
			<thead>
				<tr>
					<th>Estatus</th>
					<th>Conteo</th>
					<th>Reciclar</th>
				</tr>
			</thead>
			<tbody>
				<?php
			}
			?>
			<tr>
				<td><?php echo $fila_traerdatos["ultimoestatus"]; ?></td>
				<td><?php echo $fila_traerdatos["conteo"]; ?></td>
				<td><button>Reciclar</button></td>
			</tr>
			<?php
			$conta++;
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