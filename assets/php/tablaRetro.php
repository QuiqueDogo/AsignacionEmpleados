<?php
$conexion_tabla = new PDO('mysql:dbname=marcador_manual;host=172.30.27.40:3306','root','4LC0M');
$conexion_tabla -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$sql_tabla="SELECT 
retro_cliente.id_retro,
retro_cliente.cuenta,
(SELECT  contacto FROM `marcador_manual`.`basecliente`
	WHERE foliocliente=cuenta LIMIT 1)AS nombre,
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
	retro_cliente.FechaAgendaAlcom
	FROM `marcador_manual`.`retro_cliente` retro_cliente
	WHERE retro_cliente.cuenta=$_REQUEST[numero_cuenta]
	";

	$arreglo_status = array("errorcode","validado","cancelado","Reagendado");
	try{
		echo "
		<table class='tablaform'>
		<thead>
		<tr>
		<th>Cuenta</th>
		<th>Nombre</th>
		<th>Plan actual</th>
		<th>Plan nuevo</th>
		<th>Folio sales force</th>
		<th>Fecha agendada</th>
		<th>Turno</th>
		<th>Fecha aplicacion</th>
		<th>Comentarios BO</th>
		<th>Nuevo estatus actualizado</th>
		<th>Fechacierre</th>
		<th>Tipo movimiento</th>
		<th>Comentarios Alcom</th>
		<th>Estatus Alcom</th>
		<th>Fecha agenda</th>
		<th>Guardar</th>
		<tr>
		</thead>
		<tbody>
		";
		foreach ($conexion_tabla -> query($sql_tabla) as $key=> $arreglo_tabla) {
			echo "<tr>
			<td>$arreglo_tabla[cuenta]</td>
			<td>$arreglo_tabla[nombre]</td>
			<td>$arreglo_tabla[planActual]</td>
			<td>$arreglo_tabla[plannuevohomologado]</td>
			<td>$arreglo_tabla[foliossalesforce]</td>
			<td>$arreglo_tabla[fechadeagendamiento]</td>
			<td>$arreglo_tabla[turno]</td>
			<td>$arreglo_tabla[fechadeapicacion]</td>
			<td>$arreglo_tabla[comentariosBo]</td>
			<td>$arreglo_tabla[nuevoestadoactualizado]</td>
			<td>$arreglo_tabla[fechadecierre]</td>			
			<td>$arreglo_tabla[tipomovimiento]</td>
			<td>
			<textarea id=comentarios_$arreglo_tabla[id_retro]>$arreglo_tabla[ComentariosAlcom]</textarea></td>
			<td>
			<select id=status_$arreglo_tabla[id_retro] required='' onChange=update_date(this)>";
			foreach ($arreglo_status as $key2 => $value) {
				if($arreglo_tabla['StatusAlcom'] == '' and $key2 == 0){
					echo "<option disabled = '' selected = '' value='Selecciona una opcion'>Selecciona una opcion</option>";
				}elseif ($value	== $arreglo_tabla['StatusAlcom']){
					echo "<option disabled = '' selected = '' value=$value>$value</option>";
				}elseif($key2>=1){
					echo "<option value=$value>$value</option>";	
				}
			}
			echo "</select>
			</td>		
			<td>
			<input type='text' id='fecha_validacion' placeholder='YYYY-MM-DD'";
			if($arreglo_tabla['StatusAlcom']=='Reagendado'){
				echo " value=$arreglo_tabla[FechaAgendaAlcom]></td>";
			}else{
				echo "style='display: none'></td>";
			}
			echo "<td><button data-idretro=$arreglo_tabla[id_retro] onclick=Update_Row(this) >Guardar</button></td>			
			</tr>";
		}
		echo "</tbody></table>";
	}catch(PDOException $e){
		echo $sql_tabla."<br>".$e;
	}
	$conexion_tabla = 0;
	?>