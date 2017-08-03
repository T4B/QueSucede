<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	
		
	}
	
	public function index(){
		
	}
	
	
	
	public function guardar()
	{
		
		setlocale(LC_ALL, 'es_MX');
		date_default_timezone_set("America/Mexico_City");
		
		$now = time();
		$gmt = local_to_gmt($now);
		
		$ext = explode('.' , $_FILES['imagen']['name']);
		
		$file_name = substr($_FILES['imagen']['name'], 0, 3) . $gmt;
		
		$config['upload_path'] = realpath(APPPATH . '../images_promo');
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '512';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['file_name']  = $file_name;
		
		$this->load->library('upload', $config);
		
		$upload_data = $this->upload->data();
		
		$field_name = "imagen";
		
		if ( $this->upload->do_upload($field_name))
		{
					
		}else{
			/*
			$data = array('upload_data' => $this->upload->data());
			$this->load->view('upload_success', $data);
			*/
		}
		
	}
	
	
	public function busqueda_avanzada(){
		
		include('check_login.php');
		include('arma_header.php');
		include('arma_menu.php');
		
		$mis_campos = array(
			'marca' => 'marcas_id_marca',
			'mes' => 'id_mes_meses',
			'estado' => 'estados_id_estado'
		);
		
		$array_campos = array();
		
		foreach($mis_campos as $key => $value) {
			$post = $this->input->post($key, TRUE);
			if($post) {
				$array_campos[$value] = $post;
			}
		}
		
		$promociones = $this->promocion_model->busqueda_avanzada($array_campos);
		
		$total_promociones = $promociones->num_rows();
		
		if( $total_promociones > 0  ){
			$data['promociones'] = $promociones;
			$data['total_promociones'] = $total_promociones;
			$data['tamanio_paginacion'] = 10;
			
			$page = 'resultados_promo_page';
			
		}else{
			$page = 'sin_resultados_page';
		}
		
		$data['permisos'] = $this->session->userdata('permisos'); 
		$data['nombre_usuario'] = $this->session->userdata('nombre_usuario');
		$data['titulo_page'] = $titulo;
		$this->session->set_userdata('titulo_page', $titulo);
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/menu', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);
		
	}
	
	public function upload(){		
		
		$this->load->helper('string_helper');
		
		$conPHPExcel = 1;
		
		if($conPHPExcel == 1){
			require_once APPPATH."/third_party/PHPExcel/IOFactory.php";
			$objPHPExcel = PHPExcel_IOFactory::load($_FILES['datafile']['tmp_name']);
			
			/*
			foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
				$worksheetTitle     = $worksheet->getTitle();
				$highestRow         = $worksheet->getHighestRow(); // e.g. 10
				$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
				$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
				$nrColumns = ord($highestColumn) - 64;
				echo "<br>The worksheet ".$worksheetTitle." has ";
				echo $nrColumns . ' columns (A-' . $highestColumn . ') ';
				echo ' and ' . $highestRow . ' row.';
				echo '<br>Data: <table border="1"><tr>';
				for ($row = 1; $row <= $highestRow; ++ $row) {
					echo '<tr>';
					for ($col = 0; $col < $highestColumnIndex; ++ $col) {
						$cell = $worksheet->getCellByColumnAndRow($col, $row);
						$val = $cell->getValue();
						$dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
						echo '<td>' . $val . '<br>(Typ ' . $dataType . ')</td>';
					}
					echo '</tr>';
				}
				echo '</table>';
			}
			*/
			$id_mes = date("n");
			$fecha_registro = date("Y-m-d", mktime());
			
			echo "mes ->$id_mes<br />";
			
			//$sheet = $objPHPExcel->getSheet(0);
			$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
			
			$contador = 1;
			
			foreach ($objWorksheet->getRowIterator() as $row) {
				$cellIterator = $row->getCellIterator();
				$cellIterator->setIterateOnlyExistingCells(false); // This loops all cells,
																   // even if it is not set.
																   // By default, only cells
																   // that are set will be
																   // iterated.
				echo "hojaaaa <br />";
				$array[] = '';
				foreach ($cellIterator as $cell) {
					$cell_row = $cell->getRow();
					echo $cell->getValue() . ' - row->' . $cell_row . "\n";
					$array[] = $cell->getValue();
					$colIndex = PHPExcel_Cell::columnIndexFromString($cell->getColumn());
					echo "col ->" . $colIndex . "\n";
					echo "<br />";
				}
				
				$now = time() + ($contador * 60);
				$gmt = local_to_gmt($now);
				$contador++;
				$ext = str_suffix($array[11], '.', 1);
				
				$nuevo_nombre = substr($array[11], 0, 3) . $gmt . "." . $ext;
				
				$ruta_imagen = realpath(APPPATH . '../images_upload') . "/" . $array[11];
				$nueva_ruta = realpath(APPPATH . '../images_promo') . "/" . $nuevo_nombre;
				echo "imagen -> " . $ruta_imagen . "<br />";
				echo "nueva ruta -> " . $nueva_ruta . "<br />";
				echo "nuevo nombre ->" . $nuevo_nombre . "<br />";
				echo "copiar <br />";
				copy($ruta_imagen,$nueva_ruta);
				
				if($array[6] == ""){
					$fecha_inicio = "N/A";
				}else{
					$fecha_inicio = $array[6];
				}
				
				if($array[7] == ""){
					$fecha_fin = "N/A";
				}else{
					$fecha_fin = $array[7];
				}
				
				
				$data = array(
					'tiendas_id_tienda' => $array[1],
					'marcas_id_marca' => $array[2],
					'producto' => $array[3],
					'estados_id_estado' => $array[4],
					'tipos_promocion_id_tipo_promocion' => $array[5],
					'fecha_inicio' => $fecha_inicio,
					'fecha_fin' => $fecha_fin,
					'titulo_promocion' => $array[8],
					'descripcion_promocion' => $array[9],
					'mecanica' => $array[10],
					'imagen' => $nuevo_nombre,
					'premios' => $array[12],
					'id_mes_meses' => $id_mes,
					'fecha_registro' => $fecha_registro,
					'visitas' => 0,
					'destacado' => 0
				);
				
				$this->db->insert('promociones', $data);
				echo "error -> " . $this->db->_error_message() . "<br /><br />";
				
				
				unset($array);
				
			}
			$currentCell = $objPHPExcel->getActiveSheet()->getActiveCell();
			echo "insertar <br />";
		}else{
			
			$arrLines = file( $_FILES['datafile']['tmp_name'] );
			
			unset($arrLines[0]);
			
			foreach( $arrLines as $line ) {
				$lineaActual = explode( ',', $line );
				
				$formato = $lineaActual[1];
				$sucursal = $lineaActual[2];
				
				$query = $this->db->get_where(
											  'formatos_sucursales',
											  array(
													'formatos_id_formato' => $formato,
													'sucursales_id_sucursal' => $sucursal) );
				
				if($query->num_rows() > 0){
					$formato_sucursal = $query->row()->id_formato_sucursal;
				}else{
					$data = array(
							'formatos_id_formato' => $formato,
							'sucursales_id_sucursal' => $sucursal
								);
					$this->db->insert('formatos_sucursales', $data);
					
					$query = $this->db->get_where(
											  'formatos_sucursales',
											  array(
													'formatos_id_formato' => $formato,
													'sucursales_id_sucursal' => $sucursal) );
					$formato_sucursal = $query->row()->id_formato_sucursal;
					
				}
				
				$fecha_registro = date("Y-m-d", mktime());
				
				$data = array(
						'id_mes_meses' => $lineaActual[0],
						'id_formato_sucursal' => $formato_sucursal,
						'marcas_id_marca' => $lineaActual[3],
						'id_producto' => $lineaActual[4],
						'categorias_id_categoria' => $lineaActual[5],
						'estados_id_estado' => $lineaActual[6],
						'fecha_inicio' => $lineaActual[7],
						'fecha_fin' => $lineaActual[8],
						'fecha_registro' => $fecha_registro,
						'tipos_promocion_id_tipo_promocion' => $lineaActual[9],
						'titulo_promocion' => $lineaActual[10],
						'descripcion_promocion' => $lineaActual[11],
						'mecanica' => $lineaActual[12],
						'imagen' => $lineaActual[13],
						'estatus' => 0,
						'premios' => '',
						'visitas' => 0,
						'destacado' => 0
							  );
				
				//$this->db->insert('promociones', $data);
			}
		}
		
		echo "OK";
		
	}
}
?>