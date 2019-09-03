<!-- Solo falta agregar el insert del form y quedara listo de nuevo el chat 2.0 -->

<?php
include 'assets/includes/header.inc';
?>

<link href="mensaje/css/chatstyle.css" rel="stylesheet" type="text/css" />



<p class="idempleado" style="display:none;" value="<?php echo $_SESSION['idEmpleado']?>"><?php echo $_SESSION['idEmpleado']?></p>


<div class="caja-principal">
	<div class="contenido">
		<div class="datos-chat"></div>
	</div>
	<div class="para">
		<form action="#" method="post"> 
			<select class="chosen-select" name="nroemp" id="nroemp" onchange="verMsj(this)">
				<option selected="" disable value="">Selecciona un empleado</option>
				<?php
				$conexion57 = mysql_connect("172.30.27.40", "root", "4LC0M");
           		 // $conexion57 = mysql_connect("172.30.27.57", "ash", "doces");

                 // $req_agentes = "SELECT emp_Nroemp, emp_nombrecompleto FROM adcom.empleados where emp_fchbaja is null and tipo_emp = 'int'";
				$req_agentes1 ="SELECT emp_Nroemp, CONCAT(emp_Nroemp,' ', emp_nombrecompleto) as nombrecomple from adcom.empleados where emp_proyecto in (71,73,22,176,76,220,211) and emp_fchbaja is null and emp_puesto = '1' ";

                 // $sql_agentes = mysql_query($req_agentes, $conexion40)or die("error: ".mysql_error());
				$sql_agentes1 = mysql_query($req_agentes1, $conexion57)or die("error: ".mysql_error());


				while ($res_agentes = mysql_fetch_array($sql_agentes1)) {
					echo "<option value='".$res_agentes['emp_Nroemp']."'>".$res_agentes['nombrecomple']."</option>";
				}
				?>
			</select>

			<div class="flex">
				<textarea name="usuariomsg" type="text" id="usuariomsg"  rows="6" cols="120"></textarea>
			</div>
			<div class="flex">
				<select name="prioridad" id="prioridad">
					<option value="1">RRHH</option>
					<option value="2">CORD</option>
					<option value="3">BO</option>
					<option value="4">GENE</option>
				</select>
				<input name="enviarmsg" type="submit" id="enviarmsg"  value="Enviar">
			</div>
		</form>


	</div>   
</div>

<div class="circulo RH"> RH </div>
<div class="circulo BO"> BO </div>
<div class="circulo CORD"> CORDI </div>
<div class="circulo GENE"> GENE </div>

<div class="contRH" style="display:none;">
	<div class="burbuja tri-right left-in animacion fade">
		<div class="talktext" id ="rh">
			
		</div>
	</div>
</div>

<div class="contBO" style="display:none;">
	<div class="burbuja2 tri-right2 left-in2 animacion fade">
		<div class="talktext" id="bo">

		</div>
	</div>
</div>

<div class="contCORDI" style="display:none;">
	<div class="burbuja3 tri-right3 left-in3 animacion fade">
		<div class="talktext" id="cordi">
			
		</div>
	</div>
</div>

<div class="contGENE" style='display:none;'>
	<div class="burbuja4 tri-right4 left-in4 animacion fade">
		<div class="talktext" id="gene">
			
		</div>
	</div>
</div>

<?php 
$mensaje = $_REQUEST['usuariomsg'];
$tipomensaje = $_REQUEST['prioridad'];
$receptor = $_REQUEST['nroemp'];
$emisor = $_SESSION['idEmpleado'];
$fechasend = date('Y-m-d h:i:s');
$fechaleido = date("Y-m-d h:i:s",strtotime($fechasend."+ 1 hour")); 



if (isset($_REQUEST['enviarmsg']) && isset($_REQUEST['enviarmsg'])) {
	$consultaChat = "INSERT INTO marcador_manual.mensajes_directos(nEmpEmisor, mensaje, tipomensaje,nEmpReceptor,fechaEnvio,FechaVisto) VALUES ('{$emisor}' , '{$mensaje}','{$tipomensaje}','{$receptor}','{$fechasend}','{$fechaleido}')";
	echo $consultaChat;
        // echo "-".$nombre. " -".$mensaje. " -".$tipomensaje. " -".$receptor. " -".$emisor. " -".$fechasend ;
}

?>

<script>
	document.addEventListener('DOMContentLoaded', function(){
		$(".chosen-select").chosen();

		var file = $('#filecount').html();
		$('#archivo_txt').change(function(event) {
			var arreglo_ruta = $(this).val().split( '\\' ).pop();
			file = $('#filecount').html(arreglo_ruta);
			if ($(this).val() != "") {
				$('.upcsv').css('opacity', '.1');
			}
		});	
		
		document.querySelector('#enviarmsg').addEventListener('click',verificar);
		

		var tempo = setInterval(ImprimirNotif, 3000);

	});

	
	
	function verificar(elemento){
				let cajatexto = document.querySelector('#usuariomsg');
				let usuario = document.querySelector('#nroemp')
				if(cajatexto.value == "" || usuario.value == ""){
					elemento.preventDefault();
					alert('El usuario/mensaje no debe ir vacio');
				}
				console.log(cajatexto.value);
			}

	function verMsj(elemento) {
		let empleado = elemento;
		
		let ruta = 'assets/php/chatmensajes.php'

		let FormAmigo = new FormData();
		FormAmigo.append('nroemp',empleado.value);

		let peticion ={
			method: "POST",
			header: {
				'Content-Type': 'application/json'
			},
			body: FormAmigo,
			mode: 'no-cors'
		};

		fetch(ruta, peticion).then(response => response.json().then(datos => manejador_chat(datos)).catch(error => console.log(error))).catch(error => console.log(error));
	}
		function manejador_chat(datos) {
			let contenido_chat = document.querySelector('.datos-chat');

			while (contenido_chat.firstChild) {
				contenido_chat.removeChild(contenido_chat.firstChild);
			}

			datos.forEach(datos_chat => {

				switch (datos_chat[2]) {
					case '1':
						datos_chat[2] = "RH"
						break;
					case '2':
						datos_chat[2] = "Cordi"
					break;
					case '3':
						datos_chat[2] = "BO"
					break;
					case '4':
						datos_chat[2] = "General"
					break;
					default:
						break;
				}


				let contenidotexto = document.createElement('div');
				contenidotexto.className = 'texto';
				contenido_chat.appendChild(contenidotexto);
				
				let separacion = document.createElement('hr');
				separacion.style.width = "80%";
				separacion.style.borderTop = "1px dashed grey";
				contenido_chat.appendChild(separacion);

				let tipomensaje = document.createElement('span');
				tipomensaje.innerHTML = datos_chat[2] + ": ";
				tipomensaje.style.fontFamily = "Open Sans, sans-serif";
				tipomensaje.style.color = "#1C62C4";


				let mensaje = document.createElement('span');
				mensaje.innerHTML = datos_chat[1];
				mensaje.style.fontFamily = "Open Sans, sans-serif";
				mensaje.style.color = "#848484";

				contenidotexto.appendChild(tipomensaje);
				contenidotexto.appendChild(mensaje);
				

				let fecha = document.createElement('span');
				fecha.style.fontFamily = "Open Sans, sans-serif";
				fecha.style.marginTop = "4px"
				fecha.style.fontSize = "12px";
				fecha.style.cssFloat = "right"
				fecha.innerHTML = datos_chat[0] + " - " + datos_chat[3];

				contenidotexto.appendChild(fecha);


			});

		}

		

		
		function ImprimirNotif() {
			let empleado = document.querySelector('.idempleado');
			
			let ruta = "assets/php/mensajes.php"
			
			let Forma = new FormData();
			Forma.append('empleado',empleado.innerHTML);
			
			let peticion = {
				method: "POST",
				header: {
					'Content-Type': 'application/json'
				},
				body: Forma,
				mode: 'no-cors'
			};
			// console.log(empleado.innerHTML)
			fetch(ruta, peticion).then(response => response.json().then(datos => chatdecaca(datos)).catch(error => console.log(error))).catch(error => console.log(error));
		}
		
		function borrar(datamamon) {
			while(datamamon.firstChild){
				datamamon.removeChild(datamamon.firstChild)
			}
		}


		function chatdecaca(datos){
			if (datos === null || datos == ''){
				clearInterval(tempo);
			}
			//Contenedores
			let notifRH = document.querySelector('.contRH');
			let notifBO = document.querySelector('.contBO');
			let notifCORDI = document.querySelector('.contCORDI');
			let notifGENE = document.querySelector('.contGENE');

			//<P>
			let textoRH = document.querySelector('#rh');
			let textoBO = document.querySelector('#bo');
			let textoCORDI = document.querySelector('#cordi');
			let textoGENE = document.querySelector('#gene');



			datos.forEach(chat_data => {
				switch (chat_data[0]) {
					case '1':
						borrar(textoRH);
						let pRH = document.createElement('p');
						pRH.innerHTML = chat_data[1];
						textoRH.appendChild(pRH);
						notifRH.style.display = "block";

						break;
					case '2':
						borrar(textoBO);
						let pBO = document.createElement('p');
						pBO.innerHTML = chat_data[1];
						textoBO.appendChild(pBO);
						notifBO.style.display = "block";
						break;
					case '3':
						borrar(textoCORDI);
						let pCORDI = document.createElement('p');
						pCORDI.innerHTML = chat_data[1];
						textoCORDI.appendChild(pCORDI);
						notifCORDI.style.display = "block";
						break;
					case '4':
						borrar(textoGENE);
						let pGENE = document.createElement('p')
						pGENE.innerHTML = chat_data[1];
						textoGENE.appendChild(pGENE);
						notifGENE.style.display = "block"
					break;	
					default:
						break;
				}
			});
		
			// console.log(datos);
		}
		

	</script>