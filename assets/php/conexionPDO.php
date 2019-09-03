<?php 
$ConexionPDO = new pdo('mysql:dbname=marcador_manual;host=172.30.27.40','root','4LC0M');
$ConexionPDO -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 

$ConexionPDO2 = new pdo('mysql:dbname=marcador_manual;host=172.30.27.40','root','4LC0M');
$ConexionPDO2 -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
?>