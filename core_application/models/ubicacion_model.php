<?php
class Ubicacion_model extends CI_Model {
    public function __construct()
    {
    }
    
    
    public function get_all()
    {
	$this->db->order_by("nombre_ubicacion", "asc");
        $query = $this->db->get('ubicaciones');
        return $query;
    }
    
}
