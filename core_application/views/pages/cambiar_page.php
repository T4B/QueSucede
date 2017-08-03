<script type="text/javascript" >
    
    $(document).ready(function(){
        campos_iguales("cont_password", "pass_echo", "Las contraseñas coinciden", "Las contraseñas deben ser iguales");
    });
    
    function cambiar() {
        
        var flag_ok = validar_form("form_recuperar");
        
        if (flag_ok) {
            $("#cont_password").val(calcMD5($("#cont_password").val()));
            $("#form_recuperar").submit();
        }
        
    }
</script>

<!--CONTENIDO-->
<div class="container f_top_bot" style="margin-bottom:130px;">
    <div class="row">
        <div class="col-md-4">&nbsp;</div>
            <div class="col-md-4 thumbnail" style="margin-top: 150px; margin-bottom:150px;">     
                <form class="form_registro text-center" id="form_recuperar" method="POST" action="<?php echo $ruta_app?>registro/cambiar">
                        <br>
                        <label>Introduce tu nueva contraseña:</label><br>
                        <br>
                        <input type="password" id="cont_password" name="password" style="width:245px;" value="" class="type_pass required">
                        <div id="cont_password_error" class="m_error" style="display: none;"></div><br><br>
						<label>Vuelve a ingresar la contraseña:</label><br>
                        <br>
                        <input type="password" id="pass_echo" name="pass_echo" style="width:245px;" value="" class="type_pass required"><br>
						<div id="pass_echo_error" class="m_error" style="display: none;"></div><br>
						
						<div id="mensaje_ok_cont_password" class="m_ok" style="display: none;"></div>
					    <div id="mensaje_error_cont_password" class="m_error" style="display: none;"></div>
                        <input type="hidden" name="uts" value="<?php echo $correo_usuario; ?>" />
						
                        <br>
                            <p>
                                <a href="javascript:cambiar();" class="btn btn-primary">Cambiar contraseña</a>
                            </p>
                        <br>
                </form>
            </div>
            
        <div class="col-md-4">&nbsp;</div>
    </div>
</div> 
  
 
<!--CONTENIDO--> 
