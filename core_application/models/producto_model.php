<?php
class Producto_model extends CI_Model {
    public function __construct()
    {
    }
    
    
    public function get_all()
    {
        $this->db->order_by('nombre_producto', 'asc');
        $query = $this->db->get('productos');
        return $query;
    }
    
    public function insert($nombre, $marca, $logo){
        
        $data = array(
            'nombre_producto' => $nombre,
            'marcas_id_marca' => $marca,
            'logo_marca' => $logo
        );
        
        $this->db->insert('productos', $data);
        
    }
    
    public function delete($id)
    {
        $query = $this->db->get_where('usuarios', array('username' => $username, 'password' => $password));
        return $query->row_array();
    }
}

?>