
function campos_iguales(id_1, id_2, mensaje_ok, mensaje_error){
	$("#"+id_1+", #"+id_2).keyup(function(){
		valor_1 = $("#"+id_1).val();
		valor_2 = $("#"+id_2).val();
		
		if (valor_1.length == valor_2.length) {
			if(valor_1 != "" && valor_2 != ""){
				if(valor_1 == valor_2){
					$("#mensaje_ok_"+id_1).html(mensaje_ok).removeClass("displayN").show();
					$("#mensaje_error_"+id_1).html("").addClass("displayN").hide();
				}else{
					$("#mensaje_error_"+id_1).html(mensaje_error).removeClass("displayN").show();
					$("#mensaje_ok_"+id_1).html("").addClass("displayN").hide();
				}
			}	
		}
	});
}

function pinta_error(id , mensaje){
    if(mensaje != ""){
        $("#"+id+"_error").html(mensaje);
        $("#div_error").html(mensaje);
        $("#"+id+"_error").removeClass("displayN").fadeIn("slow");
    }else{
        $("#"+id+"_error").addClass("displayN").hide(); 
    }
}

function limpia_errores(){
    $("*[id$='_error']").addClass("displayN").hide();
}

function limpia_mensajes(id_buscar){
    $("#"+id_buscar+" div.mensaje").hide();
}


function validar_input(id, error){
    var valor = $("#"+id).val();
    
    if( valor == ""){
        pinta_error(id, error);
        return false;
    }
    
    return true;
}

function validar_check(id){
    var checado = $("#"+id).is(":checked");
    return checado;
}

function validar_radio(name, error){
    if($("input[name='"+name+"']").is(":checked")){
        return true;
    }else{
        pinta_error(name, error);
        return false;
    }
}

//Validators	
function validar_combo(id, error){
    var flag_ok = true;
    
    var valor = $("#"+id).find("option:selected").val();
	
    if( valor == "" || valor == "PS"){
        flag_ok = false;
        pinta_error(id, error);
    }
    
    return flag_ok;
}
	

//Validar formulario
function validar_recaptcha(funcion, parametro){
	var challenge_field = Recaptcha.get_challenge();
	var response_field = Recaptcha.get_response();
	
	var url = $("#ruta_app").val()+"recaptcha/verifica_captcha";
	
	limpia_errores();
	
	$.ajax({
		type: "POST",
		url: url,
		data: {'challenge_field':challenge_field, 'response_field':response_field},
		success: function(response){
			if(response == 1){
				funcion(parametro);
			}else{
				pinta_error("captcha", "El código no corresponde con la imágen");
				Recaptcha.reload();
			}
		},
		error: function(response){
			pinta_error("captcha", "Error de comunicación intente más tarde");
		}
	});
}


function validar_captcha(funcion, parametro, id_padre){
	var captcha = $("#"+id_padre).find("input.captcha").val();
	
	if(captcha == ""){
		pinta_error("captcha", "Por favor captura el código de la imágen");
	}else{
		
		var url = $("#ruta_app").val()+"captcha/check";
		
		limpia_errores();
		
		$.ajax({
			type: "POST",
			url: url,
			data: {'captcha':captcha},
			success: function(response){
				if(response == 1){
					funcion(parametro);
				}else{
					pinta_error("captcha", "El código no corresponde con la imágen");
				}
			},
			error: function(response){
				pinta_error("captcha", "Error de comunicación intente más tarde");
			}
		});
	}
}

function recargar_captcha(id_contenedor, id_input){
	limpia_errores();
	var url = $("#ruta_app").val()+"captcha/make";
	$.ajax({
		type: "POST",
		url: url,
		success: function(response){
			$("#"+id_contenedor).html(response);
		},
		error: function(response){
			pinta_error("captcha", "Error de comunicación intente más tarde");
		}
	});
}


var err_vacio = "Campo requerido";
var err_alpha = "El campo debe ser alfabético";
var err_alphanumeric = "El campo debe ser alfanumérico";
var err_mail = "Introduce un correo válido";
var err_numeric = "El campo debe ser numérico";
var err_rfc = "RFC no válido";
var err_pass = "No es un password válido";
var err_combo = "Elije una opción";
var err_username = "El usuario no puede contener espacios ni caracteres especiales";
var err_decimal = "El cambo debe ser decimal.";
var err_generic = "El campo no puede estar vacío";
var err_file = "Elige un archivo";

function generic(valor) {
	var re = new RegExp("^[^]+$");
	var match = re.test(valor);
    return match;
}

function alpha(valor){
	var re = new RegExp("^[A-Za-z ñÑáéíóúÁÉÍÓÚ]+$");
	var match = re.test(valor);
	return match;
}

function alphanumeric(valor){
	var re = new RegExp("^[A-Za-z0-9 ñÑáéíóúÁÉÍÓÚ._-]+$");
	var match = re.test(valor);
	return match;
}

function username(valor){
	var re = new RegExp("^[A-Za-z0-9ñÑáéíóúÁÉÍÓÚ.]+$");
	var match = re.test(valor);
	return match;
}

function mail(valor){
	var re = new RegExp("^[_a-zA-Z0-9-]+(\\.[_a-zA-Z0-9-]+)*@[A-Za-z0-9-]{2,}(\\.[A-Za-z]{2,}){1,2}$");
	var match = re.test(valor);
	return match;
}

function numeric(valor){
	var re = new RegExp("^[0-9]+$");
	var match = re.test(valor);
	return match;
}

function rfc(valor){
	//var re = new RegExp("^(([A-Z]|[a-z]|\s){1})(([A-Z]|[a-z]){3})([0-9]{6})((([A-Z]|[a-z]|[0-9]){3}))");
	var re = new RegExp("^(([A-Z]|[a-z]|\s){1})(([A-Z]|[a-z]){1,3})([0-9]{6})((([A-Z]|[a-z]|[0-9]){1,3})*)");
	var match = re.test(valor);
	return match;
}

function pass(valor){
	var re = new RegExp("(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9{}]{8,24})$");
	//(\d+)(\1){4,}
	var match = re.test(valor);
	return match;
}

function decimal(valor) {
	var re = new RegExp("^[0-9]+(\.[0-9]{1,2})?$");
	var match = re.test(valor);
	return match;
}

function obtener_tipo(clase){
	var clases = new Array();
	var tipo_campo = "";
	
	if(clase.indexOf(' ') > -1){
		clases = clase.split(' ');
		for(clase in clases){
			if(clases[clase].indexOf('type') > -1){
				tipo_campo = clases[clase].split("_")[1];
				break;
			}
		}
	}else{
		tipo_campo = clase.split("_")[1];
	}
	
	return tipo_campo;
}

function validar_form(id_form){
	limpia_errores();
	
	var campo_error = "";
	var tipo_campo = "";
	
	$("#"+id_form).find("[class*='type_'], .combo").removeClass('formee-error');
	//$("#"+id_form).find("[class*='type_'], .combo").css('border','');
	
	
	$("#"+id_form).find("[class*='type_']").each(function(){
		var clase = $(this).attr("class");
		var tipo = obtener_tipo(clase);
		var id = $(this).attr("id");
		if (tipo != 'file'){
			$(this).val($.trim($(this).val()));	
		}
		
		var valor = $(this).val();
		
		if(valor == ""){
			if($(this).hasClass("required")){
				
				if (tipo == 'file') {
					var error_actual = err_file;
				}else{
					var error_actual = err_vacio;
				}
				
				pinta_error(id, error_actual);
				if(campo_error == ""){
					campo_error = id;
					tipo_campo = 'input';
				}
			}
		}else{
			if (tipo != 'file' && tipo != 'html') {
				var funcion = tipo;
				var evaluar = funcion+"('"+valor+"');";
				if(!eval(evaluar)){
					pinta_error(id, eval("err_"+tipo));
					if(campo_error == ""){
						campo_error = id;
						tipo_campo = 'input';
					}
				}
			}
		}
	});
	
	$("#"+id_form).find(".combo").each(function(){
		var id = $(this).attr("id");
		if(!validar_combo(id, err_combo)){
			if(campo_error == ""){
				campo_error = id;
				tipo_campo = 'combo';
			}
		}
	});
	
	//$('html, body').animate({ scrollTop: $('#navigation').offset().top }, 'slow');
	
	var errores = $("#"+id_form).find("div[id$='_error']:visible, div[id^='mensaje_error']:visible").length;
	
	if(errores <= 0){
		return true;
	}else{
		switch(tipo_campo){
			case "combo":
				var top = $("#"+campo_error).offset().top-120;
				break;
			case "input":
				var top = $("#"+campo_error).offset().top-120;
				break;
		}
		
		$('html, body').animate({ scrollTop: top }, 'slow');
		
		$("#"+campo_error).addClass('formee-error').focus();
		return false;
	}
	
}

//formulario