<div class="modalValidacion" id="modalValidacion__1">
	<div class="modal__container">
		<div class="modal__header">
			<h1>Validacion</h1>
		</div>
		<div class="modal__body">

			<div class="container_lolo">


				<?php 
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
					?>
					<div class="formgroup" style="display: block;">
						<label for="adicional_servicio_tv_adicional_bo">SERVICIO DE TV ADICIONAL</label>
						<div class="container_checks" id="adicional_servicio_tv_adicional_bo">
							<div class="checkin">
								<input id="tv_adicional_bo" name="adicional_servicio_tv_adicional_bo" value="0" onchange="manejador_check_tv_adicional_bo(this)" data-valor="89" type="checkbox">
								<select onchange="manejador__select_cantidades_bo(this)" id="select_cantidades_check" data-name="27_valor" name="27_valor" required="">
									<option value="1" selected="">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
								</select>
								<label for="tv_adicional_bo">Elija cuantos quiere</label>
							</div>
						</div>
					</div>


					<div class="formgroup" style="display: block;">
						<label for="adicional_internet_crecelo_bo">INTERNET CRECELO</label>
						<select onchange="manejador__select_adicional_internet_crecelo_bo(this)" id="adicional_internet_crecelo_bo" name="adicional_internet_crecelo_bo">
							<option value="" selected="" data-valor="0">Selecciona una opcion</option>
							<option value="291" data-valor="70">20 Mbps</option>
							<option value="6" data-valor="80">30 Mbps</option>
							<option value="7" data-valor="210">50 Mbps</option>
							<option value="8" data-valor="390">100 Mbps</option>
							<option value="9" data-valor="640">200 Mbps</option>
							<option value="17" data-valor="1040">300 Mbps</option>
							<option value="51" data-valor="3000">500 Mbps</option>
						</select>
					</div>	
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
			<button type="button" id="cerrar_btn_validado">Cancelar</button>
			<button type="button" id="enviar_btn_validado">Guardar</button>
		</div>
	</div>
</div>