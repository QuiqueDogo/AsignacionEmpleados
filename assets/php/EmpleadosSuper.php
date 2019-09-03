<?php 
session_start();
$conexion40 = mysql_connect('172.30.27.40','root','4LC0M');
$idRegistro =$_REQUEST['idfolio'];
$sql_getEmpleados = "select emp_nombre,emp_Nroemp from adcom.empleados WHERE emp_jefe = '{$_SESSION['idEmpleado']}' and emp_fchbaja is null;";
$result_getempleado = mysql_query($sql_getEmpleados,$conexion40);
if (mysql_num_rows($result_getempleado) > 0) {
	?>
	<select name="Empleados" id="Empleados" required="">
		<option selected="" disabled="">Selecciona un agente</option>
		<?php 
		while ($arregloEmpleados = mysql_fetch_array($result_getempleado)) {
			?>
			<option value="<?php echo $arregloEmpleados['emp_Nroemp']; ?>"><?php echo $arregloEmpleados['emp_nombre']; ?></option>
			<?php
		}
		?>
	</select>
	<button data-idfolio="<?php echo $idRegistro; ?>" onClick="AsignaRegistro(this)">Asignar</button>
	<?php
}else{
	?>
	<h1>No se encontraron empleados a tu cargo, si crees que es un error Contacta con RH.</h1>
	<?php
}
mysql_close($conexion40);
AsignaRegistro
?>