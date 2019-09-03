<?php
$archivo = $_FILES['base_txt'];
$nombre_temporal = $archivo['tmp_name'];
$csv = array();
$lineas =
file($nombre_temporal, FILE_IGNORE_NEW_LINES);
foreach ($lineas as $key => $value) {
    $csv[$key] = str_getcsv(utf8_encode($value));
}
$conteo = count($csv);
$sql_retro ="INSERT INTO `marcador_manual`.`retro_cliente_2` 
(
    `cuenta`, 
    `foliossalesforce`, 
    `accion`, 
    `fechadeagendamiento`, 
    `turno`,
    fechadeapicacion, 
    `comentariosBo`, 
    `Estado`, 
    `nuevoestadoactualizado`, 
    `fechadecierre`, 
    `plannuevo`, 
    `plannuevohomologado`, 
    `precioplanactual`, 
    `precioplannuevo`, 
    `margenpaquete`, 
    `resumenaddons`, 
    `creceloa100megas`, 
    `creceloa20megas`, 
    `creceloa50megas`, 
    `creceloa30megas`, 
    `creceloa200megas`, 
    `creceloa300megas`, 
    `creceloa500megas`, 
    `addonwifiextender`, 
    `lineatelefononicaadicional`, 
    `paquetehbohdmaxhd`, 
    `paquetefox+`, 
    `addongamefly`, 
    `televisionadicional`, 
    `margenaddon`, 
    `margencrecimiento`, 
    `tipomovimiento`, 
    `FechaRetroAlcom`
    )
    VALUES";
    foreach ($csv as $key => $value) {
        $fecha1 =explode('/',$value[23]);
        $fecha2 =explode('/',$value[25]);
        $fecha3 =explode('/',$value[29]);
        $fecha4 =explode('/',$value[52]);
        if (count($fecha1)==3) {
            $formato1= $fecha1[2]."-".$fecha1[1]."-".$fecha1[0];
        }else{
            $formato1='';
        }
        if (count($fecha2)==3) {
            $formato2= $fecha2[2]."-".$fecha2[1]."-".$fecha2[0];
        }else{
            $formato2='';
        }
        if (count($fecha3)==3) {
            $formato3= $fecha3[2]."-".$fecha3[1]."-".$fecha3[0];
        }else{
            $formato3='';
        }
        if (count($fecha4)==3) {
            $formato4= $fecha4[2]."-".$fecha4[1]."-".$fecha4[0];
        }else{
            $formato4='';
        }

        
        if ($key >=1) {
            if ($key === $conteo-1) { 
                $sql_retro .= "(
                    '$value[0]','$value[21]','$value[22]','$formato1','$value[24]','$formato2','$value[26]','$value[27]','$value[28]','$formato3','$value[30]','$value[31]','$value[32]','$value[33]','$value[34]','$value[35]','$value[36]','$value[37]','$value[38]','$value[39]','$value[40]','$value[41]','$value[42]','$value[43]','$value[44]','$value[45]','$value[46]','$value[47]','$value[48]','$value[49]','$value[50]','$value[51]','$formato4')";
                }else{
                    $sql_retro .="('$value[0]','$value[21]','$value[22]','$formato1','$value[24]','$formato2','$value[26]','$value[27]','$value[28]','$formato3','$value[30]','$value[31]','$value[32]','$value[33]','$value[34]','$value[35]','$value[36]','$value[37]','$value[38]','$value[39]','$value[40]','$value[41]','$value[42]','$value[43]','$value[44]','$value[45]','$value[46]','$value[47]','$value[48]','$value[49]','$value[50]','$value[51]','$formato4'),";   
                }
            }
        }
        $conexion40 = mysql_connect('172.30.27.40','root','4LC0M');
        $result_retro =mysql_query($sql_retro,$conexion40)or die(mysql_error());
        if ($result_retro) {
            echo "Insercion Exitosa";
        }
        mysql_close($conexion40);
        ?>