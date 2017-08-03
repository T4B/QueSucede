<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function sumar_fecha($fecha, $cantidad, $concepto){
	return date("Y-m-d H:i:s", strtotime($fecha." +$cantidad $concepto"));
}

function suma_dias($fecha, $dias){
	return date("Y-m-d H:i:s", strtotime($fecha." +$dias days"));
}

function resta_dias($fecha, $dias){
	return date("Y-m-d H:i:s", strtotime($fecha." -$dias days"));
}

function comparar_fechas($fecha1, $fecha2){
	
	$fecha1 = strtotime($fecha1);
	$fecha2 = strtotime($fecha2);
	
	if($fecha1 == $fecha2){
		return 0;
	}else if($fecha1 > $fecha2){
		return 1;
	}else{
		return 2;
	}
}

function suma_horas($fecha, $horas){
	$var = strtotime($fecha);
	$horas_mas = 60 * 60 * $horas;
	$var += $horas_mas;
	return date("Y-m-d H:i:s",$var);
}


function suma_minutos($fecha, $minutos){
	$var = strtotime($fecha);
	$horas_mas = 60 * $minutos;
	$var += $horas_mas;
	return date("Y-m-d H:i:s",$var);
}

function suma_segundos($fecha, $segundos){
	$var = strtotime($fecha);
	$horas_mas = $segundos;
	$var += $horas_mas;
	return date("Y-m-d H:i:s",$var);
}

function diferencia_hora($fecha_menor, $fecha_mayor){
	$diferencia = strtotime($fecha_mayor) - strtotime($fecha_menor);
	$horas_orig = ($diferencia/(60*60));
	$horas = (int)$horas_orig;
	$minutos_orig = ($horas_orig - (int)$horas_orig) * 60;
	$minutos = (int)$minutos_orig;
	$segundos_orig = ($minutos_orig - (int)$minutos_orig) * 60;
	$segundos = (int)$segundos_orig;
	if($horas < 10){
		$horas = '0'.$horas;
	}
	if($minutos < 10){
		$minutos = '0'.$minutos;
	}
	if($segundos < 10){
		$segundos = '0'.$segundos;
	}
	
	$resultado = $horas . ":" . $minutos . ":" . $segundos;
	
	return $resultado;
}

function diferencia_dias($fecha_menor, $fecha_mayor){
	$diferencia = strtotime($fecha_mayor) - strtotime($fecha_menor);
	$horas_orig = ($diferencia/(60*60));
	$horas = (int)$horas_orig;
	$dias = (int)($horas / 24);
	
	return $dias;
	
}



function diferencia_minutos($fecha_menor, $fecha_mayor){
	$diferencia = strtotime($fecha_mayor) - strtotime($fecha_menor);
	$horas_orig = ($diferencia/(60*60));
	$horas = (int)$horas_orig;
	
	echo "horas -> ";
	echo $horas;
	
	$minutos_orig = ($horas_orig - (int)$horas_orig) * 60;
	$minutos = (int)$minutos_orig;
	echo "<br />minutos-> ";
	echo $minutos;
	$segundos_orig = ($minutos_orig - (int)$minutos_orig) * 60;
	$segundos = (int)$segundos_orig;
	
	echo "<br />segundos ->";
	echo $segundos;
	
	echo "<br />";
	
	return $minutos;
}

function diferencia_segundos($fecha_menor, $fecha_mayor){
	$diferencia = strtotime($fecha_mayor) - strtotime($fecha_menor);
	$segundos = $diferencia;
	return $segundos;
}

function fecha_pago($fecha){
	
	$fecha_aprob = str_prefix($fecha, 'T', 1);
	$hora_aprob = str_suffix($fecha, 'T', 1);
	$hora_aprob = str_prefix($hora_aprob, '.', 1);
	
	$fecha_aprobacion = date($fecha_aprob . " " . $hora_aprob);
	
	return $fecha_aprobacion;
}


