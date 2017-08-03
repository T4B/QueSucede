<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario_lib {

	public function crear($datos_usuario){
		echo "creando usuario <br />";
		
	}
	
	public function activar($id_usuario){
		$CI =& get_instance();
		$CI->load->model("usuario_model");
		
		$array = array(
			'id_usuario' => $id_usuario
		);
		$datos = array(
			'activo' => 1
		);
		
		$codigo = $CI->usuario_model->update($array, $datos);
		
		return $codigo;
	}
}
