<?php
class Cadena_model extends CI_Model {
    public function __construct()
    {
    }
    
    
    public function get_all()
    {
		$this->db->order_by("nombre_cadena", "asc");
        $query = $this->db->get('cadenas');
        return $query;
    }
    
    public function delete($id)
    {
        $query = $this->db->get_where('usuarios', array('username' => $username, 'password' => $password));
        return $query->row_array();
    }

}

?>