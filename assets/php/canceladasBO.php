<?php 
	$conexion40 = mysql_connect("172.30.27.40","root","4LC0M");

	$folioAcambiar = $_REQUEST['folioCancelados'];
  $estatusCambio = $_REQUEST['status_a_cambiar'];
  $cambiada = $_REQUEST['cambio'];

	$ejecutarCancelados = "UPDATE marcador_manual.basecliente SET ultimoestatus = '{$estatusCambio}', cancelada = '{$cambiada}' WHERE foliocliente = '{$folioAcambiar}' ";

	 print($ejecutarCancelados);
	$lel = mysql_query($ejecutarCancelados,$conexion40);

 ?>

<script>

//setTimeout("history.back(1)", 2000);

</script>

  <!DOCTYPE html>
    <html lang="es">
    <head>
     <!--  <meta http-equiv="Refresh" content="1;URL=http://172.30.27.57:8080/sialcom/system/marcadormanual/reporteCanceladasBOv2.php"> -->
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <link href="https://fonts.googleapis.com/css?family=Quattrocento+Sans" rel="stylesheet">
      <title></title>
    </head>
    <body>
    	<div>
      		<h1>Actualizacion Hecha </h1>
    	</div>
    </body>
    </html>
    <style media="screen">
    body {
      background-image: linear-gradient(120deg, #1E4BE8 0%, #30B7FF 100%);
      min-height     : 100vh;
      width          : 100vw;
      display        : flex;
      flex-direction : column;
      align-items    : center;
      justify-content: center;
    }

    div{
    	width: 500px;
    	height: 200px;
    	background: white;
    	margin: auto;
    	text-align: center;
      	-webkit-box-shadow: 4px 9px 0px 0px rgba(0,0,0,0.75);
      	-moz-box-shadow: 4px 9px 0px 0px rgba(0,0,0,0.75);
      	box-shadow: 4px 9px 0px 0px rgba(0,0,0,0.75);
    }

    h1{
    	padding-top: 55px;
      font-family: 'Quattrocento Sans', sans-serif;
    	text-decoration: underline;
    }

    a {
      margin-top     : 50px;
    }
  </style>