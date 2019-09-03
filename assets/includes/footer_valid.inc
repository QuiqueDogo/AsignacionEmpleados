<script>
	function ocultarCheck(ids) {
		var clic = document.getElementById(ids+"_bo").checked;
		var comprobar = document.getElementById('adicional__bo_'+ids+'_0');
		seleccionado = comprobar.selectedIndex;
		var campos_selects= ['adicional__bo_49_0','adicional__bo_50_0','adicional__bo_34_0','adicional__bo_23_0','adicional__bo_27_0'];

		if (clic == true ) {

			if (seleccionado  == -1) {
				document.getElementById("adicional__bo_"+ids+"_0").selectedIndex = 0 ;	
			}

			if(campos_selects.includes(comprobar.id)){
				document.getElementById("adicional__bo_"+ids+"_0").style.display = 'inline-block';
			}

		}else{
			document.getElementById("adicional__bo_"+ids+"_0").style.display = 'none';
			//document.getElementById("adicional__bo_"+ids+"_0").selectedIndex = 1 ;	
		}
	}


	function calcularValoresModal22(){
		// definir variable del total general
		let totalGeneral = 0;
		let subtotalChecks = 0;
		let subtotalSelect = 0;
		// calcular valores de los checks y guardarlo en variables de subtotales
		let misChecksPadres = document.querySelectorAll(".checkinn");
		misChecksPadres.forEach(elemento => {
			let checkActual = elemento.querySelector("input[type=checkbox]");
			if(checkActual.checked){
				let selectActual = elemento.querySelector("select");
				let cantidadSelect = 1;
				if(selectActual != undefined){
					// tenemos select - multiplar la cantidad del check por el valor del select
					if(selectActual.value == ""){
						cantidadSelect = 1;
					}else{
						cantidadSelect = selectActual.value;
					}
				}
				let valorDataCheck = parseInt(checkActual.dataset.valor) * parseInt(cantidadSelect);
				subtotalChecks = subtotalChecks + valorDataCheck;
			}

		});
		
		// calcular vaores de los select  y guardarlo en variables de subtotales
		let losSelects = document.querySelectorAll('.selectin');
		losSelects.forEach(elemento =>{
		   //se cambia la forma de obtener el valor
		   if(elemento.options[elemento.selectedIndex] != undefined){
		   	let losOptions = elemento.options[elemento.selectedIndex].value.dataset.valor;

		   	if (losOptions == "" || losOptions == undefined) {
		   		losOptions = 0;
		   	}
			////////////////valida si mantiene su paquete para tomar el valor de su renta actual
			if(elemento.options[elemento.selectedIndex].text=="Mantiene su paquete"){
				losOptions=  document.querySelector("#oferta_realizada > option:nth-child(1)").dataset.valor;
			}
			let valorDataSelect = parseInt(losOptions);
			
			subtotalSelect = subtotalSelect + valorDataSelect;
		}
	});
		// sumar todo
		totalGeneral = subtotalChecks + subtotalSelect;
		console.log(subtotalChecks +' --- '+subtotalSelect);
		// renta actual ... aaaaay amigo
		let rentaActu = document.querySelector("#oferta_realizada > option:nth-child(1)").dataset.valor;


		// ponerlo en el input
		//let cajitaValor = document.querySelector('.precio_totaltxt_bo').value = totalGeneral;// - parseInt(rentaActu);
		let cajitaValor = document.querySelector('.precio_totaltxt_bo');
		if(cajitaValor != null){
			cajitaValor.value = totalGeneral - parseInt(rentaActu);
		}
	}
	

	function validarFormularioVentas(){
		console.log("trato de enviar");
		let elementoStatusMarcacion = document.querySelector("#statusmarcacion_txt").value;
		let elementoVenta = document.querySelector("#statusmarcacion_txt option:nth-child(2)").value;
		switch(elementoStatusMarcacion){
			case "Llamar más tarde ":
			let elem_calendarioagenda =  document.querySelector("#calendarioagenda_txt").value;
			let elem_horaagenda =  document.querySelector("#horaagenda_txt").value;
			if(elem_horaagenda.length != 0 && elem_calendarioagenda.length != 0){
				return true;
			}else{
				alert("rellena los campos de agenda");
			}
			break;
			case elementoVenta:
			console.log("what do you here ? ");
			break;
			default:
			return true;
			break;
		}
		return false;
	}

	function manejador__select_adicional_descuentodeporvida(){

	}


</script>

<div class="modalValidacion" id="modalValidacion__1" style="display: none;">
	<div class="modal__container">
		<div class="modal__header">
			<h1>Validacion</h1>
		</div>
		<div class="modal__body">

			<div class="container_lolo">


				<?php 
				$conetsion = mysql_connect('172.30.27.40','root','4LC0M');

				$consulta1 =" SELECT
				*
				from
				marcador_manual.campos_requeridos
				where
				idcampania = '22'
				and activo = '1'
				and grupocampo not in (
				'fecha_instalacion',
				'adicional_horario_instalacion',
				'adicional_descuentodeporvida',
				'adicional_nombre_decisor',
				'adicional_numero_whatsapp',
				'adicional_fechaFacturacion',
				'adicional_familiar_empresarios'
			) and nivel = '1'" ;



			$cons1= mysql_query($consulta1, $conetsion);



			switch($_SESSION["campania_id_selected"]){
				// conmutador virtual
				case "175":
				?>
				<br><br>
				<p>
					El No. Cuenta al que van a depositar es el <span style="font-weight: bold;">0322074239</span>
					para realizar la transferencia es este: <span style="font-weight: bold;">072 470 00322074239 2</span>
					y la razón social es <span style="font-weight: bold;">CORATSA S DE RL DE CV</span>
				</p>
				<br><br>
				<?php
				break;
				// upsell totalplay
				case "22":

				while ($imp = mysql_fetch_assoc($cons1)) {

					$consulta2 = "SELECT * from marcador_manual.campos_requeridos where grupocampo = '{$imp['grupocampo']}' and nivel = '2' and activo = '1' and idcampania = '22';";
					$cons2= mysql_query($consulta2, $conetsion);

					switch ($imp['tipocampo']  ) {

						case 'select':

						?>
						<div class="formgroup" style="display: block;" >

							<label for='"<?php echo $imp['grupocampo'];?>"'><?php echo$imp['nombrecampo'];?> </label>
							<select class="selectin" name="adicional__bo_<?php echo $imp['grupocampo']; ?>" id="adicional__bo_<?php echo $imp['grupocampo']; ?>" onchange="calcularValoresModal22()" data-valor="<?php echo $imp['id'];?>"
								onchange="manejador__select_ofertaamigo_bo(this)">
								<option value="<?php echo $imp['id'];?>" data-valor="0">Seleccione una opcion</option>

								<?php 

								if ($imp['grupocampo'] == 'oferta_realizada'){

						//////en el footer se pone valor 0 , en la principal tiene su renta actual , se valida en el script
									?>
									<option value="0" data-valor="">Mantiene su paquete</option>

									<?php 
								}
								?>	




								<?php 
								while ($Campos = mysql_fetch_assoc($cons2)) {
									?>
									<option value="<?php echo $Campos['id']; ?>" data-valor="<?php echo $Campos['valorcampo']; ?>"> <?php echo $Campos['nombrecampo']; ?></option>
									<?php 
								}
								?>

							</select>	

						</div>

						<?php 


						break;

						case 'grupo_checkbox':

						?>	
						<div class="formgroup" style="display: block;">
							<label for='"<?php echo $imp['grupocampo'];?>"'><?php echo$imp['nombrecampo'];?> </label>



							<?php
							while ($Campos = mysql_fetch_assoc($cons2)) {
								?>




								<div class="checkinn" >
									<input type="checkbox" id="<?php echo $Campos['id']; ?>_bo" name="<?php echo $Campos['grupocampo']; ?>_bo[]" value="<?php echo $Campos['id']; ?>" onchange="calcularValoresModal22()" onclick="ocultarCheck(<?php echo $Campos['id']; ?>)" data-valor="<?php echo $Campos["valorcampo"]; ?>" class = "adicional__bo_<?php echo($Campos['id']) ?>" >

									<select onchange="calcularValoresModal22()" id="adicional__bo_<?php echo $Campos['id']; ?>_0" data-name="" name="adicional__bo_<?php echo $Campos['id']; ?>_bo" required=""  style= "display: none;" class= "adicional__bo_<?php echo $Campos['id']; ?>_bo">

										<?php for ($i=1; $i <= $Campos['cantidad']  ; $i++) { 
											if ($i != 0) {

												?>

												<option value="<?php echo $i; ?>"> <?php echo $i; ?></option>

												<?php  
											}
										}

										?>

									</select>


									<label for="<?php echo $Campos['id']; ?>_bo" value="<?php echo $Campos['valorcampo']; ?>"><?php echo$Campos['nombrecampo']?></label>

								</div>
								<?php 
							} 
							?>


						</div>

						<?php 

						break;



						default:

						break;
					}




				}?>


				<?php
				break;
				default:
				break;
			}
			?>

			<div class="formgroup">
				<label for="">Contraseña de validacion</label>
				<input type="password" id="claveValidacion_txt" autocomplete="none-cosa">		
			</div>	


		</div>

			<!-- 
					<p>
				Usted debe validar que todo lo que sigue este correcto. pero primero, ponga su clave de validacion aqui
			</p>
			<input type="password" id="claveValidacion_txt" autocomplete="none-cosa"> -->

		</div>
		<div class="modal__footer">

			<table style="float:left"><tr><td>
				<?php 
				if ($_SESSION["campania_id_selected"] =='22') {
					echo "<code><span>Diferencia: </span></code>";
					echo "</td></tr>";
					echo "<tr><td>";
					echo "<input type='text' class='precio_totaltxt_bo' readonly=''>";
				}else{

				}
				?>
			</td></tr>
		</table>

		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<button type="button" id="cerrar_btn_validado">Cancelar</button>
		&nbsp;&nbsp;&nbsp;&nbsp;
		<button type="button" id="enviar_btn_validado">Guardar</button>
	</div>
</div>
</div>
<?php mysql_close($conetsion); ?>

<style>
div.checkinn label{
	cursor: pointer;
}
</style>