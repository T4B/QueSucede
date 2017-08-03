<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paginacion_lib {

    public function paginar($tabla, $objetos_por_pagina, $num_pagina){
        $CI =& get_instance();
        
        $arr_objetos = array();
        
        $paginas_mostrar = 10;
        
        $numero_objetos = count($tabla);
        
        $total_paginas = round(($numero_objetos / $objetos_por_pagina) + .4);
        
        $primer_elemento = ($num_pagina * $objetos_por_pagina) - ($objetos_por_pagina);
        
        $ultimo_elemento = $primer_elemento + ($objetos_por_pagina - 1);
        
        $ultimo_elemento = $ultimo_elemento >= $numero_objetos ? $numero_objetos - 1 : $ultimo_elemento;
        
        $elementos_agregar = $ultimo_elemento - $primer_elemento + 1;
        
        $contador = 1;
        
        $indice = $primer_elemento;
        
        $array_paginas = array();
        
        if($total_paginas <= $paginas_mostrar){
            $pagina_actual = 1;
        }else{
            $pagina_actual = $num_pagina - (int)($paginas_mostrar / 2);
            $pagina_actual = ($pagina_actual <= 0) ? 1 : $pagina_actual;
        }
        
        for($i = 1; $i <= $paginas_mostrar; $i++){
            if($pagina_actual <= $total_paginas){
                array_push($array_paginas, $pagina_actual);
                $pagina_actual++;
            }
        }
        
        for($i = 0; $i < $elementos_agregar; $i++){
            array_push($arr_objetos, $tabla[$indice]);
            $indice++;
        }
        
        $response = array(
            'total_paginas' => $total_paginas,
            'tabla' => $arr_objetos,
            'array_paginas' => $array_paginas
        );
        
        return $response;
    }
    
    public function set_variable($variable, $valor){
        $CI =& get_instance();
        
        $CI->session->set_userdata($variable, $valor);
    }
    
    public function pag_consulta($consulta, $objetos_por_pagina, $num_pagina){
        $CI =& get_instance();
        
        $array_paginas = array();
        $arr_objetos = array();
        
        $paginas_mostrar = 10;
        
        $query = $CI->session->userdata($consulta);
        $CI->session->unset_userdata($consulta);
        $CI->session->set_userdata($consulta, $query);
        
        $query_count = 'select count(*) as total from ( ';
        $query_count .= $query . ') as total_tab;';
        
        $total_objetos = $CI->db->query($query_count)->row()->total;
        
        if($total_objetos > 0){
            $total_paginas = round(($total_objetos / $objetos_por_pagina) + .4);
            
            $primer_elemento = ($num_pagina * $objetos_por_pagina) - ($objetos_por_pagina);
            
            $query_final = $query;
            $query_final .= ' limit ' . $primer_elemento . ", " . $objetos_por_pagina . "; ";
            
            $arr_objetos = $CI->db->query($query_final)->result_array();
            
            if($total_paginas <= $paginas_mostrar){
                $pagina_actual = 1;
            }else{
                $pagina_actual = $num_pagina - (int)($paginas_mostrar / 2);
                $pagina_actual = ($pagina_actual <= 0) ? 1 : $pagina_actual;
            }
            
            for($i = 1; $i <= $paginas_mostrar; $i++){
                if($pagina_actual <= $total_paginas){
                    array_push($array_paginas, $pagina_actual);
                    $pagina_actual++;
                }
            }
            
        }else{
            $total_paginas = 0;
        }
        
        $response = array(
            'total_objetos' => $total_objetos,
            'total_paginas' => $total_paginas,
            'tabla' => $arr_objetos,
            'array_paginas' => $array_paginas
        );
        
        return $response;
        
    }

}
