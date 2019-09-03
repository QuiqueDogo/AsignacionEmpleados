<?php
include 'funciones.php';
$nroempleado = $_REQUEST['nroempleado'];
$tipoemp = $_REQUEST['tipoemp'];
$datos = array();
array_push($datos,$tipoemp,$nroempleado);
$SQL = "SELECT emp_Nroemp,concat(emp_Nroemp,' - ',emp_nombrecompleto) as nombres from adcom.empleados where emp_fchbaja is null and emp_jefe";

if ($tipoemp == "TICS") {
    $SQL .= " in (3505,2741,1679,2262,3064)";
}elseif($tipoemp != "TICS"){
    $SQL .= " ='{$nroempleado}'";
}

$querydatos = mysql_query($SQL,$conexion40);

while($empleados = mysql_fetch_assoc($querydatos)){
    $datos[] = [$empleados['emp_Nroemp'], $empleados['nombres']];
}

echo json_encode($datos);
?>