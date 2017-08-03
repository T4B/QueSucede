<?php
class Pago_model extends CI_Model {
    public function __construct()
    {
    }
	
    public function get($datos)
    {
        $this->db->where($datos);
        $query = $this->db->get('pagos');
        return $query;
    }
    
	public function insert($datos){
		$this->db->insert('pagos', $datos);
		return $this->db->_error_number();
	}
	
    public function delete($id)
    {
        $query = $this->db->get_where('usuarios', array('username' => $username, 'password' => $password));
        return $query->row_array();
    }
	
	public function update($array, $data){
		$this->db->where($array);
		$this->db->update('pagos', $data);
		return $this->db->_error_number();
	}
	
	public function get_in($array){
		$this->db->where_in($array['campo'], $array['valores']);
        $query = $this->db->get('pagos');
        return $query;
    }
}

?>