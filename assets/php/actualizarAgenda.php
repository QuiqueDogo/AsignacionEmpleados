<?php
include 'funciones.php';
$id = $_REQUEST['idModal'];
$folio = $_REQUEST['folioModal'];
$super = $_REQUEST['superModal'];
$agente = $_REQUEST['agenteModal'];
$confirmacion = '';

if($id == '' || $folio == '' || $super == '' || $agente == ''){
    $confirmacion = "NO";
}else{
    $SQL = "UPDATE marcador_manual.basecliente SET ultimoestatus = 'tomado', nagente = '{$agente}', nsuper = '{$super}' where id = '{$id}' ";
    mysql_query($SQL,$conexion40);
    $confirmacion = "SI";
    
}

mysql_close($conexion40);
echo json_encode($confirmacion);
?>