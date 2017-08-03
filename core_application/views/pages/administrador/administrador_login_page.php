<script type="text/javascript" >
    
    $(document).ready(function(){
	$("#pass_admin").keyup(function(e){
	    var code = e.keycode || e.which;
	    if(code == 13){
		login_admin();
	    }
	});
    });
    
    function login_admin() {
        
        var flag_ok = validar_form("form_admin");
        if (flag_ok) {
            $("#form_admin").submit();
        }
        
    }
</script>

<!--CONTENIDO-->
<div class="container f_top_bot" style="margin-bottom:130px;">
    <div class="row">
        <div class="col-md-4">&nbsp;</div>
            <div class="col-md-4 thumbnail" style="margin-top: 150px; margin-bottom:150px;">     
                <form class="form_registro text-center" id="form_admin" method="POST" action="<?php echo $ruta_app?>administrador/login">
                        <br>
                        <label>Correo:</label><br>
                        <br>
                        <input type="text" id="correo_admin" name="correo_admin" style="width:245px;" value="" class="type_mail required">
                        <div id="correo_admin_error" class="m_error" style="display: none;"></div><br><br>
			<label>Contraseña:</label><br>
                        <br>
                        <input type="password" id="pass_admin" name="pass_admin" style="width:245px;" value="" class="type_pass required"><br>
			<div id="pass_admin_error" class="m_error" style="display: none;"></div><br>
                        <br>
                            <p>
                                <a href="javascript:login_admin();" class="btn btn-primary">Aceptar</a>
                            </p>
                        <br>
                </form>
            </div>
            
        <div class="col-md-4">&nbsp;</div>
    </div>
</div> 
<!--CONTENIDO-->

