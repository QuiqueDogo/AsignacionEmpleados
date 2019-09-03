<?php
header('Content-Type: application/json');
$conexion40 = mysql_connect('172.30.27.40','root','4LC0M'); 

$empleado 	=	isset($_REQUEST['emp'])?$_REQUEST['emp'] : '';
$idregistro	=	isset($_REQUEST['folio'])?$_REQUEST['folio'] :'';

$SqlUpdateRow ="
UPDATE
marcador_manual.basecliente 
SET 
ultimoestatus ='tomado', nagente='{$empleado}' 
where 
id = '{$idregistro}'
and ultimoestatus not in(
'venta', 
'nuevo',
'tomado',
'llamar mas tarde') limit 1;
";
$ResultAsigna = mysql_query($SqlUpdateRow,$conexion40);

if (mysql_affected_rows($conexion40) == 1) {
	$result['msg'] = 'Asignacion Exitosa';
}else{
	$result['msg'] = 'El registro esta en un status que no puede modificarse (Venta, Nuevo, Tomado, Llamar mas tarde)';
}
mysql_close($conexion40);
echo json_encode($result);
?>