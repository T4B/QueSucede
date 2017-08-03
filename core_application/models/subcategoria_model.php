<?php
class Subcategoria_model extends CI_Model {
    public function __construct()
    {
    }
    
    
    public function get_all()
    {
	$this->db->order_by("nombre_subcategoria", "asc");
        $query = $this->db->get('subcategorias');
        return $query;
    }
    
}
