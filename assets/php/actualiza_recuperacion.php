<?php 
include 'conexionPDO.php';
$status_retro ='Recuperacion_Agente';
$sql_update_retro ="
UPDATE
marcador_manual.retro_cliente_2 
set
StatusAlcom= :statusAlcom
where
cuenta= :cuenta ;";

$sql_update_basecliente = "
UPDATE 
marcador_manual.basecliente 
set ultimoestatus = :ultimoestatus
where id =:id;"; 


try {
	$pre_sql = $ConexionPDO -> prepare($sql_update_retro);
	$pre_sql -> bindParam(':statusAlcom',$status_retro,PDO::PARAM_STR);
	$pre_sql -> bindParam(':cuenta',$_REQUEST['folio_cuenta'],PDO::PARAM_INT);
	$pre_sql -> execute();	
	echo "Actualizacion exitosa";	
} catch (PDOException $e) {
	echo $sql_update_retro."<br>".$e;
}


try {
	$presql2 = $ConexionPDO -> prepare($sql_update_basecliente);
	$presql2 -> bindParam(':ultimoestatus',$status_retro,PDO::PARAM_STR);
	$presql2 -> bindParam(':id',$_REQUEST['idcuenta'],PDO::PARAM_INT);
	$presql2 -> execute();
	echo "basecliente upd";
} catch (PDOException $e2) {
	echo $sql_update_basecliente."".$e2;
}
$ConexionPDO =0;
?>