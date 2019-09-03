<?php 
require 'conexionPDO.php';

$sql_marcacion_last =
"SELECT 
a.id,
a.foliocliente,
a.telefono,
a.contacto,
a.nagente,
a.nsuper,
a.idcampania,
(select dt from marcador_manual.marcaciones where id = max(b.id)) AS fecha,
(select status from marcador_manual.marcaciones where id =max(b.id)) AS status
from 
marcador_manual.basecliente a
inner join
marcador_manual.marcaciones b on  a.id = b.idbasecliente";
if (isset($_REQUEST['fecha'])) {
$sql_marcacion_last .="  WHERE date_format(b.dt,'%Y-%m-%d') = '".$_REQUEST['fecha']."' and a.idcampania = 178";
}else{
$sql_marcacion_last .=" where a.idcampania = 178 ";
}
$sql_marcacion_last .=" group by a.id
order by a.id;
";try {
	foreach ($ConexionPDO -> query($sql_marcacion_last) as $key => $arreglo_marcacion) {
		echo $arreglo_marcacion['foliocliente'];
	}
} catch (PDOException $e2) {
	echo $sql_marcacion_last."".$e2;	
}
$conexionPDO =0;
?>