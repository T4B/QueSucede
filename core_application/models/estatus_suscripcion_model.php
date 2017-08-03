<?php
class Estatus_suscripcion_model extends CI_Model {
    public function __construct()
    {
    }
    
    public function get_all(){
        $query = $this->db->get('estatus_suscripcion');
    }
    
    public function get($array)
    {
        $this->db->where($array);
        $query = $this->db->get('estatus_suscripcion');
        return $query;
    }
    
	public function insert($data){
		$this->db->insert('suscripciones', $data);
		return $this->db->_error_number();
	}
	
    public function delete($array)
    {
        $this->db->where($array);
        $this->db->delete('suscripciones');
        return $this->db->_error_number();
    }
	
	public function get_param($array){
        $query = "SELECT * from invitaciones where 1 = 1 ";
        
        foreach($array as $key => $value){
            $query .= " and " . $key . " = '" . $value . "'";
        }
        
        $result = $this->db->query($query);
        return $result;
    }
	
	public function update($array, $data){
		$this->db->where($array);
		$this->db->update('suscripciones', $data);
		return $this->db->_error_number();
	}

}

?>