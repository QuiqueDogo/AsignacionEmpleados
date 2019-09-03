<?php
include 'funciones.php';
$supervisor = $_REQUEST['supervisor'];
$campa = $_REQUEST["campania"];
  // contador nuevos
$req_disponibles = "SELECT COUNT(id) FROM basecliente WHERE nsuper = '".$supervisor."' AND nagente = '' and ultimoestatus = 'nuevo' and idcampania = '{$campa}'";
$sql_disponibles = mysql_query($req_disponibles, $conexion40)or die(mysql_error());
$res_disponibles = mysql_fetch_array($sql_disponibles);
  // contador para reciclar
$supervisorNormal = "!=";
if($supervisor == "2262"){
  $supervisorNormal = "=";
}
$sql_conte = "select count(id) as conteo from marcador_manual.basecliente where idcampania = {$campa} AND ultimoestatus = 'No contesta' AND nsuper {$supervisorNormal} '".$supervisor. "' AND date_format(fecha_carga,'%Y-%m-%d') BETWEEN '2017-11-01' AND CURDATE()";
$res_conte = mysql_query($sql_conte, $conexion40)or die(mysql_error());
$fila_conte = mysql_fetch_array($res_conte);
// contador de revalidados
$sql_conteR = "select count(id) as conteo from marcador_manual.basecliente WHERE idcampania = {$campa} AND ultimoestatus = 'reciclado' and nagente = '1'";
$res_conteR = mysql_query($sql_conteR, $conexion40);
$fila_conteR = mysql_fetch_array($res_conteR);

?>
<h3>Registros revalidados: <span id="cantidad_registros1"><?php echo $fila_conteR[0]; ?></span></h3>
<h3>Registros para reciclar: <span id="cantidad_registros2"><?php echo $fila_conte[0]; ?></span></h3>
<h3>Registros para asignar: <span id="cantidad_registros3"><?php echo $res_disponibles[0]; ?></span></h3>

<table class="tablaform">
  <thead>
    <th>Agente</th>
    <th>Nombre</th>
    <th>Nuevos</th>
    <th>Modificar registros</th>
  </thead>
  <tbody>
    <?php
    // $req_estatus = "SELECT nagente FROM basecliente WHERE nsuper =  AND nagente != '' GROUP BY nagente ORDER BY nagente ASC";
    $req_estatus = "SELECT emp_Nroemp FROM adcom.empleados WHERE emp_jefe = '".$supervisor."' AND emp_fchbaja IS NULL;";
    $sql_estatus = mysql_query($req_estatus, $conexion40);
    while ($res_estatus = mysql_fetch_array($sql_estatus)) {
      $req_agente = "SELECT emp_nombrecompleto FROM adcom.empleados WHERE emp_Nroemp = '".$res_estatus[0]."'";
      $sql_agente = mysql_query($req_agente, $conexion40);
      $res_agente = mysql_fetch_array($sql_agente);
      ?>
      <tr>
        <td class="agente"><?php echo $res_estatus[0]; ?></td>
        <td class="agente"><?php echo $res_agente['emp_nombrecompleto']; ?></td>

        <?php
        $req_llamar = "SELECT count(id) FROM basecliente WHERE idcampania = '{$campa}' AND nagente = '".$res_estatus[0]."' AND ultimoestatus = 'Nuevo' AND idcampania = '{$campa}' GROUP BY ultimoestatus";
        $sql_llamar = mysql_query($req_llamar, $conexion40);
        $res_llamar = mysql_fetch_array($sql_llamar);
        ?>
        <td class="nuevo"> <?php if (isset($res_llamar[0])) { echo $res_llamar[0]; } else { echo 0; } ?> </td>
        <td>
          <div class="botones">
            <button class="asignarrevalidados" style="background: red;">Asignar revalidados</button>
            <button class="recicla">Asigna nuevos Registros</button>
            <button class="asignar">Asignar</button>
            <button class="desasigna">desasignar</button>
          </div>
        </td>
      </tr>
      <?php
    }
    mysql_close($conexion40);
    ?>
  </tbody>
</table>
