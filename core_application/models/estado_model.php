<?php
class Estado_model extends CI_Model {
    public function __construct()
    {
    }
    
    
    public function get_all()
    {
        $query = $this->db->get('estados');
        return $query;
    }
    
    public function delete($id)
    {
        $query = $this->db->get_where('usuarios', array('username' => $username, 'password' => $password));
        return $query->row_array();
    }
}

?>