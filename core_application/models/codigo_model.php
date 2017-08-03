<?php
class Codigo_model extends CI_Model {
    public function __construct()
    {
    }
    
    public function get($array)
    {
        $this->db->where($array);
        $query = $this->db->get('codigo_membresia');
		echo $this->db->_error_message();
        return $query;
    }
	
	public function update($array, $data){
		$this->db->where($array);
		$this->db->update('codigo_membresia', $data);
		return $this->db->_error_number();
	}
	
	public function insert($data){
		$this->db->insert('codigo_membresia', $data);
		return $this->db->_error_number();
	}
	
}

?>