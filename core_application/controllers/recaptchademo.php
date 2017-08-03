<?php

class Recaptchademo extends CI_Controller {

	function __construct()
	{
		parent::__construct();	
	}
	
	function index()
  {
    $this->load->library('recaptcha');
    $this->load->library('form_validation');
    $this->load->helper('form');
    $this->lang->load('recaptcha');
	
	$challenge_field = '03AHJ_Vuvdw90OFD1oogRkmb-sNdJIe0uKxQ-h9BSz38YGglJHq3V1tLMhKTgN5rk9nHxbXNz7UxKjHQcfntCuXjN7B8jHnKPo4Rqz377caDnXx08Gs_oerIuk00p_Y_UcpZojbKM_k31PyXk-bqcGyr82N13QoEI_yL_g_JgmxC9L3pfB_0tuyDU';
	$response_field = 'Morersio century';
	
	
	if ($this->recaptcha->check_answer($this->input->ip_address(),$challenge_field,$response_field)) {
		$mensaje = "bien";
	} else {
	$this->form_validation->set_message('check_captcha',$this->lang->line('recaptcha_incorrect_response'));
		$mensaje = "mal";
	}
	
	echo $mensaje;
	
	/*
    if ($this->form_validation->run()) 
    {
	  echo "entra 1";
      $this->load->view('pages/recaptcha_demo',array('recaptcha'=>'Yay! You got it right!'));
    }
    else
    {
      //the desired language code string can be passed to the get_html() method
      //"en" is the default if you don't pass the parameter
      //valid codes can be found here:http://recaptcha.net/apidocs/captcha/client.html
	  echo "entra 222";
      $this->load->view('pages/recaptcha_demo',array('recaptcha'=>$this->recaptcha->get_html()));
    }
	*/
	
  }
  
  function verifica_captcha(){
		/*
		
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->lang->load('recaptcha');
		*/
		
		//$this->load->library('recaptcha');
		
		$this->load->library('Recaptcha');
		
		$challenge_field = $this->input->post('challenge_field');
		$response_field = $this->input->post('response_field');
		
		$mensaje = "no pasaaas";
		
		/*
		if ($this->recaptcha->check_answer($this->input->ip_address(),$challenge_field,$response_field)) {
			$mensaje = "bien";
		} else {
		$this->form_validation->set_message('check_captcha',$this->lang->line('recaptcha_incorrect_response'));
			$mensaje = "mal";
		}
		*/
		echo $mensaje;
	}
  
	
	function check_captcha($val) {
		echo "entra 3";
	  if ($this->recaptcha->check_answer($this->input->ip_address(),$this->input->post('recaptcha_challenge_field'),$val)) {
	    return TRUE;
	  } else {
	    $this->form_validation->set_message('check_captcha',$this->lang->line('recaptcha_incorrect_response'));
	    return FALSE;
	  }
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
