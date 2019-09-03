<table>
	<thead>
		<th>Status</th>
		<th>Folio Sales Force</th>
		<th>Fecha Venta</th>
		<th>Fecha Retro</th>
		<th>Contacto</th>
		<th>Telefono</th>
		<th>Telefono 2</th>
		<th>Telefono 3</th>
		<th>Oferta Realizada</th>
		<th>Addons</th>
		<th>Monto</th>
		<th>Tiempo</th>
		<th>Comentarios BO</th>
		<th>Comentarios Agentes</th>
		<?php
		$agente = $_REQUEST['agente'];
		$tipo_busqueda = $_REQUEST['tipo_busqueda'];		
		if ($tipo_busqueda == 'Recuperacion') {
			echo "<th>Recuperar</th>";		
		}else{
			echo "<th>Status</th>";
		}
		?>
</thead>
<tbody>
	<?php 

	require "conexionPDO.php";
	$sql_validacionretro = "
	SELECT
	Retro_cliente.tipomovimiento,
	Retro_cliente.cuenta,
	Retro_cliente.foliossalesforce,
	Base_cliente.fechaventaoriginal,
	Retro_cliente.fechadecierre,
	Retro_cliente.FechaRetroAlcom,
	Retro_cliente.FechaAlcom,
	3 - datediff(curdate(),date_format(Retro_cliente.Fechaalcom,'%Y-%m-%d'))as tiempo_recuperacion,
	Base_cliente.contacto,
	Base_cliente.telefono,
	Base_cliente.id,
	Base_cliente.ultimocomentario,
	Base_cliente.diferencia,
	Retro_cliente.comentariosBo,
	Retro_cliente.StatusAlcom
	from
	marcador_manual.retro_cliente_2  Retro_cliente 
	inner join marcador_manual.basecliente Base_cliente 
	on Retro_cliente.cuenta = Base_cliente.foliocliente
	where Base_cliente.nagente = ".$agente;

	if ($tipo_busqueda =='Recuperacion') {
		$sql_validacionretro .= " and datediff(curdate(),date_format(Retro_cliente.Fechaalcom,'%Y-%m-%d')) <= 3 and StatusAlcom is null
		group by Base_cliente.foliocliente;";
	}
	try {
		foreach ($ConexionPDO -> query($sql_validacionretro) as $key => $arreglo_retro) {
			?>
			<tr>
				<td><?php echo $arreglo_retro['tipomovimiento']; ?></td>
				<td><?php echo $arreglo_retro['foliossalesforce']; ?></td>
				<td><?php echo $arreglo_retro['fechaventaoriginal']; ?></td>
				<td><?php echo $arreglo_retro['FechaAlcom']; ?></td>
				<td><?php echo $arreglo_retro['contacto']; ?></td>
				<td><?php echo $arreglo_retro['telefono']; ?></td>
				<?php
				$sql_getcontacto2 ="select valor_campo from marcador_manual.campos_adicionales 
				where idfolio_externo = '".$arreglo_retro['cuenta']."' and nombre_campo = 'CONTACTO 2'";

				$sql_getcontacto3 ="select valor_campo from marcador_manual.campos_adicionales 
				where idfolio_externo = '".$arreglo_retro['cuenta']."' and nombre_campo = 'CONTACTO 3'";

				$sql_getoferta ="
				SELECT
				(select nombrecampo from marcador_manual.campos_requeridos where id =valor_campo)as oferta_realizada 
				from marcador_manual.campos_adicionales 
				where idfolio_externo ='".$arreglo_retro['id']."'
				and 
				nombre_campo ='oferta_realizada'";

				$sql_getaddons ="		
				SELECT
				nombre_campo as fk_cmp,
				(select 
				if(grupocampo = 'wifi_extender',nombrecampo,
					if(grupocampo = 'servicio_tv_4k',nombrecampo,
						if(grupocampo = 'servicio_tv_adicional',nombrecampo,
							if(grupocampo = 'gamepad',nombrecampo,
								if(grupocampo = 'internet_crecelo',nombrecampo,
									if(grupocampo = 'telefonia',nombrecampo,
										if(grupocampo = 'modulos_tv',nombrecampo,if(grupocampo = null,'',''))))))))
											from marcador_manual.campos_requeridos 
										where 
										idcampania = 22 and grupocampo = fk_cmp limit 1)as addon,
										valor_campo
										from
										marcador_manual.campos_adicionales 
										where idfolio_externo ='".$arreglo_retro['id']."'";

										?>
										<td><?php try {
											foreach ($ConexionPDO -> query($sql_getcontacto2) as $key2 => $arreglo_c1) {
												?>
												<?php echo $arreglo_c1['valor_campo']; ?>
												<?php			}
											} catch (PDOException $e2) {
												echo $sql_getcontacto2.$e2;
											} ?></td>
											<td>
												<?php 
												try {
													foreach ($ConexionPDO -> query($sql_getcontacto3) as $key3 => $arreglo_c2) {
														echo $arreglo_c2['valor_campo'];
													}
												} catch (PDOException $e2) {
													echo $sql_getcontacto2.$e2;
												}
												?>
											</td>

											<td>
												<?php 
												try {
													foreach ($ConexionPDO ->query($sql_getoferta) as $key5 => $arreglo_oferta) {
														echo $arreglo_oferta['oferta_realizada'];
													}
												} catch (PDOException $e5) {
													echo $sql_getoferta.$e5;
												} ?>
											</td>
	<?php	//contacto 3

			//addons
	?><td>
		<?php try {
			foreach ($ConexionPDO -> query($sql_getaddons) as $key4 => $arreglo_addon) {
				if ($arreglo_addon['addon'] !='' ) {
					echo $arreglo_addon['addon'].","; 
				}
			}	
		} catch (PDException $e4) {
			echo $sql_getoferta." ".$e4;
		} ?>
	</td>
	<?php 

	?>
	<td>$<?php echo $arreglo_retro['diferencia']; ?>.00</td>
	<td><?php echo $arreglo_retro['tiempo_recuperacion'];?> dias</td>
	<td><?php echo $arreglo_retro['comentariosBo']; ?></td>
	<td><?php echo $arreglo_retro['ultimocomentario']; ?></td>
	<?php if ($tipo_busqueda =='Recuperacion') {
		?>
		<td>
			<button data-cuenta="<?php echo $arreglo_retro['id']; ?>" data-folio="<?php echo $arreglo_retro['cuenta']; ?>" <?php  if($arreglo_retro['tiempo_recuperacion'] < 1){echo "disabled=''";}else{}?> onclick='upd_folio(this)')>Recuperar</button>
		</td>
		<?php
	} else{
		echo "<td>".$arreglo_retro['StatusAlcom']."</td>";
		?>
		<?php
	}?>
	<?php
}	
echo "</tr>";
} catch (PDOException $e) {
	echo $sql_validacionretro."<hr>".$e;
}
$ConexionPDO = 0 ;
?>
</tbody>

</table>