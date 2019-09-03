<table class="tableform" id="tableform">
	<thead>
		<th>Folio Cliente</th>
		<th>Telefono</th>
		<th>Contacto</th>
		<th>Nombre Empleado</th>
		<th>Ultimo Comentario</th>
		<th>Fecha reagenda</th>
		<th>Asignar</th>
	</thead>
	<tbody>
		<?php 

		if (isset($_REQUEST['supervisor'])) {
			$sql_agentes = "SELECT emp_Nroemp,substr(emp_nombrecompleto,1,25) as emp_nombrecompleto from adcom.empleados where emp_fchbaja is null and emp_jefe ='".$_REQUEST['supervisor']."';";
		}else{

		}
		$campaniaDD = "totalplay.idcampania = '22'";
		if($_REQUEST['supervisor'] == "2262"){
			$campaniaDD = "totalplay.idcampania = '176'";
		}


		$tipo_reporte = isset($_REQUEST['tipo_reporte']) ? $_REQUEST['tipo_reporte']:'Baja';
		include 'conexionPDO.php';
		
		$sql_default ="
		SELECT
		totalplay.id ,
		totalplay.foliocliente ,
		concat('******',substring(totalplay.telefono,7,10))as telefono ,
		totalplay.contacto ,
		empleados.emp_Nroemp ,
		substr(empleados.emp_nombrecompleto,1,25) as emp_nombrecompleto,
		totalplay.nsuper ,
		totalplay.fecha_reagenda ,
		totalplay.ultimoestatus ,
		convert(totalplay.ultimocomentario using utf8)as last_comment
		from marcador_manual.basecliente as totalplay 
		inner join adcom.empleados as empleados 
		on totalplay.nagente = empleados.emp_Nroemp
		where
		totalplay.ultimoestatus like '%llamar mas tarde%' 
		and {$campaniaDD}
		and totalplay.nsuper ='".$_REQUEST['supervisor']."'";
		if ($tipo_reporte =='Baja') {
			$sql_default.= "AND empleados.emp_fchbaja is not null 
			order by totalplay.fecha_reagenda ;";
		}else{
			$sql_default.= "AND empleados.emp_fchbaja is null 
			order by totalplay.fecha_reagenda ";

		}

		try{

			foreach ($ConexionPDO -> query($sql_default)as $key => $arreglo) {
				?>
				<tr>
					<?php $cuenta =$arreglo['id'];
					$fecha_hora =str_replace(' ','T',$arreglo['fecha_reagenda'])?>

					<td><input disabled="" type="text" class="folio<?php echo $cuenta; ?>" value ="<?php echo $arreglo['foliocliente']; ?>"></td>
					<td><input disabled="" type="text" class="telefono<?php echo $cuenta; ?>" value ="<?php echo $arreglo['telefono']; ?>"></td>
					<td><input disabled="" type="text" class="contacto<?php echo $cuenta; ?>" value ="<?php echo $arreglo['contacto']; ?>"></td>
					<td>
						<select class="emp_Nroemp<?php echo $cuenta; ?>" >
							<?php 
							if ($tipo_reporte == 'Baja') {?>
								<option disabled="" selected=""><?php echo $arreglo['emp_nombrecompleto'];?></option><?php
								try {
									foreach ($ConexionPDO -> query($sql_agentes) as $key2 => $arreglo2) {
										?>
										<option value="<?php echo $arreglo2['emp_Nroemp'] ?>"><?php echo $arreglo2['emp_nombrecompleto'];?></option>
										<?php
									}	
								} catch (PDOException $e2) {
									echo "<option>".$sql_agentes.$e2."<option>";	
								} 
							}else{
								?>
								<?php
								if (isset($_REQUEST['supervisor'])) {
									?>
									<option value='<?php echo $arreglo['emp_Nroemp'];?>' disabled="" selected=""><?php echo $arreglo['emp_nombrecompleto'];?></option>
									<?php

								} else{

								}
							}
							?>
						</select>
					</td>
					<td><input  type="text" class="last_comment<?php echo $cuenta; ?>" value ="<?php echo $arreglo['last_comment'];?>" data-cuenta="<?php echo $cuenta;?>" onClick='Request_comments(this)'"></td>
					<td><input disabled = "" class="fecha_reagenda<?php echo $cuenta;?>" type="datetime-local" value="<?php echo $fecha_hora;?>"></td>
					<td><button data-cuenta="<?php  echo $cuenta;?>" onClick='Upd_Get(this)'>Asigna</button></td>
				</tr>
				<?php
			}
		}catch(PDOException $e){
			echo $e;
		}
		$ConexionPDO = 0;
		?>
	</table>
</tbody>
