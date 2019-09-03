<?php 
    date_default_timezone_set('America/Mexico_City');
    $months = "- ".$_POST['months'] . " month";    
    $dbhost = "172.30.27.40";
    $dbuser = "root";
    $dbpass = "4LC0M";
    $db = "marcador_manual";
    $conn = new mysqli($dbhost, $dbuser, $dbpass,$db) or die("Connect failed: %s\n". $conn -> error);

    /* CAMBIAR EL CONJUNTO DE CARATERES A UTF8 */
    if (!$conn->set_charset("utf8")) {
        exit();
    }

    $fecha_actual = date("Y-m-d");
    $date = date("Y-m-d",strtotime($fecha_actual.$months));

    $sql = "SELECT 
    a.lote as base,
    count(b.id) as total_ventas,
    (SELECT count(c.id) FROM marcador_manual.bases_lotes as c left join marcador_manual.basecliente as d on d.foliocliente = c.cuenta where d.ultimoestatus != 'venta' and c.lote = a.lote) AS total_registros
    from marcador_manual.bases_lotes as a
    INNER join marcador_manual.basecliente as b on a.cuenta = b.foliocliente
    where b.ultimoestatus = 'venta' and a.fecha_asignacion_toque_3 <= ('$date') and a.fecha_asignacion_toque_2 <= ('$date') and a.fecha_asignacion_toque_1 <= ('$date')  group by a.lote order by a.lote desc;
    ";
    
    $result = mysqli_query($conn, $sql);
    $registros = array();
    
    if (mysqli_num_rows($result) >= 0) {
                
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            array_push($registros, $row);
        }
    }
    mysqli_free_result($result);

    print_r(json_encode($registros));
    $conn -> close();
?>