<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Registro extends CI_Controller {

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
		
		$this->login_lib->set_seccion(0);
		
		$page = 'registro_page';
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);
		
	}
	
	public function guardar(){
		
		if(!$this->input->post()){
			redirect('/');
		}
		
		$this->load->model('usuario_model');
		$this->load->model('cliente_model');
		$this->load->library('usuario_lib');
		
		$data = $this->header_lib->arma_rutas();
		
		$flag_ok = FALSE;
		$titulo_mensaje = "Error";
		$texto_mensaje = "Error interno intente más tarde";
		$imagen_mensaje = "error";
		
		//verificar datos
		$correo = $this->input->post('correo');
		
		$array = array(
			'correo' => $correo
		);
		
		$cliente = $this->cliente_model->get($array);
		$usuario = $this->usuario_model->get($array);
		
		if($cliente->num_rows() == 0 && $usuario->num_rows() == 0){
			
			//Insertar cliente
			$nombre = $this->input->post('nombre');
			$datos = array(
				'nombre' => $nombre,
				'correo' => $correo,
				'a_paterno' => $this->input->post('a_paterno'),
				'a_materno' => $this->input->post('a_materno'),
				'lada' => $this->input->post('lada'),
				'telefono' => $this->input->post('telefono'),
				'paises_id_pais' => 1,
				'estado' => 1,
				'edades_id_edad' => 1
			);
			
			$codigo = $this->cliente_model->insert($datos);
			
			if($codigo == 0){
				//Crear suscripción
				$id_cliente = $this->db->insert_id();
				$descripcion = "Prueba";
				$id_suscripcion = $this->suscripcion_lib->crear($id_cliente, $descripcion, 0);
				
				$correo_recomendacion = $this->input->post('correo_recomendacion');
				
				if($id_suscripcion != 0){
					$pass = $this->input->post('password_echo');
					$datos_usuario = array(
						'suscripciones_id_suscripcion' => $id_suscripcion,
						'nombre' => $nombre,
						'correo' => $correo,
						'a_paterno' => $this->input->post('a_paterno'),
						'a_materno' => $this->input->post('a_materno'),
						'telefono' => $this->input->post('telefono'),
						'lada' => $this->input->post('lada'),
						'password' => $this->input->post('password'),
						'pass' => $pass,
						'grupos_id_grupo' => 2
					);
					
					$codigo_usuario = $this->usuario_model->insert($datos_usuario);
					
					if($codigo_usuario == 0){
						
						if($correo_recomendacion != ""){
							$nuevo_usuario = $this->usuario_model->get($datos_usuario)->row();
							$this->suscripcion_lib->agregar_dias($nuevo_usuario, 3);
							$id_invitacion = $this->session->flashdata("id_invitacion");
							$array_inv = array(
								'id_invitacion' => $id_invitacion
							);
							$datos_inv = array(
								'estatus' => 1
							);
							
							$this->db->where($array_inv);
							$this->db->update('invitaciones', $datos_inv);
							
						}
						
						$codigo_correo = $this->suscripcion_lib->correo_confirmacion($correo,$nombre,$pass);
						
						if($codigo_correo == 0){
							$imagen_mensaje = 'ok';
							$titulo_mensaje = 'Registro exitoso';
							$texto_mensaje = "Se le ha enviado un correo con instrucciones para confirmar su registro.";
						}else{
							$texto_mensaje = "Error interno por favor intente más tarde.";
						}
					}
				}else{
					$texto_mensaje = "Error interno por favor intente más tarde.";
				}
			}
		}else{
			$texto_mensaje = "El correo que proporcionó ya se encuentra registrado.";
		}
		
		$this->header_lib->mensaje($titulo_mensaje, $texto_mensaje, $imagen_mensaje);
	}
	
	public function validar_usuario(){
		
		$this->load->model('usuario_model');
		
		$usuario = $this->input->post('usuario');
		
		$mis_campos = array(
			'usuario' => $usuario
		);
		
		$usuario = $this->usuario_model->get($mis_campos);
		
		if($usuario->num_rows() > 0){
			$mensaje = 'Nombre de usuario ya registrado';
		}else{
			$mensaje = 'OK';
		}
		
		$response = array(
			'mensaje' => $mensaje
		);
		
		echo json_encode($response);
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
		$codigo = $this->suscripcion_lib->activar($usuario->suscripciones_id_suscripcion, 2);
		
		//Si la suscripción se activó correctamente
		if($codigo == 0){
			//Activar usuario
			$this->usuario_lib->activar($usuario->id_usuario);
			$this->login_lib->login($usuario);
		}
		
		redirect('/');
	}
	
	public function recuperar(){
		$data = $this->header_lib->arma_rutas();
		
		$correo = $this->input->post('correo');
		
		if($correo){
			$this->load->model('usuario_model');
			$this->load->library('email');
			$this->load->helper('security');
			$this->load->helper('string_helper');
			
			$imagen_mensaje = 'error';
			$string_mensaje = 'Tu tiempo de sesión ha terminado.';
			
			$array = array(
				'correo' => $correo
			);
			
			$usuario = $this->usuario_model->get($array);
			
			
			if($usuario->num_rows() > 0){
				$usuario = $usuario->row();
				
				$pass = $usuario->pass;
				$nombre_usuario = $usuario->nombre;
				
				$subject = "Recuperación de contraseña";
				
				$nuevo_correo_user = $this->encrypt->encode($correo);
				$nuevo_correo_user = str_replace('+','|',$nuevo_correo_user);
				
				$ruta_cambiar = $data['ruta_app'].'registro/cambiar?uts='.$nuevo_correo_user;
				
				echo $ruta_cambiar;
				
				$mensaje_correo = '
					<html>
						<head>
						<title>Confirmación de registro</title>
						<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
						</head>
						<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; text-align:left; color:#0000 !important;">
						<center>
							<table width="650" height="400" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td width="600" height="90">
									<img src="'.$data['ruta_images'].'logo_correo.png">
									<hr>
									</td>			
										
								</tr>
								<tr>
									<td width="600"valign="top" style="color:#000000;">
										<strong><font color="#000000">Hola '.$nombre_usuario.',</font></strong><br><br>
										Para reestablecer tu contraseña haz clic en la siguiente liga:<br><br>
									   <br>
										
										<a href="'.$ruta_cambiar.'" style="color:#e32a1f; text-decoration: none;">http://www.quesucede.com.mx</a>
										
									</td>
								</tr>
								<tr>
									<td width="600" height="68">
									<hr>
									
									</td>
								</tr>
							</table>
					</center>
					</body>
					</html>
				';
				
				$subject = 'cambio de contraseña quesucede.com.mx';
				$this->email->set_mailtype("html");
				$this->email->from('info@quesucede.com.mx', 'quesucede');
				
				$this->email->to($correo);
				
				$this->email->subject($subject);
				$this->email->message($mensaje_correo);
				
				if($this->email->send()){
					$imagen_mensaje = 'message';
					$string_mensaje = "Se ha enviado un correo a " . $correo . " con su contraseña.";
				}else{
					$imagen_mensaje = 'error';
					$string_mensaje = "Ocurrió un error al recuperar tu contraseña, intentalo de nuevo más tarde.";
				}
			}else{
				$string_mensaje = "Este correo no se está registrado.";
			}
			
			$data['titulo'] = 'Recuperación de contraseña';
			$data['mensaje'] = $string_mensaje;
			$data['imagen'] = $imagen_mensaje;
			
			$page = "mensaje_page";
			
		}else{
			$page = "recuperar_page";
		}
		
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);
		
	}
	
	public function cambiar(){
		$data = $this->header_lib->arma_rutas();
		
		$nuevo_pass = $this->input->post('password');
		
		$data['titulo'] = "Cambio de contraseña.";
		
		if($nuevo_pass){
			$this->load->model('usuario_model');
			$this->load->helper('security');
			$this->load->library('security_lib');

			$pass_echo = $this->input->post('pass_echo');
			
			$correo = $this->input->post('uts');
			$nuevo_correo = str_replace('|','+',$correo);
			$nuevo_correo = $this->encrypt->decode($nuevo_correo);
			
			$array = array(
				'correo' => $nuevo_correo
			);
			
			$datos = array(
				'pass' => $pass_echo,
				'password' => $nuevo_pass
			);
			
			$datos = $this->security_lib->escapeArray($datos);

			$codigo = $this->usuario_model->update($array, $datos);
			
			if($codigo == 0){
				$string_mensaje = "Su contraseña se ha actualizado correctamente.";
				$imagen_mensaje = "message";
			}else{
				$string_mensaje = "Ocurrió un error al actualizar su contraseña.";
				$imagen_mensaje = "error";
			}
			
			$data['mensaje'] = $string_mensaje;
			$data['imagen'] = $imagen_mensaje;
			
			$page = "mensaje_page";
			
		}else{
			$correo = $this->input->get('uts');
			
			$correo = $id_usuario = $this->input->get('uts');
			
			$data['correo_usuario'] = $correo;
			
			$page = "cambiar_page";
		}
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page, $data);
		$this->load->view('templates/footer', $data);
	}
	
	public function validar_recomendacion(){
		$this->load->model("usuario_model");
		$codigo = -1;
		$mensaje = "Invitación no encontrada";
		
		$correo_recomendacion = $this->input->post('correo_recomendacion');
		//$correo_recomendacion = 'oscarb@promored.mx';
		
		$correo = $this->input->post("correo");
		//$correo = "malakian1.bs@gmail.com";
		
		
		$array = array(
			'correo' => $correo_recomendacion
		);
		
		$usuario = $this->usuario_model->get($array);
		
		if($usuario->num_rows() > 0){
			$usuario = $usuario->row();
			
			$array = array(
				'usuarios_id_usuario' => $usuario->id_usuario,
				'correo' => $correo
			);
			
			$invitacion = $this->db->get_where('invitaciones', $array);
			
			if($invitacion->num_rows()){
				$invitacion = $invitacion->row();
				
				if($invitacion->estatus == 0){
					$this->session->set_flashdata("id_invitacion", $invitacion->id_invitacion);
					$codigo = 0;
					$mensaje = "";
				}
			}
		}else{
			$mensaje = "El correo de referencia no se encuentra registrado.";
		}
		
		$response = array(
			'codigo' => $codigo,
			'mensaje' => $mensaje
		);
		
		echo json_encode($response);
	}
	
}

