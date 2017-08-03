<?php
class Sucursal_model extends CI_Model {
    public function __construct()
    {
    }
    
    public function get_all()
    {
        $query = $this->db->get('sucursales');
        return $query;
    }
    
    public function insert($nombre){
        
        $data = array(
            //'kjs' => 1,
            'nombre_sucursal' => $nombre
        );
        
        $query = $this->db->insert('sucursales', $data);
        
        return $query;
        
    }
    
    public function delete($id)
    {
        $query = $this->db->get_where('usuarios', array('username' => $username, 'password' => $password));
        return $query->row_array();
    }

}

?>