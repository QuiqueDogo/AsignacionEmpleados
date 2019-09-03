<?php
include 'funciones.php';
$supervisor = $_REQUEST['supervisor'];
$campa = $_REQUEST["campania"];
  // contador nuevos
if($supervisor == "1980"){
	$req_disponibles = "SELECT COUNT(id) as contador FROM basecliente WHERE nagente = '3710' and ultimoestatus = 'nuevo' and idcampania = '22'";
} elseif($campa == 176){
	$req_disponibles = "SELECT COUNT(id) as contador FROM basecliente WHERE nagente = '4134' and ultimoestatus = 'nuevo' and idcampania = '176'";
} else if($campa == 22){
	$req_disponibles = "SELECT COUNT(id) as contador FROM basecliente WHERE nagente = '3710' and ultimoestatus = 'nuevo' and idcampania = '22'";
}
	$sql_disponibles = mysql_query($req_disponibles, $conexion40)or die(mysql_error());
	$res_disponibles = mysql_fetch_array($sql_disponibles);	


?>
<h3>Restantes en base: <span id="cantidad_registros1"><?php echo $res_disponibles['contador']; ?></span></h3>
<table class="tablaform" style="text-align: center;">
	<thead>
		<th>Agente</th>
		<th>Nombre</th>
		<th>Nuevos</th>
		<th></th>    
	</thead>
	<tbody>
		<?php
		$req_estatus = "SELECT emp_Nroemp, emp_nombrecompleto FROM adcom.empleados WHERE emp_jefe = '".$supervisor."' AND emp_fchbaja IS NULL and emp_Nroemp not in (1679,3505,2741,3064,2262) ;";
		$sql_estatus = mysql_query($req_estatus, $conexion40);
		while ($res_estatus = mysql_fetch_array($sql_estatus)) {
			?>
			<tr>
				<td class="agente"><?php echo $res_estatus[0]; ?></td>
				<td class="agente"><?php echo $res_estatus['emp_nombrecompleto']; ?></td>

				<?php
				$req_llamar = "SELECT count(id) FROM basecliente WHERE idcampania = '{$campa}' AND nagente = '".$res_estatus[0]."' AND ultimoestatus = 'Nuevo'  GROUP BY ultimoestatus";
				$sql_llamar = mysql_query($req_llamar, $conexion40);
				$res_llamar = mysql_fetch_array($sql_llamar);
				?>
				<td value = "<?php if($res_llamar[0] != null){echo $res_llamar[0];}else{echo 0;} ?>" class="nuevo"> <?php if (isset($res_llamar[0])) { echo $res_llamar[0]; } else { echo 0; } ?> </td>
				<td><button value ="<?php echo $res_estatus['emp_Nroemp'] ?>" class="nuevoooooos">Asignar</button></td>
				
			</tr>
			<?php
		}
		mysql_close($conexion40);
		?>
	</tbody>
</table>
