<?php 
	include "funciones.php";
	$_SESSION['campania_id_selected'] = $_REQUEST['campaniaid'];
	header("location: ../../marcador.php");
 ?>