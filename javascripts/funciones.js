function lanzar_modal(id) {
	$("#"+id).modal();
}

$(document).ready(function(){
	$("#form_login").submit(function(event){
		var flag_ok = validar_form($(this).attr("id"));
		if(!flag_ok){
			event.preventDefault();
		}else{
			$("#password").val(calcMD5($("#password").val()));
		}
	});
});