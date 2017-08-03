<script type="text/javascript">
    function recuperar() {
        var correo = $("#correo").val();
        var flag_ok = validar_form("form_recuperar");
        
        if (flag_ok) {
            $("#form_recuperar").submit();
        }
    }
</script>


<!--CONTENIDO-->
<div class="container f_top_bot" style="margin-bottom:130px;">
    <div class="row">
        <div class="col-md-4">&nbsp;</div>
            <div class="col-md-4 thumbnail" style="margin-top: 150px; margin-bottom:150px;">     
                <form class="form_registro text-center" id="form_recuperar" method="POST" action="<?php echo $ruta_app?>registro/recuperar">
                      <br>
                        <label>Ingresa tu correo registrado:</label><br>
                      <br>
                      <input type="text" id="correo" name="correo" style="width:245px;" value="" class="type_mail required">
                        <div id="correo_error" class="m_error" style="display: none;"></div><br>
                        <br>
                            <p>
                                <a href="javascript:recuperar();" class="btn btn-primary">Recuperar contraseña</a>
                            </p>
                        <br>
                </form>
            </div>
            
        <div class="col-md-4">&nbsp;</div>
    </div>
</div> 
  
 
<!--CONTENIDO--> 
