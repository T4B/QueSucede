<script type="text/javascript">
  
	$(document).ready(function(){
		campos_iguales("correo_reg", "correo_echo", "Los correos coinciden", "Los correos no coinciden");
		//campos_iguales("usuario", "usuario_echo", "Los campos coinciden", "Los campos no coinciden");
		campos_iguales("password_reg", "password_echo", "Los campos coinciden", "Los campos no coinciden");
		
		$("#check_recomendado").click(function(){
			if ($(this).is(":checked")) {
				$("#div_correo_recomendacion").show();
			}else{
				$("#div_correo_recomendacion").hide();
				$("#correo_recomendacion").val("");
			}
		}).prop("checked", false);
	});
  
  function validar_usuario() {
	var mi_url = "<?php echo $ruta_app?>registro/validar_usuario";
	var usuario = $("#usuario_reg").val();
	if ($.trim(usuario) != "") {
	  $.ajax({
		type:"post",
		dataType:"json",
		url: mi_url,
		data:{usuario:usuario},
		success:function(response){
		  if(response.mensaje != "OK"){
			$("#usuario_reg_error").html(response.mensaje).show();
			usuario_ok = false;
		  }else{
			usuario_ok = true;
		  }
		},
		error:function(err){
		  
		}
	  });
	}
  }
  
  function registrar() {
	var flag_ok = validar_form('form_registro');
	
	if (flag_ok) {
		
		if ($("#check_recomendado").is(":checked")) {
			var mi_url = "<?php echo $ruta_app?>registro/validar_recomendacion";
			var correo_recomendacion = $("#correo_recomendacion").val();
			var correo = $("#correo_reg").val();
			
			$.ajax({
				type:"post",
				url:mi_url,
				dataType:"json",
				data:{correo:correo, correo_recomendacion: correo_recomendacion},
				success:function(response){
					if (response.codigo == 0) {
						enviar_formulario();
					}else{
						alert(response.mensaje);
					}
				},
				error:function(){
					alert("Error de comunicación");
				}
			});
		}else{
			enviar_formulario();
		}
	}
  }
  
	function enviar_formulario() {
		alert("Enviar formulario");
		$("#password_reg").val(calcMD5($("#password_reg").val()));
		$("#form_registro").submit();
	}
  
</script>

<div class="container f_top_bot">
  <h5 class="h2_m_blue text-center">Regístrate y obtén 7 días de acceso gratis para probar Qué Sucede.</h5>
  
  
  <form role="form" id="form_registro" method="post" action="<?php echo $ruta_app?>registro/guardar">
    
    <div class="row">
      <div class="col-md-3"></div><div class="col-md-6"><h3>Datos generales</h3><hr></div><div class="col-md-3"></div>
    </div>
    
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-3">
	<label for="nombre_basico">(*) Nombre (s)</label>
        <input type="text" class="form-control type_alpha required" id="nombre_basico" placeholder=" " name="nombre" autocomplete="off">
	<div id="nombre_basico_error" class="alert alert-danger" style="display: none;"></div>
	<span style="font-size:12px; color:#6c6c6c;">(Ejemplo: Ana)</span>
      </div>
      
	<div class="col-md-3">
	  <label for="a_paterno_basico">(*) Apellido paterno</label>
	  <input type="text" class="form-control type_alpha required" id="a_paterno_basico" placeholder=" " maxlength="15" name="a_paterno" autocomplete="off">
	  <div id="a_paterno_basico_error" class="alert alert-danger" style="display: none;"></div>
	  	<span style="font-size:12px; color:#6c6c6c;">(Ejemplo: Pérez)</span>
	  
	</div>
	  <div class="col-md-3"></div>
    </div><!--/ROW-->
	
	<div class="row" style="margin-top: 15px;">
      <div class="col-md-3"></div>
      <div class="col-md-3">
	<label for="a_materno_basico">(*) Apellido materno</label>
        <input type="text" class="form-control type_alpha required" id="a_materno_basico" placeholder=" " name="a_materno" autocomplete="off">
	<div id="a_materno_basico_error" class="alert alert-danger" style="display: none;"></div>
		  	<span style="font-size:12px; color:#6c6c6c;">(Ejemplo: Ruíz)</span>
	
      </div>
      
	<div class="col-md-3">
	</div>
	  <div class="col-md-3"></div>
    </div><!--/ROW-->
	
	<div class="row" style="margin-top: 15px;">
      <div class="col-md-3"></div>
	  
      <div class="col-md-1">
	<label for="lada_basico">(*) Lada</label>
        <input type="text" class="form-control type_numeric required" id="lada_basico" placeholder=" " name="lada" autocomplete="off" maxlength="4">
	<div id="lada_basico_error" class="alert alert-danger" style="display: none;"></div>
		  	<span style="font-size:12px; color:#6c6c6c;">(Ejemplo: 55)</span>
	
      </div>
    
	<div class="col-md-2">
	  <label for="telefono_basico">(*) Teléfono</label>
	  <input type="text" class="form-control type_numeric required" id="telefono_basico" placeholder=" " maxlength="15" name="telefono" autocomplete="off">
	  <div id="telefono_basico_error" class="alert alert-danger" style="display: none;"></div>
		  	<span style="font-size:12px; color:#6c6c6c;">(Ejemplo: 56894155)</span>
	  
	</div>
	<div class="col-md-2"></div>
	  <div class="col-md-3"></div>
    </div><!--/ROW-->
	
    
	<div class="row" style="margin-top:30px;">
	  <div class="col-md-3"></div><div class="col-md-6"><h3>Datos de acceso</h3><hr></div><div class="col-md-3"></div>
	</div>
	  
	  <div class="row" style="margin-top: 15px;">
	    <div class="col-md-3"></div>
		
	    <div class="col-md-3">
	      <label for="correo_reg">(*) Correo electrónico</label>
	      <input type="text" class="form-control type_mail required" id="correo_reg" placeholder=" " name="correo" autocomplete="off">
	      <div id="correo_reg_error" class="alert alert-danger" style="display: none;"></div>
	      	  	<span style="font-size:12px; color:#6c6c6c;">(Ejemplo: ejemplo@tucorreo.com.mx)</span>
	      
	    </div>
	    
	    <div class="col-md-3">
	      <label for="correo_echo">(*) Repetir Correo electrónico</label>
	      <input type="text" class="form-control type_mail required" id="correo_echo" placeholder=" " autocomplete="off">
	      <div id="correo_echo_error" class="alert alert-danger" style="display: none;"></div>
	    </div>
	    <div class="col-md-3"></div>
	  </div><!--/ROW-->
	  
	  <div class="row">
		<div class="col-md-3">
		</div>
		<div class="col-md-6">
		    <div id="mensaje_ok_correo_reg" class="alert alert-success" style="display: none;"></div>
		<div id="mensaje_error_correo_reg" class="alert alert-danger" style="display: none;"></div>
		</div>
		<div class="col-md-3">
		</div>
	  </div>
	  
	    <div class="row" style="margin-top: 15px;">
	      <div class="col-md-3"></div>
	      <div class="col-md-3">
			<label for="password_reg">(*) Contraseña</label>
			<input type="password" class="form-control type_pass required" id="password_reg" placeholder=" " name="password" maxlength="12">
			<div id="password_reg_error" class="alert alert-danger" style="display: none;"></div>
			<span style="font-size:12px; color:#6c6c6c;">(Debe contener al menos 8 caracteres alfanuméricos.)</span>
		  </div>
			<div class="col-md-3">
			  <label for="password_echo">(*) Repetir contraseña </label>
			  <input type="password" class="form-control type_pass required" id="password_echo" name="password_echo" placeholder=" " maxlength="12">
			  <div id="password_echo_error" class="alert alert-danger" style="display: none;"></div>
			</div>
	      <div class="col-md-3"></div>
	    </div><!--/ROW-->
		
		<!--IMPUT_PARA VALIDAR-->
		<div class="row" style="margin-top: 15px;">
	      <div class="col-md-3"></div>
	      <div class="col-md-3">
			<div class="checkbox">
			  <label>
				<input type="checkbox" id="check_recomendado">Alguien me recomendo Qué Sucede
			  </label>
			</div>
		  </div>
			
	    </div><!--/ROW-->
		<!--/Nuevo_contenido-->
		
		  <!--IMPUT_PARA INGRESAR CORREO-->
		  <div id="div_correo_recomendacion" class="row" style="margin-top:2px; display: none;">
			<div class="col-md-3"></div>
			<div class="col-md-3" style="background-color: #FFF; min-height: 95px;"><br/>
			  <label for="correo_recomendado">Correo electrónico</label>
			  <input type="text" class="form-control type_alpha required" id="correo_recomendacion" name="correo_recomendacion" placeholder=" " autocomplete="off">
			</div>
			  <div class="col-md-3" style="background-color: #FFF;  min-height: 95px; color: #ed1847;">
				<br /><br />Mensaje para corroborar la información.
			  </div>
			<div class="col-md-3"></div>
		  </div><!--/ROW-->
		  <!--Nuevo_contenido-->
		
	    <div class="row">
		<div class="col-md-3">
		</div>
		<div class="col-md-6">
		    <div id="mensaje_ok_password_reg" class="alert alert-success" style="display: none;"></div>
		<div id="mensaje_error_password_reg" class="alert alert-danger" style="display: none;"></div>
		</div>
		<div class="col-md-3">
		</div>
	  </div>
		
		<div class="row">
		  <div class="col-md-3"></div>
		  <div class="col-md-6 text-right"><br>
		  
		  <div class="col-md-6 text-left"><span style="font-size:12px; color:#6c6c6c;">Los campos con (*) son obligatorios.</span>
		  </div>
		  <br />
		  	 <div class="col-md-6 text-left">Para mayor información contáctanos dando clic <a href="http://quesucede.com.mx/contacto"><b>aquí.</b></a></div>
		  	 
			<button type="button" onclick="javascript:registrar();" class="btn btn-primary btn-lg">Registrarme</button>
			<hr>
		  </div>
		  <div class="col-md-3"></div>
		</div>
  
  </form>
</div> <!-- /container -->

