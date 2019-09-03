<?php

$conexionpdo = new pdo('mysql:dbname=marcador_manual;host=172.30.27.40:3306','root','4LC0M');
$conexionpdo -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql ="UPDATE `marcador_manual`.`retro_cliente_2` SET ComentariosAlcom = :comentarios,StatusAlcom = :status ,AgenteAlcom = :agente , FechaAlcom =NOW(),
FechaAgendaAlcom = :fecha, Turno_Recuperacion = :turno
where id_retro=:id";
try{
	$stmt = $conexionpdo -> prepare($sql);
	$stmt -> bindParam(':comentarios',$_REQUEST['comentarios'],PDO::PARAM_STR);
	$stmt -> bindParam(':status',$_REQUEST['status'], PDO::PARAM_STR);
	$stmt -> bindParam(':id',$_REQUEST['id_registro'], PDO::PARAM_INT);
	$stmt -> bindParam(':agente', $_REQUEST['agente'], PDO::PARAM_INT);
	$stmt -> bindParam(':fecha', $_REQUEST['fecha'], PDO::PARAM_STR);
	$stmt -> bindParam(':turno', $_REQUEST['turno'],PDO::PARAM_STR);
	$stmt -> execute();
	echo "Se han guardado tus Comentarios";
}catch(PDOException $e){
	echo $sql."<br>".$e;
}
$conexionpdo = 0;
?>