<?php 
header('Content-Type: application/json');

include 'conexionPDO.php';

$nombre_titular = isset($_REQUEST['nombre_titular'])? $_REQUEST['nombre_titular']:'';
$nombre_negocio = isset($_REQUEST['nombre_negocio'])? $_REQUEST['nombre_negocio']:'';
$correo_cliente = isset($_REQUEST['correo_cliente'])? $_REQUEST['correo_cliente']:'';
$direccion = isset($_REQUEST['direccion'])? $_REQUEST['direccion']:'';
$celular = isset($_REQUEST['celular'])? $_REQUEST['celular']:'';
$telefono_fijo = isset($_REQUEST['telefono_fijo'])? $_REQUEST['telefono_fijo']:'';
$comentarios = isset($_REQUEST['comentarios'])? $_REQUEST['comentarios']:'';
$agente = isset($_REQUEST['agente'])? $_REQUEST['agente']:'';

$sql_folio ="select max(id+1)as folio from marcador_manual.basecliente";

$sql_supervisor = "select emp_jefe from adcom.empleados where emp_Nroemp ='".$agente."'";
$campania ='175';
$tipocampo = 'cliente';
$status = 'tomado';
$validaciones = array();
$lote = 'conmutador_virtual__'.date('Ymd')."_".date('His');

try {//saca el folio maximo +1
	foreach ($ConexionPDO -> query($sql_folio) as $key => $arreglo_folio) {
		$folio =$arreglo_folio['folio'];
	}	
} catch (PDOException $e) {
	//echo $sql_folio."<br>".$e;
}

try {// toma el jefe 
	foreach ($ConexionPDO -> query($sql_supervisor) as $key2 => $arreglo_super) {
		$supervisor = $arreglo_super['emp_jefe'];
	}
} catch (PDOException $e2) {
	//echo $sql_supervisor."<br>".$e2;
}

$sql_insert_row = "
INSERT into marcador_manual.basecliente
(
	telefono,
	foliocliente,
	contacto,
	nagente,
	ultimoestatus,
	nsuper,
	idcampania,
	lotenombre
	)
	values(
	:telefono,
	:foliocliente,
	:contacto,
	:nagente,
	:ultimoestatus,
	:nsuper,
	:idcampania,
	:lotenombre)";

	$sql_valida_contacto ="SELECT count(*) as total from marcador_manual.basecliente where telefono ='".$celular."'";

	try {
		foreach ($ConexionPDO -> query($sql_valida_contacto) as $key4 => $arreglo_validacion) {
			if ($arreglo_validacion['total'] >= 1) {
				//echo "no puedes amiguito";
				$duplicado = true;
				$validacion['duplicado'] = true;
			}else{
				//echo "si puedes amiguito";
				$validacion['duplicado'] = false;
				$duplicado = false;
			}
		}
	} catch (PDOException $e4) {
		//echo $sql_valida_contacto."<br>".$e4;
	}
	if (!$duplicado) {
		try {
			$pre_instert = $ConexionPDO -> prepare($sql_insert_row);
			$pre_instert -> bindParam(':telefono',$celular,PDO::PARAM_INT);
			$pre_instert -> bindParam(':foliocliente',$folio,PDO::PARAM_INT);
			$pre_instert -> bindParam(':contacto',$nombre_titular,PDO::PARAM_STR);
			$pre_instert -> bindParam(':nagente',$agente,PDO::PARAM_INT);
			$pre_instert -> bindParam(':ultimoestatus',$status,PDO::PARAM_STR);
			$pre_instert -> bindParam(':nsuper',$supervisor,PDO::PARAM_INT);
			$pre_instert -> bindParam(':idcampania',$campania,PDO::PARAM_INT);
			$pre_instert -> bindParam(':lotenombre',$lote,PDO::PARAM_STR);
			$pre_instert -> execute();
			$validacion['insert_registro'] = true;

			$sql_campo =" 
			INSERT into campos_adicionales(
			idfolio_externo,
			idcampania,
			nombre_campo,
			tipocampo,
			valor_campo,
			lotenombre)
			values(
			:idfolio_externo,
			:idcampania,
			:nombre_campo,
			:tipocampo,
			:valor_campo,
			:lotenombre);";

			try {
				$nombrecampo1 = 'nombre_negocio';
				$predato1 = $ConexionPDO -> prepare($sql_campo);
				$predato1 ->bindParam(':idfolio_externo',$folio,PDO::PARAM_INT);
				$predato1 ->bindParam(':idcampania',$campania,PDO::PARAM_INT);
				$predato1 ->bindParam(':nombre_campo',$nombrecampo1,PDO::PARAM_STR);
				$predato1 ->bindParam(':tipocampo',$tipocampo,PDO::PARAM_INT);
				$predato1 ->bindParam(':valor_campo',$nombre_negocio,PDO::PARAM_STR);
				$predato1 ->bindParam(':lotenombre',$lote,PDO::PARAM_STR);
				$predato1 -> execute();
				$validacion['campo1'] = true;
		     	//echo "sb1 true";			;
			} catch (PDOException $e_1) {
				$validacion['campo1'] = false;
			    //echo $e_1;
			}


			try {
				$nombrecampo2 = 'direccion';
				$predato2 = $ConexionPDO -> prepare($sql_campo);
				$predato2 ->bindParam(':idfolio_externo',$folio,PDO::PARAM_INT);
				$predato2 ->bindParam(':idcampania',$campania,PDO::PARAM_INT);
				$predato2 ->bindParam(':nombre_campo',$nombrecampo2,PDO::PARAM_STR);
				$predato2 ->bindParam(':tipocampo',$tipocampo,PDO::PARAM_INT);
				$predato2 ->bindParam(':valor_campo',$direccion,PDO::PARAM_STR);
				$predato2 ->bindParam(':lotenombre',$lote,PDO::PARAM_STR);
				$predato2 -> execute();
			//echo "sb2 true";
				$validacion['campo2'] = true;
			} catch (PDOException $e_2) {
				$validacion['campo2'] = false;
			//echo $e_2;
			}


			try {
				$nombrecampo3 = 'comentarios';
				$predato3 = $ConexionPDO -> prepare($sql_campo);
				$predato3 ->bindParam(':idfolio_externo',$folio,PDO::PARAM_INT);
				$predato3 ->bindParam(':idcampania',$campania,PDO::PARAM_INT);
				$predato3 ->bindParam(':nombre_campo',$nombrecampo3,PDO::PARAM_STR);
				$predato3 ->bindParam(':tipocampo',$tipocampo,PDO::PARAM_INT);
				$predato3 ->bindParam(':valor_campo',$comentarios,PDO::PARAM_STR);
				$predato3 ->bindParam(':lotenombre',$lote,PDO::PARAM_STR);
				$predato3 -> execute();
            //			echo "sb2 true";
				$validacion['campo3'] = true;
			} catch (PDOException $e_3) {
				$validacion['campo3'] = false;
			//			echo $e_3;
			}

			try {
				$nombrecampo3 = 'contacto';
				$predato3 = $ConexionPDO -> prepare($sql_campo);
				$predato3 ->bindParam(':idfolio_externo',$folio,PDO::PARAM_INT);
				$predato3 ->bindParam(':idcampania',$campania,PDO::PARAM_INT);
				$predato3 ->bindParam(':nombre_campo',$nombrecampo3,PDO::PARAM_STR);
				$predato3 ->bindParam(':tipocampo',$tipocampo,PDO::PARAM_INT);
				$predato3 ->bindParam(':valor_campo',$telefono_fijo,PDO::PARAM_STR);
				$predato3 ->bindParam(':lotenombre',$lote,PDO::PARAM_STR);
				$predato3 -> execute();
            //			echo "sb2 true";
				$validacion['campo3'] = true;
			} catch (PDOException $e_3) {
				$validacion['campo3'] = false;
			//			echo $e_3;
			}

		} catch (PDOException $e3) {
			$validacion['insert_registro'] = false;
			//echo $sql_insert_row." ".$e3;
		}
	}
	$ConexionPDO = 0;
	
	echo  json_encode($validacion);
	?>