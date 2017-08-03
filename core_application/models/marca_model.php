<?php
class Marca_model extends CI_Model {
    public function __construct()
    {
    }
    
    
    public function get_all()
    {
        $this->db->order_by("nombre_marca", "asc"); 
        $query = $this->db->get('marcas');
        return $query;
    }
    
    public function insert($nombre, $logo){
        
        $data = array(
            'nombre_marca' => $nombre,
            'logo_marca' => $logo
        );
        
        $this->db->insert('marcas', $data);
        
    }
    
    public function delete($id)
    {
        $query = $this->db->get_where('usuarios', array('username' => $username, 'password' => $password));
        return $query->row_array();
    }
}

?>