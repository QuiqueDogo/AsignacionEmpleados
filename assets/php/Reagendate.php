
<?php


include 'funciones.php';
$id           = "";
$foliocliente = "";
$nagente      = "";
$nsuper       = "";
$tipoEmp      = "";
$queryUP      = "";

$conexion40 = mysql_connect("172.30.27.40", "root", "4LC0M");

mysql_select_db("marcador_manual", $conexion40);

if ($_GET['foliocliente'] != "") {
    $foliocliente = $_GET['foliocliente'];
}
if ($_GET['id'] != "") {
    $id = $_GET['id'];
}
if ($_GET['nsuper'] != "") {
    $nsuper = $_GET['nsuper'];
}

$consulta  = 'select id, foliocliente, contacto, nagente, nsuper from marcador_manual.basecliente where foliocliente="' . $foliocliente . '";';
$consulta2 = 'select nsuper from marcador_manual.basecliente where foliocliente ="' . $foliocliente . '";';

$datos  = mysql_query($consulta, $conexion40) or die("Error al consultar");
$datos2 = mysql_query($consulta2, $conexion40) or die("Error al obtener super");

$datos_reporte = mysql_fetch_array($datos2);

$nsuper  = $datos_reporte['nsuper'];
$nagente = $datos_reporte['nagente'];

$consulta3 = 'select emp_Nroemp, emp_nombrecompleto from adcom.empleados where emp_fchbaja is null and emp_proyecto in (71,73) and emp_puesto = "1";';

$datos3 = mysql_query($consulta3, $conexion40) or die("Error al obtener agentes");

mysql_close($conexion40);
?>


<script>


       function pro(queryUP){
          $.ajax({
                 type: "GET",
                 url:"assets/php/ReagendaQuery.php?queryUP="+queryUP
                 ,
                 success: function(datos){
             $('#resp').html(datos);
             $('#cuerpo').css("display", "none");
         }
            });

        }


        function myFunction() {
            var x = document.getElementById("mySelect").value;
             $nagente = x;

             $idN = <?php echo $id ?>;
             $queryUP = 'update marcador_manual.basecliente set nagente = "'+$nagente+'" , ultimoestatus = "tomado" where id = "'+$idN+'" limit 1;';

             document.getElementById("demo").innerHTML = $queryUP;


            //alert("Actualizando");
            event.preventDefault();
            pro($queryUP);

        }

</script>
      <!-- modal para actualizar -->
    <dir id="cuerpo">
      <form name="procesareciclar"  method="GET" >

        <p>Folio Cliente: <input readonly name="foliocliente" value="<?php echo $foliocliente ?>"> </p>
        <br>
        <p>Id: <input readonly name="id" value="<?php echo $id ?>"> </p>
        <br>
        <p>Nsuper: <input  readonly name="nsuper" value="<?php echo $datos_reporte['nsuper'] ?>" ></p>
        <br>
        <p>Asignar al agente:
          <form class="form_line" method="post" >
        <select name="agente" id="mySelect" onchange="">
        <?php

mysql_pconnect($conexion40);

while ($datos_reporte2 = mysql_fetch_array($datos3)) {
    echo '<option value="' . $datos_reporte2['emp_Nroemp'] . '">' . $datos_reporte2['emp_Nroemp'] . "-" . $datos_reporte2['emp_nombrecompleto'] . '</option>';
}

mysql_close($conexion40);
?>
      </select>
      </form>
      </p>
      <br>
      <input type="button" onclick="myFunction()" name="reasignar" value="Reasignar">
      <br>
      <br>
      <p id="demo"></p>
      </form>
    </form>
    </dir>
    <div id="resp"></div>