<table>
	<thead>
		<th>fecha_carga</th>
		<th>foliocliente</th>
		<th>telefono</th>
		<th>contacto</th>
		<th>nagente</th>
		<th>nsuper</th>
		<th>FoliosSalesForce</th>
		<th>StatusFolioSalesforce</th>
		<th>Estado</th>
		<th>comentariosBo</th>
		<th>ultimocomentario</th>
		<th>StatusAlcom</th>
		<th>ultimo FSF</th>
		<th>Historial FSF</th>
		<th>Nuevo Status FSF</th>
	</thead>
	<tfoot>
		<th>fecha_carga</th>
		<th>foliocliente</th>
		<th>telefono</th>
		<th>contacto</th>
		<th>nagente</th>
		<th>nsuper</th>
		<th>FoliosSalesForce</th>
		<th>StatusFolioSalesforce</th>
		<th>Estado</th>
		<th>comentariosBo</th>
		<th>ultimocomentario</th>
		<th>StatusAlcom</th>
		<th>ultimo FSF</th>
		<th>Historial FSF</th>
		<th>Nuevo Status FSF</th>
		
	</tfoot>
	<tbody>
		
		<?php 
		include 'conexionPDO.php';

		$sql_get_recuperaciones = "
		SELECT 
		bscliente.id as subid,
		bscliente.fecha_carga,
		bscliente.foliocliente,
		bscliente.telefono,
		bscliente.contacto,
		bscliente.nagente,
		bscliente.nsuper,
		bscliente.FoliosSalesForce,
		bscliente.StatusFolioSalesforce,
		rtrcliente2.Estado,
		rtrcliente2.comentariosBo,
		bscliente.ultimocomentario,
		rtrcliente2.StatusAlcom,
		(select folio_anterior from marcador_manual.HistorialFSF  
		where id_registro = subid  order by fecha_cambio desc limit 1)as ultimofolio
		from marcador_manual.basecliente bscliente inner join marcador_manual.retro_cliente_2 rtrcliente2
		on bscliente.foliocliente = rtrcliente2.cuenta 
		where bscliente.ultimoestatus ='Agente_Recuperacion' and bscliente.Statusfoliosalesforce is null;
		";

		try {
			foreach ($ConexionPDO -> query($sql_get_recuperaciones) as $key => $arreglo_recuperaciones) {
				?>
				<tr>
					<td><?php echo $arreglo_recuperaciones['fecha_carga']; ?></td>
					<td><?php echo $arreglo_recuperaciones['foliocliente']; ?></td>
					<td><?php echo $arreglo_recuperaciones['telefono']; ?></td>
					<td><?php echo $arreglo_recuperaciones['contacto']; ?></td>
					<td><?php echo $arreglo_recuperaciones['nagente']; ?></td>
					<td><?php echo $arreglo_recuperaciones['nsuper']; ?></td>
					<td><?php echo $arreglo_recuperaciones['FoliosSalesForce']; ?></td>
					<td><?php echo $arreglo_recuperaciones['StatusFolioSalesforce']; ?></td>
					<td><?php echo $arreglo_recuperaciones['Estado']; ?></td>
					<td><?php echo $arreglo_recuperaciones['comentariosBo']; ?></td>
					<td><?php echo $arreglo_recuperaciones['ultimocomentario']; ?></td>
					<td><?php echo $arreglo_recuperaciones['StatusAlcom']; ?></td>
					<td><?php echo $arreglo_recuperaciones['ultimofolio']; ?></td>
					<td><button  data-idcuenta="<?echo $arreglo_recuperaciones['subid'];?>" onClick='muestra_modal(this)'>Actualizar FSF</button></td>
					<td><select name="statusFSF<?php echo $arreglo_recuperaciones['subid'];?>" id="statusFSF<?php echo $arreglo_recuperaciones['subid'];?>">
						<option selected="" disabled="" >Selecciona una</option>
						<option value="NUEVO">NUEVO</option>
						<option value="EN PROCESO">EN PROCESO</option>
						<option value="En Espera">En Espera</option>
						<option value="Escalado">Escalado</option>
						<option value="Validacion">Validacion</option>
						<option value="CERRADO">CERRADO</option>
						<option value="CANCELADO">CANCELADO</option>
						<option value="Reagendado">Reagendado</option>
					</select></td>
				</tr>
				<?php
			}
		} catch (PDOException $e) {
			echo $sql_get_recuperaciones."".$e;
		}

		?>

	</tbody>
</table>










