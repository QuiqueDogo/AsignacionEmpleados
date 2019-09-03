<?php
include './funciones.php';
$idbasecliente = $_REQUEST['idbasecliente'];
$ultimoestatus = $_REQUEST['estatus'];
$agente        = $_REQUEST['agente'];
$supervisor    = $_REQUEST['supervisor'];
$estatusVenta  = 0;
$idEmpleado    = $_SESSION['idEmpleado'];

if ($ultimoestatus == "Venta") { 
    $estatusVenta = 1; 
}
$sql_basecliente = "UPDATE marcador_manual.basecliente SET ultimoestatus = '{$ultimoestatus}' WHERE id = {$idbasecliente}";

$sql_marcaciones = 
"INSERT INTO
marcador_manual.marcaciones(
idbasecliente,
agente,
supervisor,
status,
venta,
habloconeltitular
)
VALUES(
'{$idbasecliente}',
'{$agente}',
'{$supervisor}',
'{$ultimoestatus}',
'{$estatusVenta}',
'Si'
)";

$sql_validador = "UPDATE marcador_manual.campos_adicionales SET valor_campo = {$idEmpleado} WHERE idfolio_externo = '{$idbasecliente}' AND nombre_campo = 'Validador' AND valor_campo = 1000";
$sql_fecha_instalacion = "UPDATE marcador_manual.campos_adicionales SET valor_campo = '{$_REQUEST["fecha_instalacion_txt"]}' WHERE idfolio_externo = '{$idbasecliente}' AND  nombre_campo = 'fecha_instalacion'";

    mysql_query($sql_basecliente, $conexion40)or die(mysql_error());
    mysql_query($sql_marcaciones, $conexion40)or die(mysql_error());
    mysql_query($sql_validador, $conexion40)or die(mysql_error());
    mysql_query($sql_fecha_instalacion, $conexion40)or die(mysql_error());
    header('Location: http://172.30.27.57:8080/sialcom/system/marcadormanual/validaciones.php');
?>