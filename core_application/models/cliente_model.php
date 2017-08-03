<?php
class Cliente_model extends CI_Model {
    public function __construct()
    {
    }
    
    public function get_all(){
        $query = $this->db->get('clientes');
	return $query;
    }
    
    public function get($array)
    {
        $query = $this->db->get_where('clientes', $array);
        return $query;
    }
    
    public function delete($array)
    {
        $this->db->where($array);
        $this->db->delete('clientes');
        return $this->db->_error_number();
    }
    
    public function insert($data){
    
        $this->db->insert('clientes', $data);        
        return $this->db->_error_number();
        
    }
    
    public function update($array, $datos){
        $this->db->where($array);
		$this->db->update('clientes', $datos);
        return $this->db->_error_number();
    }
    
    public function get_like($criterio){
        
        $this->db->like('nombre_usuario', $criterio);
        $this->db->or_like('correo_usuario', $criterio);
        $query = $this->db->get('clientes');
        
        return $query;
    }
    
    public function get_param($array){
        $query = "SELECT * from clientes where 1 = 1 ";
        
        foreach($array as $key => $value){
            $query .= " and " . $key . " = '" . $value . "'";
        }
        
        $result = $this->db->query($query);
        
        return $result;
    }

}

?>