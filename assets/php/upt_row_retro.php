<?php 
include 'ConexionPDO.php';

$sql_updt ="
UPDATE
marcador_manual.basecliente set 
FoliosSalesForce = :FoliosSalesForce,
Statusfoliosalesforce = :Statusfoliosalesforce
where 
id=:ids
";
try {
	$sql_prep = $ConexionPDO -> prepare($sql_updt);
	$sql_prep -> bindParam(":FoliosSalesForce",$_REQUEST['FoliosSalesForce'],PDO::PARAM_INT);
	$sql_prep -> bindParam(":Statusfoliosalesforce",$_REQUEST['Statusfoliosalesforce'],PDO::PARAM_STR);
	$sql_prep -> bindParam(":ids",$_REQUEST['ids'],PDO::PARAM_INT);
	$sql_prep -> execute();
	echo "Actualizacion exitosa";	
} catch (PDOException $e) {
	echo $sql_updt."<br>".$e;
}
$ConexionPDO = 0;

?>