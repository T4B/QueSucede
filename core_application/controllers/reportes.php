<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reportes extends CI_Controller {

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
			$this->db->order_by('nombre_categoria');
			$categorias = $this->db->get('categorias');
			$data['categorias'] = $categorias;
			/*$query_grafica = 'select tp.nombre_tipo_promocion as promocion,';
			$query_grafica .= 'sum(if (f.id_formato = 5 , 1,0)) as "Bodega_Aurrera", ';
			$query_grafica .= 'sum(if (f.id_formato = 4 , 1,0)) as "Chedraui", ';
			$query_grafica .= 'sum(if (f.id_formato = 2 , 1,0)) as "Comercial_Mexicana", ';
			$query_grafica .= 'sum(if (f.id_formato = 3 , 1,0)) as "Soriana", ';
			$query_grafica .= 'sum(if (f.id_formato = 6 , 1,0)) as "Superama", ';
			$query_grafica .= 'sum(if (f.id_formato = 1 , 1,0)) as "Walmart_Supercenter" ';
			$query_grafica .= 'from ubicacion_promocion as up ';
			$query_grafica .= 'LEFT JOIN formatos as f on f.id_formato = up.formatos_id_formato ';
			$query_grafica .= 'LEFT JOIN promociones as p on p.id_promocion = up.promociones_id_promocion ';
			$query_grafica .= 'LEFT JOIN tipos_promocion as tp on tp.id_tipo_promocion = p.tipos_promocion_id_tipo_promocion ';
			$query_grafica .= 'GROUP BY promocion ';
			$query_grafica .= 'ORDER BY promocion ';*/

			$query_grafica = 'select f.nombre_formato as formato, ';
			$query_grafica .= 'sum(if (tp.id_tipo_promocion = 1 , 1,0)) as "Activación", ';
			$query_grafica .= 'sum(if (tp.id_tipo_promocion = 2 , 1,0)) as "Autoliquidable", ';
			$query_grafica .= 'sum(if (tp.id_tipo_promocion = 10 , 1,0)) as "Bonificación_de_Producto", ';
			$query_grafica .= 'sum(if (tp.id_tipo_promocion = 3 , 1,0)) as "Canje", ';
			$query_grafica .= 'sum(if (tp.id_tipo_promocion = 4 , 1,0)) as "Concurso", ';
			$query_grafica .= 'sum(if (tp.id_tipo_promocion = 9 , 1,0)) as "Descuento_en_Precio", ';
			$query_grafica .= 'sum(if (tp.id_tipo_promocion = 5 , 1,0)) as "Emplaye", ';
			$query_grafica .= 'sum(if (tp.id_tipo_promocion = 6 , 1,0)) as "In_On_Pack", ';
			$query_grafica .= 'sum(if (tp.id_tipo_promocion = 7 , 1,0)) as "Instant_Win", ';
			$query_grafica .= 'sum(if (tp.id_tipo_promocion = 8 , 1,0)) as "Sampling" ';
			$query_grafica .= 'from ubicacion_promocion as up ';
			$query_grafica .= 'LEFT JOIN formatos as f on f.id_formato = up.formatos_id_formato ';
			$query_grafica .= 'LEFT JOIN promociones as p on p.id_promocion = up.promociones_id_promocion ';
			$query_grafica .= 'LEFT JOIN tipos_promocion as tp on tp.id_tipo_promocion = p.tipos_promocion_id_tipo_promocion ';
			$query_grafica .= 'GROUP BY formato ';
			$query_grafica .= 'ORDER BY formato ';

			$promociones = $this->db->query($query_grafica);
			$data['promociones'] = $promociones;
			
			$page = 'reportes_page';
			$this->load->view('templates/header',$data);
			$this->load->view('pages/'.$page);
			$this->load->view('templates/footer', $data);
			

		}else{
			redirect('/', 'refresh');
		}	
		

	}

	public function semana()
	{
		//$data = $this->header_lib->arma_rutas();
		
		//$data['es_index'] = TRUE;

		$semana = $this->input->post("semana");
		$anio = $this->input->post("anio");
		$categoria = $this->input->post("categoria");

		/*$query_grafica = 'select tp.nombre_tipo_promocion as promocion,';
		$query_grafica .= 'sum(if (f.id_formato = 5 , 1,0)) as "Bodega_Aurrera", ';
		$query_grafica .= 'sum(if (f.id_formato = 4 , 1,0)) as "Chedraui", ';
		$query_grafica .= 'sum(if (f.id_formato = 2 , 1,0)) as "Comercial_Mexicana", ';
		$query_grafica .= 'sum(if (f.id_formato = 3 , 1,0)) as "Soriana", ';
		$query_grafica .= 'sum(if (f.id_formato = 6 , 1,0)) as "Superama", ';
		$query_grafica .= 'sum(if (f.id_formato = 1 , 1,0)) as "Walmart_Supercenter" ';
		$query_grafica .= 'from ubicacion_promocion as up ';
		$query_grafica .= 'LEFT JOIN formatos as f on f.id_formato = up.formatos_id_formato ';
		$query_grafica .= 'LEFT JOIN promociones as p on p.id_promocion = up.promociones_id_promocion ';
		$query_grafica .= 'LEFT JOIN tipos_promocion as tp on tp.id_tipo_promocion = p.tipos_promocion_id_tipo_promocion ';
		$query_grafica .= 'WHERE up.semana = '.$semana ;
		$query_grafica .= ' GROUP BY promocion ';
		$query_grafica .= 'ORDER BY promocion ';*/

		$query_grafica = 'select f.nombre_formato as formato, ';
		$query_grafica .= 'sum(if (tp.id_tipo_promocion = 1 , 1,0)) as "Activación", ';
		$query_grafica .= 'sum(if (tp.id_tipo_promocion = 2 , 1,0)) as "Autoliquidable", ';
		$query_grafica .= 'sum(if (tp.id_tipo_promocion = 10 , 1,0)) as "Bonificación_de_Producto", ';
		$query_grafica .= 'sum(if (tp.id_tipo_promocion = 3 , 1,0)) as "Canje", ';
		$query_grafica .= 'sum(if (tp.id_tipo_promocion = 4 , 1,0)) as "Concurso", ';
		$query_grafica .= 'sum(if (tp.id_tipo_promocion = 9 , 1,0)) as "Descuento_en_Precio", ';
		$query_grafica .= 'sum(if (tp.id_tipo_promocion = 5 , 1,0)) as "Emplaye", ';
		$query_grafica .= 'sum(if (tp.id_tipo_promocion = 6 , 1,0)) as "In_On_Pack", ';
		$query_grafica .= 'sum(if (tp.id_tipo_promocion = 7 , 1,0)) as "Instant_Win", ';
		$query_grafica .= 'sum(if (tp.id_tipo_promocion = 8 , 1,0)) as "Sampling" ';
		$query_grafica .= 'from ubicacion_promocion as up ';
		$query_grafica .= 'LEFT JOIN formatos as f on f.id_formato = up.formatos_id_formato ';
		$query_grafica .= 'LEFT JOIN promociones as p on p.id_promocion = up.promociones_id_promocion ';
		$query_grafica .= 'LEFT JOIN tipos_promocion as tp on tp.id_tipo_promocion = p.tipos_promocion_id_tipo_promocion ';
		$query_grafica .= 'LEFT JOIN subcategorias as sc on sc.id_subcategoria = p.subcategorias_id_subcategoria ';
		$query_grafica .= 'LEFT JOIN categorias as ca on ca.id_categoria = sc.categorias_id_categoria ';
		//$query_grafica .= 'WHERE up.semana = '. $semana ;
		if($semana != 0 and $categoria == 0){
			$query_grafica .= 'WHERE up.semana = '. $semana ;
			$query_grafica .= ' AND up.anio = '. $anio ;
		}
		if($semana == 0 and $categoria != 0){
			$query_grafica .= 'WHERE sc.categorias_id_categoria = '. $categoria ;
		}
		if($semana != 0 and $categoria != 0){
			$query_grafica .= 'WHERE up.semana = '. $semana ;
			$query_grafica .= ' AND up.anio = '. $anio ;
			$query_grafica .= ' and sc.categorias_id_categoria = '. $categoria ;
		}

		$query_grafica .= ' GROUP BY formato ';
		$query_grafica .= 'ORDER BY formato ';

		$promociones = $this->db->query($query_grafica);

		$array_promociones = array();

		foreach ($promociones->result() as $promocion) {
			array_push($array_promociones, $promocion);
		}

		//echo 'Resultados totales: ' . $promociones->num_rows();

		$array_grafica = array(
			"query"=>$array_promociones,
			"query1"=>$query_grafica
		);
		
		echo json_encode($array_grafica,JSON_NUMERIC_CHECK);


	}
	/*Funciones graficas pastel*/
	public function todas_cadenas()
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
			$query_general .= 'tp.color_grafica as color,f.nombre_formato as formato,ca.nombre_categoria ';
			$query_general .= 'from ubicacion_promocion as up ';
			$query_general .= 'left join formatos as f on f.id_formato = up.formatos_id_formato ';
			$query_general .= 'left join promociones as p on p.id_promocion = up.promociones_id_promocion ';
			$query_general .= 'left join tipos_promocion as tp on tp.id_tipo_promocion = p.tipos_promocion_id_tipo_promocion ';
			$query_general .= 'left join subcategorias as sc on sc.id_subcategoria = p.subcategorias_id_subcategoria ';
			$query_general .= 'left join categorias as ca on ca.id_categoria = sc.categorias_id_categoria ';
			$query_general .= 'where 1 ';
			$query_general .= ' group by promocion ';

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
		$semana_ini = $this->input->post("semana_ini");
		$anio_ini = $this->input->post("anio_ini");
		$semana_fin = $this->input->post("semana_fin");		
		$anio_fin = $this->input->post("anio_fin");

		/*Grafica General*/
		$query_general = 'select tp.nombre_tipo_promocion as promocion,count(tp.nombre_tipo_promocion)as total, ';
		$query_general .= 'tp.color_grafica as color,f.nombre_formato as formato,ca.nombre_categoria,up.semana,up.anio ';
		$query_general .= 'from ubicacion_promocion as up ';
		$query_general .= 'left join formatos as f on f.id_formato = up.formatos_id_formato ';
		$query_general .= 'left join promociones as p on p.id_promocion = up.promociones_id_promocion ';
		$query_general .= 'left join tipos_promocion as tp on tp.id_tipo_promocion = p.tipos_promocion_id_tipo_promocion ';
		$query_general .= 'left join subcategorias as sc on sc.id_subcategoria = p.subcategorias_id_subcategoria ';
		$query_general .= 'left join categorias as ca on ca.id_categoria = sc.categorias_id_categoria ';
		$query_general .= 'where 1 ';		
		if($categoria != 0){
			$query_general .= 'AND sc.categorias_id_categoria = '. $categoria ;
		}

		if($anio_ini == $anio_fin){
			$conj = ' AND ';
		}else{
			$conj = ' OR ';
		}		

		if($cadena == 0 and $categoria == 0){
			$query_general .= ' AND ((up.anio = '.$anio_ini.' AND up.semana >= '.$semana_ini.')'.$conj.'(up.anio = '.$anio_fin.' and up.semana <= '.$semana_fin.') ) ';
		}
		$query_general .= ' group by promocion ';

		$promociones_general = $this->db->query($query_general);
		$data['promociones_general'] = $promociones_general;

		$array_general = array();
		$array_color_general = array();

		foreach ($promociones_general->result() as $promocion)
		{
			array_push($array_general, array($promocion->promocion,$promocion->total));
			array_push($array_color_general, array($promocion->color));
		}


		/*Grafica tipo cadena*/
		$query_cadena = 'select tp.nombre_tipo_promocion as promocion,count(tp.nombre_tipo_promocion)as total, ';
		$query_cadena .= 'tp.color_grafica as color,f.nombre_formato as formato,ca.nombre_categoria ';
		$query_cadena .= 'from ubicacion_promocion as up ';
		$query_cadena .= 'left join formatos as f on f.id_formato = up.formatos_id_formato ';
		$query_cadena .= 'left join promociones as p on p.id_promocion = up.promociones_id_promocion ';
		$query_cadena .= 'left join tipos_promocion as tp on tp.id_tipo_promocion = p.tipos_promocion_id_tipo_promocion ';
		$query_cadena .= 'left join subcategorias as sc on sc.id_subcategoria = p.subcategorias_id_subcategoria ';
		$query_cadena .= 'left join categorias as ca on ca.id_categoria = sc.categorias_id_categoria ';
		$query_cadena .= 'WHERE 1 ';

		if($anio_ini == $anio_fin){
				$conj = ' AND ';
			}else{
				$conj = ' OR ';
			}	

		if($cadena != 0 and $categoria == 0 and $semana_ini != 0 and $semana_fin != 0){
			$query_cadena .= ' AND up.formatos_id_formato = '. $cadena ;
			$query_cadena .= ' AND ((up.anio = '.$anio_ini.' AND up.semana >= '.$semana_ini.')'.$conj.'(up.anio = '.$anio_fin.' and up.semana <= '.$semana_fin.') ) ';
			//$query_cadena .= ' AND sc.categorias_id_categoria = '. $categoria ;
		}
		if($cadena == 0 and $categoria != 0 and $semana_ini != 0 and $semana_fin != 0){
			$query_cadena .= ' AND sc.categorias_id_categoria = '. $categoria ;
			$query_cadena .= ' AND ((up.anio = '.$anio_ini.' AND up.semana >= '.$semana_ini.')'.$conj.'(up.anio = '.$anio_fin.' and up.semana <= '.$semana_fin.') ) ';
		}
		if($cadena == 0 and $categoria == 0 and $semana_ini != 0 and $semana_fin != 0){			
			$query_cadena .= ' AND ((up.anio = '.$anio_ini.' AND up.semana >= '.$semana_ini.')'.$conj.'(up.anio = '.$anio_fin.' and up.semana <= '.$semana_fin.') ) ';
		}

		if($cadena != 0 and $categoria == 0 and $semana_ini == 0 and $semana_fin == 0){
			$query_cadena .= 'AND up.formatos_id_formato = '. $cadena ;
		}
		if($cadena == 0 and $categoria != 0 and $semana_ini == 0 and $semana_fin == 0){
			$query_cadena .= 'AND sc.categorias_id_categoria = '. $categoria ;
		}

		if($cadena != 0 and $categoria != 0 and $semana_ini == 0 and $semana_fin == 0){
			$query_cadena .= ' AND up.formatos_id_formato = '. $cadena ;
			$query_cadena .= ' AND sc.categorias_id_categoria = '. $categoria ;
		}

		if($cadena != 0 and $categoria != 0 and $semana_ini != 0 and $semana_fin != 0){
			$query_cadena .= ' AND up.formatos_id_formato = '. $cadena ;
			$query_cadena .= ' AND sc.categorias_id_categoria = '. $categoria ;
			$query_cadena .= ' AND ((up.anio = '.$anio_ini.' AND up.semana >= '.$semana_ini.')'.$conj.'(up.anio = '.$anio_fin.' and up.semana <= '.$semana_fin.') ) ';
		}

		$query_cadena .= ' GROUP BY promocion ';

		$promociones_cadenas = $this->db->query($query_cadena);
		$data['promociones_cadenas'] = $promociones_cadenas;

		$array_cadenas = array();
		$array_color = array();
		
		foreach ($promociones_cadenas->result() as $cadenas)
		{
			array_push($array_cadenas, array($cadenas->promocion,$cadenas->total));
			array_push($array_color, array($cadenas->color));
		}

		$dato_cadenas = array(
			"general"=>$array_general,
			"cadenas"=>$array_cadenas,
			"general_color"=>$array_color_general,
			"color"=>$array_color,
			"query"=>$query_cadena
		);

		echo json_encode($dato_cadenas,JSON_NUMERIC_CHECK);

	}

	/*Funciones graficas lineales*/
	public function lineal()
	{
		$data = $this->header_lib->arma_rutas();

		if($this->login_lib->verifica_login()){
			$data = $this->header_lib->arma_menu($data);
			
			$idsCanales = array(1,3,4,12);
			$this->db->where_in('id_canal', $idsCanales);
			$canales = $this->db->get('canales');
			$data['canales'] = $canales;

			$grafica_lineal = 'SELECT up.semana,up.anio, ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 12 , 1,0)) as "Seven_Eleven", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 5 , 1,0)) as "Bodega_Aurrera", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 9 , 1,0)) as "Casa_Ley", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 4 , 1,0)) as "Chedraui", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 14 , 1,0)) as "Círculo_K", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 7 , 1,0)) as "City_Market", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 2 , 1,0)) as "Comercial_Mexicana", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 13 , 1,0)) as "Extra", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 16 , 1,0)) as "Farmacia_del_Ahorro", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 8 , 1,0)) as "HEB", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 11 , 1,0)) as "Oxxo", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 15 , 1,0)) as "San_Pablo", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 3 , 1,0)) as "Soriana", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 6 , 1,0)) as "Superama", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 1 , 1,0)) as "Walmart_Supercenter", ';
			$grafica_lineal .= 'COUNT(up.semana)as total ';
			$grafica_lineal .= 'FROM ubicacion_promocion as up ';
			$grafica_lineal .= 'LEFT JOIN formatos as f on f.id_formato = up.formatos_id_formato ';
			$grafica_lineal .= 'LEFT JOIN promociones as p on p.id_promocion = up.promociones_id_promocion ';
			$grafica_lineal .= 'LEFT JOIN tipos_promocion as tp on tp.id_tipo_promocion = p.tipos_promocion_id_tipo_promocion ';
			$grafica_lineal .= 'LEFT JOIN subcategorias as sc on sc.id_subcategoria = p.subcategorias_id_subcategoria ';
			$grafica_lineal .= 'LEFT JOIN categorias as ca on ca.id_categoria = sc.categorias_id_categoria ';
			//$grafica_lineal .= 'WHERE up.semana between 10 and 21 ';
			$grafica_lineal .= 'GROUP BY up.semana ';
			$grafica_lineal .= 'ORDER BY up.anio,up.semana ';

			$lineales = $this->db->query($grafica_lineal);
			$data['lineales'] = $lineales;

			$page = 'reportes_lineal_page';
			$this->load->view('templates/header',$data);
			$this->load->view('pages/'.$page);
			$this->load->view('templates/footer', $data);
		}
		else{
			redirect('/', 'refresh');
		}
		
	}

	public function lineal_parametros()
	{
		$canal = $this->input->post("canal");
		$semana_ini = $this->input->post("semana_ini");
		$anio_ini = $this->input->post("anio_ini");
		$semana_fin = $this->input->post("semana_fin");		
		$anio_fin = $this->input->post("anio_fin");

		$grafica_lineal = 'SELECT up.semana,up.anio, ';

		if($canal == 0){
			$grafica_lineal .= 'SUM(if (f.id_formato = 12 , 1,0)) as "Seven_Eleven", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 5 , 1,0)) as "Bodega_Aurrera", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 9 , 1,0)) as "Casa_Ley", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 4 , 1,0)) as "Chedraui", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 14 , 1,0)) as "Círculo_K", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 7 , 1,0)) as "City_Market", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 2 , 1,0)) as "Comercial_Mexicana", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 13 , 1,0)) as "Extra", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 16 , 1,0)) as "Farmacia_del_Ahorro", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 8 , 1,0)) as "HEB", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 11 , 1,0)) as "Oxxo", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 15 , 1,0)) as "San_Pablo", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 3 , 1,0)) as "Soriana", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 6 , 1,0)) as "Superama", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 1 , 1,0)) as "Walmart_Supercenter", ';
		}

		if($canal == 1){
			$grafica_lineal .= 'SUM(if (f.id_formato = 5 , 1,0)) as "Bodega_Aurrera", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 9 , 1,0)) as "Casa_Ley", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 4 , 1,0)) as "Chedraui", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 7 , 1,0)) as "City_Market", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 2 , 1,0)) as "Comercial_Mexicana", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 8 , 1,0)) as "HEB", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 3 , 1,0)) as "Soriana", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 6 , 1,0)) as "Superama", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 1 , 1,0)) as "Walmart_Supercenter", ';

		}
		elseif($canal == 3){
			$grafica_lineal .= 'SUM(if (f.id_formato = 12 , 1,0)) as "Seven_Eleven", ';		
			$grafica_lineal .= 'SUM(if (f.id_formato = 14 , 1,0)) as "Círculo_K", ';		
			$grafica_lineal .= 'SUM(if (f.id_formato = 13 , 1,0)) as "Extra", ';
			$grafica_lineal .= 'SUM(if (f.id_formato = 11 , 1,0)) as "Oxxo", ';

		}
		elseif($canal == 4){
			$grafica_lineal .= 'SUM(if (f.id_formato = 16 , 1,0)) as "Farmacia_del_Ahorro", ';		
			$grafica_lineal .= 'SUM(if (f.id_formato = 15 , 1,0)) as "San_Pablo", ';
		}		
		$grafica_lineal .= 'COUNT(up.semana)as total ';
		$grafica_lineal .= 'FROM ubicacion_promocion as up ';
		$grafica_lineal .= 'LEFT JOIN formatos as f on f.id_formato = up.formatos_id_formato ';
		$grafica_lineal .= 'LEFT JOIN promociones as p on p.id_promocion = up.promociones_id_promocion ';
		$grafica_lineal .= 'LEFT JOIN tipos_promocion as tp on tp.id_tipo_promocion = p.tipos_promocion_id_tipo_promocion ';
		$grafica_lineal .= 'LEFT JOIN subcategorias as sc on sc.id_subcategoria = p.subcategorias_id_subcategoria ';
		$grafica_lineal .= 'LEFT JOIN categorias as ca on ca.id_categoria = sc.categorias_id_categoria ';
		$grafica_lineal .= 'WHERE 1 ';
		if($anio_ini == $anio_fin){
				$conj = ' AND ';
			}else{
				$conj = ' OR ';
			}

		if($canal == 0 and $semana_ini != 0 and $semana_fin != 0){
			$grafica_lineal .= ' AND ((up.anio = '.$anio_ini.' AND up.semana >= '.$semana_ini.')'.$conj.'(up.anio = '.$anio_fin.' and up.semana <= '.$semana_fin.') ) ';
			//$grafica_lineal .= ' AND ((up.anio = '.$anio_ini.' AND up.semana >= '.$semana_ini.')OR(up.anio = '.$anio_fin.' and up.semana <= '.$semana_fin.') )';

		}
		if($canal != 0 and $semana_ini != 0 and $semana_fin != 0){
			$grafica_lineal .= ' AND f.canales_id_canal = '.$canal ;
			$grafica_lineal .= ' AND ((up.anio = '.$anio_ini.' AND up.semana >= '.$semana_ini.')'.$conj.'(up.anio = '.$anio_fin.' and up.semana <= '.$semana_fin.') ) ';
			//$grafica_lineal .= ' AND ((up.anio = '.$anio_ini.' AND up.semana >= '.$semana_ini.')OR(up.anio = '.$anio_fin.' and up.semana <= '.$semana_fin.') )';
		}

		$grafica_lineal .= ' GROUP BY up.semana ';
		$grafica_lineal .= 'ORDER BY up.anio,up.semana ';

		$lineales_parametros = $this->db->query($grafica_lineal);

		$array_lineal = array();

		foreach ($lineales_parametros->result() as $lineal_parametro) {
			array_push($array_lineal, $lineal_parametro);
		}

		$array_grafica_lineal = array(
			"lineal"=>$array_lineal,
			"query"=>$grafica_lineal
		);
		
		echo json_encode($array_grafica_lineal,JSON_NUMERIC_CHECK);

		
	}
}