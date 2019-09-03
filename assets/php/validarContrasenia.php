<?php 
	header('Content-Type: application/json');
	include 'funciones.php';
	$contra_txt = $_REQUEST['contra_txt'];
	getNumeroValidacion($contra_txt);
 ?>