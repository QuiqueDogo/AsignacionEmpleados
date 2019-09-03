<?php
include "funciones.php";
$idregistor = $_REQUEST['idcaptura'];

$sqldd = "SELECT a.nombre_campo, b.nombrecampo, a.valor_campo FROM marcador_manual.campos_adicionales a  LEFT JOIN campos_requeridos b ON a.valor_campo = b.id WHERE a.idfolio_externo = '{$idregistor}' and a.nombre_campo not in ('adicional_numero_whatsapp', 'adicional_nombre_decisor') and valor_campo != ''";
$query = mysql_query($sqldd, $conexion40);
?>
<table class="tablaform">
	<?php
	$ic = 0;

	$sql_kh = "select valor_campo from marcador_manual.campos_adicionales where idfolio_externo = (select foliocliente from marcador_manual.basecliente where id = '{$idregistor}') and nombre_campo = 'plan actual'";
	$reo = mysql_query($sql_kh, $conexion40);
	$filka = mysql_fetch_array($reo);
	$fecha_instalacion_agente = "";

	while ($fila = mysql_fetch_assoc($query)) {
		if($ic == 0){
			?>
			<thead>
				<tr>
					<th>Tipo</th>
					<th>Detalle</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Plan Actual</td>
					<td><?php echo $filka["valor_campo"]; ?></td>
				</tr>
				<?php
				$ic = 1;
			}
			?>
			<tr>
				<?php
				switch ($fila['nombre_campo']) {
					case 'oferta_realizada':
					?>
					<td>Oferta Realizada</td>
					<td>
						<?php
						if($fila['valor_campo'] == 0){
							echo $filka["valor_campo"];
						}else{
							echo $fila['nombrecampo'];
						}
						?>
					</td>
					<?php
					break;
					case 'fecha_instalacion':
					?>
					<td>Fecha Instalación</td>
					<td>
						<?php echo $fecha_instalacion_agente = $fila['valor_campo']; ?>
					</td>
					<?php
					break;
					case 'modulos_tv':
					?>
					<td>Modulos de TV</td>
					<td>
						<?php
						$numerosvalidos = array(29,35,36,37,38,39,40,41,42,43,44,45,46,47,154,288,289,290);
						if(in_array($fila['valor_campo'], $numerosvalidos)){
							echo $fila['nombrecampo'];
						}else{
							echo $fila['valor_campo'];
						}
						?>
					</td>
					<?php
					break;
					case 'adicional_paqueteTelevision':
					?>
					<td>Paquete de TV</td>
					<td>
						<?php
						$numerosvalidos = array(288,289,290);
						if(in_array($fila['valor_campo'], $numerosvalidos)){
							echo $fila['nombrecampo'];
						}else{
							echo $fila['valor_campo'];
						}
						?>
					</td>
					<?php
					break;
					case 'internet_crecelo':
					?>
					<td>Internet Crecelo</td>
					<td><?php echo $fila['nombrecampo']; ?></td>
					<?php
					break;
					case 'adicional_horario_instalacion':
					if($fila['nombrecampo'] != ""){
						?>
						<td>Horario de instalacion</td>
						<td><?php echo $fila['nombrecampo']; ?></td>
						<?php
					}
					break;
					case 'wifi_extender':
					?>
					<td>Wifi Extender</td>
					<td><?php echo $fila['valor_campo']; ?></td>
					<?php
					break;
					case 'servicio_tv_4k':
					?>
					<td>Servicio de TV 4K</td>
					<td><?php echo $fila['valor_campo']; ?></td>
					<?php
					break;
					case 'servicio_tv_adicional':
					?>
					<td>Servicio de TV Adicional</td>
					<td><?php echo $fila['valor_campo']; ?></td>
					<?php
					break;
					case 'gamefly_plan':
					?>
					<td>Plan de Gamefly</td>
					<td><?php echo $fila['nombrecampo']; ?></td>
					<?php
					break;
					case 'gamepad':
					?>
					<td>Gamepads</td>
					<td><?php echo $fila['valor_campo']; ?></td>
					<?php
					break;
					case '49':
					?>
					<td>Linea adicional</td>
					<td><?php echo $fila['valor_campo']; ?></td>
					<?php
					break;
					case '184':
					?>
					<td>Linea adicional</td>
					<td><?php echo $fila['valor_campo']; ?></td>
					<?php
					break;
					case '50':
					?>
					<td>Extension telefonica</td>
					<td><?php echo $fila['valor_campo']; ?></td>
					<?php
					break;
					case '185':
					?>
					<td>Extension telefonica</td>
					<td><?php echo $fila['valor_campo']; ?></td>
					<?php
					break;
					case 'validador':
					?>
					<td>Validador</td>
					<td><?php if ($fila['valor_campo'] == 1000) {
						echo "sin validar";
					} else {
						echo getNombre($fila['valor_campo']);
					} ?></td>
					<?php
					break;
					case 'adicional_ip_fija':
					?>
					<td>ip fija adicional</td>
					<td>1</td>
					<?php
					break;
					default:
					?>
					<td><?php echo $fila['nombre_campo']; ?></td>
					<td><?php echo $fila['valor_campo']; ?></td>
					<?php
					break;
				}
				?>
			</tr>
			<?php
		}

		$sqldatos_adicionales = "";


		?>
	</tbody>
</table>
