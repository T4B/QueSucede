<?php
class Formato_model extends CI_Model {
    public function __construct()
    {
    }
    
    public function get_all()
    {
        $query = $this->db->get('formatos');
        return $query;
    }
    
    public function delete($id)
    {
        $query = $this->db->get_where('usuarios', array('username' => $username, 'password' => $password));
        return $query->row_array();
    }
    
    public function insert($cadena, $nombre, $canal){
        
        $data = array(
            'nombre_formato' => $nombre,
            'cadenas_id_cadena' => $cadena,
            'canales_id_canal' => $canal
        );
        
        $this->db->insert('formatos', $data);
        
    }

}

?>