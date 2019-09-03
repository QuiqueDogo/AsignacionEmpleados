<?php 
include "funciones.php";

$idregistor = $_REQUEST['idcaptura'];

$sqldd = "SELECT a.nombre_campo, b.nombrecampo, a.valor_campo FROM marcador_manual.campos_adicionales a  LEFT JOIN marcador_manual.campos_requeridos b ON a.valor_campo = b.id WHERE a.idfolio_externo = '{$idregistor}' and a.nombre_campo not in ('adicional_numero_whatsapp', 'adicional_nombre_decisor', 'adicional_descuentodeporvida') and a.valor_campo != ''";

if($_SESSION['idEmpleado'] == '2898'){	
	// echo $sqldd;
}
$query = mysql_query($sqldd, $conexion40);
?>
<table class="tablaform">
	<?php
	$ic = 0;
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
							?>
							Mantiene su paquete
							<?php
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
						<?php echo $fila['valor_campo']; ?>
					</td>
					<?php 
					break;
					case 'modulos_tv':
					?>
					<td>Modulos de TV</td>
					<td>
						<?php 
						$numerosvalidos = array(29,35,36,37,38,39,40,41,42,43,44,45,46,47,154, 265,266,267,306, 310);
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
					case 'adicional_internetcrecelo_bo':
					if($fila['nombrecampo'] != ""){
						?>
						<td>Internet Crecelo(BO)</td>
						<td><?php echo $fila['nombrecampo']; ?></td>
						<?php
					}
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
					case 'adicional_fechaFacturacion':
					if($fila['valor_campo'] != ""){
						?>
						<td>Fecha de facturacion</td>
						<td><?php echo $fila['valor_campo']; ?></td>
						<?php
					}
					break;
					case 'adicional_servicios_adicionales';
					?>
						<td>Servicio Adicional</td>
						<td><?php echo $fila['nombrecampo']; ?></td>
					<?php
					break;
					case 'adicional_paqueteTelevision':
					if($fila['valor_campo'] != ""){
						?>
						<td>Paquete television</td>
						<td><?php echo $fila['nombrecampo']; ?></td>
						<?php
					}
					break;
					case 'adicional_tvadicional_bo':
					if($fila['valor_campo'] != "" && $fila['valor_campo'] != "0"){
						?>
						<td>Servicio de TV Adicional(BO)</td>
						<td><?php echo $fila['valor_campo']; ?></td>
						<?php
					}
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
					case 'administrador_total':
					?>
					<td>Servicio Adicional Empresarial</td>
					<td><?php echo $fila['nombrecampo']; ?></td>
					<?php
					break;
					case '49':
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
					case '184':
					?>
					<td>Linea adicional</td>
					<td><?php echo $fila['valor_campo']; ?></td>
					<?php
					break;
					case '185':
					?>
					<td>Extension telefonica</td>
					<td><?php echo $fila['valor_campo']; ?></td>
					<?php
					break;
					case 'adicional_domiciliarconlatarjetadeliverpool':
					?>
					<td>Domiciliar con la tarjeta de liverpool</td>
					<td><?php echo $fila['nombrecampo']; ?></td>
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
		?>
	</tbody>
</table>

