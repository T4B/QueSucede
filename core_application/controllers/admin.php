<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function campo_promocion($col_ent){
	$hdc = array(
			0 => "id_mes_meses", 1 => "B", 2 => "C", 3 => "D", 4 => "E",
			5 => "F", 6 => "G", 7 => "H", 8 => "I", 9 => "J",
			10 => "K", 11 => "L", 12 => "M", 13 => "N", 14 => "O",
			15 => "P", 16 => "Q", 17 => "R", 18 => "S", 19 => "T",
			20 => "U", 21 => "V", 22 => "W", 23 => "X", 24 => "Y", 25 => "Z");
	return ($col_ent < 26) ? $hdc[$col_ent] : $hdc[(int)($col_ent/26)-1].$hdc[($col_ent % 26)];
}

function entradaColumna($col_ent){
	$hdc = array(
			0 => "A", 1 => "B", 2 => "C", 3 => "D", 4 => "E",
			5 => "F", 6 => "G", 7 => "H", 8 => "I", 9 => "J",
			10 => "K", 11 => "L", 12 => "M", 13 => "N", 14 => "O",
			15 => "P", 16 => "Q", 17 => "R", 18 => "S", 19 => "T",
			20 => "U", 21 => "V", 22 => "W", 23 => "X", 24 => "Y", 25 => "Z");
	return ($col_ent < 26) ? $hdc[$col_ent] : $hdc[(int)($col_ent/26)-1].$hdc[($col_ent % 26)];
}

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('date_helper');
		$this->load->library('header_lib');
		$this->load->library('login_lib');
		$this->load->library('promociones_lib');
		date_default_timezone_set('America/Mexico_City');
		
	}
	
	public function index(){
		
		$this->load->helper('form');
		
		$data = $this->header_lib->arma_rutas();
		$data = $this->header_lib->arma_menu($data);
		
		$data['categorias'] = $this->db->get('categorias');
		$data['canales'] = $this->db->get('canales');
		$data['formatos'] = $this->db->get('formatos');
		$this->db->order_by('nombre_marca');
		$data['marcas'] = $this->db->get('marcas');
		
		$sesion_admin = $this->session->userdata('sesion_admin');
		
		if($sesion_admin){
			$page = 'admin_page';
		}else{
			$page = 'admin_login_page';
		}
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);
	}
	
	public function login(){
		$this->load->helper('security');
        
        $correo_admin = $this->input->post('correo_admin');
        $password = $this->input->post('pass_admin');
        $password = do_hash($password, 'md5');
        
        $datos_usuario = array(
            'correo_admin' => $correo_admin,
            'password_admin' => $password
        );
        
        $usuario = $this->db->get_where('usuarios_admin', $datos_usuario);
        
        if($usuario->num_rows() > 0){
            $usuario = $usuario->row();
            if($correo_admin == 'oscarb@promored.mx'){
                $this->session->set_userdata('admin_root', TRUE);
            }
            $this->session->set_userdata('id_usuario_admin', $usuario->id_usuario_admin);
            $this->session->set_userdata('sesion_admin', TRUE);
            $this->session->set_userdata('sesion_administrador', TRUE);
            $this->session->set_userdata('login_ok', TRUE);
        }else{
            $this->session->set_flashdata("error_login", "Usuario y/o contraseña incorrectos.");
        }
		
		redirect('/admin');
		
	}
	
	public function logout(){
		$this->session->unset_userdata('sesion_admin');
		redirect('/admin');
	}
	
	public function validar_archivo(){
		$data = $this->header_lib->arma_rutas();
		$data = $this->header_lib->arma_menu($data);
		
		require_once APPPATH."/third_party/PHPExcel/IOFactory.php";
		$objPHPExcel = PHPExcel_IOFactory::load($_FILES['datafile']['tmp_name']);
		$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
		
		$con_foto = 0;
		$sin_foto = 0;
		
		$errores = array();
		$maximo_index = 4;
		$total_index = 0;
		
		$query_index = "update promociones set ver_index = 0 where ver_index = 1;";
		$this->db->query($query_index);
		
		//echo "<br />===============================================================<br />";
		
		foreach ($objWorksheet->getRowIterator() as $row) {
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false); 
			$rowIndex = $row->getRowIndex();
			$existe = FALSE;
			
			if($rowIndex != 1){
				
				$err_fila = "Fila : " . $rowIndex . ": ";
				
				$array = array();
				$array[] = '';
				foreach ($cellIterator as $cell) {
					$cell_row = $cell->getRow();
					$array[] = trim($cell->getValue());
					$colIndex = PHPExcel_Cell::columnIndexFromString($cell->getColumn());
				}
				
				//validar existencia de la promo
				$encuesta = $array[20];
				$promocion = $this->db->get_where('promociones',array('encuesta'=>$encuesta));
				if($promocion->num_rows() > 0){
					$existe = TRUE;
				}
				//validar existencia de la promo
				
				
				if($array[9] == "" || $array[9] == 0){
					$fecha_inicio = "N/A";
				}else{
					$fecha_inicio = $array[9];
				}
				
				if($array[10] == "" || $array[10] == 0){
					$fecha_fin = "N/A";
				}else{
					$fecha_fin = $array[10];
				}
				
				if($array[3] == "" || $array[3] == 0){
					$precio = "N/A";
				}else{
					$precio = $array[3];
				}
				
				if(!$existe){
					//Subir foto y agregar marca de agua
					$foto = trim($array[15]);
					
					$ruta_imagen = realpath(APPPATH . '../info/img') . "/" . $foto;
					$nueva_ruta = realpath(APPPATH . '../images_promo') . "/" . $foto;
					
					$error_foto = TRUE;
					
					if(file_exists($ruta_imagen)){
						//copy($ruta_imagen,$nueva_ruta);
						$error_foto = FALSE;
					}
				}else{
					$error_foto = FALSE;
				}
				
				
				if($error_foto){
					$error_actual = $err_fila . " Error al subir foto, Archivo: " . $foto;
					array_push($errores, $error_actual);
					$sin_foto++;
				}else{
					$error_promo = FALSE;
					
					if(!$error_promo){
						//Validar formato
						$id_formato = $array[17];
						$response = $this->promociones_lib->validar_formato($id_formato);
						if($response){
							$error_actual = $err_fila . $response;
							array_push($errores, $error_actual);
							$sin_foto++;
							$error_promo = TRUE;
						}
					}
					
					if(!$error_promo){
						//Validar ubicación
						$ubicacion = $array[18];
						$response = $this->promociones_lib->validar_ubicacion($ubicacion);
						if($response){
							$error_actual = $err_fila . $response;
							array_push($errores, $error_actual);
							$sin_foto++;
							$error_promo = TRUE;
						}
					}
					
					if(!$error_promo){
						//Validar año
						$anio = $array[8];
						
						$response = $this->promociones_lib->validar_anio($anio);
						if($response){
							$error_actual = $err_fila . $response;
							array_push($errores, $error_actual);
							$sin_foto++;
							$error_promo = TRUE;
						}
					}
					
					if(!$error_promo){
						//Validar semana
						$semana = $array[7];
						
						$response = $this->promociones_lib->validar_semana($semana);
						if($response){
							$error_actual = $err_fila . $response;
							array_push($errores, $error_actual);
							$sin_foto++;
							$error_promo = TRUE;
						}
					}
					
					if(!$error_promo){
						//Validar estado
						$estado = $array[16];
						
						$response = $this->promociones_lib->validar_estado($estado);
						if($response){
							$error_actual = $err_fila . $response;
							array_push($errores, $error_actual);
							$sin_foto++;
							$error_promo = TRUE;
						}
					}
					
					if(!$existe && !$error_promo){
						if(!$error_promo){
							//Validar subcategoría
							$subcategoria = $array[1];
							$response = $this->promociones_lib->validar_categoria($subcategoria);
							if($response){
								$error_actual = $err_fila . $response;
								array_push($errores, $error_actual);
								$sin_foto++;
								$error_promo = TRUE;
							}
						}
						
						if(!$error_promo){
							//Validar marca
							$marca = $array[2];
							$response = $this->promociones_lib->validar_marca($marca);
							if($response){
								$error_actual = $err_fila . $response;
								array_push($errores, $error_actual);
								$sin_foto++;
								$error_promo = TRUE;
							}
						}
						
						if(!$error_promo){
							//Validar tipo promocion
							$tipo_promocion = $array[6];
							$response = $this->promociones_lib->validar_promocion($tipo_promocion);
							if($response){
								$error_actual = $err_fila . $response;
								array_push($errores, $error_actual);
								$sin_foto++;
								$error_promo = TRUE;
							}
						}
						
						if(!$error_promo){
							$con_foto++;
						}
					}else{
						$con_foto++;
					}
				}
				
				unset($array);
				
			}//Termina if rowIndex
			
		}//Termina foreach
		
		if($sin_foto > 0){
			$this->load->helper('file');
			$this->load->helper('download');
			$datos_log = '';
			$datos_log .= "Lineas correctas -> " . $con_foto . "\r\n";
			$datos_log .= "Total errores -> " . $sin_foto . "\r\n\r\n";
			
			foreach($errores as $key => $value){
				$datos_log .= $value;
				$datos_log .= " \r\n";
			}
			
			$ahora = date('Y-m-d_H:i:s');
			$nombre_archivo = 'log_' . $ahora . '.txt';
			
			write_file(realpath(APPPATH . '..').'/logs/'.$nombre_archivo, $datos_log, 'a+');
			
			$data = file_get_contents(realpath(APPPATH . '..').'/logs/'.$nombre_archivo);
			
			force_download($nombre_archivo, $data);
		}else{
			$page = 'admin_upload_page';
			
			$this->load->view('templates/header', $data);
			$this->load->view('pages/'.$page, $data);
			$this->load->view('templates/footer', $data);
		}
		
	}
	
	public function upload_promos(){
		
		$this->load->library('promociones_lib');
		
		$data = $this->header_lib->arma_rutas();
		$data = $this->header_lib->arma_menu($data);
		
		$this->load->helper('string_helper');
		
		require_once APPPATH."/third_party/PHPExcel/IOFactory.php";
		$objPHPExcel = PHPExcel_IOFactory::load($_FILES['datafile']['tmp_name']);
		
		$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
		
		$con_foto = 0;
		$sin_foto = 0;
		
		$errores = array();
		$maximo_index = 4;
		$total_index = 0;
		
		$query_index = "update promociones set ver_index = 0 where ver_index = 1;";
		$this->db->query($query_index);
		
		//echo "<br />===============================================================<br />";
		
		foreach ($objWorksheet->getRowIterator() as $row) {
			$cellIterator = $row->getCellIterator();
			$cellIterator->setIterateOnlyExistingCells(false); 
			$rowIndex = $row->getRowIndex();
			$existe = FALSE;
			
			if($rowIndex != 1){
				
				$err_fila = "Fila : " . $rowIndex . ": ";
				
				$array = array();
				$array[] = '';
				foreach ($cellIterator as $cell) {
					$cell_row = $cell->getRow();
					$array[] = trim($cell->getValue());
					$colIndex = PHPExcel_Cell::columnIndexFromString($cell->getColumn());
				}
				
				
				$encuesta = $array[20];
				$promocion = $this->db->get_where('promociones',array('encuesta'=>$encuesta));
				
				if($promocion->num_rows() > 0){
					$existe = TRUE;
				}
				
				if($array[9] == "" || $array[9] == 0){
					$fecha_inicio = "N/A";
				}else{
					$fecha_inicio = $array[9];
				}
				
				if($array[10] == "" || $array[10] == 0){
					$fecha_fin = "N/A";
				}else{
					$fecha_fin = $array[10];
				}
				
				if($array[3] == ""){
					$precio = "N/A";
				}else{
					$precio = $array[3];
				}
				
				if(!$existe){
					$foto = trim($array[15]);
					
					$ruta_imagen = realpath(APPPATH . '../info/img') . "/" . $foto;
					$nueva_ruta = realpath(APPPATH . '../images_promo') . "/" . $foto;
					
					$error_foto = TRUE;
					
					$subir_foto = TRUE;
					
					if($subir_foto){
						if(file_exists($ruta_imagen)){
							//copy($ruta_imagen,$nueva_ruta);
							
							$image_overlay = realpath(APPPATH . '../images/wm.png');
							
							$config['source_image']	= $ruta_imagen;
							$config['wm_overlay_path'] = $image_overlay;
							$config['wm_type'] = 'overlay';
							$config['new_image'] = $nueva_ruta;
							$config['wm_font_color'] = 'ffffff';
							$config['wm_vrt_alignment'] = 'bottom';
							$config['wm_hor_alignment'] = 'center';
							$config['wm_padding'] = '20';
							
							$this->load->library('image_lib');
							$this->image_lib->initialize($config); 
							$this->image_lib->watermark();
							
							$error_foto = FALSE;
						}
					}else{
						$error_foto = FALSE;
					}
					
				}else{
					$error_foto = FALSE;
				}
				
				if($error_foto){
					
					$error_actual = $err_fila . " Error al subir foto, Archivo: " . $foto;
					array_push($errores, $error_actual);
					$sin_foto++;
				}else{
					
					$error_promo = FALSE;
					
					if(!$error_promo){
						//Validar formato
						$id_formato = $array[17];
						$response = $this->promociones_lib->validar_formato($id_formato);
						if($response){
							$error_actual = $err_fila . $response;
							array_push($errores, $error_actual);
							$sin_foto++;
							$error_promo = TRUE;
						}
					}
					
					if(!$error_promo){
						//Validar semana
						
						$semana = $array[7];
						
						$response = $this->promociones_lib->validar_semana($semana);
						if($response){
							$error_actual = $err_fila . $response;
							array_push($errores, $error_actual);
							$sin_foto++;
							$error_promo = TRUE;
						}
					}
					
					if(!$error_promo){
						//Validar año
						$anio = $array[8];
						
						$response = $this->promociones_lib->validar_anio($anio);
						if($response){
							$error_actual = $err_fila . $response;
							array_push($errores, $error_actual);
							$sin_foto++;
							$error_promo = TRUE;
						}
					}
					
					if(!$error_promo){
						//Validar estado
						$estado = $array[16];
						
						$response = $this->promociones_lib->validar_estado($estado);
						if($response){
							$error_actual = $err_fila . $response;
							array_push($errores, $error_actual);
							$sin_foto++;
							$error_promo = TRUE;
						}
					}
					
					if(!$error_promo){
						//Validar ubicación
						$ubicacion = $array[18];
						$response = $this->promociones_lib->validar_ubicacion($ubicacion);
						if($response){
							$error_actual = $err_fila . $response;
							array_push($errores, $error_actual);
							$sin_foto++;
							$error_promo = TRUE;
						}
					}
					
					if(!$existe && !$error_promo){
						if(!$error_promo){
							//Validar subcategoría
							$subcategoria = $array[1];
							$response = $this->promociones_lib->validar_categoria($subcategoria);
							if($response){
								$error_actual = $err_fila . $response;
								array_push($errores, $error_actual);
								$sin_foto++;
								$error_promo = TRUE;
							}
						}
						
						if(!$error_promo){
							//Validar marca
							$marca = $array[2];
							$response = $this->promociones_lib->validar_marca($marca);
							if($response){
								$error_actual = $err_fila . $response;
								array_push($errores, $error_actual);
								$sin_foto++;
								$error_promo = TRUE;
							}
						}
						
						if(!$error_promo){
							//Validar tipo promocion
							$tipo_promocion = $array[6];
							$response = $this->promociones_lib->validar_promocion($tipo_promocion);
							if($response){
								$error_actual = $err_fila . $response;
								array_push($errores, $error_actual);
								$sin_foto++;
								$error_promo = TRUE;
							}
						}
						
						
						/*
						if(!$error_promo){
							$con_foto++;
						}
						*/
					}
					
					if(!$error_promo){
						
						if(!$existe){
							
							$ahora = date('Y-m-d_H:i:s');
						
							if($total_index < $maximo_index){
								$ver_index = 1;
							}else{
								$ver_index = 0;
							}
							
							$total_index++;
							
							$datos = array(
								'subcategorias_id_subcategoria' => $subcategoria,
								'marcas_id_marca' => $marca,
								'precio' => $precio,
								'producto' => $array[4],
								'titulo' => $array[5],
								'tipos_promocion_id_tipo_promocion' => $tipo_promocion,
								'semana_inicio' => $semana,
								'anio' => $anio,
								'fecha_inicio' => $fecha_inicio,
								'fecha_fin' => $fecha_fin,
								'vigencia' => $array[11],
								'descripcion' => $array[12],
								'mecanica' => $array[13],
								'regalo' => $array[14],
								'foto' => $foto,
								'fecha_alta' => $ahora,
								'ver_index' => $ver_index,
								'encuesta' => $encuesta
							);
							
							$this->db->insert('promociones', $datos);
							
							if($this->db->_error_number() != 0){
								$error_promo = TRUE;
							}else{
								$id_promocion = $this->db->insert_id();
							}
							
						}else{
							$id_promocion = $promocion->row()->id_promocion;
						}
						
						if($error_promo){
							$error_actual = "Fila: " . $rowIndex;
							$error_actual .= " - Error en base de datos - " . $this->db->_error_message();
							array_push($errores, $error_actual);
						}else{
							$datos = array(
								'promociones_id_promocion' => $id_promocion,
								'estados_id_estado' => $array[16],
								'formatos_id_formato' => $id_formato,
								'ubicaciones_id_ubicacion' => $ubicacion,
								'semana' => $semana,
								'activa' => $array[19],
								'anio' => $anio,
								'precio' => $precio
							);
							
							$this->db->insert('ubicacion_promocion', $datos);
							
							if($existe){
								$id_promocion = $this->db->insert_id();
								$error_actual = "Id insertado de promoción existente-> " .  $id_promocion;
							}else{
								$error_actual = "Id insertado de promoción nueva-> " .  $id_promocion;
							}
							
							array_push($errores, $error_actual);
							
							$con_foto++;
						}
					}
					
				}
				
				unset($array);
				
			}//Termina if rowIndex
			
		}//Termina foreach
		
		
		$currentCell = $objPHPExcel->getActiveSheet()->getActiveCell();
		
		$data['errores'] = $errores;
		
		$this->load->helper('file');
		$this->load->helper('download');
		$datos_log = '';
		$datos_log .= "Lineas correctas -> " . $con_foto . "\r\n";
		$datos_log .= "Total errores -> " . $sin_foto . "\r\n\r\n";
		
		foreach($errores as $key => $value){
			$datos_log .= $value;
			$datos_log .= " \n";
		}
		
		
		$ahora = date('Y-m-d_H:i:s');
		$nombre_archivo = 'log_' . $ahora . '.txt';
		
		if ( ! write_file(realpath(APPPATH . '..').'/logs/'.$nombre_archivo, $datos_log, 'a+'))
		{
			//echo 'Unable to write the file';
		}
		else
		{
			//echo 'File written!';
		}
		
		
		$this->session->set_flashdata('nombre_log', $nombre_archivo);
		redirect('/admin');
		/*
		$data = file_get_contents(realpath(APPPATH . '..').'/logs/'.$nombre_archivo);
		
		force_download($nombre_archivo, $data);
		
		$page = 'resultados_admin_page';
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);
		*/
	}
	
	public function catalogo(){
		$array_contenido = array();
		$array_nuevo = array();
		
		$this->load->model('formato_model');
		$this->load->model('marca_model');
		$this->load->model('estado_model');
		$this->load->model('categoria_model');
		$this->load->model('tipo_promocion_model');
		
		$array_sheets = array();
		
		$formatos = $this->formato_model->get_all();
		$columnas = array('nombre_formato', 'id_formato');
		$titulo = 'Formato';
		$array_nuevo = array($formatos, $columnas, $titulo);
		array_push($array_sheets, $titulo);
		array_push($array_contenido, $array_nuevo);
		
		$marcas = $this->marca_model->get_all();
		$columnas = array('nombre_marca', 'id_marca');
		$titulo = 'Marca';
		$array_nuevo = array($marcas, $columnas, $titulo);
		array_push($array_sheets, $titulo);
		array_push($array_contenido, $array_nuevo);
		
		$estados = $this->estado_model->get_all();
		$columnas = array('nombre_estado', 'id_estado');
		$titulo = 'Estados';
		$array_nuevo = array($estados, $columnas, $titulo);
		array_push($array_sheets, $titulo);
		array_push($array_contenido, $array_nuevo);
		
		$tipos_promocion = $this->tipo_promocion_model->get_all();
		$columnas = array('nombre_tipo_promocion', 'id_tipo_promocion');
		$titulo = 'Tipo de Promoción';
		$array_nuevo = array($tipos_promocion, $columnas, $titulo);
		array_push($array_sheets, $titulo);
		array_push($array_contenido, $array_nuevo);
		
		$ubicaciones = $this->db->get('ubicaciones');
		$columnas = array('id_ubicacion', 'nombre_ubicacion');
		$titulo = 'Ubicaciones';
		$array_nuevo = array($ubicaciones, $columnas, $titulo);
		array_push($array_sheets, $titulo);
		array_push($array_contenido, $array_nuevo);
		
		$query_categorias = '
		select cat.id_categoria as ID_CATEGORIA_PADRE, cat.nombre_categoria as NOMBRE_CATEGORIA_PADRE, 
		sub.id_subcategoria, sub.nombre_subcategoria 
		from subcategorias as sub
		left join categorias as cat on cat.id_categoria = sub.categorias_id_categoria
		order by cat.id_categoria, sub.nombre_subcategoria
		';
		
		$categorias = $this->db->query($query_categorias);
		$columnas = array('ID_CATEGORIA_PADRE', 'NOMBRE_CATEGORIA_PADRE', 'id_subcategoria', 'nombre_subcategoria');
		$titulo = 'Categoria';
		$array_nuevo = array($categorias, $columnas, $titulo);
		
		array_push($array_contenido, $array_nuevo);
		
		$crear_excel = 1;
		
		if($crear_excel == 1){
			//cargar la libreria de excel
			$this->load->library('excel');
			
			$contador_letra = 0;
			$contador_titulos = 0;
			
			foreach( $array_contenido as $key => $array_cont){
				//Activa hoja de catálogo
				$contador_letra = 0;
				
				$objetos = $array_cont[0];
				$columnas = $array_cont[1];
				$titulo = $array_cont[2];
				$letras = array();
				$contador = 1;
				
				$objWorkSheet = $this->excel->createSheet($key);
				$this->excel->setActiveSheetIndex($key);
				$this->excel->getActiveSheet()->setTitle($titulo);
				$this->excel->setActiveSheetIndex($key);
				
				
				
				$this->excel->getActiveSheet()->setCellValue(entradaColumna($contador_letra).$contador, $titulo);
				$this->excel->getActiveSheet()->getRowDimension($contador)->setRowHeight(15);
				$contador++;
				
				
				
				for($i=0;$i<count($columnas);$i++){
					$letra = entradaColumna($contador_letra);
					array_push($letras, $letra);
					$this->excel->getActiveSheet()->setCellValue($letra.$contador, $columnas[$i]);
					$this->excel->getActiveSheet()->getColumnDimension($letra)->setAutoSize(true);
					//$this->excel->getActiveSheet()->getColumnDimension($letra)->setWidth(20);
					$contador_letra++;
				}
				
				//Hasta aquí ok
				$this->excel->getActiveSheet()->getStyle($letras[0].($contador-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				
				$cadena = $letras[0].($contador-1).":".$letras[count($letras)-1].($contador-1);
				$letra_inicio = $letras[0];
				$letra_fin = $letras[count($letras)-1];
				
				$this->excel->getActiveSheet()->mergeCells($cadena);
				
				$this->excel->getActiveSheet()->getRowDimension($contador)->setRowHeight(15);
				$contador++;
				
				$cont_inicio = $contador;
				
				if(gettype($objetos) == 'object'){
					foreach($objetos->result_array() as $objeto){
						for($i=0;$i<count($columnas);$i++){
							$this->excel->getActiveSheet()->setCellValue($letras[$i].$contador, $objeto[ $columnas[$i] ]);
						}
						$this->excel->getActiveSheet()->getRowDimension($contador)->setRowHeight(15);
						$contador++;
					}	
				}else{
					foreach($objetos as $objeto){
						for($i=0;$i<count($columnas);$i++){
							$this->excel->getActiveSheet()->setCellValue($letras[$i].$contador, $objeto[ $columnas[$i] ]);
						}
						$this->excel->getActiveSheet()->getRowDimension($contador)->setRowHeight(15);
						$contador++;
					}
				}
			}
			
			$this->excel->setActiveSheetIndex(0);
			
			$campos_extra = 6;
			
			
			$descargar_excel = TRUE;
			
			if($descargar_excel){
				$filename='Catalogo.xls'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel'); //mime type
				header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
				header('Cache-Control: max-age=0'); //no cache
				
				//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
				//if you want to save it as .XLSX Excel 2007 format
				
				$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
				
				//force user to download the Excel file without writing it to server's HD
				$objWriter->save('php://output');
			}
			
		}else{
			echo gettype($crear_excel) . "<br />";
			echo gettype($productos) . "<br />";
			echo gettype($categorias) . "<br />";
		}
	}
	
	public function watermark(){
		$this->load->helper('directory');
		$this->load->library('image_lib');
		
		$ruta_imagenes = realpath(APPPATH . '../info/img2');
		$nueva_ruta_imagenes = realpath(APPPATH . '../info/img3');
		$image_overlay = realpath(APPPATH . '../images/wm.png');
		
		echo "imagenes -> ";
		echo $ruta_imagenes;
		$imagenes = directory_map($ruta_imagenes);
		
		foreach($imagenes as $imagen){
			echo "<br />";
			$ruta_imagen = $ruta_imagenes . "/" . $imagen;
			$nueva_ruta = $nueva_ruta_imagenes . "/" . $imagen;
			echo $ruta_imagen;
			
			$config['source_image']	= $ruta_imagen;
			$config['wm_overlay_path'] = $image_overlay;
			$config['wm_type'] = 'overlay';
			$config['new_image'] = $nueva_ruta;
			$config['wm_font_color'] = 'ffffff';
			$config['wm_vrt_alignment'] = 'bottom';
			$config['wm_hor_alignment'] = 'center';
			$config['wm_padding'] = '20';
			
			try{
				$this->load->library('image_lib');
				$this->image_lib->clear();
				$this->image_lib->initialize($config);
				$this->image_lib->watermark();
			}catch(Exception $e){
				echo "<br />exc";
			}
			
			echo "Error: ";
			echo $this->image_lib->display_errors();
			echo "<br />";
		}
	}
	
	public function waterm($imagen = NULL){
		if($imagen){
			$this->load->library('image_lib');
			$ruta_imagenes = realpath(APPPATH . '../info/img');
			$nueva_ruta_imagenes = realpath(APPPATH . '../images_promo');
			$image_overlay = realpath(APPPATH . '../images/wm.png');
			
			$ruta_imagen = $ruta_imagenes . "/" . $imagen;
			$nueva_ruta = $nueva_ruta_imagenes . "/" . $imagen;
			
			$config['source_image']	= $ruta_imagen;
			$config['wm_overlay_path'] = $image_overlay;
			$config['wm_type'] = 'overlay';
			$config['new_image'] = $nueva_ruta;
			$config['wm_font_color'] = 'ffffff';
			$config['wm_vrt_alignment'] = 'bottom';
			$config['wm_hor_alignment'] = 'center';
			$config['wm_padding'] = '20';
			
			try{
				$this->load->library('image_lib');
				$this->image_lib->clear();
				$this->image_lib->initialize($config);
				$this->image_lib->watermark();
			}catch(Exception $e){
				echo "<br />exc";
			}
			
			echo "Error: ";
			echo $this->image_lib->display_errors();
			echo "<br />";
			
		}else{
			echo "No hay imagen";
		}
	}
	
	public function descargar_log($nombre_log){
		
		$this->load->helper('download');
		$data = file_get_contents(realpath(APPPATH . '..').'/logs/'.$nombre_log);
		
		force_download($nombre_log, $data);
		
		echo $nombre_log;
	}
	
	public function obtener_promo(){
		$id_promo = $this->input->post('id_promo');
		
		$promocion = $this->db->get_where('promociones', array('id_promocion' => $id_promo));
		
		if($promocion->num_rows() > 0){
			$promocion = $promocion->row_array();
			$id_subcategoria = $promocion['subcategorias_id_subcategoria'];
			$subcategoria = $this->db->get_where('subcategorias',array('id_subcategoria' => $id_subcategoria))->row()->nombre_subcategoria;
			$promocion['subcategoria'] = $subcategoria;
		}
		
		$codigo = 77;
		
		
		$response = array(
			'codigo' => $codigo,
			'promocion' => $promocion
		);
		
		echo json_encode($response);
	}
	
	public function actualizar_promo(){
		$id_promo = $this->input->post('id_promo');
		$campo = $this->input->post('campo');
		$valor = $this->input->post('valor');
		
		
		$arr_campos = array(
			'titulo' => 'titulo',
			'producto' => 'producto',
			'descripcion' => 'descripcion',
			'subcategoria' => 'subcategorias_id_subcategoria',
			'marca' => 'marcas_id_marca'
		);
		
		$campo = $arr_campos[$campo];
		
		$datos_promocion = array(
			'id_promocion' => $id_promo
		);
		
		$nuevos_datos_promo = array(
			$campo => $valor
		);
		
		$this->db->where($datos_promocion);
		$this->db->update('promociones',$nuevos_datos_promo);
		$codigo = $this->db->_error_number();
		
		$response = array(
			'codigo' => $codigo
		);
		
		echo json_encode($response);
		
	}
	
	public function borrar_promo(){
		$id_promo = $this->input->post("id_promo");
		$mensaje = '';
		
		$query1 = 'delete from ubicacion_promocion where promociones_id_promocion = '.$id_promo.';';
		
		$this->db->query($query1);
		$codigo =$this->db->_error_number();
		
		if($codigo == 0){
			$query2 = 'delete from promociones where id_promocion = '.$id_promo.';';
			$this->db->query($query2);
		}
		
		$codigo =$this->db->_error_number();
		$mensaje = $this->db->_error_message();
		
		
		$response = array(
			'codigo' => $codigo,
			'mensaje' => $mensaje
		);
		
		echo json_encode($response);
	}
	
	public function modificar_campo(){
		
		$campo = $this->input->post('campo');
		$id_campo = $this->input->post('id_campo');
		$nuevo_nombre = $this->input->post('nuevo_nombre');
		
		$codigo = 0;
		
		switch($campo){
			case 'marca':
				$datos_update = array(
					'nombre_marca' => $nuevo_nombre
				);
				$this->db->where('id_marca', $id_campo);
				$this->db->update('marcas', $datos_update);
				$codigo = $this->db->_error_number();
				break;
		}
		
		$response = array(
			'codigo' => $codigo
		);
		
		echo json_encode($response);
	}
	
	public function set_index(){
		
		$this->db->update('promociones', array('ver_index' => 0));
		
		$this->db->order_by('fecha_alta', 'desc');
		$this->db->limit(20);
		$promociones = $this->db->get('promociones');
		
		foreach($promociones->result() as $promocion){
			$id_promo = $promocion->id_promocion;
			
			$this->db->where('id_promocion', $id_promo);
			$this->db->update('promociones', array('ver_index' => 1));
			
		}
		
	}
	
}
