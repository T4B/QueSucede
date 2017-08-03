<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Suscripcion extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('header_lib');
		$this->load->library('login_lib');
		$this->load->library('suscripcion_lib');
		$this->load->helper('security');
	}

	
	public function index()
	{
		
		$data = $this->header_lib->arma_rutas();
		
		if($this->login_lib->verifica_login()){
			$data = $this->header_lib->arma_menu($data);
		}
		
		$this->login_lib->set_seccion(0);
		
		$page = 'suscripcion_page';
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);
		
	}
	
	public function form(){
		
		if(!$this->input->post()){
			redirect('/');
		}
		
		$data = $this->header_lib->arma_rutas();
		
		$data['paquete'] = $this->input->post('paquete');
		
		if($this->login_lib->verifica_login()){
			$data = $this->header_lib->arma_menu($data);
		}else{
			$data['categorias'] = $this->db->get('categorias');
		}
		
		$data['edades'] = $this->db->get('edades');
		
		$page = 'suscripcion_form_page';
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);
	}
	
	public function guardar(){
		
		$this->load->model('cliente_model');
		$this->load->model('usuario_model');
		$this->load->model('suscripcion_model');
		
		if(!$this->input->post()){
			redirect('/');
		}
		
		$titulo_mensaje = "Error";
		$texto_mensaje = "Error interno intente más tarde";
		$imagen_mensaje = "error";
		
		
		$correo = $this->input->post('correo');
		$nombre = $this->input->post('nombre');
		$a_paterno = $this->input->post('a_paterno');
		$a_materno = $this->input->post('a_materno');
		$edad = $this->input->post('edad');
		$paquete = $this->input->post('paquete');
		
		$array = array(
			'correo' => $correo
		);
		
		$cliente = $this->db->get_where('clientes', $array);
		
		$datos = array(
			'nombre' => $nombre,
			'a_paterno' => $a_paterno,
			'a_materno' => $a_paterno,
			'correo' => $correo,
			'telefono' => $this->input->post('telefono'),
			'lada' => $this->input->post('lada'),
			'cp' => $this->input->post('cp'),
			'compania' => $this->input->post('compania'),
			'ocupacion' => $this->input->post('ocupacion'),
			'puesto' => $this->input->post('puesto'),
			'paises_id_pais' => 1,
			'estado' => 1,
			'edades_id_edad' => $edad,
		);
		
		$descripcion = "Permanente";
		$estatus = 1;
		
		if($cliente->num_rows() > 0){
			$cliente = $cliente->row();
			$id_cliente = $cliente->id_cliente;
			//actualizar cliente
			$codigo = $this->cliente_model->update($array, $datos);
			$cliente = $this->db->get_where('clientes', $array)->row();
			$id_suscripcion = $this->suscripcion_lib->actualizar($id_cliente, $descripcion, $estatus, 1, 0);
			$arr_usuario = array(
				'correo' => $cliente->correo
			);
			$id_usuario = $this->usuario_model->get($arr_usuario)->row()->id_usuario;
		}else{
			//crear cliente
			$codigo = $this->cliente_model->insert($datos);
			$id_cliente = $this->db->insert_id();
			$arr_cliente = array(
				'id_cliente' => $id_cliente
			);
			$cliente = $this->cliente_model->get($arr_cliente)->row();
			$id_suscripcion = $this->suscripcion_lib->crear($id_cliente, $descripcion, $estatus);
			
			if($id_suscripcion != 0){
				//Insertar usuario
				$datos_usuario = array(
					'suscripciones_id_suscripcion' => $id_suscripcion,
					'nombre' => $nombre,
					'correo' => $correo,
					'a_paterno' => $this->input->post('a_paterno'),
					'a_materno' => $this->input->post('a_materno'),
					'telefono' => $this->input->post('telefono'),
					'lada' => $this->input->post('lada'),
					'password' => $this->input->post('password'),
					'grupos_id_grupo' => 2
				);
				
				$codigo_usuario = $this->usuario_model->insert($datos_usuario);
				
				if($codigo_usuario == 0){
					$id_usuario = $this->db->insert_id();
				}
			}
		}
		
		if($id_suscripcion != 0){
			//Insertar usuario
			$this->db->delete('intereses', array('usuarios_id_usuario' => $id_usuario));
			$categorias = $this->input->post('categorias');
			foreach($categorias as $key => $categoria){
				$array_interes = array(
					'usuarios_id_usuario' => $id_usuario,
					'categorias_id_categoria' => $categoria
				);
				$this->db->insert('intereses', $array_interes);
			}
		}
		
		$codigo = $this->suscripcion_lib->correo_suscripcion($cliente, $paquete);
		
		if($codigo == 0){
			$imagen_mensaje = 'ok';
			$titulo_mensaje = 'Gracias por suscribirte';
			$texto_mensaje = 'Se ha enviado un correo con sus datos de suscripción, en breve nuestro equipo se pondrá en contacto con usted.';
		}
		
		$this->header_lib->mensaje($titulo_mensaje, $texto_mensaje, $imagen_mensaje);
		
	}
	
	public function confirmar(){
		$data = $this->header_lib->arma_rutas();
		
		$this->load->helper('string_helper');
		$this->load->helper('security');
		$this->load->model('usuario_model');
		$this->load->library('usuario_lib');
		
		$correo_usuario = $this->input->get('uts');
		$correo_usuario = str_replace('|','+',$correo_usuario);
		$correo_usuario = $this->encrypt->decode($correo_usuario);
		
		$array = array(
			'correo' => $correo_usuario
		);
		
		$usuario = $this->usuario_model->get($array)->row();
		
		//Activar suscripcion
		$codigo = $this->suscripcion_lib->activar($usuario->suscripciones_id_suscripcion);
		
		//Si la suscripción se activó correctamente
		if($codigo == 0){
			//Activar usuario
			$this->usuario_lib->activar($usuario->id_usuario);

			$this->login_lib->login($usuario);
		}
		
		//redirect('/');
	}
	
	public function recomendar(){
		$this->load->library('suscripcion_lib');
		$this->load->helper("security");
		
		$id_usuario = $this->session->userdata("id_usuario");
		$id_usuario = $this->encrypt->decode($id_usuario);
		
		$usuario = $this->db->get_where('usuarios', array('id_usuario' => $id_usuario))->row();
		
		$correo_usuario = $usuario->correo;
		$nombre_usuario = $usuario->nombre . " " . $usuario->a_paterno; 
		
		
		$correos = $this->input->post("correos");
		$correos = explode("~", $correos);
		
		$string_correos = '';
		
		$ahora = date("Y-m-d H:i:s");
		
		foreach($correos as $key => $valor){
			$datos = array(
				'usuarios_id_usuario' => $id_usuario,
				'correo' => $valor,
				'fecha_creacion' => $ahora,
				'ultima_actualizacion' => $ahora,
				'estatus' => 0
			);
			
			$this->db->insert('invitaciones', $datos);
			if($this->db->_error_number() == 0){
				$codigo_correo = $this->suscripcion_lib->correo_recomendacion($nombre_usuario, $correo_usuario, $valor);
			}
		}
		
		$codigo = 0;
		
		$response = array(
			'codigo' =>  $codigo
		);
		
		echo json_encode($response);
	}
	
	public function recomendar2(){
		$this->load->library('suscripcion_lib');
		$this->load->helper("security");
		
		$id_usuario = $this->session->userdata("id_usuario");
		$id_usuario = $this->encrypt->decode($id_usuario);
		
		$usuario = $this->db->get('usuarios', array('id_usuario' => $id_usuario))->row();
		
		$this->suscripcion_lib->agregar_dias($usuario, 5);
		
	}
	
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
