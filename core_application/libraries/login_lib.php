<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_lib {

    public function verifica_login(){
        $CI =& get_instance();
        $login_ok = $CI->session->userdata('login_ok');
        return $login_ok;
    }

    public function verifica_checkin(){
	$CI =& get_instance();
	$check_in = $CI->session->userdata('check_in_ok');
	return $check_in;
    }
    
    public function login($usuario){
	$CI =& get_instance();
	$CI->load->helper('security');
	$CI->load->model('suscripcion_model');
	$id = $usuario->id_usuario;
	$grupo = $usuario->grupos_id_grupo;
	$nombre = $usuario->nombre;
	
	//Insertar usuario logueado
	$ahora = date('Y-m-d H:i:s');
	$datos_login = array(
	    'id_usuario' => $id,
	    'fecha_login' => $ahora
	);
	
	//$CI->db->insert('usuarios_logueados', $datos_login);
	
	$id_suscripcion = $usuario->suscripciones_id_suscripcion;
	$array_susc = array(
	    'id_suscripcion' => $id_suscripcion
	);
	$tipo_suscripcion = $CI->suscripcion_model->get($array_susc)->row()->tipo_suscripcion;
	
	$query = "select t2.id_permiso, t2.nombre_permiso from permisos_grupos t1, permisos t2 ".
	"where t1.permisos_id_permiso = t2.id_permiso and t1.grupos_id_grupo = ".$grupo;
	$permisos = $CI->db->query($query);
	
	$datasession = array(
	    'id_usuario'  => $CI->encrypt->encode($id),
	    'nombre_usuario' => $nombre,
	    'tipo_suscripcion' => $tipo_suscripcion,
	    'login_ok' => TRUE,
	    'error' => '',
	    'permisos' => $permisos
	);
	
	foreach($permisos->result() as $permiso){
		$datasession['perm_'.$permiso->nombre_permiso] = $permiso->id_permiso;
	}
	
	$CI->session->set_userdata($datasession);
	
	return 0;
    }
	
    public function check_in($tienda){
        $CI =& get_instance();
		$CI->load->model('tienda_model');
		$CI->load->model('visita_model');
		$CI->load->helper('security');
		
		$id_usuario = $CI->session->userdata('id_usuario');
		$id_usuario = $CI->encrypt->decode($id_usuario);
		$ahora = date("Y-m-d H:i:s");
		
		$array = array(
            'tiendas_id_tienda' => $tienda->id_tienda,
			'usuarios_id_usuario' => $id_usuario,
			'check_in' => $ahora
            );
		
		$CI->visita_model->insert($array);
		
		$id_visita = $CI->visita_model->get($array)->row()->id_visita;
		
		$CI->session->set_userdata('id_visita', $id_visita);
		
		$array = array(
			'id_tienda' => $tienda->id_tienda
			);
		
		$visitas_tienda = $CI->tienda_model->get($array)->row()->visitas;
		$visitas_tienda++;
		$data = array(
			'visitas' => $visitas_tienda
			);
		
		$CI->tienda_model->update($array, $data);
		
        $array = array(
            'check_in_ok' => TRUE,
            'nombre_tienda' => $tienda->nombre_tienda,
            'id_tienda' => $tienda->id_tienda
            );
        $CI->session->set_userdata($array);
    }
	
    public function check_out(){
	$CI =& get_instance();
	$CI->load->model('visita_model');
	
	$id_visita = $CI->session->userdata('id_visita');
	
	$array = array(
		'id_visita' => $id_visita
		);
	
	$ahora = date("Y-m-d H:i:s");
	
	$data = array(
		'check_out' => $ahora
		);
	
	$CI->visita_model->update($array, $data);
	
	$CI->session->unset_userdata('check_in_ok');
    }
	
    public function set_seccion($secc){
	$CI =& get_instance();
	
	$secciones = array(
	    0 => '',
	    1 => 'active',
	    2 => 'active_green',
	    3 => 'active_blue',
	    4 => 'active_white',
	    5 => 'active_yellow'
	);
	
	$array = array(
		'seccion' => $secc,
		'clase_seccion' => $secciones[$secc]
	);
	
	$CI->session->set_userdata($array);
    }
    
    public function logout(){
	$CI =& get_instance();
	$CI->load->helper('security');
	
	$id_usuario = $CI->session->userdata('id_usuario');
	$id_usuario = $CI->encrypt->decode($id_usuario);
	
	$datos_usuario = array(
	    'id_usuario' => $id_usuario
	);
	
	$CI->db->where($datos_usuario);
	$CI->db->delete('usuarios_logueados');
	
	$CI->session->sess_destroy();
	
	return 0;
    }
    
    public function usuario_logueado($usuario){
	$CI =& get_instance();
	
	$datos = array(
	    'id_usuario' => $usuario->id_usuario
	);
	
	$usuario_logueado = $CI->db->get_where('usuarios_logueados', $datos);
	
	if($usuario_logueado->num_rows() > 0){
	    return true;
	}else{
	    return false;
	}
    }

}
