<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contacto extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('promocion_model');
		$this->load->library('header_lib');
        $this->load->library('login_lib');
	}
	
	public function index()
	{
		
		$data = $this->header_lib->arma_rutas();
		
		$data = $this->header_lib->arma_menu($data);
		
		$this->login_lib->set_seccion(5);
        
		$page = 'contacto_page';
		
		$this->load->view('templates/header', $data);
		$this->load->view('pages/'.$page);
		$this->load->view('templates/footer', $data);
	}
	
	public function enviar(){
		$data = $this->header_lib->arma_rutas();
		$ruta_images = $data['ruta_images'];
		
		$this->load->library('email');
		
		$nombre = $this->input->post('nombre');
		$correo = $this->input->post('correo');
		$telefono = $this->input->post('telefono');
		$mensaje = $this->input->post('mensaje');
		
		
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
                            <img src="'.$ruta_images.'logo_correo.png">
                            <hr>
                            </td>			
                                
                        </tr>
                        <tr>
                            <td width="600" valign="top" style="color:#000000;">
                                <strong><font color="#000000">Contacto desde Qué Sucede: </font></strong><br><br>
                                La persona '.$nombre.' se puso en contacto con los siguientes datos:<br><br>
                                
                                <strong>Correo: </strong>'.$correo.'<br>
                                
								<strong>Teléfono: </strong>'.$telefono.'<br>
								
								<strong>Mensaje: </strong><br />'.$mensaje.'<br>
								
                             </td>
                        </tr>
                        <tr>
                            <td width="600" height="">
                            <hr>
                            </td>
                        </tr>
                    </table>
			</center>
			</body>
			</html>
		';
		
		$subject = 'contacto desde quesucede.com.mx';
		$this->email->set_mailtype('html');
		$this->email->from('info@quesucede.com.mx', 'quesucede');
		$this->email->to('psoria@promored.mx');
		$CI->email->bcc('danielb@promored.mx');
		
		$this->email->subject($subject);
		$this->email->message($mensaje_correo);
		
		if($this->email->send()){
			$imagen_mensaje = 'ok';
			$titulo_mensaje = 'Contacto';
			$texto_mensaje = 'Se ha enviado un correo con sus datos, en breve nuestro equipo se pondrá en contacto con usted.';
		}else{
			$imagen_mensaje = 'error';
			$titulo_mensaje = 'Contacto';
			$texto_mensaje = 'Ocurrió un error al procesar la solicitud, por favor intente más tarde.';
		}
		
		
		
		
		
		$this->header_lib->mensaje($titulo_mensaje, $texto_mensaje, $imagen_mensaje);
		
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */