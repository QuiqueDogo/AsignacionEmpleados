<?php 
$conexion = mysql_connect('172.30.27.40','root','4LC0M');
$file = $_FILES['excel'];
$cadenaFolio = '';
$cadenaFolioSale='';
$cadenastatus = '';
$cadenafecha = '';
$sinfolios = '';
$sinfolio = '';
$row = 0;

if (($handle = fopen($file['tmp_name'] , "r")) !== FALSE) {
	# inicio del ciclo
	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		## quitar lo de && en adelante
		if ($row != 0 ) {
			$cadenaFolio= $data[0];
			$cadenaFolioSale =$data[7];
			$cadenastatus=$data[1];
			$cadenafecha=$data[11];
			$sql2 = "SELECT    id,    foliocliente    from    marcador_manual.basecliente    WHERE  foliocliente like '%{$cadenaFolioSale}%' and (FolioSalesForce_admin like '%{$cadenaFolio}%' || FoliosSalesForce like '%{$cadenaFolio}%')";
			$prueba = mysql_query($sql2, $conexion); 
			$prueba1 = mysql_fetch_array($prueba);
			if (!empty($prueba1['id'])) {
				$sql1 = "UPDATE      marcador_manual.basecliente      set      statusretrobo = '{$cadenastatus}' , fechacierre = '{$cadenafecha}'  WHERE  id = '{$prueba1['id']}';";
                $sinfolios.= '"'. ($cadenaFolioSale).'",';
				$cadenaFolio = substr($cadenaFolio, 0, -1);
				$cadenaFolioSale = substr($cadenaFolioSale,0 ,-1);
				$cadenastatus = substr($cadenastatus,0 ,-1);
				$cadenafecha = substr($cadenafecha,0 ,-1);


				mysql_query($sql1,$conexion);

			}else{
				$sinfolio.= $cadenaFolioSale.'-' .$cadenaFolio.'<br>';
			}
			// echo $row."<br>";
		}
		$row++;
	}
    }
	// # fin del ciclo
	
// mysql_close($conexion);
?>

<html>
<head>
	<meta charset="UTF-8">
	<title>Subida</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/jquery.CSV.js"></script>
	<script>
        $(document).ready( function () {

            $.extend( true, $.fn.dataTable.defaults, {
                "language": {
                    "decimal": ",",
                    "thousands": ".",
                    "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "infoPostFix": "",
                    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "loadingRecords": "Cargando...",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "searchPlaceholder": "Término de búsqueda",
                    "zeroRecords": "No se encontraron resultados",
                    "emptyTable": "Ningún dato disponible en esta tabla",
                    "aria": {
                        "sortAscending":  ": Activar para ordenar la columna de manera ascendente",
                        "sortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "create": "Nuevo",
                        "edit": "Cambiar",
                        "remove": "Borrar",
                        "copy": "Copiar",
                        "csv": "fichero CSV",
                        "excel": "tabla Excel",
                        "pdf": "documento PDF",
                        "print": "Imprimir",
                        "colvis": "Visibilidad columnas",
                        "collection": "Colección",
                        "upload": "Seleccione fichero...."
                    },
                    "select": {
                        "rows": {
                            _: '%d filas seleccionadas',
                            0: 'clic fila para seleccionar',
                            1: 'una fila seleccionada'
                        }
                    }
                }           
            } );        

            function exportTableToCSV($table, filename) {
                var $headers = $table.find('tr:has(th)')
                ,$rows = $table.find('tr:has(td)')
                    // Temporary delimiter characters unlikely to be typed by keyboard
                    // This is to avoid accidentally splitting the actual contents
                    ,tmpColDelim = String.fromCharCode(11) // vertical tab character
                    ,tmpRowDelim = String.fromCharCode(0) // null character
                    // actual delimiter characters for CSV format
                    ,colDelim = '","'
                    ,rowDelim = '"\r\n"';
                    // Grab text from table into CSV formatted string
                    var csv = '"';
                    csv += formatRows($headers.map(grabRow));
                    csv += rowDelim;
                    csv += formatRows($rows.map(grabRow)) + '"';
                    // Data URI
                    var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);
                    $(this)
                    .attr({
                        'download': filename
                        ,'href': csvData
                        //,'target' : '_blank' //if you want it to open in a new window
                    });
                //------------------------------------------------------------
                // Helper Functions 
                //------------------------------------------------------------
                // Format the output so it has the appropriate delimiters
                function formatRows(rows){
                    return rows.get().join(tmpRowDelim)
                    .split(tmpRowDelim).join(rowDelim)
                    .split(tmpColDelim).join(colDelim);
                }
                // Grab and format a row from the table
                function grabRow(i,row){

                    var $row = $(row);
                    //for some reason $cols = $row.find('td') || $row.find('th') won't work...
                    var $cols = $row.find('td'); 
                    if(!$cols.length) $cols = $row.find('th');  
                    return $cols.map(grabCol)
                    .get().join(tmpColDelim);
                }
                // Grab and format a column from the table 
                function grabCol(j,col){
                    var $col = $(col),
                    $text = $col.text();
                    return $text.replace('"', '""'); // escape double quotes
                }
            }
            // This must be a hyperlink
            $("#exportTable").click(function (event) {
                // var outputFile = 'export'
                var outputFile = window.prompt("¿Qué nombre quieres que tenga tu archivo?") || 'export';
                outputFile = outputFile.replace('.csv','') + '.csv'

                // CSV
                exportTableToCSV.apply(this, [$('#myTable'), outputFile]);
                
                // IF CSV, don't do event.preventDefault() or return false
                // We actually need this to be a typical hyperlink
            });


            $('#myTable').DataTable({
                paging: false
            });
        } );
    </script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#tabla').DataTable();
    } );
    </script>
</head>
<body>
	<a href="#" id="exportTable">Bajar reporte</a>
	<?php 
		$foliosPartidos = explode(',', $sinfolios);
	 ?>
	<table id="tabla">
		<thead>
			<tr>
				<td>Folios no encontrados</td>
			</tr>
			<tbody>
				<?php 
			
				foreach ($foliosPartidos as $folio ) {
				
				echo "<tr>";
					echo "<td>". $folio. "</td>" ; 
				echo "</tr>";
				
				}

				 ?>
				
			</tbody>	

		</thead>

	</table>
	
</body>
</html>
<?php 
fclose($handle);
mysql_close($conexion);
?>