<?php 
include 'conexionPDO.php';
$campo_buscar = $_REQUEST['campos'];
$sql_validacion ="
SELECT 
foliocliente as folio,
telefono,
contacto,
nagente,
nsuper,
ultimoestatus,
ultimocomentario,
count(*)as total 
from marcador_manual.basecliente
where idcampania = 22 and foliocliente like '%".$campo_buscar."%' or contacto like '%".$campo_buscar."%' or telefono like '%".$campo_buscar."%' group by foliocliente limit 20; 
";
?>
<table class="tablaform"> 
	<thead>
		<th>folio</th>
		<th>telefono</th>
		<th>contacto</th>
		<th>nagente</th>
		<th>nsuper</th>
		<th>ultimoestatus</th>
		<th>ultimocomentario</th>
	</thead>
	<tbody>
		<?php 
		try {
			foreach ($ConexionPDO -> query($sql_validacion) as $key => $arreglo_cosnt) {
				?>
				<tr>
					<td><?php  echo $arreglo_cosnt['folio']; ?></td>
					<td><?php  echo $arreglo_cosnt['telefono']; ?></td>
					<td><?php  echo $arreglo_cosnt['contacto']; ?></td>
					<td><?php  echo $arreglo_cosnt['nagente']; ?></td>
					<td><?php  echo $arreglo_cosnt['nsuper']; ?></td>
					<td><?php  echo $arreglo_cosnt['ultimoestatus']; ?></td>
					<td><?php  echo $arreglo_cosnt['ultimocomentario']; ?></td>
				</tr>
				<?php
			}
		} catch (PDOException $e) {
			echo $sql_validacion." ".$e;
		}
		$ConexionPDO = 0;
		?>
	</tbody>
</table>