<?php

include 'funciones.php';
$consulta  = "";

$conexion40 = mysql_connect("172.30.27.40", "root", "4LC0M");

mysql_select_db("marcador_manual", $conexion40);

if ($_GET['consulta'] != "") {
    $consulta = $_GET['consulta'];
}


mysql_query($consulta, $conexion40) or die("error al bloquear");

//echo "Actualizacion Exitosa";

mysql_close($conexion40);

?>
<script>

var c2 = <?php echo $consulta ?>;
alert(c2);
</script>
