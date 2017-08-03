<?php
class Session extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model('usuario_model');
		$this->load->library('login_lib');
		$this->load->library('header_lib');
	}
	
	public function index(){
	    $page = 'index_page';
		
		$data['title'] = ucfirst($page);
		
		$this->load->view('templates/header', $data);
		$this->load->view('templates/menu', $data);
        $this->load->view('pages/'.$page);
        $this->load->view('templates/footer', $data);
	}
	
	public function login(){
		
		if(!$this->input->post()){
			redirect('/');
		}
		
		$ruta = "/";
		$this->load->helper('security');
		$this->load->library('suscripcion_lib');
		
		$flag_mensaje = FALSE;
		$flag_error = 1;
		$flag_ok = FALSE;
		$validar_codigo = FALSE;
		$titulo_mensaje = "Error";
		$texto_mensaje = "Error interno intente más tarde";
		$imagen_mensaje = "error";
		
		$correo = $this->input->post('correo');
		$password = $this->input->post('password');
		
		$array = array(
			'correo' => $correo,
			'password' => $password
		);
		
		$usuario = $this->usuario_model->get($array);
		
		if( ($correo == "" || $password == "") || $usuario->num_rows() == 0){
			$texto_mensaje = "El usuario y/o contraseña son incorrectos.";
		}else{
			$usuario = $usuario->row();
			
			//Verificar estatus de suscripción
			$id_suscripcion = $usuario->suscripciones_id_suscripcion;
			$estatus_suscripcion = $this->suscripcion_lib->verificar_suscripcion($id_suscripcion);
			
			if($estatus_suscripcion['codigo'] == 0){
				if($usuario->activo == 1){
					//Verificar sesión activa
					
					if($this->login_lib->usuario_logueado($usuario)){
						$texto_mensaje = "Sólo puedes tener una sesión activa.";
					}else{
						$this->login_lib->login($usuario);
					
						if($estatus_suscripcion['tipo_suscripcion'] == 'Prueba'){
							$dias_restantes = $estatus_suscripcion['dias_restantes'];
							
							if($dias_restantes == 0 || $dias_restantes == 1){
								$dias_restantes = 1;
								$mensaje_time = " " . $dias_restantes . "dia ";
							}else{
								$mensaje_time = " " . $dias_restantes . " días ";
							}
							$flag_mensaje = TRUE;
							$this->session->set_flashdata("mensaje_time", $mensaje_time);
						}
						
						$flag_ok = TRUE;
					}
					
				}else{
					$texto_mensaje = "Tu usuario se encuentra inactivo.";
				}
			}else{
				$texto_mensaje = $estatus_suscripcion['mensaje'];
			}
		}
		
		if($flag_ok){
			//redirect('/interno/view/2013');
			redirect('/');
		}else{
			$this->header_lib->mensaje($titulo_mensaje, $texto_mensaje, $imagen_mensaje);
		}
		
	}
	
	
	public function logout(){
		
		$this->login_lib->logout();
		
        redirect('/');
	}
 }