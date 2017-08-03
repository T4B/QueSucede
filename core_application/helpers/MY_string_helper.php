<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function str_suffix($cadena, $caracter, $tamanio){
		
	$suffix = "suffix - " . $cadena;
	$inicio = 0;
	$fin = strlen($cadena);
	$contador = 1;
	
	for($i=0;$i<strlen($cadena);$i++){
		if($cadena[$i] == $caracter){
			if($contador < $tamanio){
				$contador++;
			}else{
				$contador++;
				$inicio = $i + 1;
				$fin = $fin - $i;
				$i = strlen($cadena);
			}
		}
	}
	
	$suffix = substr($cadena, $inicio, $fin);
	
	return $suffix;
}

function str_prefix($cadena, $caracter, $tamanio){
		
	$suffix = "suffix - " . $cadena;
	$inicio = 0;
	$fin = 0;
	$contador = 1;
	
	for($i=0;$i<strlen($cadena);$i++){
		$fin++;
		if($cadena[$i] == $caracter){
			if($contador < $tamanio){
				$contador++;
				$inicio = $i + 1;
				$fin = 0;
			}else{
				$contador++;
				$fin--;
				$i = strlen($cadena);
			}
		}
	}
	
	$prefix = substr($cadena, $inicio, $fin);
	
	return $prefix;
}

function encrypt($string){
	$key = 'LAKSJDHFG1029384756QPWOEIRUTY';
	$result = '';
	for($i=0; $i<strlen($string); $i++) {
	   $char = substr($string, $i, 1);
	   $keychar = substr($key, ($i % strlen($key))-1, 1);
	   $char = chr(ord($char)+ord($keychar));
	   $result.=$char;
	}
	return base64_encode($result);
}

function decrypt($string) {
   $key = 'LAKSJDHFG1029384756QPWOEIRUTY';
   $result = '';
   $string = base64_decode($string);
   for($i=0; $i<strlen($string); $i++) {
      $char = substr($string, $i, 1);
      $keychar = substr($key, ($i % strlen($key))-1, 1);
      $char = chr(ord($char)-ord($keychar));
      $result.=$char;
   }
   return $result;
}

function obtener_ruta($ruta){
	$ruta_app = base_url();
	
	switch ($ruta){
		case 'app':
			return $ruta_app;
		case 'css':
			return $ruta_app.'css/';
		case 'js':
			return $ruta_app.'javascripts/';
		case 'images':
			return $ruta_app.'images/';
	}
	
}

