<?php
class Canal_model extends CI_Model {
    public function __construct()
    {
    }
    
    
    public function get_all()
    {
        $query = $this->db->get('canales');
        return $query;
    }
    
    public function get_titulo($id){
        
        $titulo = '';
        
        $result = $this->db->get_where('canales', array('id_canal' => $id));
        $canal = $result->row();
        $titulo = $canal->nombre_canal;
        
        $titulo = "Canal -> " . $titulo;
        
        return $titulo;
    }
    
    public function delete($id)
    {
        $query = $this->db->get_where('usuarios', array('username' => $username, 'password' => $password));
        return $query->row_array();
    }

}

?>