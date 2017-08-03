<?php
class Estatus_pago_model extends CI_Model {
    public function __construct()
    {
    }
    
    public function get($array)
    {
        $this->db->where($array);
        $query = $this->db->get('estatus_pago');
        return $query;
    }
    
    public function delete($id)
    {
        $query = $this->db->get_where('usuarios', array('username' => $username, 'password' => $password));
        return $query->row_array();
    }
}

?>