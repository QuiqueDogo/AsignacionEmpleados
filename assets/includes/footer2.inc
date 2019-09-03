<div class="modalValidacion" id="modalValidacion__1" style="display: flex;">
	<div class="modal__container">
		<div class="modal__header">
			<h1>Validacion</h1>
		</div>
		<div class="modal__body">

			<div class="container_lolo">
				
				<div id="cajas_paraValidar">
					
				</div>
				
				<div class="formgroup">
					<label for="">Contraseña de validacion</label>
					<input type="password" id="claveValidacion_txt" autocomplete="none-cosa">		
				</div>	

				
			</div>
		</div>
		<div class="modal__footer">
			<button onclick="recargarCajaValidacion()">Recargar</button>
			<button type="button" style="display: none;" id="cerrar_btn_validado">Cancelar</button>
			<button type="button" style="display: none;" id="enviar_btn_validado">Guardar</button>
		</div>
	</div>
</div>

<script src="/sialcom/system/marcadormanual/assets/js/nuevaValidacion.js"></script>