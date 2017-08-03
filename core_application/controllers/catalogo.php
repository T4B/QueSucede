<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function entradaColumna($col_ent){
	$hdc = array(
			0 => "A", 1 => "B", 2 => "C", 3 => "D", 4 => "E",
			5 => "F", 6 => "G", 7 => "H", 8 => "I", 9 => "J",
			10 => "K", 11 => "L", 12 => "M", 13 => "N", 14 => "O",
			15 => "P", 16 => "Q", 17 => "R", 18 => "S", 19 => "T",
			20 => "U", 21 => "V", 22 => "W", 23 => "X", 24 => "Y", 25 => "Z");
	return ($col_ent < 26) ? $hdc[$col_ent] : $hdc[(int)($col_ent/26)-1].$hdc[($col_ent % 26)];
}

function get_array_titulos(){
	$hdc = array(
			0 => "MES", 1 => "FORMATO", 2 => "SUCURSAL", 3 => "MARCA",
			4 => "PRODUCTO", 5 => "CATEGORIA", 6 => "ESTADO", 7 => "TIPO DE PROMOCION",
			8 => "FECHA_INICIO",9 => "FECHA_FIN", 10 => "TITULO",
			11 => "DESCRIPCION", 12 => "MECANICA", 13 => "IMAGEN");
	return $hdc;
}

function llenaExcel(){
	$this->excel->setActiveSheetIndex(0);
	$this->excel->getActiveSheet()->setCellValue('F1', 'Valorr');
}

class Catalogo extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('date_helper');
		$this->load->library('header_lib');
		$this->load->library('login_lib');
		date_default_timezone_set('America/Mexico_City');
		
	}
	
	public function index()
	{
		
		$data = $this->header_lib->arma_rutas();
		
		if($this->login_lib->verifica_login()){
			$this->load->helper("security");
			
			$data = $this->header_lib->arma_menu($data);
		}
		
		$page = "catalogos_page";
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page);
		$this->load->view('templates/footer', $data);
	}
	
	public function nueva_marca(){
		
		$marca = $this->input->post("marca");
		
		$id_marca = '';
			$nombre_marca = '';
		
		$array = array(
			'nombre_marca' => $marca
		);
		
		$obj_marca = $this->db->get_where('marcas', $array);
		
		if($obj_marca->num_rows() == 0){
			$this->db->insert('marcas',array(
			'nombre_marca' => $marca,
			'logo_marca' => 'img_ref.jpg'
			));
			
			$codigo = $this->db->_error_number();
			
			if($codigo == 0){
				$obj_marca = $this->db->get_where('marcas', $array)->row();
				
				$id_marca = $obj_marca->id_marca;
				$nombre_marca = $obj_marca->nombre_marca;
				
				$mensaje = "Marca agregada correctamente";
			}else{
				$mensaje = $this->db->_error_message();
			}
		}else{
			$codigo = -1;
			$mensaje = "Esa marca ya se encuentra en la base;";
		}
		
		
		
		$response = array(
			'codigo' => $codigo,
			'id_marca' => $id_marca,
			'nombre_marca' => $nombre_marca,
			'mensaje' => $mensaje
		);
		
		echo json_encode($response);
	}
	
	public function nueva_subcategoria(){
		
		$categoria = $this->input->post("categoria");
		$subcategoria = $this->input->post("subcategoria");
		
		$datos = array(
			'nombre_subcategoria' => $subcategoria,
			'categorias_id_categoria' => $categoria
		);
		
		$this->db->insert('subcategorias', $datos);
		$codigo = $this->db->_error_number();
		
		if($codigo == 0){
			$mensaje = "Subcategoría agregada correctamente.";
		}else{
			$mensaje = $this->db->_error_message();
		}
		
		$response = array(
			'codigo' => $codigo,
			'mensaje' => $mensaje
		);
		
		echo json_encode($response);
	}
	
	public function nueva_categoria(){
		$categoria = $this->input->post("categoria");
		$id_categoria = 0;
		
		$this->db->insert('categorias', array(
										'nombre_categoria' => $categoria,
										'img_categoria' => 'img_cat.jpg'
										));
		
		$codigo = $this->db->_error_number();
		
		if($codigo == 0){
			$id_categoria = $this->db->insert_id();
			$mensaje = "Categoría agregada correctamente";
		}else{
			$mensaje = "Error al agregar categoría, verifique el catálogo e intente de nuevo.";
		}
		
		$response = array(
			'codigo' => $codigo,
			'mensaje' => $mensaje,
			'id_categoria' => $id_categoria
		);
		
		echo json_encode($response);
	}
	
	
	public function nuevo_canal(){
		$canal = $this->input->post("canal");
		$id_categoria = 0;
		
		$this->db->insert('canales', array(
										'nombre_canal' => $canal
										));
		
		$codigo = $this->db->_error_number();
		
		if($codigo == 0){
			$id_canal = $this->db->insert_id();
			$mensaje = "Canal agregado correctamente";
		}else{
			$mensaje = "Error al agregar canal, verifique el catálogo e intente de nuevo.";
		}
		
		$response = array(
			'codigo' => $codigo,
			'mensaje' => $mensaje,
			'id_canal' => $id_canal
		);
		
		echo json_encode($response);
		
	}
	
}
