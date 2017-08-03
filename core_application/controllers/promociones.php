<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Promociones extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('promocion_model');
		$this->load->helper('date_helper');
		$this->load->library('header_lib');
		$this->load->library('login_lib');
	}
	
	public function index(){
		
		redirect('/');
	}
	
	public function buscar(){
		
		$this->load->library('paginacion_lib');
		$this->load->helper('security');
		
		$criterio_busqueda = '';
		
		$alerta = array();
		$criterio_subcategoria = '';
		
		if(!$this->input->post() || !$this->login_lib->verifica_login()){
			redirect('/');
		}
		
		$data = $this->header_lib->arma_rutas();
		
		$data = $this->header_lib->arma_menu($data);
		
		$semana_actual = (int) date('W');
		$anio_actual = date('Y');
		
		$query_promociones = '
			select p.id_promocion, concat(left(p.titulo, 15), "...") as titulo, p.foto, m.logo_marca, m.nombre_marca,
			cat.nombre_categoria, sub.nombre_subcategoria, tp.nombre_tipo_promocion, up.formatos_id_formato
			from promociones as p
			left join marcas as m on m.id_marca = p.marcas_id_marca
			left join subcategorias as sub on sub.id_subcategoria = p.subcategorias_id_subcategoria 
			left join categorias as cat on cat.id_categoria = sub.categorias_id_categoria
			left join tipos_promocion as tp on tp.id_tipo_promocion = p.tipos_promocion_id_tipo_promocion
			left join ubicacion_promocion as up on up.promociones_id_promocion = p.id_promocion
			left join formatos as form on up.formatos_id_formato = form.id_formato
			left join canales as can on can.id_canal = form.canales_id_canal
			where 1
		';
		
		$query_promociones .= ' and ((up.semana >= '.($semana_actual - 1).' and up.anio = '.($anio_actual - 1).')
			or (up.semana <= '.($semana_actual).' and up.anio = '.$anio_actual.') ) ';
		
		
		$subcategorias = $this->input->post("subcategorias");
		$categoria = $this->input->post('categoria');
		
		$str_subcategoria = '';
		
		if(!empty($subcategorias)){
			$cont_sub = 1;
			$str_subcategoria .= '(';
			$query_promociones .= ' and p.subcategorias_id_subcategoria in( ';
			foreach($this->input->post("subcategorias") as $subcategoria){
				if($cont_sub <= 3){
					$nombre_subcategoria = $this->db->get_where('subcategorias', array('id_subcategoria' => $subcategoria))->row()->nombre_subcategoria;
					$str_subcategoria .= ucfirst(strtolower($nombre_subcategoria));
					$cont_sub++;
				}
				if($cont_sub <= 3){
					$str_subcategoria .= ", ";
				}
				$criterio_subcategoria .= $subcategoria . "|";
				$query_promociones .= $subcategoria.',';
			}
			$str_subcategoria .= '... )';
			$query_promociones = substr_replace($query_promociones ,"",-1) . ' ) ';
			
			$alerta['subcategorias'] = $criterio_subcategoria;
			
		}else if($categoria && $categoria != 'TODOS'){
			$criterio_subcategoria = '0';
			$query_promociones .= ' and cat.id_categoria = ' . $categoria;
		}
		
		if($categoria && $categoria != 'TODOS'){
			$id_categoria = $this->input->post('categoria');
			$alerta['categoria'] = $id_categoria;
			$nombre_categoria = $this->db->get_where('categorias', array('id_categoria' => $id_categoria))->row()->nombre_categoria;
			$criterio_busqueda .= ucfirst(strtolower($nombre_categoria)) . " " . $str_subcategoria . " / ";
		}else{
			$alerta['categoria'] = 0;
		}
		
		$tipo_promocion = $this->input->post('tipo_promocion');
		if($tipo_promocion && $tipo_promocion != 'TODOS'){
			$alerta['tipo_promo'] = $tipo_promocion;
			$nombre_tipo_promo = $this->db->get_where('tipos_promocion', array('id_tipo_promocion' => $tipo_promocion))->row()->nombre_tipo_promocion;
			$criterio_busqueda .= $nombre_tipo_promo . " / ";
			$query_promociones .= ' and p.tipos_promocion_id_tipo_promocion = ' . $tipo_promocion;
		}else{
			$alerta['tipo_promo'] = 0;
		}
		
		$canal = $this->input->post('canal');
		$formatos = $this->input->post('formatos');
		$str_formatos = '';
		$criterio_formatos = '';
		if( !empty($formatos) ){
			$str_formatos .= '(';
			$cont_formatos = 1;
			$query_promociones .= ' and up.formatos_id_formato in( ';
			foreach($formatos as $formato){
				if($cont_formatos <= 3){
					$nombre_formato = $this->db->get_where('formatos', array('id_formato' => $formato))->row()->nombre_formato;
					$str_formatos .= ucfirst(strtolower($nombre_formato));
					$cont_formatos++;
				}
				
				if($cont_formatos <= 3){
					$str_formatos .= ", ";
				}
				
				$criterio_formatos .= $formato . "|";
				$query_promociones .= $formato.',';
			}
			$str_formatos .= '...)';
			$query_promociones = substr_replace($query_promociones ,"",-1) . ' ) ';
			
			
		}else if($canal && $canal != 'TODOS'){
			$criterio_formatos = '0';
			$query_promociones .= ' and can.id_canal = ' . $canal;
		}
		
		if($canal && $canal != 'TODOS'){
			$alerta['canal'] = $canal;
			$nombre_canal = $this->db->get_where('canales', array('id_canal' => $canal))->row()->nombre_canal;
			$criterio_busqueda .= ucfirst(strtolower($nombre_canal)) . " " . $str_formatos . " / ";
		}
		
		$fecha = date('Y-m-d H:i:s');
		$id_usuario = $this->session->userdata('id_usuario');
		$id_usuario = $this->encrypt->decode($id_usuario);
		
		$alerta['usuarios_id_usuario'] = $id_usuario;
		$alerta['alta'] = $fecha;
		$alerta['activa'] = 1;
		$alerta['titulo'] = $criterio_busqueda;
		$alerta['formatos'] = $criterio_formatos;
		
		$this->session->set_userdata('alerta_actual', $alerta);
		
		
		$query_promociones .= ' group by p.id_promocion ';
		$query_promociones .= ' order by up.anio desc, up.semana desc';
		$query_promociones .= ';';
		
		$this->session->set_userdata('criterio_busqueda', $criterio_busqueda);
		
		$promociones = $this->db->query($query_promociones);
		
		if($promociones->num_rows() > 0){
			
			$arr_promociones = $promociones->result_array();
			
			$elementos_por_pagina = 12;
			$num_pagina = 1;
			
			$this->session->set_userdata('query_promociones', $query_promociones);
			
			$response_pag = $this->paginacion_lib->paginar($arr_promociones, $elementos_por_pagina, $num_pagina);
			
			
			$tabla_promociones = $response_pag['tabla'];
			$total_paginas = $response_pag['total_paginas'];
			$paginacion = $response_pag['array_paginas'];
			
			$data['tabla_promociones'] = $tabla_promociones;
			$data['total_paginas'] = $total_paginas;
			$data['promociones'] = $promociones;
			$data['pagina_actual'] = $num_pagina;
			$data['paginacion'] = $paginacion;
			
			$error = 0;
			
		}else{
			$data['titulo'] = "Sin resutados";
			$data['mensaje'] = "No se encontraron resultados con el criterio de búsqueda, por favor intente de nuevo.";
			$data['imagen'] = "warning";
			$error = 1;
		}
		
		$data['error'] = $error;
		$page = 'promociones_page';
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page);
		$this->load->view('templates/footer', $data);
	}
	
	public function pag(){
		$this->load->library('paginacion_lib');
		
		if(!$this->input->post() || !$this->login_lib->verifica_login()){
			redirect('/');
		}
		
		$data = $this->header_lib->arma_rutas();
		$data = $this->header_lib->arma_menu($data);
		
		$data['error'] = 0;
		
		$query_promociones = $this->session->userdata('query_promociones');
		$promociones = $this->db->query($query_promociones);
		$arr_promociones = $promociones->result_array();
		
		$elementos_por_pagina = 12;
		$num_pagina = $this->input->post('pagina');
		
		$response_pag = $this->paginacion_lib->paginar($arr_promociones, $elementos_por_pagina, $num_pagina);
		$tabla_promociones = $response_pag['tabla'];
		$total_paginas = $response_pag['total_paginas'];
		$paginacion = $response_pag['array_paginas'];
		
		$data['pagina_actual'] = $num_pagina;
		$data['tabla_promociones'] = $tabla_promociones;
		$data['total_paginas'] = $total_paginas;
		$data['paginacion'] = $paginacion;
		
		$page = 'promociones_page';
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page);
		$this->load->view('templates/footer', $data);
	}
	
	public function detalle($id_promo = null){
		
		if($id_promo){
			$data = $this->header_lib->arma_rutas();
			$data = $this->header_lib->arma_menu($data);
			
			$promocion = $this->promocion_model->get($id_promo);
			
			if(!$promocion){
				redirect('/');
			}
			
			if(!$this->login_lib->verifica_login() && $promocion->ver_index == 0){
				redirect('/registro');
			}
			
			$data['promocion'] = $promocion;
			
			$pos = strrpos($promocion->precio, ".");
			
			if($pos === FALSE){
				$nuevo_precio = $promocion->precio . '.' . 0;
				$promocion->precio = $nuevo_precio;
			}
			
			$formatos_ubicaciones = array();
			
			$query_formatos = '
				select distinct(up.formatos_id_formato) as id_formato, f.nombre_formato, f.img_formato,
				up.ubicaciones_id_ubicacion, up.precio, u.nombre_ubicacion
				from ubicacion_promocion as up
				left join ubicaciones as u on u.id_ubicacion = up.ubicaciones_id_ubicacion
				left join formatos as f on f.id_formato = up.formatos_id_formato
				where up.promociones_id_promocion = ' . $id_promo .
				' group by id_formato order by formatos_id_formato;';
			
			$formatos = $this->db->query($query_formatos);
			
			$data['formatos_detalle'] = $formatos;
			
			foreach($formatos->result() as $formato){
				
				$formato_ubicacion = array();
				$array_ubicaciones = array();
				$semanas = array();
				$formato_ubicacion['formato'] = $formato;
				
				$datos = array(
					'promociones_id_promocion' => $id_promo,
					'formatos_id_formato' => $formato->id_formato
				);
				
				$this->db->order_by('anio', 'asc');
				$ubicaciones = $this->db->get_where('ubicacion_promocion',$datos);
				
				$anio_actual = date("Y");
				
				$primera_ubicacion = $ubicaciones->row();
				
				$anio_inicio = $primera_ubicacion->anio;
				$semana_inicio = $primera_ubicacion->semana;
				$total_semanas = date("W", mktime(0, 0, 0, 12, 27, $anio_inicio));
				
				$semana_actual = (int) date('W');
				$ultima_ubicacion = $ubicaciones->last_row();
				$anio_fin = $ultima_ubicacion->anio;
				$semana_fin = $ultima_ubicacion->semana;
				
				$anios = $this->genera_semanas($anio_actual, $semana_actual);
				
				foreach($ubicaciones->result() as $ubicacion){
					$ubicacion_actual = $ubicacion->anio . '_' . $ubicacion->semana;
					
					array_push($array_ubicaciones, $ubicacion_actual);
				}
				
				$formato_ubicacion['ubicaciones'] = $array_ubicaciones;
				$formato_ubicacion['anios'] = $anios;
				
				array_push($formatos_ubicaciones, $formato_ubicacion);
			}
			
			$mostrar = TRUE;
			
			if($mostrar){
				foreach($formatos_ubicaciones as $formato_ubicacion){
					$formato = $formato_ubicacion['formato'];
					$ubicaciones = $formato_ubicacion['ubicaciones'];
				}
				
				$data['formatos_ubicaciones'] = $formatos_ubicaciones;
				$data['num_semanas'] = 52;
				$data['semana'] = $semana_actual . '-' . $anio_actual;
				
				$visitas = $this->promocion_model->add_visitas($id_promo);
				
				$data['destacadas'] = $this->promocion_model->get_ranking_top(3);
				$data['ultimas'] = $this->promocion_model->get_ultimos(3);
				
				$mostrar = TRUE;
				
				if($mostrar){
					$page = 'detalle_promo_page';
					
					$this->load->view('templates/header', $data);
					$this->load->view('pages/'.$page);
					$this->load->view('templates/footer', $data);
				}
			}
			
		}else{
			redirect('/');
		}
	}
	
	function genera_semanas(){
		
		$anio_actual = date("Y");
		$semana_actual = (int) date('W');
		
		$anios = array();
		$semanas = array();
		$max_semanas = 52;
		$anio_anterior = $anio_actual - 1;
		$total_semanas_actual = date("W", mktime(0, 0, 0, 12, 27, $anio_actual));
		$total_semanas = date("W", mktime(0, 0, 0, 12, 27, $anio_anterior));
		
		if($semana_actual == 53){
			$anio_fin = $anio_actual;
			$semana_fin = 1;
		}else{
			if( $semana_actual == $total_semanas_actual){
				$semana_fin = $semana_actual;
				$anio_fin = $anio_actual;
			}else{
				$semana_fin = $semana_actual;
				$anio_fin = $anio_anterior;
			}
		}
		
		for($i=0; $i<=$max_semanas; $i++){
			$cambio = 0;
			$semana_actual = $anio_fin . '_' . $semana_fin;
			
			if($i == 0){
				$anios[$anio_fin] = array();
			}
			
			$arr_semana = array(
				'id_semana' => $semana_actual,
				'num_semana' => $semana_fin
			);
			
			if($semana_fin == $total_semanas){
				$semana_fin = 1;
				$anio_fin++;
				$anios[$anio_fin] = array();
				$cambio = 1;
			}else{
				$semana_fin++;
			}
			
			if($cambio == 0){
				array_push($anios[$anio_fin], $arr_semana);
			}else{
				array_push($anios[$anio_fin-1], $arr_semana);
			}
			
			array_push($semanas, $arr_semana);
		}
		
		return $anios;
	}
	
}