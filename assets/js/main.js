document.addEventListener('DOMContentLoaded', () => {
	let recuperarBO = document.querySelector('#recuperarBO');
	if(recuperarBO != null){
		recuperarBO.addEventListener('click', manejador__tomarregistro_bo);
	}
});

function manejador__tomarregistro_bo(){
	let ruta = "assets/php/tomarregistroBO.php";
	ajax_peticion(ruta, manejador__clic_recuperar);
}

function manejador__clic_recuperar(response){
	console.log("2hola");
}		

function ajax_peticion(args_ruta, callback){
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