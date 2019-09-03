<?php 
include 'funciones.php';
$agente = $_REQUEST['agente'];
$supervisor = $_REQUEST['supervisor'];

if ($supervisor == "1980") {
	$consultaRegistros = "UPDATE marcador_manual.basecliente SET nagente = '{$agente}', nsuper = '{$supervisor}' WHERE nagente = '3710' and ultimoestatus = 'nuevo' and idcampania = '22' limit 35;";
} elseif ($supervisor == "3505" || $supervisor == "1679" || $supervisor == "2741" || $supervisor == "3064") {
	if ($agente == "3657") {
	$consultaRegistros = "UPDATE marcador_manual.basecliente SET nagente = '{$agente}', nsuper = '{$supervisor}' WHERE nagente = '4134' and ultimoestatus = 'nuevo' and idcampania = '176' limit 25;";
		}else{	
	$consultaRegistros = "UPDATE marcador_manual.basecliente SET nagente = '{$agente}', nsuper = '{$supervisor}' WHERE nagente = '3710' and ultimoestatus = 'nuevo' and idcampania = '22' limit 35;";
		}
}elseif ($supervisor == "2262" || $supervisor == "3064") {
	$consultaRegistros = "UPDATE marcador_manual.basecliente SET nagente = '{$agente}', nsuper = '{$supervisor}' WHERE nagente = '4134' and ultimoestatus = 'nuevo' and idcampania = '176' limit 25;";
}elseif ($supervisor == "3902") {
	if ($agente == "3659" || $agente == "3938") {
	$consultaRegistros = "UPDATE marcador_manual.basecliente SET nagente = '{$agente}', nsuper = '{$supervisor}' WHERE nagente = '4134' and ultimoestatus = 'nuevo' and idcampania = '176' limit 25;";
	}else{
	$consultaRegistros = "UPDATE marcador_manual.basecliente SET nagente = '{$agente}', nsuper = '{$supervisor}' WHERE nagente = '3710' and ultimoestatus = 'nuevo' and idcampania = '22' limit 35;";
		
	}
}


// echo $agente."<br>";
// echo $supervisor."<br>";
// echo $consultaRegistros."<br>";

if ($sql = mysql_query($consultaRegistros, $conexion40)or die(mysql_error())) {
    echo "Ya hay registros amigooooo";
  } else {
    echo "Hubo un error al asignar los registros";
  }
  mysql_close($conexion40);



?> 
