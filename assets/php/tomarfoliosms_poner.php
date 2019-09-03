<?php 
if(isset($_REQUEST["idfolio"])){
	$conexion40 = mysql_connect('172.30.27.40','root','4LC0M');
	session_start();
	$idfolio = $_REQUEST["idfolio"];
	$empleado = $_SESSION['idEmpleado'];
	$sql_tomar = "
	UPDATE marcador_manual.basecliente set 
	ultimoestatus ='tomado',
	idcampania = '22',
	nagente ='{$empleado}'
	where id ='{$idfolio}'
	and idcampania = 215
	limit 1
	;";
	$result = mysql_query($sql_tomar,$conexion40)or die(mysql_error());
	
	if($result){
		echo "Exitoso";
	}else{
		echo "Error".$result;
	}
	mysql_close($conexion40);
}
?>