<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Codigo_lib {
	
	public function generar(){
		$CI =& get_instance();
		$CI->load->model('codigo_model');
		
		$codigo = 1;
		
		while($codigo > 0){
			$codigo_membresia = random_string('alnum', 30);
			
			$data = array(
				'codigo' => $codigo_membresia,
				'estatus' => 1
			);
			
			$obj_codigo = $CI->codigo_model->get($data);
			$codigo = $obj_codigo->num_rows();
		}
		
		return $codigo_membresia;
	}
	
}
