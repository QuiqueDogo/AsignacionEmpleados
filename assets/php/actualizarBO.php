<?php 
				$conexion40 = mysql_connect("172.30.27.40","root","4LC0M");

				$fechabobo =$_REQUEST['fecha_bobo'];
        $id_com = $_REQUEST['id_comentario'];
				$opciones=$_REQUEST['opcion'];
				$a1 =$_REQUEST['Comentario'];
        $force = $_REQUEST['foliosales'];

        // print_r($fechabobo);

				$ejecutar = "
				UPDATE 
				marcador_manual.basecliente 
				SET 
				ultimocomentario = '$a1', statusbo = '$opciones', FoliosSalesForce = '$force', fecha_statusbo = '$fechabobo'
				where
				id = '$id_com' ";

        mysql_query($ejecutar,$conexion40);
			 
	
 ?>
  <script>

setTimeout("history.back(1)", 1000);

</script>

  <!DOCTYPE html>
    <html lang="es">
    <head>
     <!--  <meta http-equiv="Refresh" content="1;URL=http://172.30.27.57:8080/sialcom/system/marcadormanual/reporteCanceladasBOv2.php"> -->
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title></title>
    </head>
    <body>
      <h1>Actualizacion Hecha </h1>
   <!--    <a href="http://172.30.27.57:8080/sialcom/system/marcadormanual/reporteCanceladasBOv2.php">Continuar</a> -->
    </body>
    </html>
    <style media="screen">
    body {
      min-height     : 100vh;
      width          : 100vw;
      display        : flex;
      flex-direction : column;
      align-items    : center;
      justify-content: center;
    }

    a {
      margin-top     : 50px;
    }
  </style>