<?php 
$folio = $_REQUEST['folio'];
$conexion40 = mysql_connect('172.30.27.40','root','4LC0M');
$SqlGetVentas ="select COUNT(id)as total from marcador_manual.marcaciones where idbasecliente ='{$folio}' and status ='Venta'";
$ResultGetVentas = mysql_query($SqlGetVentas,$conexion40)or die(mysql_close());

$arreglo = mysql_fetch_array($ResultGetVentas);

if ($arreglo['total']>=1) {
	$mensaje ='Registro en venta';
}else{
	$mensaje ='Registro disponible';
}
mysql_close($conexion40);
echo $mensaje;
?>