<?php include 'assets/php/funciones.php' ?>

<!DOCTYPE html>
<html lang="es">
<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="assets/css/master_note.css">
  <link rel="stylesheet" href="assets/css/master.css">
  <link rel="stylesheet" href="assets/chosen/chosen.min.css">
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet"> -->
  <link rel="stylesheet" href="assets/css/jquery-ui.css">

  <script type="text/javascript" src="assets/js/excellentexport.min.js"></script>
  <script type="text/javascript" src="assets/js/jquery.min.js"></script>
  <script type="text/javascript" src="assets/js/Chart.min.js"></script>
  <script type="text/javascript" src="assets/js/jquery-ui.js"></script>
  <script type="text/javascript" src="assets/chosen/chosen.jquery.min.js"></script>
  <script type="text/javascript" src="assets/js/main_code_alternate.js"></script>
  <script type="text/javascript" src="assets/js/main.js"></script>
  <script type="text/javascript" src="assets/js/main_code3.js"></script>


  <link rel="apple-touch-icon" sizes="57x57" href="assets/favicon/apple-icon-57x57.png">
  <link rel="apple-touch-icon" sizes="60x60" href="assets/favicon/apple-icon-60x60.png">
  <link rel="apple-touch-icon" sizes="72x72" href="assets/favicon/apple-icon-72x72.png">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/favicon/apple-icon-76x76.png">
  <link rel="apple-touch-icon" sizes="114x114" href="assets/favicon/apple-icon-114x114.png">
  <link rel="apple-touch-icon" sizes="120x120" href="assets/favicon/apple-icon-120x120.png">
  <link rel="apple-touch-icon" sizes="144x144" href="assets/favicon/apple-icon-144x144.png">
  <link rel="apple-touch-icon" sizes="152x152" href="assets/favicon/apple-icon-152x152.png">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-icon-180x180.png">
  <link rel="icon" type="image/png" sizes="192x192"  href="assets/favicon/android-icon-192x192.png">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="96x96" href="assets/favicon/favicon-96x96.png">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
  <link rel="manifest" href="assets/favicon/manifest.json">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">


  <link rel="stylesheet" type="text/css" href="assets/css/jquery.dataTables.css">
  <script type="text/javascript" charset="utf8" src="assets/js/jquery.dataTables.js"></script>



  <title>Marcador manual</title>
  <?php 

  $condicionAg = " and nagente = {$_SESSION['idEmpleado']}";

  $sql_select = "SELECT b.emp_jefe, c.emp_nombre,a.nagente, b.emp_nombrecompleto,  if(b.emp_fchbaja is null, 'activo', 'baja') as estatus, 
  datediff(curdate(), b.emp_fchingreso) as antiguedad, SUM(IF(a.IDCAMPANIA=22,a.diferencia,0)) AS 'Upsell',
  SUM(IF(a.IDCAMPANIA=176,a.diferencia,0)) AS 'Upgrade',
  count(*) as conteo, 
  sum(a.diferencia) as Total,
  sum(a.diferencia)/count(*) as promedio,
  if(b.emp_fchbaja is null,
  if(datediff(curdate(), b.emp_fchingreso) > 30, '30', datediff(curdate(), b.emp_fchingreso)),
  datediff(b.emp_fchbaja, DATE_SUB(curdate(), INTERVAL 30 DAY) ) )  as jornales,
  @promedio:=sum(a.diferencia)/(if(b.emp_fchbaja is null,
  if(datediff(curdate(), b.emp_fchingreso) > 30, '30', datediff(curdate(), b.emp_fchingreso)),
  datediff(b.emp_fchbaja, DATE_SUB(curdate(), INTERVAL 30 DAY) ) )) as promedio_diario,
  if(sum(a.diferencia)/(if(b.emp_fchbaja is null,
  if(datediff(curdate(), b.emp_fchingreso) > 30, '30', datediff(curdate(), b.emp_fchingreso)),
  datediff(b.emp_fchbaja, DATE_SUB(curdate(), INTERVAL 30 DAY) ) )) >= 350, 'VERDE', 
  if(sum(a.diferencia)/(if(b.emp_fchbaja is null,
  if(datediff(curdate(), b.emp_fchingreso) > 30, '30', datediff(curdate(), b.emp_fchingreso)),
  datediff(b.emp_fchbaja, DATE_SUB(curdate(), INTERVAL 30 DAY) ) )) <200,'#e74c3c','#f8bb17')) as color
  FROM marcador_manual.basecliente as a
  inner join adcom.empleados b on a.nagente = b.emp_Nroemp
  inner join adcom.empleados c on b.emp_jefe = c.emp_Nroemp
  WHERE date_format(a.fechaventaoriginal, '%Y-%m-%d') >= DATE_SUB(curdate(), INTERVAL 30 DAY)  {$condicionAg}
  group by b.emp_jefe, a.nagente 
  order by b.emp_fchbaja,b.emp_jefe, a.nsuper, Total desc";
  $resultado40 = mysql_query($sql_select, $conexion40);
  $filaa = mysql_fetch_array($resultado40);
  $empleadosChidos = array(2898, 2938, 3325,2695);

  if(($filaa["color"] == "#e74c3c" || $filaa["color"] == "#f8bb17") && !in_array($_SESSION["idEmpleado"], $empleadosChidos)){
    ?>
    <script>
      console.log("<?php echo $filaa["color"]; ?>");
      document.documentElement.style.setProperty("--colorbg1", "<?php echo $filaa["color"]; ?>");
      document.documentElement.style.setProperty("--color2", "<?php echo $filaa["color"]; ?>");
    </script>
    <?php
  }
  ?>
</head>
<body>
  <header>
    <h1>
      <a href="index.php">Marcador Manual</a>
      <span style="display: none;" id="campania_id_marcador"><?php echo $_SESSION["campania_id_selected"]; ?></span>
    </h1>
    <div class="session">
      <p><?php echo $_SESSION['nombre']; ?></p>
      <span class="barra"></span>
      <div class="session_img">
        <img src="<?php echo fotorealPersona(); ?>" alt="<?php echo $_SESSION['idEmpleado'] ?>">

        <div class="panel__padre_notificaciones2" data-status='on' id="elementopanel">

          <div class="panel__notificaciones">

            <div class="panel_noti">
              <div class="panel_noti__img">
                <img src="assets/img/user.jpg" alt="">
              </div>
              <div class="panel_noti__info">
                <span class="panel_noti__title">Campania</span>
                <span class="panel_noti__paragraph">
                  Tienes un agendado a las 17:00:05
                </span>
              </div>
              <div class="panel_noti__cross">
                <svg viewBox="0 0 24 24">
                  <path fill="#000000" d="M12,20C7.59,20 4,16.41 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,16.41 16.41,20 12,20M12,2C6.47,2 2,6.47 2,12C2,17.53 6.47,22 12,22C17.53,22 22,17.53 22,12C22,6.47 17.53,2 12,2M14.59,8L12,10.59L9.41,8L8,9.41L10.59,12L8,14.59L9.41,16L12,13.41L14.59,16L16,14.59L13.41,12L16,9.41L14.59,8Z" />
                </svg>
              </div>
            </div>
          </div>

        </div>

      </div>
    </div>
  </header>
  <nav class="nav">
   <ul>
    <?php

    function getTipoUsuario44(){
      if($_SESSION['cc'] == "TICS" || $_SESSION['idEmpleado'] == "3902" || $_SESSION['idEmpleado'] == "1679"){
        return "sistemas";
      }elseif($_SESSION['cc'] == "totalplay"){
        return "totalplay";
      }else{
        $idEmpleado = $_SESSION["idEmpleado"];
        $sxq = "SELECT COUNT(*) AS cuantos, essuper, esvalidador, esBO FROM validadores WHERE idEmpleado = '{$idEmpleado}' and estatus = 1";
        $res_sxq = mysql_query($sxq, $GLOBALS['conexion40']);
        $fila_sxq = mysql_fetch_array($res_sxq);
        if($fila_sxq['cuantos'] != '0'){
          if($fila_sxq['essuper'] == '2'){
            return "superuser";
          }else{
            if($fila_sxq['essuper'] == '1'){
              return "supervisor";
            }elseif($fila_sxq['esBO'] == '1'){
              return "bo";
            }elseif($fila_sxq['esvalidador'] == '1'){
              return "validador";
            }else{
              return "normal";
            }
          }
        }else{
          return "normal";
        }
      }

    }
    function menuNormal(){
      $ruta_actual = obtenerRuta();
      if($ruta_actual != "index.php"){
        ?>
        <li>
          <a href="#" id="btn__tomarregistro">
            <span class="menu_icon">
              <svg viewBox="0 0 24 24">
                <path fill="#000000" d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z" />
              </svg>
            </span>
            Tomar registro
          </a>
        </li>
        <li>
          <a href="marcadoManua.php">
            <span class="menu_icon">
              <svg viewBox="0 0 24 24">
                <path fill="#000000" d="M6.62,10.79C8.06,13.62 10.38,15.94 13.21,17.38L15.41,15.18C15.69,14.9 16.08,14.82 16.43,14.93C17.55,15.3 18.75,15.5 20,15.5A1,1 0 0,1 21,16.5V20A1,1 0 0,1 20,21A17,17 0 0,1 3,4A1,1 0 0,1 4,3H7.5A1,1 0 0,1 8.5,4C8.5,5.25 8.7,6.45 9.07,7.57C9.18,7.92 9.1,8.31 8.82,8.59L6.62,10.79Z" />
              </svg>
            </span>
            Marcar manual
          </a>
        </li>
        <li>
          <a href="tomarFolio.php">
            <span class="menu_icon">
              <svg viewBox="0 0 24 24">
                <path fill="#000000" d="M6.62,10.79C8.06,13.62 10.38,15.94 13.21,17.38L15.41,15.18C15.69,14.9 16.08,14.82 16.43,14.93C17.55,15.3 18.75,15.5 20,15.5A1,1 0 0,1 21,16.5V20A1,1 0 0,1 20,21A17,17 0 0,1 3,4A1,1 0 0,1 4,3H7.5A1,1 0 0,1 8.5,4C8.5,5.25 8.7,6.45 9.07,7.57C9.18,7.92 9.1,8.31 8.82,8.59L6.62,10.79Z" />
              </svg>
            </span>
            Buscar Folio Adicionales
          </a>
        </li>
        <?php

        $status = getStatus();
        $status_sintomarencuenta = array('NUEVO', 'BORRADO');
        for ($i=0; $i < count($status); $i++) {
          if(!in_array(strtoupper($status[$i]['status']), $status_sintomarencuenta)){
            ?>
            <li>
              <a href="detalles.php?status=<?php echo $status[$i]['status']; ?>" id="">
                <span class="menu_icon <?php if($status[$i]['conteo'] != 0){ echo 'with_noti'; } ?>" <?php if($status[$i]['conteo'] != 0){ echo "data-conteopendientes = '{$status[$i]['conteo']}'"; } ?>>
                  <svg  viewBox="0 0 24 24">
                    <path fill="#000000" d="M7,5H21V7H7V5M7,13V11H21V13H7M4,4.5A1.5,1.5 0 0,1 5.5,6A1.5,1.5 0 0,1 4,7.5A1.5,1.5 0 0,1 2.5,6A1.5,1.5 0 0,1 4,4.5M4,10.5A1.5,1.5 0 0,1 5.5,12A1.5,1.5 0 0,1 4,13.5A1.5,1.5 0 0,1 2.5,12A1.5,1.5 0 0,1 4,10.5M7,19V17H21V19H7M4,16.5A1.5,1.5 0 0,1 5.5,18A1.5,1.5 0 0,1 4,19.5A1.5,1.5 0 0,1 2.5,18A1.5,1.5 0 0,1 4,16.5Z" />
                  </svg>
                </span>
                <?php echo $status[$i]['status']; ?>
              </a>
            </li>
            <?php
          }
        }
      }
    }
    function menuBO(){
      $ruta_actual = obtenerRuta();
      if($ruta_actual != "index.php"){
        ?>
        <li>
          <a href="#" id="recuperarBO">
            <span class="menu_icon">
              <svg viewBox="0 0 24 24">
                <path fill="#000000" d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z" />
              </svg>
            </span>
            Tomar registro BO
          </a>
        </li>
        <?php
      }
    }
    function menuTotalplay(){
      ?>
      <script>
        function leerpag(pagina){
          document.getElementById('myiframe').src="../SIALCOM/system/marcadormanual/"+pagina+".php";
        }
      </script>
      <li>
        <a href="javascript: leerpag('reporteMarcaciones')" id="">
          <span class="menu_icon">
            <svg  viewBox="0 0 24 24">
              <path fill="#000000" d="M7,5H21V7H7V5M7,13V11H21V13H7M4,4.5A1.5,1.5 0 0,1 5.5,6A1.5,1.5 0 0,1 4,7.5A1.5,1.5 0 0,1 2.5,6A1.5,1.5 0 0,1 4,4.5M4,10.5A1.5,1.5 0 0,1 5.5,12A1.5,1.5 0 0,1 4,13.5A1.5,1.5 0 0,1 2.5,12A1.5,1.5 0 0,1 4,10.5M7,19V17H21V19H7M4,16.5A1.5,1.5 0 0,1 5.5,18A1.5,1.5 0 0,1 4,19.5A1.5,1.5 0 0,1 2.5,18A1.5,1.5 0 0,1 4,16.5Z" />
            </svg>
          </span>
          Menu item
        </a>
      </li>
      <?php
    }
    function menuSistemas(){
      ?>
      <li>
        <a href="subir.php">
          <span class="menu_icon">
            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
              <path fill="#000000" d="M9,16V10H5L12,3L19,10H15V16H9M5,20V18H19V20H5Z" />
            </svg>
          </span>
          Cargar Base
        </a>
      </li>
      <li style="display: none">
        <a href="reciclarBase.php">
          <span class="menu_icon">
            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
              <path fill="#000000" d="M16,9C18.33,9 23,10.17 23,12.5V15H17V12.5C17,11 16.19,9.89 15.04,9.05L16,9M8,9C10.33,9 15,10.17 15,12.5V15H1V12.5C1,10.17 5.67,9 8,9M8,7A3,3 0 0,1 5,4A3,3 0 0,1 8,1A3,3 0 0,1 11,4A3,3 0 0,1 8,7M16,7A3,3 0 0,1 13,4A3,3 0 0,1 16,1A3,3 0 0,1 19,4A3,3 0 0,1 16,7M9,16.75V19H15V16.75L18.25,20L15,23.25V21H9V23.25L5.75,20L9,16.75Z" />
            </svg>
          </span>
          Reciclar Base
        </a>
      </li>
      <li style="display: none">
        <a href="reasignarReciclados.php">
          <span class="menu_icon">
            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
              <path fill="#000000" d="M16,9C18.33,9 23,10.17 23,12.5V15H17V12.5C17,11 16.19,9.89 15.04,9.05L16,9M8,9C10.33,9 15,10.17 15,12.5V15H1V12.5C1,10.17 5.67,9 8,9M8,7A3,3 0 0,1 5,4A3,3 0 0,1 8,1A3,3 0 0,1 11,4A3,3 0 0,1 8,7M16,7A3,3 0 0,1 13,4A3,3 0 0,1 16,1A3,3 0 0,1 19,4A3,3 0 0,1 16,7M9,16.75V19H15V16.75L18.25,20L15,23.25V21H9V23.25L5.75,20L9,16.75Z" />
            </svg>
          </span>
          Reasignar reciclados
        </a>
      </li>
      <li>
        <a href="asigna_registros.php">
          <span class="menu_icon">
            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
              <path fill="#000000" d="M16,9C18.33,9 23,10.17 23,12.5V15H17V12.5C17,11 16.19,9.89 15.04,9.05L16,9M8,9C10.33,9 15,10.17 15,12.5V15H1V12.5C1,10.17 5.67,9 8,9M8,7A3,3 0 0,1 5,4A3,3 0 0,1 8,1A3,3 0 0,1 11,4A3,3 0 0,1 8,7M16,7A3,3 0 0,1 13,4A3,3 0 0,1 16,1A3,3 0 0,1 19,4A3,3 0 0,1 16,7M9,16.75V19H15V16.75L18.25,20L15,23.25V21H9V23.25L5.75,20L9,16.75Z" />
            </svg>
          </span>
          Asigna registros
        </a>
      </li>
      <?php
    }

    $tipoUsuario = getTipoUsuario44();
    $ruta_actual = obtenerRuta();
    if($tipoUsuario != 'bo'){
      echo menuNormal();
    }
    switch ($tipoUsuario) {
      case 'bo':
      echo menuBO();
      echo menuGenerico();
      break;
      case 'sistemas':
      echo menuSistemas();
      echo menuGenerico();
      echo menuSuperusuario();
      break;
      case 'superuser':
      echo menuGenerico();
      echo menuSuperusuario();
      break;
      case 'supervisor':
      echo menuGenerico();
      break;
      case 'validador':
      echo menuGenerico();
      break;
      case 'totalplay':
      echo menuTotalplay();
      break;
    }
    ?>
  </ul>
</nav>


<div id="loader_peso" style="display: flex; width: 100vw; justify-content: center; align-items: center;">
  <img src="assets/img/perrito.gif" alt="" style="width: 450px;">
</div>

<section class="cont" id="contenedorMadre">
