<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Promociones_cadena extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('date_helper');
		$this->load->library('header_lib');
		$this->load->library('login_lib');
		
	}
	
	public function index()
	{
		$data = $this->header_lib->arma_rutas();
		

		if($this->login_lib->verifica_login()){

			$data = $this->header_lib->arma_menu($data);
			
			$data['title'] = 'Reportes';

			$this->db->order_by('nombre_formato');
			$formatos = $this->db->get('formatos');
			$data['formatos'] = $formatos;

			$this->db->order_by('nombre_categoria');
			$categorias = $this->db->get('categorias');
			$data['categorias'] = $categorias;

			/*Grafica General*/
			$query_general = 'select tp.nombre_tipo_promocion as promocion,count(tp.nombre_tipo_promocion)as total, ';
			$query_general .= 'f.nombre_formato as formato,ca.nombre_categoria ';
			$query_general .= 'from ubicacion_promocion as up ';
			$query_general .= 'left join formatos as f on f.id_formato = up.formatos_id_formato ';
			$query_general .= 'left join promociones as p on p.id_promocion = up.promociones_id_promocion ';
			$query_general .= 'left join tipos_promocion as tp on tp.id_tipo_promocion = p.tipos_promocion_id_tipo_promocion ';
			$query_general .= 'left join subcategorias as sc on sc.id_subcategoria = p.subcategorias_id_subcategoria ';
			$query_general .= 'left join categorias as ca on ca.id_categoria = sc.categorias_id_categoria ';
			//$query_general .= 'where up.formatos_id_formato = 1
			//$query_general .= 'and sc.categorias_id_categoria = 1
			$query_general .= 'group by promocion ';

			$promociones_general = $this->db->query($query_general);
			$data['promociones_general'] = $promociones_general;


			$page = 'promocion_cadena_page';
			$this->load->view('templates/header',$data);
			$this->load->view('pages/'.$page);
			$this->load->view('templates/footer', $data);
			
		}
		else{
			redirect('/', 'refresh');
		}
	}

	public function cadena()
	{

		$cadena = $this->input->post("cadena");
		$categoria = $this->input->post("categoria");

		/*Grafica General*/
		$query_general = 'select tp.nombre_tipo_promocion as promocion,count(tp.nombre_tipo_promocion)as total, ';
		$query_general .= 'f.nombre_formato as formato,ca.nombre_categoria ';
		$query_general .= 'from ubicacion_promocion as up ';
		$query_general .= 'left join formatos as f on f.id_formato = up.formatos_id_formato ';
		$query_general .= 'left join promociones as p on p.id_promocion = up.promociones_id_promocion ';
		$query_general .= 'left join tipos_promocion as tp on tp.id_tipo_promocion = p.tipos_promocion_id_tipo_promocion ';
		$query_general .= 'left join subcategorias as sc on sc.id_subcategoria = p.subcategorias_id_subcategoria ';
		$query_general .= 'left join categorias as ca on ca.id_categoria = sc.categorias_id_categoria ';
		if($categoria != 0){
			$query_general .= 'where sc.categorias_id_categoria = '. $categoria ;
		}
		$query_general .= ' group by promocion ';

		$promociones_general = $this->db->query($query_general);
		$data['promociones_general'] = $promociones_general;

		$array_general = array();
		
		foreach ($promociones_general->result() as $promocion)
		{
			array_push($array_general, array($promocion->promocion,$promocion->total));
		}


		/*Grafica tipo cadena*/
		$query_cadena = 'select tp.nombre_tipo_promocion as promocion,count(tp.nombre_tipo_promocion)as total, ';
		$query_cadena .= 'f.nombre_formato as formato,ca.nombre_categoria ';
		$query_cadena .= 'from ubicacion_promocion as up ';
		$query_cadena .= 'left join formatos as f on f.id_formato = up.formatos_id_formato ';
		$query_cadena .= 'left join promociones as p on p.id_promocion = up.promociones_id_promocion ';
		$query_cadena .= 'left join tipos_promocion as tp on tp.id_tipo_promocion = p.tipos_promocion_id_tipo_promocion ';
		$query_cadena .= 'left join subcategorias as sc on sc.id_subcategoria = p.subcategorias_id_subcategoria ';
		$query_cadena .= 'left join categorias as ca on ca.id_categoria = sc.categorias_id_categoria ';
		$query_cadena .= 'where up.formatos_id_formato = '. $cadena ;
		if($categoria != 0){
			$query_cadena .= ' and sc.categorias_id_categoria = '. $categoria ;
		}
		$query_cadena .= ' group by promocion ';

		$promociones_cadenas = $this->db->query($query_cadena);
		$data['promociones_cadenas'] = $promociones_cadenas;

		$array_cadenas = array();
		
		foreach ($promociones_cadenas->result() as $cadenas)
		{
			array_push($array_cadenas, array($cadenas->promocion,$cadenas->total));
		}

		$dato_cadenas = array(
			"general"=>$array_general,
			"cadenas"=>$array_cadenas
		);

		echo json_encode($dato_cadenas,JSON_NUMERIC_CHECK);

	}
}