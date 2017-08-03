<?php
class Item_model extends CI_Model {
    public function __construct()
    {
    }
	
    public function get($datos)
    {
        $this->db->where($datos);
        $query = $this->db->get('items');
        return $query;
    }
    
	public function insert($datos){
		$this->db->insert('items', $datos);
		return $this->db->_error_number();
	}
	
    public function delete($id)
    {
        $query = $this->db->get_where('usuarios', array('username' => $username, 'password' => $password));
        return $query->row_array();
    }
}

?>