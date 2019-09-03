
<?php 
include 'ConexionPDO.php';
$cuenta = $_REQUEST['id_cuenta'];
$sql_commenthistory = "
select 
comentario,
idempleado as fkempleado,
(select emp_nombrecompleto from adcom.empleados where emp_Nroemp=fkempleado)as empleado
from marcador_manual.comentarios 
where 
idregistro = '".$cuenta."'
order by fechahora;
";
try {
	?>
	<div class="comment" id="comment">
		<table>
			<thead>
				<th>Agente</th>
				<th>Comentario</th>
			</thead>
			<tbody>
				<?php
				foreach ($ConexionPDO -> query($sql_commenthistory) as $key => $arreglo) {
					?>
					<tr>
						<td><input type="text" disabled="" value="<?php echo $arreglo['empleado']?>"></td>
						<td><textarea name="" id="" style="resize: none;"><?php echo $arreglo['comentario']; ?></textarea></td>
					</tr>					
				</div>
				<?php
			}
			?>
		</tbody>
	</table>
	<?php
} catch (PDOException $e) {
	echo $e;
}
$ConexionPDO = 0;
?>