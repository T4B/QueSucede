<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mostrar extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('promocion_model');
		$this->load->helper('date_helper');
		$this->load->library('header_lib');
		$this->load->library('login_lib');
	}

	public function categoria($categoria = NULL){
		if($categoria){
			$this->load->library('paginacion_lib');
			$this->load->helper('security');
			
			$criterio_busqueda = '';
			
			$alerta = array();
			$criterio_subcategoria = '';
			
			/*
			if(!$this->input->post() || !$this->login_lib->verifica_login()){
				redirect('/');
			}
			*/
			
			$data = $this->header_lib->arma_rutas();
			$data = $this->header_lib->arma_menu($data);

			$id_categoria = $this->db->get_where('categorias', array('nombre_categoria' => $categoria))->row()->id_categoria;
			
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
			
			$query_promociones .= ' and cat.id_categoria = ' . $id_categoria;




			$query_promociones .= ' group by p.id_promocion ';
			$query_promociones .= ' order by up.anio desc, up.semana desc';
			$query_promociones .= ';';
			
			$this->session->set_userdata('criterio_busqueda', $criterio_busqueda);

			$promociones = $this->db->query($query_promociones);
			
			$arr_promociones = $promociones->result_array();
			
			$elementos_por_pagina = 1000;
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
			$data['error'] = $error;

			$page = 'promociones_page';
		
			$this->load->view('templates/header', $data);
			$this->load->view('pages/'.$page);
			$this->load->view('templates/footer', $data);

		}else{
			echo 'No hay';
		}
		
	}
	

}