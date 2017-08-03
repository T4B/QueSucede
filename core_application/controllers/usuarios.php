<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('usuario_model');
		
	}

	
	public function index()
	{
		include('check_login.php');
		include('arma_menu.php');
		
		$usuarios = $this->usuario_model->get_all();
		$data['permisos'] = $this->session->userdata('permisos'); 
		$data['nombre_usuario'] = $this->session->userdata('nombre_usuario');
		
		
		$page = 'usuarios_page';
		
		$data['title'] = ucfirst($page); // Capitaliza la primera letra
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/menu', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);
	}
	
	public function buscar()
	{
		include('check_login.php');
		include('arma_header.php');
		include('arma_menu.php');
		
		$criterio = $this->input->post('criterio');
		
		$usuarios = $this->usuario_model->get_like($criterio);
		
		$data['usuarios'] = $usuarios;
		$data['permisos'] = $this->session->userdata('permisos'); 
		$data['nombre_usuario'] = $this->session->userdata('nombre_usuario');
		
		$page = 'usuarios_page';
		
		$data['title'] = ucfirst($page); // Capitaliza la primera letra
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/menu', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);
		
		
	}
	
	
	public function buscar2()
	{
		
		/* Encriptado
		$this->load->library('encrypt');
		$msg = 'My secret message';
		$encrypted_string = $this->encrypt->encode($msg);
		echo 'mensaje: '.$msg.'<br/>';
		echo 'encriptado: '.$encrypted_string;
		$encrypted_string = $this->encrypt->decode($encrypted_string);
		echo 'desencriptado: '.$encrypted_string;
		*/
		
		//include('check_login.php');
		
		$categorias = $this->categoria_model->get_all();
		$tipos_promocion = $this->tipo_promocion_model->get_all();
		$canales = $this->canal_model->get_all();
		
		$usuarios = $this->usuario_model->get_all();
		
		$data['categorias'] = $categorias;
		$data['tipos_promocion'] = $tipos_promocion;
		$data['canales'] = $canales;
		$data['permisos'] = $this->session->userdata('permisos'); 
		$data['nombre_usuario'] = $this->session->userdata('nombre_usuario');
		
		$permisos = $this->session->userdata('permisos');
		
		$page = 'usuarios_page';
		
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