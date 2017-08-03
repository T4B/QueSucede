<?php
class Usuario_model extends CI_Model {
    public function __construct()
    {
    }
    
    public function get_all(){
        $query = $this->db->get('usuarios');
        return $query;
    }
    
    public function get($array)
    {
        $query = $this->db->get_where('usuarios', $array);
        return $query;
    }
    
    public function delete($array)
    {
        $this->db->where($array);
        $this->db->delete('usuarios');
        return $this->db->_error_number();
    }
    
    public function insert($data){
        $this->db->insert('usuarios', $data);        
        return $this->db->_error_number();
    }
    
    public function update($array, $datos){
        $this->db->where($array);
		$this->db->update('usuarios', $datos);
        return $this->db->_error_number();
    }
    
    public function get_like($criterio){
        
        $this->db->like('nombre_usuario', $criterio);
        $this->db->or_like('correo_usuario', $criterio);
        $query = $this->db->get('usuarios');
        
        return $query;
    }
    
    public function get_param($array){
        $query = "SELECT * from usuarios where 1 = 1 ";
        
        foreach($array as $key => $value){
            $query .= " and " . $key . " = '" . $value . "'";
        }
        
        $result = $this->db->query($query);
        
        return $result;
    }
    
    public function get_intereses($id_usuario){
        echo "get intereses";
    }
}

?>