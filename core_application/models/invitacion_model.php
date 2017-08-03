<?php
class Invitacion_model extends CI_Model {
    public function __construct()
    {
    }
    
    public function get_all(){
        $query = $this->db->get('invitaciones');
    }
    
    public function get($correo, $password)
    {
        $query = $this->db->get_where('usuarios', array('correo' => $correo, 'password' => $password));
        //return $query;
        return $query->row_array();
    }
    
	public function insert($data){
		$this->db->insert('invitaciones', $data);
		return $this->db->_error_number();
	}
	
    public function delete($id)
    {
        $query = $this->db->get_where('invitaciones', array('nombre_usuario' => $username, 'pass_usuario' => $password));
        return $query->row_array();
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
		$this->db->update('invitaciones', $data);
		return $this->db->_error_number();
	}

}

?>