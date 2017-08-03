<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Interno extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('promocion_model');
		$this->load->helper('date_helper');
		$this->load->library('header_lib');
		$this->load->library('login_lib');
	}
	
	public function index()
	{
		redirect('/');
	}
    
    public function view($param = NULL){
        
		redirect('/');
		
    }
	
}
