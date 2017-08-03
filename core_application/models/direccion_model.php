<?php
class Direccion_model extends CI_Model {
    public function __construct()
    {
    }
    
    public function get_all(){
        $query = $this->db->get('direcciones');
    }
    
    public function get($correo, $password)
    {
        $query = $this->db->get_where('usuarios', array('correo' => $correo, 'password' => $password));
        //return $query;
        return $query->row_array();
    }
    
	public function insert($data){
		$this->db->insert('direcciones', $data);
		return $this->db->_error_number();
	}
	
    public function delete($array)
    {
        $this->db->where($array);
        $this->db->delete('direcciones');
        return $this->db->_error_number();
    }

}

?>