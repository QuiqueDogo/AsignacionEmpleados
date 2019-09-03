<?php 
include 'assets/includes/header.inc';
$barrio = array(3733,4134,3902,2898,3064,3505,2262,2741,1679,3710,4338);


if(!in_array($_SESSION['idEmpleado'], $barrio) ){
	die("No tienes permisos amigoooooo");	
}else{


	?> 
	<style>
	* {
		font-size: .9rem;
	}

	.tablita th {
		padding: 8px !important;
		box-sizing: border-box;
	}

	.potter_cont {
		width: 30%;
		margin-bottom: 40px;
		display: flex;
		flex-direction: column;
	}

	.potter_cont button {
		margin-top: 15px;
	}

	.botones {
		display: flex;
	}

	.botones button {
		margin-right: 10px;
	}

	.tablita {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: flex-start;
	}
	.colorsin {
		background: tomato;
		color: #fff;
	}
</style>
<div class="potter_cont">

	<label>Supervisor</label>
	<select id="supervisor" name="supervisor">
		<option value="0" selected hidden>Selecciona una opción</option>
		<option value="2741">BERTHA LILIA GONZALEZ TALANCON</option>
		<option value="1980">YULIANA YUNUEN RODRIGUEZ RODRIGUEZ</option>
		<option value="3505">GABRIELA TORRES PEDRAZA</option>
		<!--<option value="1679">RODRIGO ACOSTA</option>-->
		<option value="2262">CARLOS ALBERTO CASTAÑEDA PASCUAL</option>
		<option value="3064">GIOVANNY QUETZAL PINA LEON</option>
		<option value="3902">OSCAR MORALES MATEOS</option>
	</select>
	<button id="recargar">Buscar</button>
</div>
<img src="assets/img/perrito.gif" id="loader" style="display: none;" alt="">
<div class="tablita" style="display: none">
	<h2 id='conteo'></h2>
	<h2 id='conteo2'></h2>
	<h2 id='conteo3'></h2>
	<h2 id='conteo4'></h2>
	<table class="tablaform" style="text-align: center;">
		<thead>
			<th>Agente</th>
			<th>Nombre</th>
			<th id="upsell">Upsell</th>    
			<th id="upgrade">Upgrade</th>    
			<th id="negocios">Negocios</th>    
			<th id="empresarial">Empresarial</th>    
			<th></th>    
			<th></th>    
		</thead>
		<tbody id="manejador">

		</tbody>
	</table>

</div>


<?php
}
?>
<script>
// Nota (16-07-2019)
// =================================================================================================
// =																							   =
// =  PD: Si llego a irme y esto se llega a usar, las asignaciones de folios las toman a partir    =
// =  del numero de empleado al que le subieron la base. Por ejemplo Upgrade esta al numero 3733.  =
// =  Solo deben cargarse a su numero de empleado la base y remplazar las consultas con su numero  =
// =  de empleado.   Las consultas estan en assets/php y las ubicaciones estan en las peticiones   =
// =  fetch. 																					   =
// =	-Q																						   =
// =																							   =
// =================================================================================================




	document.querySelector('#recargar').addEventListener('click', TraemeEsta)

	function TraemeEsta(argument) {
		let perrito = document.querySelector("#loader");
		if (perrito.style.display == 'none' && perrito.classList == 'cargado') {
			perrito.style.display = 'none';
		}else if(perrito.style.display == 'none'){
			perrito.style.display = 'block';
			perrito.classList.add('cargado');		
		}

		let supervisor = document.querySelector('#supervisor');
		let campana;
		if (supervisor.value == '2262') {
			campana = 176;
		}else{
			campana = 22;
		}

		let ruta = "assets/php/nuevoasignador2.php"

		let FormEsta = new FormData()
		FormEsta.append('super', supervisor.value)
		FormEsta.append('campa', campana)		

		let PeticionFetch = {
			method: "POST",
			header : {
				'Content-Type': 'application/json'
			},
			body: FormEsta,
			mode: 'no-cors'
		}

		fetch(ruta, PeticionFetch).then(response => response.json().then(datos => Tablita(datos)).catch(error => console.log(error))).catch(error => console.log(error))
	}

	

	function Tablita(datos){
		let superchido = document.querySelector('#supervisor');
		let campana22 = document.querySelector('#upsell');
		let campana176 = document.querySelector('#upgrade');
		let campana211 = document.querySelector('#negocios');
		let campana220 = document.querySelector('#empresarial');
		let perrito = document.querySelector("#loader");
		if(superchido.value == "2741" || superchido.value == "3505" || superchido.value == "1679" || superchido.value == "3902"){
			campana22.style.display = "table-cell"
			campana211.style.display = "none";
			campana220.style.display = "none";
		}else if(superchido.value == "2262"){
			campana22.style.display = "table-cell";
			campana211.style.display = "none";
			campana220.style.display = "none";
		}else if(superchido.value == "3064"){
			campana22.style.display = "table-cell";
			campana211.style.display = "table-cell";
			campana220.style.display = "table-cell";
		}
		perrito.style.display = 'none';
		// console.log(datos)
		document.querySelector('.tablita').style.display = 'flex'
		let tbody = document.querySelector('#manejador');
		let conteo = datos[0];
		let conteo2 = datos[1];
		let conteo3 = datos[2];
		let conteo4 = datos[3];
		let contador = document.querySelector('#conteo');
		let contador2 = document.querySelector('#conteo2');
		let contador3 = document.querySelector('#conteo3');
		let contador4 = document.querySelector('#conteo4');
		contador.innerHTML = '';
		contador.innerHTML = 'Restantes en base upsell: '+ conteo;
		contador2.innerHTML = '';
		contador2.innerHTML = 'Restantes en base upgrade: '+ conteo2;
		contador3.innerHTML = '';
		contador3.innerHTML = 'Restantes en base negocios: '+ conteo3;
		contador4.innerHTML = '';
		contador4.innerHTML = 'Restantes en base empresariales: '+ conteo4;

		while (tbody.firstChild) {
			tbody.removeChild(tbody.firstChild);
		}
		datos.shift();
		datos.shift();
		datos.shift();
		datos.shift();
		console.log(datos);
		datos.forEach( function(agentes, index) {
			let losTR = document.createElement('tr')
			agentes.forEach( function(element, index) {
				if (typeof element == 'object') {
					element = '0'
				}
				let losTD = document.createElement('td')
				losTD.innerHTML = element
				losTR.appendChild(losTD)
				tbody.appendChild(losTR)
			});
			//boton Asignar
			let tdbotonAsig = document.createElement('td')
			let botonAsig = document.createElement('button')
			botonAsig.className = 'nuevoooooos'
			botonAsig.addEventListener('click', Asignamiento)
			botonAsig.innerHTML = 'Asignar'
			botonAsig.value = agentes[0]
			tdbotonAsig.appendChild(botonAsig)
			losTR.appendChild(tdbotonAsig)

			//boton Limpiar base segun jajaja
			let tdbotonLimpiar = document.createElement('td')
			let botonLimpiar = document.createElement('button')
			botonLimpiar.className = 'nuevoooooos'
			botonLimpiar.addEventListener('click', LimpiameEsta)
			botonLimpiar.innerHTML = 'Mover Base'
			botonLimpiar.value = agentes[0]
			tdbotonLimpiar.appendChild(botonLimpiar)
			losTR.appendChild(tdbotonLimpiar)

		});
	}

	

	function Asignamiento(elemento){
		let idEmp = elemento.target
		let supervisor = document.querySelector('#supervisor');
		let selectcampa = 0;

		if (supervisor.value == 2262) {
			selectcampa = 176;
		}else{
			selectcampa = prompt('Que campaña asignaras? (Upsell:22, Upgrade:176, Empresarial:220, Negocios: 211) Escribe el numero')
		}



		let ruta = "assets/php/asignadorRegistros.php"

		let FormDelAsignamiento = new FormData()
		FormDelAsignamiento.append('empleado', idEmp.value)
		FormDelAsignamiento.append('super', supervisor.value)
		FormDelAsignamiento.append('campana', selectcampa)

		let PeticionFetch = {
			method: "POST",
			header : {
				'Content-Type': 'application/json'
			},
			body: FormDelAsignamiento,
			mode: 'no-cors'
		}
		


		fetch(ruta, PeticionFetch).then(response => response.json().then(datos => alert(datos)).catch(error => console.log(error))).catch(error => console.log(error));
		//Para actualizar cuando asignas registros
		TraemeEsta();


	}

	function LimpiameEsta(elemento){
		let idEmp = elemento.target;
		let supervisor = document.querySelector('#supervisor');
		let campana = 0;

		if (supervisor.value == 2262){
			campana = 176;
		}else if (supervisor.value == "3505" || supervisor.value == "1679" || supervisor.value == "2741" || supervisor.value =="1980") {
			campana = prompt('Que campaña vas mover? (Upsell:22, Upgrade:176) Escribe el numero');
		}else if (supervisor.value == "3064") {
			campana = prompt('Que campaña vas mover? (Upsell:22, Upgrade:176, Empresarial:220, Negocios: 211) Escribe el numero');			
		}

		let ruta = "assets/php/limpiador.php";

		let formularioLimpieza = new FormData();
		formularioLimpieza.append('agente', idEmp.value);
		formularioLimpieza.append('supervisor', supervisor.value);
		formularioLimpieza.append('idcampana', campana);

		let peticionFETCH ={
			method: "POST",
			header: {
				'Content-Type': 'application/json'
			},
			body: formularioLimpieza,
			mode: 'no-cors'
		};

		fetch(ruta, peticionFETCH).then(response => response.json().then(datos => alert(datos)).catch(error => console.log(error))).catch(error => console.log(error));
		//Para actualizar cuando mueves registros
		TraemeEsta();
	}




</script>
