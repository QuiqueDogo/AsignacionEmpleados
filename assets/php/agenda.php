<?php 
include 'funciones.php';
$tipoagente = $_REQUEST['tipoagente'];
$nroempleado = $_REQUEST['nroempleado'];
$tipoemp = $_REQUEST['tipoemp'];
$SQL = "SELECT
a.id , a.foliocliente, a.telefono, a.contacto, b.emp_nombrecompleto, a.nagente, a.nsuper, a.ultimocomentario, a.fecha_reagenda
from marcador_manual.basecliente as a
inner join adcom.empleados as b on a.nagente = b.emp_Nroemp
where a.ultimoestatus = 'llamar mas tarde' and b.emp_fchbaja is"; 

if ($tipoagente == 'Alta' && $tipoemp != 'TICS') {
    $SQL .= " null and nsuper = '{$nroempleado}'";
}elseif($tipoagente == 'Alta' && $tipoemp == 'TICS'){
    $SQL .= " null";
}elseif ($tipoagente == 'Baja' && $tipoemp != 'TICS') {
    $SQL .= " not null and nsuper = '{$nroempleado}'";
}elseif($tipoagente == 'Baja' && $tipoemp == 'TICS'){
    $SQL .= " not null";
}

$querySQL = mysql_query($SQL,$conexion40);

while($Reagenda = mysql_fetch_assoc($querySQL)){
    $Agendados[] = [$Reagenda['id'], $Reagenda['foliocliente'], $Reagenda['telefono'], $Reagenda['contacto'], $Reagenda['emp_nombrecompleto'], $Reagenda['nagente'], $Reagenda['nsuper'], $Reagenda['ultimocomentario'], $Reagenda['fecha_reagenda'],'Asignar'];
}

mysql_close($conexion40);
echo json_encode($Agendados);

?>