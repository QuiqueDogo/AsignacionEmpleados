<?php 
include "funciones.php";
$status = $_REQUEST["statusareciclar"];
$cade = "";
$msg = "";
if(count($status) == "0"){
	$msg = "Tienes que escoger al menos un estatus";
}else{
	for ($i=0; $i < count($status); $i++) {
		$cade .= "'".$status[$i]."'";
		if(($i+1) != count($status)){
			$cade .= ",";
		}
	}

	// $sqlagentes = "SELECT nagente FROM basecliente WHERE ultimoestatus IN ({$cade}) GROUP BY nagente";
	// $respp = mysql_query($sqlupdate, $conexion40);
	// $agenteaas = "";
	// $j = 0;
	// $filasq = mysql_num_rows($respp);
	// while ($filaf = mysql_fetch_array($respp)) {
	// 	$agenteaas .= $filaf;
	// 	if(($j+1) != $filasq){
	// 		$agenteaas .= ", ";
	// 	}	
	// }
	// echo $agenteaas;

	$sqlupdate = "UPDATE marcador_manual.basecliente SET ultimoestatus = 'Nuevo', fecha_reagenda = null WHERE ultimoestatus IN ({$cade})";
	mysql_query($sqlupdate, $conexion40);
	$msg = "Listo :)";
}
header("location: ../../reciclarBase.php?msg={$msg}");
?>