<?php
class Tipo_promocion_model extends CI_Model {
    public function __construct()
    {
    }
    
    
    public function get_all()
    {
        $query = $this->db->get('tipos_promocion');
        return $query;
        //return $query->row_array();
    }
    
    public function get_titulo($id){
        
        $titulo = '';
        
        $result = $this->db->get_where('tipos_promocion', array('id_tipo_promocion' => $id));
        $tipo_promocion = $result->row();
        $titulo = $tipo_promocion->nombre_tipo_promocion;
        
        $titulo = "Tipo de actividad -> " . $titulo;
        
        return $titulo;
    }
    
    public function delete($id)
    {
        $query = $this->db->get_where('usuarios', array('username' => $username, 'password' => $password));
        return $query->row_array();
    }

}

?>