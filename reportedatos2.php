<?php 
include 'assets/includes/header.inc';

$fechaI = $_REQUEST['fechaI'];
$fechaF = $_REQUEST['fechaF'];
$numero = 1;

if (isset($_REQUEST["fechaI"])) {
	$fechaI = $_REQUEST["fechaI"];
}else{
	$fechaI = date("Y-m-d");
}

if (isset($_REQUEST["fechaF"])) {
	$fechaF = $_REQUEST["fechaF"];
}else{
	$fechaF = date("Y-m-d");
}


function adicionales($puños){
	$consulta = "SELECT 
	a.nombre_campo,
	a.valor_campo,
	b.nombrecampo
	from 
	marcador_manual.campos_adicionales as a
	inner join marcador_manual.campos_requeridos as b on a.valor_campo = b.id
	where idfolio_externo = '{$puños}'
	and valor_campo != ''
	and b.nombrecampo != 'si'
	and a.nombre_campo not in ('adicional_horario_instalacion','oferta_realizada')";

	$ejecucion = mysql_query($consulta,$GLOBALS['conexion40']);
	$Todo = "";
	while ($Valor = mysql_fetch_assoc($ejecucion)) {
		if($Valor['nombrecampo'] == 'Si' && $Valor['nombre_campo'] == 'adicional_descuentodeporvida' && $Valor['valor_campo'] == 390){
			$Valor['nombrecampo'] = 'Descuento de por vida';	
		}elseif($Valor['nombre_campo'] == 184 && $Valor['valor_campo'] == 3 && $Valor['nombrecampo'] == 'Adicional') { //176 3
			$Valor['nombrecampo'] = '3 Lineas Adicional';

		}elseif($Valor['nombre_campo'] == 184 && $Valor['valor_campo'] == 2 && $Valor['nombrecampo'] == 'Fecha de instalacion') { //176 2
			$Valor['nombrecampo'] = '2 Lineas Adicional';

		}elseif($Valor['nombre_campo'] == 184 && $Valor['valor_campo'] == 1 && $Valor['nombrecampo'] == 'Oferta realizada') { //176 1
			$Valor['nombrecampo'] = '1 Linea Adicional';

		}elseif($Valor['nombre_campo'] == 185 && $Valor['valor_campo'] == 3 && $Valor['nombrecampo'] == 'Adicional') { //176 3
			$Valor['nombrecampo'] = '3 Extensiones Telefonica';

		}elseif($Valor['nombre_campo'] == 185 && $Valor['valor_campo'] == 2 && $Valor['nombrecampo'] == 'Fecha de instalacion') { //176 2 
			$Valor['nombrecampo'] = '2 Extensiones Telefonica';

		}elseif($Valor['nombre_campo'] == 185 && $Valor['valor_campo'] == 1 && $Valor['nombrecampo'] == 'Oferta realizada') { //176 1
			$Valor['nombrecampo'] = '1 Extension Telefonica';

		}elseif($Valor['nombre_campo'] == 50 && $Valor['valor_campo'] == 1 && $Valor['nombrecampo'] == 'Oferta realizada') { //22
			$Valor['nombrecampo'] = '1 Extension Telefonica';

		}elseif($Valor['nombre_campo'] == 50 && $Valor['valor_campo'] == 2 && $Valor['nombrecampo'] == 'Fecha de instalacion') { //22
			$Valor['nombrecampo'] = '2 Extensiones Telefonica';

		}elseif($Valor['nombre_campo'] == 49 && $Valor['valor_campo'] == 2 && $Valor['nombrecampo'] == 'Fecha de instalacion') { //22
			$Valor['nombrecampo'] = '2 Lineas Adicionales';

		}elseif($Valor['nombre_campo'] == 49 && $Valor['valor_campo'] == 1 && $Valor['nombrecampo'] == 'Oferta realizada') { //22
			$Valor['nombrecampo'] = '1 Linea Adicional';

		}elseif($Valor['nombre_campo'] == 'adicional_tvadicional_bo' && $Valor['valor_campo'] == 1 && $Valor['nombrecampo'] == 'Oferta realizada') { // TV adicional de BO
			$Valor['nombrecampo'] = '1 Tv Adicional BO';

		}elseif($Valor['nombre_campo'] == 'adicional_tvadicional_bo' && $Valor['valor_campo'] == 2 && $Valor['nombrecampo'] == 'Fecha de instalacion') { // TV adicional de BO
			$Valor['nombrecampo'] = '2 Tv Adicional BO';

		}elseif($Valor['nombre_campo'] == 'wifi_extender' && $Valor['valor_campo'] == 4 && $Valor['nombrecampo'] == 'Tripleplay Inicial') {
			$Valor['nombrecampo'] = '4 Wifi Extender';

		}elseif($Valor['nombre_campo'] == 'wifi_extender' && $Valor['valor_campo'] == 3 && $Valor['nombrecampo'] == 'Adicional') {
			$Valor['nombrecampo'] = '3 Wifi Extender';

		}elseif($Valor['nombre_campo'] == 'wifi_extender' && $Valor['valor_campo'] == 2 && $Valor['nombrecampo'] == 'Fecha de instalacion') {
			$Valor['nombrecampo'] = '2 Wifi Extender';

		}elseif ($Valor['nombre_campo'] == 'wifi_extender' && $Valor['valor_campo'] == 1 && $Valor['nombrecampo'] == 'Oferta realizada') {
			$Valor['nombrecampo'] = '1 Wifi Extender';

		}elseif ($Valor['nombre_campo'] == 'adicional_descuentodeporvida' && ($Valor['valor_campo'] == 389 || $Valor['valor_campo'] == 391) && $Valor['nombrecampo'] == 'No') {
			$Valor['nombrecampo'] = 'No al Descuento de por vida';

		}elseif($Valor['nombre_campo'] == "servicio_tv_adicional" && $Valor['nombrecampo'] == 'Fecha de instalacion' && $Valor['valor_campo'] == 2) {
			$Valor['nombrecampo'] = '2 Tv adicional';

		}elseif($Valor['nombre_campo'] == "servicio_tv_adicional" && $Valor['nombrecampo'] == 'Oferta realizada' && $Valor['valor_campo'] == 1) {
			$Valor['nombrecampo'] = '1 Tv adicional';

		}elseif($Valor['nombre_campo'] == 'servicio_tv_adicional' && $Valor['valor_campo'] == 3 && $Valor['nombrecampo'] == 'Adicional') {
			$Valor['nombrecampo'] = '3 TV adicional';

		}elseif($Valor['nombre_campo'] == 'servicio_tv_adicional' && $Valor['valor_campo'] == 4 && $Valor['nombrecampo'] == 'Tripleplay Inicial') {
			$Valor['nombrecampo'] = '4 TV adicional';

		}elseif($Valor['nombre_campo'] == 'servicio_tv_adicional' && $Valor['valor_campo'] == 5 && $Valor['nombrecampo'] == 'Tripleplay Esencial') {
			$Valor['nombrecampo'] = '5 TV adicional';
		}

		$Todo[] = $Valor['nombrecampo'];
	}


	$All = implode($Todo, ', ');
	return $All;

}


$consultaDatos = "
SELECT 
id,
idcampania,
foliocliente,
contacto,
PlanActual,
ultimoestatus,
DATE_FORMAT(fechaventaoriginal,'%Y-%m-%d') as fecha,
PlanOfrecido,
tipo_movimiento,
FechaInstalacion,
HorarioInstalacion,
FoliosSalesForce,
diferencia,
requiere_visita
from marcador_manual.basecliente 
where ultimoestatus = 'venta' 
and idcampania in (22,176,211,206,220) 
and fechaventaoriginal between '{$fechaI}' and '{$fechaF}' order by FechaUltimoStatus DESC ";

$queryConsulta = mysql_query($consultaDatos, $conexion40);

?>

<style type="text/css">
.formu *{
	display: flex;
	margin: 5px 5px 0 0;
}

th, tr {
	font-size: .8rem;
	white-space: nowrap;
}

.contenido{
	display: flex;
	overflow: auto;
	width: 80%;
	max-height: 75vh;
	margin-top: 50px;
}
</style>

<div class="formu">
	<form class="caja" action="#" method="GET">
		<label>Fecha Inicio: </label><input type="date" name="fechaI" value="<?php if(isset($_REQUEST["fechaI"])){ echo $_REQUEST["fechaI"]; }else {echo date("Y-m-d"); }  ?>">
		<label>Fecha Final: </label><input type="date" name="fechaF" value="<?php if(isset($_REQUEST["fechaF"])){ echo $_REQUEST["fechaF"]; }else {echo date("Y-m-d"); }  ?>">
		<button>Consultar</button>
	</form>
</div>

<div class="contenido">
	<table id="datatable" class="tablaform">
		<thead>
			<th>#</th>
			<th>Cuenta</th>
			<th>Nombre</th>
			<th>Plan Actual</th>
			<th>Llamada Realizada</th>
			<th>Llamada Efectiva</th>
			<th>Motivo</th>
			<th>Fecha Cambio</th>
			<th>Plan Posicionado</th>
			<th>Tipo Movimiento</th>
			<th>Addons</th>
			<th>Fecha Instalacion</th>
			<th>Horario Instalacion</th>
			<th>FolioSalesForce</th>
			<th>Diferencia</th>
			<th>Requiere Visita</th>
		</thead>
		<tbody>
			<?php 
			while ($Reporte = mysql_fetch_assoc($queryConsulta)) {
				$idReporte = $Reporte['id'];
				?>
				<tr>
					<td><?php echo $numero; ?></td>
					<td><?php echo $Reporte['foliocliente']; ?></td>
					<td><?php echo $Reporte['contacto']; ?></td>
					<td><?php echo $Reporte['PlanActual']; ?></td>
					<td>Sí</td>
					<td>Sí</td>
					<td><?php echo $Reporte['ultimoestatus']; ?></td>
					<td><?php echo $Reporte['fecha']; ?></td>
					<td><?php echo $Reporte['PlanOfrecido']; ?></td>
					<td>
						<?php
			//gettype($arreglo) --- Muestra que tipo de valor es devuelto del arreglo. Ej: string, null, boolean, etc...
						if ($Reporte['tipo_movimiento'] == "2p a 2p" && (gettype(adicionales($idReporte)) == "string")) {
							echo "Upgrade 2p Con Contratacion de Addons";
						}elseif($Reporte['tipo_movimiento'] == "2p a 2p"){
							echo "Upgrade 2p";
						}elseif($Reporte['tipo_movimiento'] == "2p a 3p" && (gettype(adicionales($idReporte)) == "string" )){
							echo "Upsell 2p a 3p Con Contratacion de Addons";
						}elseif($Reporte['tipo_movimiento'] == "2p a 3p"){
							echo "Upsell 2p a 3p";
						}elseif($Reporte['tipo_movimiento'] == "3p a 3p" && (gettype(adicionales($idReporte)) == "string" )){
							echo "Upgrade 3p Con Contratacion de Addons";
						}elseif($Reporte['tipo_movimiento'] == "3p a 3p"){
							echo "Upgrade 3p";
						}elseif($Reporte['tipo_movimiento'] == "Addons" ){
							echo "Contratacion de Adicionales";
						}
						?> 	
					</td>
					<td>
						<?php echo adicionales($idReporte)?>
					</td>
					<td>
						<?php
						if ($Reporte['FechaInstalacion'] == "0000-00-00") {
							$Reporte['FechaInstalacion'] = "";
						}else{
							echo $Reporte['FechaInstalacion'];	 	
						} 
						?>

					</td>
					<td><?php echo $Reporte['HorarioInstalacion']; ?></td>
					<td ><?php echo $Reporte['FoliosSalesForce']; ?></td>
					<td><?php echo $Reporte['diferencia']; ?></td>
					<td>
						<?php
						if ($Reporte['requiere_visita'] == 1) {
							echo 'Sí'; 
						}elseif (gettype($Reporte['requiere_visita']) == "NULL" ) {
							echo "";
						}elseif ($Reporte['requiere_visita'] == 0) {
							echo 'No';
						}

						?>	
					</td>
				</tr>
				<?php 
				$numero++;}
				?> 	
			</tbody>
		</table>
	</div>
	<a download="reporteDatos.csv" class="btn_bolita"  href="#" onclick="return ExcellentExport.csv(this, 'datatable');">
	<svg viewBox="0 0 24 24">
		<path fill="#000000" d="M5,20H19V18H5M19,9H15V3H9V9H5L12,16L19,9Z" />
	</svg>
	</a>

	<?php mysql_close($conexion40); ?>

