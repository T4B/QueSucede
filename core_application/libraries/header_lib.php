<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Header_lib {

    public function arma_rutas(){
        $CI =& get_instance();
        
        $ruta_app = base_url();
        $data['ruta_app'] = $ruta_app;
        $ruta_css = $ruta_app.'css/';
        $data['ruta_css'] = $ruta_css;
        $data['ruta_js'] = $ruta_app.'javascripts/';
        $ruta_images = $ruta_app.'images/';
        $data['ruta_images'] = $ruta_images;
        $data['ruta_images_promo'] = $ruta_app.'images_promo/';
        $data['es_index'] = FALSE;
        
        return $data;
    }
    
    public function arma_menu($data){
        $CI =& get_instance();
        
        $array_categorias = array(7,12);
        $CI->db->where_not_in('id_categoria', $array_categorias);
        $categorias = $CI->db->get('categorias');
        $data['categorias'] = $categorias;
        $subcategorias = $CI->db->get('subcategorias');
        $data['subcategorias'] = $subcategorias;
        $tipos_promocion = $CI->db->get('tipos_promocion');
        $data['tipos_promocion'] = $tipos_promocion;
        $CI->db->order_by('nombre_formato');
        $formatos = $CI->db->get('formatos');
        $data['formatos'] = $formatos;
        $id_canales = array(1, 12, 3, 4);
        $CI->db->where_in('id_canal', $id_canales);
        $canales = $CI->db->get('canales');
        $data['canales'] = $canales;
        
        return $data;
    }
    
    public function mensaje( $titulo, $texto, $imagen){
        $CI =& get_instance();
        $flash_data = array(
            'titulo_mensaje' => $titulo,
            'texto_mensaje' => $texto,
            'imagen_mensaje' => $imagen
        );
        
        $CI->session->set_flashdata($flash_data);
        
        redirect('/page/mensaje');
        
    }
}
