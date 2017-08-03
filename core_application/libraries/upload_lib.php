<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload_lib {

	public function upload($field_name, $upload_path){
        date_default_timezone_set("America/Mexico_City");
        $CI =& get_instance();
		
        $now = time();
        $gmt = local_to_gmt($now);
        
        $ext = explode('.' , $_FILES[$field_name]['name']);
		
		$nombre_orig = str_replace('.','_',$_FILES[$field_name]['name']);
        $file_name = substr($nombre_orig, 0, 3) . $gmt;
		
        $upload_path = realpath(APPPATH . '..'.$upload_path);
		
        $indice = count($ext) - 1;
        
        $nombre_archivo = $file_name . '.' . $ext[$indice];
        
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'gif|jpg|png|pdf|html|htm';
        $config['max_size']	= '10000000';
        $config['max_width']  = '10000000';
        $config['max_height']  = '10000000';
        $config['file_name']  = $file_name;
        
        $CI->load->library('upload', $config);
        
		$CI->upload->initialize($config);
		
        $upload_data = $CI->upload->data();
		
		
        if ( $CI->upload->do_upload($field_name))
        {
            $result = $nombre_archivo;
        }else{
			echo $CI->upload->display_errors();
            $result = '-1';
        }
        
		$response = array(
			'nombre' => $result,
			'mensaje' => $CI->upload->display_errors()
		);
		
        return $response;
    }
}
