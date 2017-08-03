<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Invitacion_lib {

	public function agregar($array){
		$CI =& get_instance();
		$CI->load->model('invitacion_model');
		
		$CI->load->helper('string');
		$ahora = date("Y-m-d H:i:s");
		
		$month = date("m",strtotime($ahora));
		
		$codigo = 1;
		
		while($codigo > 0){
			$codigo_invitacion = random_string('alnum', 30);
			$data = array(
				'codigo_invitacion' => $codigo_invitacion,
				'estatus' => 1
			);
			
			$invitacion = $CI->invitacion_model->get_param($data);
			$codigo = $invitacion->num_rows();
		}
		
		$id_usuario = $array['id_usuario'];
		
		$data = array(
			'codigo_invitacion' => $codigo_invitacion,
			'usuarios_id_usuario' => $id_usuario,
			'estatus' => 1,
			'fecha_invitacion' => $ahora
			);
			
		$insert = $CI->invitacion_model->insert($data);
		
		if($insert == 0){
			$codigo = 0;
			$mensaje = "error en la invitacion";
		}else{
			$codigo = 1;
			$mensaje = "invitacion ok";
		}
		
		$invitacion = array(
			'codigo' => $codigo,
			'mensaje' => $mensaje,
			'codigo_invitacion' => $codigo_invitacion
		);
		
		return $invitacion;
		
	}

    public function validar($codigo)
    {
		$CI =& get_instance();
		$CI->load->model('invitacion_model');
		
		$array = array(
			'codigo_invitacion' => $codigo
		);
		
		$result = $CI->invitacion_model->get_param($array);
		
		
		$mensaje = "";
		$fecha_expiracion = "";
		
		if($result->num_rows() > 0){
			$invitacion = $result->row();
			$activa = $invitacion->activa;
			if( $activa == 1){
				//$dias_validos = 60 * 60 * 24 * 10;
				$dias_validos = 60 * 60 * 2;
				$ahora = date("Y-m-d H:i:s");
				
				$diferencia = strtotime($ahora) - strtotime($invitacion->fecha_invitacion);
				
				if($diferencia >= $dias_validos){
					$mensaje = "La invitación ha expirado";
					$codigo = 1;
				}else{
					$sesenta_dias = 60 * 60 * 24 * 60;
					$fecha_suscripcion = strtotime($ahora) + $sesenta_dias;
					$fecha_cambiada = date("Y-m-d H:i:s", $fecha_suscripcion );
					$data = array(
						'activa' => 0
					);
					$fecha_expiracion = $fecha_cambiada;
					$codigo = 0;
				}
			}else if( $activa == 2){
					$mensaje = "La invitación ha expirado";
					$codigo = 1;
				}else{
				$mensaje = "La invitación no es válida";
				$codigo = 1;
			}
		}else{
			$mensaje = "la invitacion no existe";
			$codigo = 1;
		}
		
		$resultado = array(
			'codigo' => $codigo,
			'mensaje' => $mensaje,
			'fecha_expiracion' => $fecha_expiracion
						);
		
		return $resultado;
    }
}
