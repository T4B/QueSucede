<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('date_helper');
		$this->load->library('header_lib');
		$this->load->library('login_lib');
	}

	
	public function index()
	{
		
	}
	
	public function view($page = NULL){
		
		if(!$page){
			redirect('/');
		}
		
		$data = $this->header_lib->arma_rutas();
		
		if($this->login_lib->verifica_login()){
			$data = $this->header_lib->arma_menu($data);
		}
		
		$page .= '_page';
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page);
		$this->load->view('templates/footer', $data);
		
	}
	
	public function mensaje(){
		$data = $this->header_lib->arma_rutas();
		
		if($this->login_lib->verifica_login()){
			$data = $this->header_lib->arma_menu($data);
		}
		
		$data['mensaje'] = $this->session->flashdata('texto_mensaje');
		$data['titulo'] = $this->session->flashdata('titulo_mensaje');
		$data['imagen'] = $this->session->flashdata('imagen_mensaje');
		
		
		$page = 'mensaje_page';
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page);
		$this->load->view('templates/footer', $data);
		
	}
	
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
