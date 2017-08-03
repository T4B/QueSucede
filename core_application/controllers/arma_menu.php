<?php
	$this->load->helper('string_helper');
	
	$this->load->model('categoria_model');
	$this->load->model('tipo_promocion_model');
	$this->load->model('canal_model');
	$this->load->model('promocion_model');
	
	$categorias = $this->categoria_model->get_all();
	$tipos_promocion = $this->tipo_promocion_model->get_all();
	$canales = $this->canal_model->get_all();
	$top_promociones = $this->promocion_model->get_ranking_top(3);
	$descatados = $this->promocion_model->get_destacados(3);
	$ultimos = $this->promocion_model->get_ultimos(3);
	
	$previous_page = $this->input->server('HTTP_REFERER', TRUE);
	
	$previous = $this->input->server('HTTP_REFERER', TRUE);
	$previous_page_2 = ($previous == "") ? $previous : str_replace("http://", "", $previous);
	
	$previous_page_2 = str_suffix($previous_page_2 , "/", 2);
	
	$data['top_promociones'] = $top_promociones;
	$data['destacados'] = $descatados;
	$data['ultimos'] = $ultimos;
	$data['categorias'] = $categorias;
	$data['tipos_promocion'] = $tipos_promocion;
	$data['canales'] = $canales;
	$data['previous_page'] = $previous_page_2;
	
	
	$data['permisos'] = $this->session->userdata('permisos'); 
	//$data['nombre_usuario'] = $this->session->userdata('nombre_usuario');
	
	if($this->session->userdata('regresa')){
		$this->session->unset_userdata('regresa');
	}else{
		if($this->session->userdata('login_ok')){
		
			if( !$this->session->userdata('array_regresar')){
				$array_regresar = array();
				$this->session->set_userdata('array_regresar', $array_regresar); 
			}else{
				$array_regresar = $this->session->userdata('array_regresar');
			}
			
			if($previous_page_2 != ""){
				$titulo = $this->session->userdata('titulo_page');
				$array_nuevo = array($previous_page_2, $titulo);
				array_push($array_regresar, $array_nuevo);
			}
			
			$this->session->set_userdata('array_regresar', $array_regresar);
		}
	}
	
?>