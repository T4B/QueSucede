<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Captcha_lib {

    public function check($captcha)
    {
		$CI =& get_instance();
		$resultado = 0;
		$CI->load->helper('captcha');
		$CI->load->model('captcha_model','',TRUE);
		
		if($captcha){
			$time = 60 * 60 * 2;
			$expiration = time()-$time;
			$binds = array ($captcha,$CI->input->ip_address(),$expiration);
			$resultado = $CI->captcha_model->captchaExist($binds);
		}
		
		return $resultado;
    }
	
	public function make(){
		
		$CI =& get_instance();
		$resultado = 0;
		$CI->load->helper('captcha');
		$CI->load->model('captcha_model','',TRUE);
		
		$ruta_app = base_url();
		
		$url = $ruta_app."captcha_dir/";
		
		$vals = array(
			'img_path'	 => './captcha_dir/',
			'img_url'	 => $url,
			'img_width'  => '180',
			'img_height' => 60,
			'expiration' => 7200
			);
		
		$cap = create_captcha($vals);
		
		$captcha_info = array (
			'captcha_time' => $cap['time'],
			'ip_address' => $CI->input->ip_address(),
			'word' => $cap['word']
		);
		
		$CI->captcha_model->insertCaptcha($captcha_info);
		
		return $cap;
		
		
	}
}

?>
