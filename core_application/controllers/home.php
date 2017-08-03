<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		
	}

	
	public function index()
	{
		
		
		include('arma_header.php');
		include('arma_menu.php');
		
		if( $this->session->userdata('array_regresar')){
				$this->session->unset_userdata('array_regresar');
		}
		
		$promociones = $this->promocion_model->get_top(6);
		$data['promociones'] = $promociones;
		
		$data['numero_promociones'] = $promociones->num_rows();
		
		$page = 'home_page';
		
		$data['title'] = ucfirst($page); // Capitaliza la primera letra
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/menu', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);
		
		
	}
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
?>
