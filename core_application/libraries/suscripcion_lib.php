<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Suscripcion_lib {
	
	public function crear($id_cliente, $descripcion, $estatus){
		$CI =& get_instance();
		$CI->load->helper('date_helper');
		$CI->load->model('suscripcion_model');
		
		$ahora = date("Y-m-d H:i:s");
		$fecha_inicio = $ahora;
		$horas = 24*7;
		$fecha_fin = suma_horas($fecha_inicio, $horas);
		
		$datos = array(
			'fecha_inicio' => $fecha_inicio,
			'fecha_fin' => $fecha_fin,
			'fecha_creacion' => $fecha_inicio,
			'ultima_actualizacion' => $fecha_inicio,
			'estatus_suscripcion' => $estatus,
			'clientes_id_cliente' => $id_cliente,
			'tipo_suscripcion' => $descripcion,
			'usuarios' => 1
		);
		
		$CI->suscripcion_model->insert($datos);
		
		if($CI->db->_error_number() == 0){
			
			$id_suscripcion = $CI->db->insert_id();
			
			$datos_historial = array(
				'fecha_creacion' => $ahora,
				'num_cuentas' => 1,
				'fecha_inicio' => $fecha_inicio,
				'fecha_fin' => $fecha_fin,
				'tipo_suscripcion' => $descripcion,
				'clientes_id_cliente' => $id_cliente,
				'contratada' => $fecha_inicio
			);
			
			$CI->db->insert('historial_suscripciones', $datos_historial);
			
			return $id_suscripcion;
		}else{
			return 0;
		}
	}
	
	public function actualizar($id_cliente, $descripcion, $estatus, $num_usuarios, $dias){
		$CI =& get_instance();
		$CI->load->helper('date_helper');
		$CI->load->model('suscripcion_model');
		
		$ahora = date("Y-m-d H:i:s");
		$fecha_inicio = $ahora;
		$horas = $dias * 24;
		$fecha_fin = suma_horas($fecha_inicio, $horas);
		
		$array = array(
			'clientes_id_cliente' => $id_cliente
		);
		
		$datos = array(
			'fecha_inicio' => $fecha_inicio,
			'fecha_fin' => $fecha_fin,
			'fecha_creacion' => $fecha_inicio,
			'ultima_actualizacion' => $fecha_inicio,
			'estatus_suscripcion' => $estatus,
			'tipo_suscripcion' => $descripcion,
			'usuarios' => 1
		);
		
		$CI->suscripcion_model->update($array, $datos);
		
		if($CI->db->_error_number() == 0){
			
			$array_susc = array(
				'clientes_id_cliente' => $id_cliente
			);
			
			$id_suscripcion = $CI->suscripcion_model->get($array_susc)->row()->id_suscripcion;
			
			
			
			$datos_historial = array(
				'fecha_creacion' => $ahora,
				'num_cuentas' => 1,
				'fecha_inicio' => $fecha_inicio,
				'fecha_fin' => $fecha_fin,
				'tipo_suscripcion' => $descripcion,
				'clientes_id_cliente' => $id_cliente,
				'contratada' => $fecha_inicio
			);
			
			$CI->db->insert('historial_suscripciones', $datos_historial);
			
			return $id_suscripcion;
		}else{
			return 0;
		}
		
	}
	
	public function activar($id_suscripcion, $estatus){
		$CI =& get_instance();
		$CI->load->model('suscripcion_model');
		
		$array = array(
			'id_suscripcion' => $id_suscripcion
		);
		
		$datos = array(
			'estatus_suscripcion' => $estatus
		);
		
		$codigo = $CI->suscripcion_model->update($array, $datos);
		
		return $codigo;
	}
	
	public function verificar_suscripcion($id_suscripcion){
		$CI =& get_instance();
		$CI->load->model('suscripcion_model');
		$CI->load->helper('date_helper');
		
		$dias_restantes = 0;
		
		
		$array = array(
			'id_suscripcion' => $id_suscripcion
		);
		
		$suscripcion = $CI->suscripcion_model->get($array)->row();
		
		$estatus_suscripcion = $suscripcion->estatus_suscripcion;
		$tipo_suscripcion = $suscripcion->tipo_suscripcion;
		
		$ahora = date('Y-m-d H:i:s');
		$fecha_fin = $suscripcion->fecha_fin;
		if(comparar_fechas($ahora, $fecha_fin) == 2){
			$vigente = TRUE;
		}else{
			$vigente = FALSE;
		}
		
		if($vigente){
			if($estatus_suscripcion == 0){
				$mensaje = "No has confirmado tu sucripción a través de tu correo.";
				$codigo = -1;
			}else{
				$dias_restantes = diferencia_dias($ahora, $fecha_fin);
				$mensaje = "";
				$codigo = 0;
			}
		}else{
			if($estatus_suscripcion == 1){
				$mensaje = "Tu sucripción está siendo procesada.";
				$codigo = -1;
			}else{
				$mensaje = "Tu sucripción ha vencido.";
				$codigo = -1;
			}
		}
		
		$response = array(
			'mensaje' => $mensaje,
			'codigo' => $codigo,
			'tipo_suscripcion' => $tipo_suscripcion,
			'dias_restantes' => $dias_restantes
		);
		
		return $response;
	}
	
	public function correo_confirmacion($correo_usuario, $nombre_usuario, $pass){
		$CI =& get_instance();
		
		$CI->load->model('usuario_model');
		$CI->load->library('email');
		$CI->load->helper('security');
		$CI->load->helper('string_helper');
		
		$ruta_app = obtener_ruta('app');
		$ruta_images = obtener_ruta('images');
		
		$nuevo_correo_usuario = $CI->encrypt->encode($correo_usuario);
		$nuevo_correo_usuario = str_replace('+','|',$nuevo_correo_usuario);
		
		$ruta_correo = $ruta_app.'registro/confirmar?uts='.$nuevo_correo_usuario;
		
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
                            <td width="600"valign="top" style="color:#000000;">
                                <strong><font color="#000000">Bienvenido (a) '.$nombre_usuario.',</font></strong><br><br>
                                Muchas gracias por registrarte, a partir de este momento, cuentas con acceso al sitio durante los próximos 7 días.<br><br>
                               <br><br />
                                Haz clic en la siguiente liga para confirmar tu registro: 
                                <a href="'.$ruta_correo.'" style="color:#e32a1f; text-decoration: none;">http://www.quesucede.com.mx</a>
                                <br />
                            </td>
                        </tr>
                        <tr>
                            <td width="600" height="68">
                            <hr>
                            Legales
                            </td>
                        </tr>
                    </table>
			</center>
			</body>
			</html>
		';
		
		$subject = 'confirma tu registro en quesucede.com.mx';
		$CI->email->set_mailtype("html");
		$CI->email->from('info@quesucede.com.mx', 'quesucede');
		$CI->email->to($correo_usuario);
		//$CI->email->bcc('oscarb@promored.mx, albertoo@promored.mx, eduardoc@promored.mx');
		
		$CI->email->subject($subject);
		$CI->email->message($mensaje_correo);
		
		if($CI->email->send()){
			return 0;
		}else{
			return -1;
		}
		//return $resultado;
	}
	
	public function correo_suscripcion($cliente, $paquete){
		$CI =& get_instance();
		
		$CI->load->model('usuario_model');
		$CI->load->library('email');
		$CI->load->helper('security');
		$CI->load->helper('string_helper');
		
		$ruta_app = obtener_ruta('app');
		$ruta_images = obtener_ruta('images');
		
		$correo_usuario = $cliente->correo;
		$nombre_usuario = $cliente->nombre . " " . $cliente->a_paterno;
		
		$paquete = ucfirst($paquete);
		
		$edad = $CI->db->get_where('edades', array('id_edad' => $cliente->edades_id_edad))->row()->descripcion_edad;
		
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
                            <td width="600"valign="top" style="color:#000000;">
                                <strong><font color="#000000">Se realizó la suscripcición inicial de: '.$nombre_usuario.',</font></strong><br><br>
                                Los datos de registro son los siguientes:<br><br>
                                
                                <h4>Datos generales</h4>
                                
                                <strong>Nombre: </strong>'.$cliente->nombre.'<br>
                                
                                <strong>Apellidos: </strong>'.$cliente->a_paterno.'&nbsp;'.$cliente->a_materno.'<br>
                                
                                <strong>Correo electrónico: </strong>'.$cliente->correo.'<br>
                                
                                <strong>Tipo de suscripción: </strong>'.$paquete.'<br>
                                
                                <strong>Edad: </strong>'.$edad.'<br>
                                
								<strong>Lada: </strong>'.$cliente->lada.'<br>
								
                           		<strong>Teléfono:</strong>'.$cliente->telefono.'<br>
                                
                                <strong>C.P.: </strong>'.$cliente->cp.'<br>
                                
                                <h4>Datos Especificos</h4>
                                
                                <strong>Compañia: </strong>'.$cliente->compania.'<br>
                                
                                <strong>Ocupación: </strong>'.$cliente->ocupacion.'<br>
                                
                                <strong>Puesto o cargo: </strong>'.$cliente->puesto.'<br>
                                
                                <p>Estos son los datos del suscriptor</p>
                             </td>
                        </tr>
                        <tr>
                            <td width="600" height="68">
                            <hr>
                            Legales
                            </td>
                        </tr>
                    </table>
			</center>
			</body>
			</html>
		';
		
		$subject = 'suscripción de usuario en quesucede.com.mx';
		$CI->email->set_mailtype("html");
		$CI->email->from('info@quesucede.com.mx', 'quesucede');
		$CI->email->to('psoria@promored.mx');
		$CI->email->bcc('oscarb@promored.mx, albertoo@promored.mx, eduardoc@promored.mx');
		
		$CI->email->subject($subject);
		$CI->email->message($mensaje_correo);
		
		if($CI->email->send()){
			return 0;
		}else{
			return -1;
		}
		
	}
	
	public function correo_recomendacion($nombre_usuario, $correo_usuario, $correo_destinatario){
		$CI =& get_instance();
		
		$CI->load->library('email');
		
		$ruta_app = obtener_ruta('app');
		$ruta_images = obtener_ruta('images');
		
		$ruta_correo = $ruta_app."registro";
		
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
                            <td width="600"valign="top" style="color:#000000;">
                                <strong><font color="#000000">'.$nombre_usuario.' te invita a ...</font></strong><br><br>
                               <br><br />
                                Haz clic en la siguiente liga para conocer....: introduce el sig correo '.$correo_usuario.'
                                <a href="'.$ruta_correo.'" style="color:#e32a1f; text-decoration: none;">http://www.quesucede.com.mx</a>
                                <br />
                            </td>
                        </tr>
                        <tr>
                            <td width="600" height="68">
                            <hr>
                            Legales
                            </td>
                        </tr>
                    </table>
			</center>
			</body>
			</html>
		';
		
		$subject = 'invitacion quesucede.com.mx';
		$CI->email->set_mailtype("html");
		$CI->email->from('info@quesucede.com.mx', 'quesucede');
		$CI->email->to($correo_destinatario);
		//$CI->email->bcc('oscarb@promored.mx, albertoo@promored.mx, eduardoc@promored.mx');
		
		$CI->email->subject($subject);
		$CI->email->message($mensaje_correo);
		
		if($CI->email->send()){
			return 0;
		}else{
			return -1;
		}
		//return $resultado;
	}
	
	public function agregar_dias($usuario, $dias){
		$CI =& get_instance();
		$CI->load->helper('date_helper');
		$CI->load->model('suscripcion_model');
		
		$array = array(
			'id_suscripcion' => $usuario->suscripciones_id_suscripcion
		);
		
		$suscripcion = $CI->suscripcion_model->get($array)->row();
		
		$fecha_fin = $suscripcion->fecha_fin;
		$nueva_fecha = suma_dias($fecha_fin, $dias);
		
		$datos = array(
			'fecha_fin' => $nueva_fecha
		);
		
		$codigo = $CI->suscripcion_model->update($array, $datos);
		
		return $codigo;
	}
	
}
