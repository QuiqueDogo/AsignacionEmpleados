<?php
$conexion_tabla = new PDO('mysql:dbname=marcador_manual;host=172.30.27.40:3306','root','4LC0M');
$conexion_tabla -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$sql_tabla="SELECT 
retro_cliente.id_retro,
retro_cliente.cuenta,
(SELECT  contacto FROM `marcador_manual`.`basecliente`
	WHERE foliocliente=cuenta LIMIT 1)AS nombre,
	(SELECT date_format(fechaventaoriginal,'%Y-%m-%d') FROM `marcador_manual`.`basecliente`
	WHERE foliocliente=cuenta LIMIT 1)AS fecha_cambio,
	(SELECT  id FROM `marcador_manual`.`basecliente`
	WHERE foliocliente=cuenta LIMIT 1)AS fk_cliente,
	(SELECT DATE_FORMAT(dt,'%Y-%m-%d')
	FROM `marcador_manual`.marcaciones WHERE STATUS='Venta' AND
	idbasecliente =fk_cliente  )AS fechaVentaAlcom,
	(SELECT telefono FROM `marcador_manual`.`basecliente`
	WHERE foliocliente=cuenta LIMIT 1)AS telefono,
	(SELECT valor_campo FROM `marcador_manual`.`campos_adicionales`
	WHERE idfolio_externo =cuenta AND 
	nombre_campo='PLAN ACTUAL'LIMIT 1)AS planActual,
	retro_cliente.plannuevohomologado,
	retro_cliente.foliossalesforce,
	retro_cliente.fechadeagendamiento,
	retro_cliente.turno,
	retro_cliente.fechadeapicacion,
	retro_cliente.comentariosBo,
	retro_cliente.nuevoestadoactualizado,
	retro_cliente.fechadecierre,
	retro_cliente.tipomovimiento,
	retro_cliente.ComentariosAlcom,
	retro_cliente.StatusAlcom,
	retro_cliente.FechaAlcom,
	retro_cliente.FechaAgendaAlcom,
	retro_cliente.AgenteAlcom,
	retro_cliente.Turno_Recuperacion
	FROM `marcador_manual`.`retro_cliente` retro_cliente
	WHERE AgenteAlcom='$_REQUEST[agente]' and StatusAlcom='$_REQUEST[status]'
	";
	$arreglo_status = array("errorcode","validado","cancelado","no contesta","Reagendado","no se encuentra tt", "instalado","Recuperada");
	$arreglo_horarios = array("errorcode","Matutino","Vespertino");

	try{
		?><Table class='tablaform' id='tablaform'>
			<thead>
				<tr>
					<th>Fecha venta alcom</th>
					<th>Cuenta</th>
					<th>Nombre</th>
					<th>telefono</th>
					<th>Tipo movimiento</th>
					<th>Plan actual</th>
					<th>Plan nuevo</th>
					<th>Folio sales force</th>
					<th>Fecha agendada</th>
					<th>Fecha Cambio</th>
					<th>Turno</th>
					<th>Fecha aplicacion</th>
					<th>Comentarios BO</th>
					<th>Nuevo estatus actualizado</th>
					<th>Fechacierre</th>
					<th>Comentarios Alcom</th>
					<th>Estatus Alcom</th>
					<th>Turno Recuperacion</th>
					<th>Fecha agenda</th>
					<th>Guardar</th>
				</tr>
			</thead>
			<tbody><?php
			foreach ($conexion_tabla ->query($sql_tabla) as $key => $arreglo_tabla) {
				echo "<tr>";
				echo "<td>$arreglo_tabla[fechaVentaAlcom]</td>
				<td>$arreglo_tabla[cuenta]</td>
				<td>$arreglo_tabla[nombre]</td>
				<td>$arreglo_tabla[telefono]</td>
				<td>$arreglo_tabla[tipomovimiento]</td>
				<td>$arreglo_tabla[planActual]</td>
				<td>$arreglo_tabla[plannuevohomologado]</td>
				<td>$arreglo_tabla[foliossalesforce]</td>
				<td>$arreglo_tabla[fechadeagendamiento]</td>
				<td>$arreglo_tabla[fecha_cambio]</td>
				<td>$arreglo_tabla[turno]</td>
				<td>$arreglo_tabla[fechadeapicacion]</td>
				<td>$arreglo_tabla[comentariosBo]</td>
				<td>$arreglo_tabla[nuevoestadoactualizado]</td>
				<td>$arreglo_tabla[fechadecierre]</td>			
				<td>
				<textarea id=comentarios_$arreglo_tabla[id_retro]>$arreglo_tabla[ComentariosAlcom]</textarea></td>
				<td>
				<select data-idfolio=$arreglo_tabla[id_retro]  id=status_$arreglo_tabla[id_retro] required='' onChange=update_date(this)>";
				foreach ($arreglo_status as $key2 => $value) {
					if($arreglo_tabla['StatusAlcom'] == '' and $key2 == 0){
						echo "<option disabled = '' selected = '' value='Selecciona una opcion'>Selecciona una opcion</option>";
					}elseif ($value	== $arreglo_tabla['StatusAlcom']){
						echo "<option disabled = '' selected = '' value='$value'>$value</option>";
					}elseif($key2>=1){
						echo "<option value='$value'>$value</option>";	
					}
				}
				echo "</select>
				</td>";
				echo "<td><select id='turno_recuperdado$arreglo_tabla[id_retro]'>";
				foreach ($arreglo_horarios as $key => $value) {
					if ($arreglo_tabla[Turno_Recuperacion]=='' && $key==0) {
						echo "<option selected='' disabled=''>Selecciona una opcion</option>";
					}else if($value==$arreglo_tabla[Turno_Recuperacion]){
						echo "<option selected='' disabled='' value='$value'>$value</option>";
					}else if($key>=1){
						echo "<option value='$value'>$value</option>";	
					}
				}
				echo "</select></td>";
				echo "<td>
				<input type='text' id='fecha_validacion$arreglo_tabla[id_retro]' placeholder='YYYY-MM-DD'";
				if($arreglo_tabla['StatusAlcom']=='Reagendado'){
					echo " value=$arreglo_tabla[FechaAgendaAlcom]></td>";
				}else{
					echo "style='display: none'></td>";
				}
				echo "<td><button data-idretro=$arreglo_tabla[id_retro] onclick=Update_Row(this) >Guardar</button></td>			
				</tr>";
				echo "</tbody></table>";
			}
		}catch(PDOException $e){
			echo $sql_tabla."<br>".$e;
		}
		$conexion_tabla = 0;
		?>
