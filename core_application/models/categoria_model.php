<?php
class Categoria_model extends CI_Model {
    public function __construct()
    {
    }
    
    
    public function get_all()
    {
        $array_categorias = array();
        
        $categorias_nivel1 = $this->db->get_where('categorias', array('nivel_categoria' => 1));
        
        foreach($categorias_nivel1->result_array() as $categoria_nivel1){
            array_push($array_categorias, $categoria_nivel1);
            $categorias_nivel2 = $this->db->get_where('categorias', array('padre_categoria' => $categoria_nivel1['id_categoria']));
            
            foreach($categorias_nivel2->result_array() as $categoria_nivel2){
                array_push($array_categorias, $categoria_nivel2);
                $categorias_nivel3 = $this->db->get_where('categorias', array('padre_categoria' => $categoria_nivel2['id_categoria']));
                
                foreach($categorias_nivel3->result_array() as $categoria_nivel3){
                    array_push($array_categorias, $categoria_nivel3);
                }
            }
        }
        
        return $array_categorias;
        //return $query->row_array();
    }
    
    
    public function get_all_object()
    {
        $this->db->order_by("nivel_categoria", "asc"); 
        $query = $this->db->get('categorias');
        return $query;
    }
    
    
    public function get_titulo($id){
        
        $titulo = '';
        
        $result = $this->db->get_where('categorias', array('id_categoria' => $id));
        $categoria = $result->row();
        $padre_categoria = $categoria->padre_categoria;
        $titulo = $categoria->nombre_categoria;
        
        while ($padre_categoria != 0) {
            $result = $this->db->get_where('categorias', array('id_categoria' => $padre_categoria));
            $categoria = $result->row();
            $padre_categoria = $categoria->padre_categoria;
            $titulo = $categoria->nombre_categoria . " / " . $titulo;
        }
        
        $titulo = "Categoría -> " . $titulo;
        
        return $titulo;
    }
    
    public function delete($id)
    {
        $query = $this->db->get_where('usuarios', array('username' => $username, 'password' => $password));
        return $query->row_array();
    }

}

?>