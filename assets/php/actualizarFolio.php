<?php 
include "funciones.php";
$idcaptura = $_REQUEST["idcaptura"];
$foliosalesforce = $_REQUEST["foliosalesforce"];
$fecha = isset($_REQUEST["fecha"])? $_REQUEST["fecha"] : date('Y-m-d');
$status_folio = isset($_REQUEST["status_folio"])? $_REQUEST["status_folio"] : '';
$sql_updateFoliosSales = "update marcador_manual.basecliente set FoliosSalesForce = '{$foliosalesforce}',
Statusfoliosalesforce ='{$status_folio}',
FechaSeguimientoBo = '{$fecha}'
where id = '{$idcaptura}'";
if(mysql_query($sql_updateFoliosSales, $conexion40)){
	echo "1";
}else{
	echo mysql_error();	
}
?>
