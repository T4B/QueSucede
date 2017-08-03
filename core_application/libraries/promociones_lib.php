<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Promociones_lib {
	
	public function validar_categoria($id_subcategoria){
        $error = TRUE;
        if(is_numeric($id_subcategoria)){
            if($id_subcategoria == 0){
                $mensaje_error = "El id de categoría no puede ser cero.";
            }else{
                $error = FALSE;
            }
        }else{
            $mensaje_error = "El id de categoría debe ser numérico.";
        }
        
        if($error){
            return $mensaje_error;
        }else{
            return FALSE;
        }
    }
    
    public function validar_marca($id){
        $error = TRUE;
        
        if(is_numeric($id)){
            if($id == 0){
                $mensaje_error = "El id de marca no puede ser cero.";
            }else{
                $error = FALSE;
            }
        }else{
            $mensaje_error = "El id de marca debe ser numérico.";
        }
        
        if($error){
            return $mensaje_error;
        }else{
            return FALSE;
        }
    }
    
    public function validar_promocion($id){
        $error = TRUE;
        
        if(is_numeric($id)){
            if($id == 0){
                $mensaje_error = "El tipo de promoción no puede ser cero.";
            }else{
                $error = FALSE;
            }
        }else{
            $mensaje_error = "El tipo de promoción debe ser numérico.";
        }
        
        if($error){
            return $mensaje_error;
        }else{
            return FALSE;
        }
    }
    
    
    public function validar_semana($semana){
        $error = TRUE; 
        
        if(is_numeric($semana)){
            if($semana <= 0 || $semana > 53){
                $mensaje_error = "La semana debe estar en el rango de 1 a 53.";
            }else{
                $error = FALSE;
            }
        }else{
            $mensaje_error = "El campo semana debe ser numérico.";
        }
        
        if($error){
            return $mensaje_error;
        }else{
            return FALSE;
        }
    }
    
    public function validar_estado($estado){
        $error = TRUE; 
        
        if(is_numeric($estado)){
            if($estado <= 0 || $estado > 32){
                $mensaje_error = "El estado debe estar en el rango de 1 a 32.";
            }else{
                $error = FALSE;
            }
        }else{
            $mensaje_error = "El campo id_estado debe ser numérico.";
        }
        
        if($error){
            return $mensaje_error;
        }else{
            return FALSE;
        }
    }
    
    public function validar_anio($anio){
        $error = TRUE; 
        
        $anio_actual = date('Y');
        
        if(is_numeric($anio)){
            if($anio > $anio_actual){
                $mensaje_error = "El año debe ser menor o igual al actual.";
            }else{
                $error = FALSE;
            }
        }else{
            $mensaje_error = "El campo año debe ser numérico.";
        }
        
        if($error){
            return $mensaje_error;
        }else{
            return FALSE;
        }
    }
    
    public function validar_formato($formato){
        $error = TRUE;
        if(is_numeric($formato)){
            if($formato == 0){
                $mensaje_error = "El id de formato no puede ser cero.";
            }else{
                $error = FALSE;
            }
        }else{
            $mensaje_error = "El id de formato debe ser numérico.";
        }
        if($error){
            return $mensaje_error;
        }else{
            return FALSE;
        }
    }
    
    public function validar_ubicacion($ubicacion){
        $error = TRUE;
        if(is_numeric($ubicacion)){
            if($ubicacion == 0){
                $mensaje_error = "El id de ubicacion no puede ser cero.";
            }else{
                $error = FALSE;
            }
        }else{
            $mensaje_error = "El id de ubicacion debe ser numérico.";
        }
        if($error){
            return $mensaje_error;
        }else{
            return FALSE;
        }
    }
   
    
	
}
