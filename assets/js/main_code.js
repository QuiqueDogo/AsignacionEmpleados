function getFDechaminInstalacion() {
	var someDate = new Date();
	var numberOfDaysToAdd = 1;
	someDate.setDate(someDate.getDate() + numberOfDaysToAdd); 
	var dia = someDate.getDay();
	if(dia == 0){
		numberOfDaysToAdd = 1;
		someDate.setDate(someDate.getDate() + numberOfDaysToAdd); 
	}
	var dd = someDate.getDate();
	var mm = someDate.getMonth() + 1;
	var y = someDate.getFullYear();
	if(dd < 10){
		dd = '0'+dd;
	}
	var someFormattedDate = y + '-'+ mm + '-'+ dd;
	return someFormattedDate;
}
jQuery(document).ready(function($) {


	$.datepicker.regional['es'] = {
		closeText: 'Cerrar',
		prevText: '<Ant',
		nextText: 'Sig>',
		currentText: 'Hoy',
		monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
		monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
		dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
		dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
		dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
		weekHeader: 'Sm',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	};
	$.datepicker.setDefaults($.datepicker.regional['es']);



	let dat = new Date();
	let fechanueva = getFDechaminInstalacion();

	$('body').on('focus', '.calendario_jquery_instalacion', function(){
		$(this).datepicker({ 
			minDate: fechanueva, 
			maxDate: '+6d',
			dateFormat: "yy-mm-dd",
			changeMonth: true,
			changeYear: true
		});
	});

	$('body').on('focus',".calendario_jquery", function(){
		$(this).datepicker({ 
			minDate: '+0', 
			maxDate: '+1w',
			dateFormat: "yy-mm-dd",
			changeMonth: true,
			changeYear: true,
			beforeShowDay: function(date) {
				let day = date.getDay();
				return [(day != 0), ''];
			}
		});
	});

});
document.addEventListener('DOMContentLoaded', function(event){

	let contenedorMadre = document.querySelector('#contenedorMadre');
	let loader = document.querySelector('#loader_peso');
	loader.style.display = 'none';
	contenedorMadre.style.display = 'flex';


	const btn_tomarregistro = document.querySelector('#btn__tomarregistro');
	if(btn_tomarregistro != null){
		btn_tomarregistro.addEventListener('click', manejador_clic_btntomarregistro);
	}
	const btn_validar = document.querySelector('#enviar_btn_validado');
	if(btn_validar != null){
		btn_validar.addEventListener('click', manejador_clic_enviar_btn_validado);
	}
	const btn_cerrarmodal = document.querySelector('#cerrar_btn_validado');
	if(btn_cerrarmodal != null){
		btn_cerrarmodal.addEventListener('click', manejador_clic_cerrarmodal);
	}

	const btn_panel_notificacion = document.querySelector('.session_img');
	btn_panel_notificacion.addEventListener('click', manejador__click_img_profile);



});

function manejador__select_adicional_paquete_seleccionado_cv  (){
	let elemento = document.querySelector("#adicional_paquete_seleccionado_cv");
	let cantidades = elemento.querySelector('option:nth-child('+(elemento.selectedIndex + 1)+')');
	cantidades.parentNode.setAttribute('data-valor', cantidades.dataset.valor);
	calcularPrecio_cv();
}

function calcularPrecio_cv(){
	let adicional_paquete_seleccionado_cv = document.querySelector("#adicional_paquete_seleccionado_cv");
	let cajita_total = document.querySelector("#precio_totaltxt");
	let checks_cv = document.querySelectorAll('#cajaVenta input[type=checkbox]');
	let sumaPaquetes = 0;

	// paquete seleccionado
	if(adicional_paquete_seleccionado_cv.dataset.valor != null){
		sumaPaquetes += parseInt(adicional_paquete_seleccionado_cv.dataset.valor);
	}
	// checks de adicionales
	checks_cv.forEach((elemento, indice) => {
		if(elemento.checked){
			let select_cantidades = elemento.parentNode.querySelector('select');
			let cantidadH = 0;
			let valor_cajita = elemento.dataset.valor;

			if(select_cantidades != null){
				let cuantos = 1;
				if(select_cantidades.dataset.valor != null){
					cuantos = select_cantidades.querySelector('option:nth-child('+(select_cantidades.selectedIndex + 1)+')').innerHTML;
				}
				sumaPaquetes += cuantos * parseInt(valor_cajita);
				elemento.value = cuantos;					
			}else{
				sumaPaquetes += parseInt(valor_cajita);
			}
		}
	});
	cajita_total.value = sumaPaquetes;
}

function manejador__click_img_profile(){
	let panel_div = document.querySelector('#elementopanel');
	if(panel_div.dataset.status == 'off'){
		panel_div.dataset.status = 'on';
		panel_div.classList.remove('panel__padre_notificaciones');
		panel_div.classList.add('panel__padre_notificaciones2');
	}else{
		panel_div.dataset.status = 'off';
		panel_div.classList.remove('panel__padre_notificaciones2');
		panel_div.classList.add('panel__padre_notificaciones');
	}
}
function manejador__notificacion_agendados(){
}
function manejador__select_onchange(elemento){
	let cajaAgenda = document.querySelector('.clase_columnaform');
	let cajaVenta = document.querySelector('#cajaVenta');
	let caja_fecha = cajaAgenda.querySelector('input');
	let caja_hora = cajaAgenda.querySelector('select');
	let button_send = document.querySelector('#enviar_registro');
	let button_send1 = document.querySelector('#enviar_registro1');

	let cajatotalesamigo = document.querySelector("#cajatotalesamigo");
	let campania_id_marcador = document.querySelector("#campania_id_marcador");


	if(elemento.value == "Pedir Informacion"){
		let elemento_informes_formulario = document.querySelector("#informes_formulario");
		if(elemento_informes_formulario != null){
			elemento_informes_formulario.style.display = "block";
			elemento_informes_formulario.setAttribute("required", "");
		}else{
			let div_select = elemento.parentNode;
			let div_formulario = document.createElement("div");
			let label_formulario = document.createElement("label");
			let input_formulario = document.createElement("input");
			input_formulario.setAttribute("name", "adicional_numero_contacto_whats");
			input_formulario.setAttribute("type", "number");
			input_formulario.setAttribute("min", "1000000000");
			input_formulario.setAttribute("max", "9999999999");
			input_formulario.setAttribute("required", "");

			label_formulario.innerHTML = "Numero de telefono para contacto";
			div_formulario.classList.add("formgroup");
			div_formulario.setAttribute("id", "informes_formulario");
			div_formulario.appendChild(label_formulario);
			div_formulario.appendChild(input_formulario);
			div_select.insertAdjacentElement('afterend', div_formulario);
		}

	}else{
		let formes_formulario = document.querySelector("#informes_formulario");
		if(formes_formulario != null){
			formes_formulario.style.display = "none";
			formes_formulario.removeAttribute("required");
		}
	}
	
	switch(elemento.selectedIndex){
		case 1:
		cajaVenta.style.display = 'flex';
		cajaAgenda.style.display = 'none';
		button_send.removeAttribute('type');
		button_send.setAttribute('type', 'button');
		button_send.innerHTML = 'Validar';
		button_send.setAttribute('onclick', 'manejador__btnsend_click()');
		caja_fecha.removeAttribute('required');
		caja_hora.removeAttribute('required');

		let diaParaVisita190 = document.querySelector("#adicional_diaParaVisita190");
		let horaParaVisita190 = document.querySelector("#adicional_horaParaVisita190");
		let correo190 = document.querySelector("#adicional_correo190");

		if(diaParaVisita190 != null && horaParaVisita190 != null && correo190 != null){
			diaParaVisita190.setAttribute("type", "date");
			horaParaVisita190.setAttribute("type", "time");
			correo190.setAttribute("type", "email");
		}


			if (campania_id_marcador.innerHTML == "189" || campania_id_marcador.innerHTML == "190" || campania_id_marcador.innerHTML == "203" || campania_id_marcador.innerHTML == "214" || campania_id_marcador.innerHTML == "8" || campania_id_marcador.innerHTML == "225" || campania_id_marcador.innerHTML == "227"){
			cajatotalesamigo.style.display = "none";
		}else{	
			button_send1.style.display = 'none';
		}
		break;
		case 3:
		cajaVenta.style.display = 'none';
		cajaAgenda.style.display = 'flex';
		button_send.removeAttribute('onclick');
		button_send.removeAttribute('type');
		button_send.innerHTML = 'Agendar';
		caja_fecha.setAttribute('required', '');
		caja_hora.setAttribute('required', '');
		button_send1.style.display = 'block';
		break;
		default:
		cajaVenta.style.display = 'none';
		cajaAgenda.style.display = 'none';
		button_send.innerHTML = 'Enviar';
		button_send.removeAttribute('onclick');
		button_send.removeAttribute('type');
		caja_fecha.removeAttribute('required');
		caja_hora.removeAttribute('required');
		button_send1.style.display = 'block';
		break;
	}
	caja_hora.value = '';
	caja_fecha.value = '';
	let precio_totaltxt = document.querySelector('#precio_totaltxt');
	precio_totaltxt.value = '';
	limpiarCajas();
}

// function manejador__select_titular_onchange(elemento){
// 	let respuestaSelect = elemento.value;
// 	let option_venta = document.querySelector('#venta_option');
// 	if(option_venta != null){

// 		if(respuestaSelect == "SI"){
// 			option_venta.style.display = 'block';
// 		}else{
// 			option_venta.style.display = 'none';
// 		}
// 	}
// }

function manejador__select_titular_onchange(elemento){
	let respuestaSelect = elemento.value;
	let option_venta = document.querySelector('#venta_option');
	if(option_venta != null){

		if(respuestaSelect == "SI"){
			let folio = document.querySelector('#idregistro_txt').value;
			fetch('assets/php/telefonosVentas.php?folio='+folio)
			.then(request_telefonos =>{return request_telefonos.text();})
			.then(text_telefonos=> {
				if(text_telefonos =='Registro en venta'){
					option_venta.style.display = 'none';
					alert("Este registro esta en venta actualmente , no podras registrarlo como venta nuevamente.");
				}else{
					option_venta.style.display = 'block';
				}
			})
			.catch(error_telefonos =>{console.error(error_telefonos)});
		}else{
			option_venta.style.display = 'none';
		}
	}
}

function manejador__click_btnmarcar(elemento){
	let telef = document.querySelector('#telefonoamarcar_txt');
	let opcion_seleccionada = telef.querySelector('option:nth-child('+(telef.selectedIndex+1)+')');
	let empleadoNum = document.querySelector('.session_img img').getAttribute('alt');
	let ruta = "http://172.30.27.4/marcaciones_externas/re.php?telefono="+opcion_seleccionada.dataset.telefono+"&&agente="+empleadoNum;
	ajax_traerRegistro(ruta, manejador_marcartelefono);
}
function manejador__click_btncolgar(elemento){
	let btn_colgar = document.querySelector('#btn_colgar_telefono');
	let canal = btn_colgar.dataset.canal;
	let ruta = "http://172.30.27.4/marcaciones_externas/co.php?canal="+canal;
	ajax_traerRegistro(ruta, manejador_colgarllamada);
}
function manejador_marcartelefono(response){
	let respuesta = JSON.parse(response);

	let btn_marcar = document.querySelector('#btn_marcar_telefono');
	let btn_colgar = document.querySelector('#btn_colgar_telefono');
	if(respuesta.msg_error == ""){
		btn_marcar.setAttribute('class','ocultarbtn');
		btn_colgar.setAttribute('data-canal', respuesta.canal);
		btn_colgar.setAttribute('class','mostrarbtn');

	}else{
		alert(respuesta.msg_error);
	}
}
function manejador_colgarllamada(response){
	let btn_marcar = document.querySelector('#btn_marcar_telefono');
	let btn_colgar = document.querySelector('#btn_colgar_telefono');
	btn_colgar.setAttribute('class', 'ocultarbtn');
	btn_marcar.setAttribute('class','mostrarbtn');
}
function manejador__select_cantidades(elemento){
	let cantidades = elemento.querySelector('option:nth-child('+(elemento.selectedIndex + 1)+')');
	cantidades.parentNode.setAttribute('data-valor', cantidades.value);
	let campania_id_marcador = document.querySelector('#campania_id_marcador');
	let campania_id = campania_id_marcador.innerHTML;
	switch(campania_id){
		case '175':
		calcularPrecio_cv();
		break;
		case '176':
		calcularPrecio();
		break;
		case '22':
		calcularPrecio();
		break;
		case '211':
		calcularPrecio();
		break;
		case '220':
		calcularPrecio();
		break;
		default:

		break;
	}
}
function manejador__select_gamefly_plan(elemento){
	let gamefly = elemento.querySelector('option:nth-child('+(elemento.selectedIndex + 1)+')');
	gamefly.parentNode.setAttribute('data-valor', gamefly.dataset.valor);
	calcularPrecio();
}


function manejador__select_adicional_paqueteTelevision(elemento){
	let paqueteTelevision = elemento.querySelector('option:nth-child('+(elemento.selectedIndex + 1)+')');
	paqueteTelevision.parentNode.setAttribute('data-valor', paqueteTelevision.dataset.valor);
	calcularPrecio();
}


function manejador__select_adicional_PaqueteTv(elemento){
	let paqueteTelevision = elemento.querySelector('option:nth-child('+(elemento.selectedIndex + 1)+')');
	paqueteTelevision.parentNode.setAttribute('data-valor', paqueteTelevision.dataset.valor);
	calcularPrecio();	
}


function calcularPrecio(){

	let precio_oferta = document.querySelector('#oferta_realizada');
	let precio_internet_crecelo  = document.querySelector('#internet_crecelo');
	let precio_gamefly_plan = document.querySelector('#gamefly_plan');


	let precio_paqueteTelevision = document.querySelector('#adicional_paqueteTelevision');


	let precio_original = document.querySelector('#oferta_realizada option:nth-child(1)').dataset.valor;

	let sumatoria = 0;
	if(typeof precio_oferta.dataset.valor == 'string'){
		sumatoria += parseInt(precio_oferta.dataset.valor);
	}else{
		if(typeof precio_oferta.dataset.valor == 'undefined'){
			precio_oferta = document.querySelector('#oferta_realizada option:nth-child(1)');
			sumatoria += parseInt(precio_oferta.dataset.valor);
		}
	}


	// paquete television
	if(precio_paqueteTelevision != null){

		if(typeof precio_paqueteTelevision.dataset.valor == 'string'){
			sumatoria += parseInt(precio_paqueteTelevision.dataset.valor);
		}else{
			if(typeof precio_paqueteTelevision.dataset.valor == 'undefined'){
				precio_paqueteTelevision = document.querySelector('#adicional_paqueteTelevision option:nth-child(1)');
				sumatoria += parseInt(precio_paqueteTelevision.dataset.valor);
			}
		}
	}




	if(precio_gamefly_plan != null){
		if(typeof precio_gamefly_plan.dataset.valor == 'string'){
			sumatoria += parseInt(precio_gamefly_plan.dataset.valor);
		}
	}

	if(precio_internet_crecelo != null){
		if(typeof precio_internet_crecelo.dataset.valor == 'string'){
			sumatoria += parseInt(precio_internet_crecelo.dataset.valor);
		}
	}

	let checkins = document.querySelectorAll('.checkin input[type=checkbox]');
	checkins.forEach(function(elemento, indice){
		if(elemento.checked){
			let preciopor = "1";
			let can = elemento.parentNode.querySelector('select');
			if(can == null){
				preciopor = 1;
			}else{
				if((typeof can.dataset.valor != 'undefined') && (typeof can.dataset.valor != null)){
					preciopor = can.dataset.valor;
				}else{
					preciopor = 1;
				}
			}
			let subtotal = parseInt(elemento.dataset.valor) * parseInt(preciopor);
			sumatoria += subtotal;
		}
	});
	let precio_totaltxt = document.querySelector('#precio_totaltxt');
	precio_totaltxt.value = sumatoria - precio_original;
}


function calcularPrecio_adicionales(){

	let precio_oferta = document.querySelector('#oferta_realizada');
	let precio_internet_crecelo  = document.querySelector('#internet_crecelo');
	let precio_gamefly_plan = document.querySelector('#gamefly_plan');


	let precio_paqueteTelevision = document.querySelector('#adicional_paqueteTelevision');


	let precio_original = "0";
	
	let sumatoria = 0;
	// if(typeof precio_oferta.dataset.valor == 'string'){
	// 	sumatoria += parseInt(precio_oferta.dataset.valor);
	// }else{
	// 	if(typeof precio_oferta.dataset.valor == 'undefined'){
	// 		precio_oferta = document.querySelector('#oferta_realizada option:nth-child(1)');
	// 		sumatoria += parseInt(precio_oferta.dataset.valor);
	// 	}
	// }


	// // paquete television
	// if(typeof precio_paqueteTelevision.dataset.valor == 'string'){
	// 	sumatoria += parseInt(precio_paqueteTelevision.dataset.valor);
	// }else{
	// 	if(typeof precio_paqueteTelevision.dataset.valor == 'undefined'){
	// 		precio_paqueteTelevision = document.querySelector('#adicional_paqueteTelevision option:nth-child(1)');
	// 		sumatoria += parseInt(precio_paqueteTelevision.dataset.valor);
	// 	}
	// }




	// if(precio_gamefly_plan != null){
	// 	if(typeof precio_gamefly_plan.dataset.valor == 'string'){
	// 		sumatoria += parseInt(precio_gamefly_plan.dataset.valor);
	// 	}
	// }

	// if(precio_internet_crecelo != null){
	// 	if(typeof precio_internet_crecelo.dataset.valor == 'string'){
	// 		sumatoria += parseInt(precio_internet_crecelo.dataset.valor);
	// 	}
	// }

	let checkins = document.querySelectorAll('.checkin input[type=checkbox]');
	checkins.forEach(function(elemento, indice){
		if(elemento.checked){
			let preciopor = "1";
			let can = elemento.parentNode.querySelector('select');
			if(can == null){
				preciopor = 1;
			}else{
				if((typeof can.dataset.valor != 'undefined') && (typeof can.dataset.valor != null)){
					preciopor = can.dataset.valor;
				}else{
					preciopor = 1;
				}
			}
			let subtotal = parseInt(elemento.dataset.valor) * parseInt(preciopor);
			sumatoria += subtotal;
		}
	});
	let precio_totaltxt = document.querySelector('#precio_totaltxt');
	precio_totaltxt.value = sumatoria - precio_original;
}



function manejador__select_internet_crecelo(elemento){
	let oferta_campo = elemento.querySelector('option:nth-child('+(elemento.selectedIndex + 1)+')');
	oferta_campo.parentNode.setAttribute('data-valor', oferta_campo.dataset.valor);
	calcularPrecio();
}
function manejador__select_ofertaamigo(elemento){
	let oferta_campo = elemento.querySelector('option:nth-child('+(elemento.selectedIndex + 1)+')');
	oferta_campo.parentNode.setAttribute('data-valor', oferta_campo.dataset.valor);
	calcularPrecio();
}
function manejador__btnsend_click(){
	let moal = document.querySelector('#modalValidacion__1');
	let precio_totaltxt = document.querySelector('#precio_totaltxt');

	let adicional_horario_instalacion = document.querySelector('#adicional_horario_instalacion');
	let fecha_instalacion = document.querySelector('#fecha_instalacion');


	let campania_id_marcador = document.querySelector('#campania_id_marcador');
	let campania_id = campania_id_marcador.innerHTML;
	switch(campania_id){
		case '175':
		if(precio_totaltxt.value != "0" && precio_totaltxt.value != ""){
			moal.style.display = 'flex';
			let campocontra = document.querySelector('#claveValidacion_txt');
			campocontra.value = '';
		}else{
			alert("No puedes validar si no has agregado nada");
		}
		break;
		case '22':
		if(precio_totaltxt.value != "0" && precio_totaltxt.value != ""){
			if(adicional_horario_instalacion.value != "0" &&  adicional_horario_instalacion.value != ""){
				if(fecha_instalacion.value != "0" &&  fecha_instalacion.value != ""){
					moal.style.display = 'flex';
					let campocontra = document.querySelector('#claveValidacion_txt');
					campocontra.value = '';
				}else{
					alert("Tienes que poner fecha de instalacion");
				}
			}else{
				alert("Tienes que poner un horario de instalacion");
			}
		}else{
			alert("No puedes validar si no hay un upsell");
		}
		break;
		case '176':
		if(precio_totaltxt.value != "0" && precio_totaltxt.value != ""){
			moal.style.display = 'flex';
			let campocontra = document.querySelector('#claveValidacion_txt');
			campocontra.value = '';
		}else{
			alert("No puedes validar si no has agregado nada");
		}
		break;
		case '211':
		if(precio_totaltxt.value != "0" && precio_totaltxt.value != ""){
			moal.style.display = 'flex';
			let campocontra = document.querySelector('#claveValidacion_txt');
			campocontra.value = '';
		}else{
			alert("No puedes validar si no has agregado nada");
		}
		break;
		case '206':
		if(precio_totaltxt.value != "0" && precio_totaltxt.value != ""){
			moal.style.display = 'flex';
			let campocontra = document.querySelector('#claveValidacion_txt');
			campocontra.value = '';
		}else{
			alert("No puedes validar si no has agregado nada");
		}
		break;
		case '220':
		if(precio_totaltxt.value != "0" && precio_totaltxt.value != ""){
			moal.style.display = 'flex';
			let campocontra = document.querySelector('#claveValidacion_txt');
			campocontra.value = '';
		}else{
			alert("No puedes validar si no has agregado nada");
		}
		break;
		default:

		break;
	}
}
function manejador_clic_btntomarregistro(event){
	let ruta = 'assets/php/tomarregistro.php';
	let campanaa = document.querySelector("#campania_id_marcador").innerHTML;
	if(campanaa == "0"){
		window.location.href = "/sialcom/system/marcadormanual";
	}else{
		ajax_traerRegistro(ruta, manejador_traerregistro);
	}
}
function ajax_traerRegistro(args_ruta, callback){
	let peticion = new XMLHttpRequest();
	let ruta = args_ruta;
	peticion.onreadystatechange = function(){
		if(peticion.readyState == 4 && peticion.status == 200){
			callback(peticion.responseText);
		}
	}
	peticion.open('GET', ruta, true);
	peticion.send(null);
}
function manejador_traerregistro(response){
	if(response == 0){
		alert("no tienes registros");
	}else{
		let respuesta = JSON.parse(response);
		let span_registrospendientes = document.querySelector('#btn__tomarregistro span');
		span_registrospendientes.setAttribute('data-conteopendientes', respuesta[2].registrospendientes);
		let container_form = document.querySelector('#container_form');
		container_form.innerHTML = "";
		let cont_formulario_principal = document.createElement('div');
		cont_formulario_principal.classList.add('formulario_principal');
		let cont_formulario_cabeza = document.createElement('div');
		cont_formulario_cabeza.classList.add('formulario_cabecera');
		cont_formulario_cabeza.innerHTML = 'Informacion de registro';
		cont_formulario_principal.appendChild(cont_formulario_cabeza);


		let formulario = document.createElement('form');
		formulario.setAttribute('method', 'post');
		formulario.setAttribute('action', 'assets/php/guardarMarcacion.php');

		let form_table = document.createElement('div');

		let tabla_form = document.createElement('table');
		tabla_form.setAttribute('id', 'tabla_form_registro');
		tabla_form.classList.add('tablaform');
		let table_body = document.createElement('tbody');
		let idregistroactual = respuesta[0]['id'];
		if (typeof idregistroactual == 'undefined'){
			alert('ya no tienes mas registros');
		}else{
			let camposquenodeborecuperar = ["idcampania", "lotenombre", "nsuper", "id"];
			let costopaqueteactual = '';
			let plan_recomendado = '';
			let esTelefono = true;
			Object.keys(respuesta[0]).forEach(function(k){
				let elem = camposquenodeborecuperar.indexOf(k);
				if(elem == -1){
					if(k == 'RENTA ACTUAL'){
						costopaqueteactual = respuesta[0][k];
					}else if(k == 'PLAN RECOMENDADO'){
						plan_recomendado = respuesta[0][k];
						let elemento_plan_recomendado = document.createElement('span');
						elemento_plan_recomendado.setAttribute('id', 'span_plan_recomendado');
						elemento_plan_recomendado.style.display="none";
						elemento_plan_recomendado.innerHTML = plan_recomendado;
						document.querySelector('#campania_id_marcador').parentNode.appendChild(elemento_plan_recomendado);
					}
					let html_tr = document.createElement('tr');
					let html_td = document.createElement('td');
					let html_strong = document.createElement('strong');
					let html_span = document.createElement('span');
					// html_span.classList.add('', );
					let text_strong = document.createTextNode(k+': ');
					let text_span = document.createTextNode(respuesta[0][k]);
					html_strong.appendChild(text_strong);
					html_span.appendChild(text_span);
					html_td.appendChild(html_strong);
					html_td.appendChild(html_span);
					html_tr.appendChild(html_td);
					tabla_form.appendChild(html_tr);
				}
			});

			form_table.appendChild(tabla_form);

			// creacion del formulario de asignacion
			let input_idregistro = document.createElement('input');
			input_idregistro.value = idregistroactual;
			input_idregistro.setAttribute('type', 'hidden');
			input_idregistro.setAttribute('name', 'idregistro_txt');
			input_idregistro.setAttribute('id', 'idregistro_txt');
			// creacion del input id del registro 
			let input_idregistro1 = document.createElement('input');
			input_idregistro1.setAttribute('type', 'hidden');
			input_idregistro1.setAttribute('name', 'idvalidador_txt');
			input_idregistro1.setAttribute('id', 'idvalidador_txt');


			// creacion del campo de los telefonos
			let container_select_telefonos = document.createElement('div');
			let cajita = document.createElement('div');
			cajita.classList.add('cajaform');


			container_select_telefonos.classList.add('formgroup');
			let select_telefonos = document.createElement('select');

			select_telefonos.setAttribute('required', '');
			select_telefonos.setAttribute('onchange', 'manejador__select_telefonos_onchange(this)');
			select_telefonos.setAttribute('id', 'telefonoamarcar_txt');
			select_telefonos.setAttribute('name', 'telefonoamarcar_txt');

			let button_calificacion = document.createElement('button');
			button_calificacion.setAttribute('type', 'button');
			button_calificacion.setAttribute('id', 'btn_marcar_telefono');
			button_calificacion.setAttribute('onclick', 'manejador__click_btnmarcar(this)');
			button_calificacion.innerHTML = "marcar";

			let button_calificacion1 = document.createElement('button');
			button_calificacion1.setAttribute('type', 'button');
			button_calificacion1.setAttribute('id', 'btn_colgar_telefono');
			button_calificacion1.classList.add('ocultarbtn');
			button_calificacion1.setAttribute('onclick', 'manejador__click_btncolgar(this)');
			button_calificacion1.innerHTML = "colgar";


			Object.keys(respuesta[4].telefonosparamarcar).forEach(function(index){
				let option_telefonos = document.createElement('option');
				option_telefonos.setAttribute('data-telefono', respuesta[4].telefonosparamarcar[index]);
				// option_telefonos.innerHTML = "******"+respuesta[4].telefonosparamarcar[index].substring(6, 10);
				option_telefonos.innerHTML = respuesta[4].telefonosparamarcar[index];
				select_telefonos.appendChild(option_telefonos);
			});
			let label_telefono = document.createElement('label');
			label_telefono.setAttribute('for', 'telefonoamarcar_txt');
			label_telefono.innerHTML = 'Telefono a marcar';
			container_select_telefonos.appendChild(label_telefono);
			cajita.appendChild(select_telefonos);
			cajita.appendChild(button_calificacion);
			cajita.appendChild(button_calificacion1);
			container_select_telefonos.appendChild(cajita);

			// creacion del select de titular o no
			let container_input_11 = document.createElement('div');
			container_input_11.classList.add('formgroup');
			let select_status1 = document.createElement('select');
			select_status1.setAttribute('required', '');
			select_status1.setAttribute('onchange', 'manejador__select_titular_onchange(this)');
			select_status1.setAttribute('id', 'llamadacontitular_txt');
			select_status1.setAttribute('name', 'llamadacontitular_txt');
			let label_status11 = document.createElement('label');
			label_status11.setAttribute('for', 'llamadacontitular_txt');
			label_status11.innerHTML = 'Hablo con el titular';
			let arregloRespuestas = ["", "SI", "NO"];

			for (var i = 0; i < arregloRespuestas.length; i++) {
				let optionR = document.createElement('option');
				optionR.value = arregloRespuestas[i];
				if(arregloRespuestas[i] == ''){
					optionR.innerHTML = "Selecciona una opcion";
					optionR.setAttribute('selected', '');
					optionR.setAttribute('disabled', '');
				}else{
					optionR.innerHTML = arregloRespuestas[i];
				}
				select_status1.appendChild(optionR);
			}

			container_input_11.appendChild(label_status11);
			container_input_11.appendChild(select_status1);


			// creacion de caja de comentarios
			let container_input_giro = document.createElement('div');
			container_input_giro.classList.add('formgroup');
			let caja_giro = document.createElement('input');
			caja_giro.setAttribute('id', 'adicional_giro_txt');
			caja_giro.setAttribute('name', 'adicional_giro_txt');
			let label_giro = document.createElement('label');
			label_giro.setAttribute('for', 'adicional_giro_txt');
			label_giro.innerHTML = "Giro del negocio";
			container_input_giro.appendChild(label_giro);
			container_input_giro.appendChild(caja_giro);


			// creacion del select de estatus - calltypes
			let container_input_1 = document.createElement('div');
			container_input_1.classList.add('formgroup');
			let select_status = document.createElement('select');
			select_status.setAttribute('required', '');
			select_status.setAttribute('onchange', 'manejador__select_onchange(this)');
			select_status.setAttribute('id', 'statusmarcacion_txt');
			select_status.setAttribute('name', 'statusmarcacion_txt');

			let option_status = document.createElement('option');
			option_status.setAttribute('value', '');
			option_status.setAttribute('selected', '');
			option_status.setAttribute('disabled', '');
			option_status.innerHTML = 'Selecciona un status';
			select_status.appendChild(option_status);

			Object.keys(respuesta[1]).forEach(function(index){
				let option_status = document.createElement('option');
				if(respuesta[1][index] == 'Venta'){
					option_status.setAttribute('id', 'venta_option');
				}
				option_status.setAttribute('value', respuesta[1][index]);
				option_status.innerHTML = respuesta[1][index];
				select_status.appendChild(option_status);
			});
			let label_status = document.createElement('label');
			label_status.setAttribute('for', 'statusmarcacion_txt');
			label_status.innerHTML = 'Selecciona un status';
			container_input_1.appendChild(label_status);
			container_input_1.appendChild(select_status);
			// creacion de caja de calendario y la hora de agenda
			let container_fechahoras = document.createElement('div');
			container_fechahoras.classList.add('clase_columnaform');
			let container_input_2 = document.createElement('div');
			container_input_2.classList.add('formgroup');
			let container_input_33 = document.createElement('div');
			container_input_33.classList.add('formgroup');
			// container_fechahoras.style.display = 'none';
			let input_calendario = document.createElement('input');
			input_calendario.setAttribute('id', 'calendarioagenda_txt');
			input_calendario.setAttribute('name', 'calendarioagenda_txt');
			input_calendario.classList.add('calendario_jquery');
			input_calendario.setAttribute('readonly', '');
			let label_calendario = document.createElement('label');
			label_calendario.setAttribute('for', 'calendarioagenda_txt');
			label_calendario.innerHTML = "Fecha de agenda";
			container_input_2.appendChild(label_calendario);
			container_input_2.appendChild(input_calendario);

			let input_horas = document.createElement('select');
			input_horas.setAttribute('required', '');
			input_horas.setAttribute('id', 'horaagenda_txt');
			input_horas.setAttribute('name', 'horaagenda_txt');
			input_horas.classList.add('reloj_jquery');

			// agregamos las horas en rangos de media hora
			let values_horas = ['09','10','11','12','13','14','15','16','17','18', '19', '20'];
			let tags_horas = ['09','10','11','12','01','02','03','04','05','06','07', '08'];
			let tipo_tiempo = 'AM';


			let element_opcion_sel_horas0 = document.createElement('option');
			let text_opcion_sel_horas0 = document.createTextNode('Selecciona una hora');
			element_opcion_sel_horas0.appendChild(text_opcion_sel_horas0);
			element_opcion_sel_horas0.setAttribute('value', '');
			input_horas.appendChild(element_opcion_sel_horas0);

			for (let i = 0; i < values_horas.length; i++) {
				// values_horas[i]
				if(values_horas[i] == '12'){
					tipo_tiempo = 'PM';
				}
				let element_opcion_sel_horas = document.createElement('option');
				let text_opcion_sel_horas = document.createTextNode(tags_horas[i]+':00 '+tipo_tiempo);
				element_opcion_sel_horas.appendChild(text_opcion_sel_horas);
				element_opcion_sel_horas.setAttribute('value', values_horas[i]+':00:00');
				input_horas.appendChild(element_opcion_sel_horas);
				if(values_horas[i] != "20"){
					let element_opcion_sel_horas1 = document.createElement('option');
					let text_opcion_sel_horas1 = document.createTextNode(tags_horas[i]+':15 '+tipo_tiempo);
					element_opcion_sel_horas1.appendChild(text_opcion_sel_horas1);
					element_opcion_sel_horas1.setAttribute('value', values_horas[i]+':15:00');
					input_horas.appendChild(element_opcion_sel_horas1);

					let element_opcion_sel_horas2 = document.createElement('option');
					let text_opcion_sel_horas2 = document.createTextNode(tags_horas[i]+':30 '+tipo_tiempo);
					element_opcion_sel_horas2.appendChild(text_opcion_sel_horas2);
					element_opcion_sel_horas2.setAttribute('value', values_horas[i]+':30:00');
					input_horas.appendChild(element_opcion_sel_horas2);

					let element_opcion_sel_horas3 = document.createElement('option');
					let text_opcion_sel_horas3 = document.createTextNode(tags_horas[i]+':45 '+tipo_tiempo);
					element_opcion_sel_horas3.appendChild(text_opcion_sel_horas3);
					element_opcion_sel_horas3.setAttribute('value', values_horas[i]+':45:00');
					input_horas.appendChild(element_opcion_sel_horas3);

				}
			}

			let label_reloj = document.createElement('label');
			label_reloj.setAttribute('for', 'horaagenda_txt');
			label_reloj.innerHTML = "Hora de agenda";
			container_input_33.appendChild(label_reloj);
			container_input_33.appendChild(input_horas);

			container_fechahoras.appendChild(container_input_2);
			container_fechahoras.appendChild(container_input_33);

			// creacion de caja de comentarios
			let container_input_3 = document.createElement('div');
			container_input_3.classList.add('formgroup');
			let caja_comentario = document.createElement('textarea');
			caja_comentario.setAttribute('id', 'cajacomentario_txt');
			caja_comentario.setAttribute('name', 'cajacomentario_txt');
			let label_comentario = document.createElement('label');
			label_comentario.setAttribute('for', 'cajacomentario_txt');
			label_comentario.innerHTML = "Escribe un comentario";
			container_input_3.appendChild(label_comentario);
			container_input_3.appendChild(caja_comentario);

			// campos adicionales
			let otrodiv_formu = document.createElement('div');
			otrodiv_formu.classList.add('formulario_principal');
			otrodiv_formu.style.display = 'none';
			otrodiv_formu.setAttribute('id', 'cajaVenta');
			let cont_formulario_cabeza1 = document.createElement('div');
			cont_formulario_cabeza1.classList.add('formulario_cabecera');
			cont_formulario_cabeza1.innerHTML = 'Informacion de captura';
			otrodiv_formu.appendChild(cont_formulario_cabeza1);
			console.log(respuesta[3]);
			Object.keys(respuesta[3]).forEach(function(index){
				let cajaform = document.createElement('div');
				cajaform.classList.add('formgroup');
				let label_campo1 = document.createElement('label');
				label_campo1.setAttribute('for', respuesta[3][index][2]);
				label_campo1.innerHTML = respuesta[3][index][0];
				let input_campo1;
				if(respuesta[3][index][1] == 'select'){
					input_campo1 = document.createElement('select');
					input_campo1.setAttribute('onchange', 'manejador__select_'+respuesta[3][index][2]+'(this)');
					let option_campo = document.createElement('option');

					if(respuesta[3][index][2] == 'oferta_realizada'){

						option_campo.innerHTML = 'Selecciona una opcion';
						option_campo.setAttribute('value', '');
						option_campo.setAttribute('selected', '');
						option_campo.setAttribute('data-valor', costopaqueteactual);
						input_campo1.appendChild(option_campo);


						input_campo1.setAttribute('onchange', 'manejador__select_ofertaamigo(this)');
						let option_campo15 = document.createElement('option');
						let nodoa = document.createTextNode('Mantiene su paquete');
						option_campo15.appendChild(nodoa);
						option_campo15.setAttribute('value', '0');
						option_campo15.setAttribute('data-valor', costopaqueteactual);
						input_campo1.appendChild(option_campo15);
					}else{
						option_campo.innerHTML = 'Selecciona una opcion';
						option_campo.setAttribute('value', '');
						option_campo.setAttribute('selected', '');
						option_campo.setAttribute('data-valor', 0);
						input_campo1.appendChild(option_campo);
					}

					for(let ia = 0; ia < respuesta[3][index][3].length; ia++){
						let option_campo = document.createElement('option');
						option_campo.innerHTML = respuesta[3][index][3][ia][0];
						option_campo.setAttribute('value', respuesta[3][index][3][ia][1]);
						option_campo.setAttribute('data-valor', respuesta[3][index][3][ia][2]);
						input_campo1.appendChild(option_campo);
					}
					input_campo1.setAttribute('id', respuesta[3][index][2]);
					input_campo1.setAttribute('name', respuesta[3][index][2]);
				}else{
					if(respuesta[3][index][1] == 'grupo_checkbox'){
						input_campo1 = document.createElement('div');
						input_campo1.classList.add('container_checks');
						for(let ia = 0; ia < respuesta[3][index][3].length; ia++){
							let label_campo = document.createElement('label');
							let div_check = document.createElement('div');
							div_check.classList.add('checkin');
							label_campo.setAttribute('for', respuesta[3][index][3][ia][1]+'_'+ia);
							label_campo.innerHTML = respuesta[3][index][3][ia][0];

							let check_campo = document.createElement('input');
							check_campo.setAttribute('type', 'checkbox');
							check_campo.setAttribute('id', respuesta[3][index][3][ia][1]+'_'+ia);
							if(respuesta[3][index][2] == 'adicional_mb_extra_cv'){
								check_campo.setAttribute('name', respuesta[3][index][2]);		
							}else{
								check_campo.setAttribute('name', respuesta[3][index][2]+'[]');
							}
							check_campo.setAttribute('value', respuesta[3][index][3][ia][1]);
							check_campo.setAttribute('onchange', 'manejador_cambiochecksregistro(this)');
							check_campo.setAttribute('data-valor', respuesta[3][index][3][ia][2]);
							let multiplos = respuesta[3][index][3][ia][3];
							div_check.appendChild(check_campo);
							if(multiplos != '0'){
								let campo_opcion = document.createElement('select');
								campo_opcion.setAttribute('onchange', 'manejador__select_cantidades(this)');
								campo_opcion.setAttribute('data-name', respuesta[3][index][3][ia][1]+'_valor');
								let valor = "1";
								let contenido = "1";
								for(let kas = 1; kas <= multiplos; kas++){
									let opcion_sel = document.createElement('option');
									if(kas == 1){
										opcion_sel.setAttribute('value', valor);
										opcion_sel.setAttribute('selected', '');
									}else{
										opcion_sel.setAttribute('value', kas);
										contenido = kas;
									}
									let nodot = document.createTextNode(contenido);
									opcion_sel.appendChild(nodot);
									campo_opcion.appendChild(opcion_sel);
								}
								div_check.appendChild(campo_opcion);
							}
							div_check.appendChild(label_campo);
							input_campo1.appendChild(div_check);
						}
						input_campo1.setAttribute('id', respuesta[3][index][2]);
					}else{
						if(respuesta[3][index][1] == 'calendario'){
							input_campo1 = document.createElement('input');
							input_campo1.classList.add('calendario_jquery_instalacion');
							input_campo1.setAttribute('id', respuesta[3][index][2]);
							input_campo1.setAttribute('name', respuesta[3][index][2]);
							input_campo1.setAttribute('readonly', '');
						}else{
							if(respuesta[3][index][1] == 'grupo_radio'){
								input_campo1 = document.createElement('div');
								input_campo1.classList.add('container_checks');
								for(let ia = 0; ia < respuesta[3][index][3].length; ia++){
									let label_campo = document.createElement('label');
									let div_check = document.createElement('div');
									div_check.classList.add('checkin');
									label_campo.setAttribute('for', respuesta[3][index][3][ia][1]+'_'+ia);
									label_campo.innerHTML = respuesta[3][index][3][ia][0];

									let check_campo = document.createElement('input');
									check_campo.setAttribute('type', 'radio');
									check_campo.setAttribute('id', respuesta[3][index][3][ia][1]+'_'+ia);
									check_campo.setAttribute('name', respuesta[3][index][2]);
									check_campo.setAttribute('value', respuesta[3][index][3][ia][1]);
									check_campo.setAttribute('onchange', 'manejador_cambioradioregistro(this)');
									check_campo.setAttribute('data-valor', respuesta[3][index][3][ia][2]);
									let multiplos = respuesta[3][index][3][ia][3];
									div_check.appendChild(check_campo);
									if(multiplos != '0'){
										let campo_opcion = document.createElement('select');
										campo_opcion.setAttribute('data-name', respuesta[3][index][3][ia][1]+'_valor');
										let valor = "";
										let contenido = "0";
										for(let kas = 0; kas <= multiplos; kas++){
											let opcion_sel = document.createElement('option');
											if(kas == 0){
												opcion_sel.setAttribute('value', valor);
											}else{
												opcion_sel.setAttribute('value', kas);
												contenido = kas;
											}
											let nodot = document.createTextNode(contenido);
											opcion_sel.appendChild(nodot);
											campo_opcion.appendChild(opcion_sel);
										}
										div_check.appendChild(campo_opcion);
									}
									div_check.appendChild(label_campo);
									input_campo1.appendChild(div_check);
								}
								input_campo1.setAttribute('id', respuesta[3][index][2]);
							}else{
								if(respuesta[3][index][1] == 'textarea'){
									input_campo1 = document.createElement('textarea');
									input_campo1.setAttribute('id', respuesta[3][index][2]);
									input_campo1.setAttribute('name', respuesta[3][index][2]);
								}else{	
									if(respuesta[3][index][1] == 'enlace'){
										input_campo1 = document.createElement('a');
										input_campo1.innerHTML = "enlace para hoja de captura";
										input_campo1.setAttribute('id', respuesta[3][index][2]);
										input_campo1.setAttribute('href', respuesta[3]["0"][3]["0"][2]);
										input_campo1.setAttribute('target', "_BLANK");
										input_campo1.classList.add("enlace_style");
										input_campo1.setAttribute('name', respuesta[3][index][2]);
									}else{

										input_campo1 = document.createElement('input');
										input_campo1.setAttribute('id', respuesta[3][index][2]);
										input_campo1.setAttribute('name', respuesta[3][index][2]);
									}
								}
							}
						}
					}
				}

				cajaform.appendChild(label_campo1);
				cajaform.appendChild(input_campo1);
				otrodiv_formu.appendChild(cajaform);

			});
			// comentario de ayuda
			let cajaform123 = document.createElement('div');
			cajaform123.classList.add('formgroup_1_1');
			cajaform123.setAttribute('id', 'cajatotalesamigo');


			let input_preciototal  = document.createElement('input');
			let label_input = document.createElement('label');


			label_input.setAttribute('for', 'precio_totaltxt');
			label_input.innerHTML = "Precio diferencia: ";
			input_preciototal.value = "0";
			input_preciototal.setAttribute('id', 'precio_totaltxt');
			input_preciototal.setAttribute('readonly', '');

			let boton_enviar1 = document.createElement('button');
			boton_enviar1.innerHTML = "Enviar";
			boton_enviar1.setAttribute('type', 'submit');
			boton_enviar1.setAttribute('name', 'enviar_registro');
			boton_enviar1.setAttribute('id', 'enviar_registro');


			cajaform123.appendChild(label_input);
			cajaform123.appendChild(input_preciototal);
			cajaform123.appendChild(boton_enviar1);
			otrodiv_formu.appendChild(cajaform123);

			// agregamos un boton enviar ... dah!
			let boton_enviar = document.createElement('button');
			boton_enviar.innerHTML = "Enviar";
			boton_enviar.setAttribute('type', 'submit');
			boton_enviar.setAttribute('name', 'enviar_registro1');
			boton_enviar.setAttribute('id', 'enviar_registro1');
			let container_input_4 = document.createElement('div');
			container_input_4.classList.add('formulario_principal_2');
			container_input_4.appendChild(boton_enviar);
			// otrodiv_formu.appendChild(container_input_4);

			// agregamos todo
			form_table.appendChild(input_idregistro);
			form_table.appendChild(input_idregistro1);
			form_table.appendChild(container_select_telefonos);
			form_table.appendChild(container_input_11);
			let campaniaIddd = document.querySelector("#campania_id_marcador");

			if(campaniaIddd.innerHTML == "211"){
				form_table.appendChild(container_input_giro);
			}

			form_table.appendChild(container_input_1);
			form_table.appendChild(container_fechahoras);
			form_table.appendChild(container_input_3);
			cont_formulario_principal.appendChild(form_table);
			
			formulario.appendChild(cont_formulario_principal);
			formulario.appendChild(otrodiv_formu);
			formulario.appendChild(container_input_4);
			container_form.appendChild(formulario);
		}
	}
}
function limpiarCajas(){
	let cajaventa = document.querySelector('#cajaVenta');
	let selects = cajaventa.querySelectorAll('select');
	selects.forEach(function(elemento){
		elemento.value = '';
		elemento.removeAttribute('required');
	});
	let cajas = cajaventa.querySelectorAll('input[type=text]');
	cajas.forEach(function(elemento){
		elemento.value = '';
		elemento.removeAttribute('required');
	});
	let textarea = cajaventa.querySelectorAll('textarea');
	textarea.forEach(function(elemento){
		elemento.value = '';
		elemento.removeAttribute('required');
	});
	let checkbox = cajaventa.querySelectorAll('input[type=checkbox]');
	checkbox.forEach(function(elemento){
		elemento.checked = false;
		elemento.removeAttribute('required');
	});
	let radio = cajaventa.querySelectorAll('input[type=radio]');
	radio.forEach(function(elemento){
		elemento.checked = false;
		elemento.removeAttribute('required');
	});
}
function manejador__select_telefonos_onchange (elemento){
}
function manejador_cambiochecksregistro(elemento){
	let padre_div = elemento.parentNode;
	let select_com = padre_div.querySelector('select');
	
	if(select_com != null){
		select_com.value = '1';
		if(elemento.checked){
			select_com.setAttribute('name', select_com.dataset.name);
			select_com.setAttribute('required', '');
		}else{
			select_com.removeAttribute('name');
			select_com.removeAttribute('required');
		}
	}
	let campania_id_marcador = document.querySelector('#campania_id_marcador');
	let campania_id = campania_id_marcador.innerHTML;
	switch(campania_id){
		case '175':
		calcularPrecio_cv();
		break;
		case '176':
		calcularPrecio();
		break;
		case '22':
		calcularPrecio();
		break;
		case '211':
		calcularPrecio();
		break;
		case '206':
		calcularPrecio_adicionales();
		break;
		case '220':
		calcularPrecio();
		break;

		default:
		break;
	}
}

function manejador_clic_enviar_btn_validado(){
	let cajaa = document.querySelector('#claveValidacion_txt');
	let cajacontra = cajaa.value;
	let ruta_validar = 'assets/php/validarContrasenia.php?contra_txt='+cajacontra;
	ajax__contraseniaValidacion(ruta_validar, manejador_validarcontrasenia);
}
function ajax__contraseniaValidacion(ruta_, callback_){
	let peticion = new XMLHttpRequest();
	let ruta = ruta_;
	peticion.onreadystatechange = function(){
		if(peticion.readyState == 4 && peticion.status == 200){
			callback_(peticion.responseText);
		}
	}
	peticion.open('GET', ruta, true);
	peticion.send(null);
}
function manejador_validarcontrasenia(response){
	let respuesta = JSON.parse(response);
	let campania_id = campania_id_marcador.innerHTML;
	let campo_contra = document.querySelector('#idvalidador_txt');
	let formulario = document.querySelector('#container_form form');
	
	let input_total = document.createElement('input');
	let input_diferencia = document.createElement('input');
	let precio_totaltxt;
	let oferta_realizada;

	campo_contra.value = '';
	switch(campania_id){
		case '175':

		input_total.setAttribute('name', 'input_total');
		input_diferencia.setAttribute('name', 'input_diferencia');
		input_total.setAttribute('type', 'hidden');
		input_diferencia.setAttribute('type', 'hidden');
		precio_totaltxt = document.querySelector('#precio_totaltxt').value;
		oferta_realizada = precio_totaltxt;
		input_total.value = precio_totaltxt;
		input_diferencia.value = oferta_realizada;

		break;
		case '22':

		input_total.setAttribute('name', 'input_total');
		input_diferencia.setAttribute('name', 'input_diferencia');
		input_total.setAttribute('type', 'hidden');
		input_diferencia.setAttribute('type', 'hidden');
		precio_totaltxt = document.querySelector('#precio_totaltxt').value;
		oferta_realizada = document.querySelector('#oferta_realizada option:nth-child(1)').dataset.valor;
		input_total.value = precio_totaltxt;
		input_diferencia.value = oferta_realizada;

		break;
		case '176':
		input_total.setAttribute('name', 'input_total');
		input_diferencia.setAttribute('name', 'input_diferencia');
		input_total.setAttribute('type', 'hidden');
		input_diferencia.setAttribute('type', 'hidden');
		precio_totaltxt = document.querySelector('#precio_totaltxt').value;
		oferta_realizada = precio_totaltxt;
		input_total.value = precio_totaltxt;
		input_diferencia.value = oferta_realizada;
		break;
		case '206':
		input_total.setAttribute('name', 'input_total');
		input_diferencia.setAttribute('name', 'input_diferencia');
		input_total.setAttribute('type', 'hidden');
		input_diferencia.setAttribute('type', 'hidden');
		precio_totaltxt = document.querySelector('#precio_totaltxt').value;
		oferta_realizada = precio_totaltxt;
		input_total.value = precio_totaltxt;
		input_diferencia.value = oferta_realizada;
		break;
		case '211':
		input_total.setAttribute('name', 'input_total');
		input_diferencia.setAttribute('name', 'input_diferencia');
		input_total.setAttribute('type', 'hidden');
		input_diferencia.setAttribute('type', 'hidden');
		precio_totaltxt = document.querySelector('#precio_totaltxt').value;
		oferta_realizada = precio_totaltxt;
		input_total.value = precio_totaltxt;
		input_diferencia.value = oferta_realizada;
		break;
		case '220':
		input_total.setAttribute('name', 'input_total');
		input_diferencia.setAttribute('name', 'input_diferencia');
		input_total.setAttribute('type', 'hidden');
		input_diferencia.setAttribute('type', 'hidden');
		precio_totaltxt = document.querySelector('#precio_totaltxt').value;
		oferta_realizada = document.querySelector('#oferta_realizada option:nth-child(1)').dataset.valor;
		input_total.value = precio_totaltxt;
		input_diferencia.value = oferta_realizada;

		break;

		default:
		break;
	}
	formulario.appendChild(input_total);
	formulario.appendChild(input_diferencia);
	if (respuesta.conteo == 1) {
		campo_contra.value = respuesta.idEmpleado;
		alert('se procede a enviar');
		if(campania_id == '22'){
			agregar_inputs_bo();
		}
		formulario.submit();
	} else {
		if (1 < respuesta.conteo) {
			alert('pide que te cambien tu contraseña antes de proceder');
		} else {
			alert('Privilegios insuficientes');
		}
	}	
}
function manejador__select_adicional_horario_instalacion() {
}
function manejador_clic_cerrarmodal(){
	let moal = document.querySelector('#modalValidacion__1');
	moal.style.display = 'none';
}
// check de la tv de bo
function manejador_check_tv_adicional_bo(){
	let tv_adicional_bo = document.querySelector('#tv_adicional_bo');
	let valorpp = 0;
	if(tv_adicional_bo.checked){
		calculadora_tv_bo();
	}else{
		tv_adicional_bo.value = valorpp;	
	}
}
function calculadora_tv_bo(){
	// let tv_adicional_bo = document.querySelector('#tv_adicional_bo');
	// let valor_x_uno=  tv_adicional_bo.dataset.valor;
	let elemento_select = document.querySelector('#select_cantidades_check').selectedIndex;
	let cantidad_tv_adicionales = document.querySelector('#select_cantidades_check option:nth-child('+(elemento_select + 1)+')').innerHTML;
	// let variable_ = parseInt(valor_x_uno) * parseInt(cantidad_tv_adicionales);

	tv_adicional_bo.value = cantidad_tv_adicionales;
}
// check de cantidad de las tv de bo
function manejador__select_cantidades_bo(){
	calculadora_tv_bo();
}
// select de internet crecelo
function manejador__select_adicional_internet_crecelo_bo(){
}
// agregar campos de bo
function agregar_inputs_bo(){
	let input_tvadicional = document.createElement('input');
	input_tvadicional.setAttribute('name', 'adicional_tvadicional_bo');
	let input_internetcrecelo = document.createElement('input');
	input_internetcrecelo.setAttribute('name', 'adicional_internetcrecelo_bo');
	let tv_adicional_bo = document.querySelector('#tv_adicional_bo').value;
	let adicional_internet_crecelo_bo = document.querySelector('#adicional_internet_crecelo_bo').value;
	input_tvadicional.value = tv_adicional_bo;
	input_internetcrecelo.value = adicional_internet_crecelo_bo;

	input_tvadicional.style.display = 'none';
	input_internetcrecelo.style.display = 'none';


	let formulario_pe = document.querySelector('#container_form form');
	formulario_pe.appendChild(input_tvadicional);
	formulario_pe.appendChild(input_internetcrecelo);
}

/************************************************************/
