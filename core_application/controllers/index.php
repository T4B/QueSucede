<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('promocion_model');
		$this->load->helper('date_helper');
		$this->load->library('header_lib');
		$this->load->library('login_lib');
	}
	
	public function index()
	{
		$data = $this->header_lib->arma_rutas();
		
		$data['es_index'] = TRUE;
		
		$this->login_lib->set_seccion(0);
		
		if($this->login_lib->verifica_login()){
			
			$data = $this->header_lib->arma_menu($data);
			
			$data['promociones'] = $this->promocion_model->get_random(6);
			$data['destacadas'] = $this->promocion_model->get_ranking_top(3);
			$data['ultimas'] = $this->promocion_model->get_ultimos(3);
			
			$page = 'index_logueado_page';
		}else{
			$page = 'index_page';
			$data['ultimas'] = $this->promocion_model->get_index();

		}

		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page);
		$this->load->view('templates/footer', $data);
		
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */