<script type="text/javascript">
    function validar() {
	var flag_ok = false;
	flag_ok = validar_form("form_contacto");
	if (flag_ok) {
	    $("#form_contacto").submit();
	}
    }
    
    $(document).ready(function(){
	$("#mensaje_contacto").keyup(function(event){
            var key = event.keyCode || event.wich;
            if (key == 13) {
                event.preventDefault();
                var valor = $(this).val();
                valor = valor.replace(/\n/g, "");
                $(this).val(valor);
            }
        });
    });
</script>

<div class="container f_top_bot" style="margin-bottom:130px;">
<div class="col-md-1">&nbsp;</div>
<div class="col-md-7 f_top">
    
    <h2 class="h2_m_yellow">Contacto</h2>
    <br>
        <form role="form" id="form_contacto" method="post" action="<?php echo $ruta_app;?>contacto/enviar">
            <div class="row">
		<div class="col-md-6">
		    <label for="nombre_contacto">(*) Nombre</label>
		    <input type="text" class="form-control type_alpha required" id="nombre_contacto" name="nombre">
		    <div id="nombre_contacto_error" class="alert alert-danger" style="display: none;"></div>
		    <span style="font-size:12px; color:#6c6c6c;">(Ejemplo: Ana)</span>
		</div>
		
		<div class="col-md-6">
		    <label for="correo_contacto">(*) Correo electrónico</label>
		    <input type="text" class="form-control type_mail required" id="correo_contacto" name="correo">
		    <div id="correo_contacto_error" class="alert alert-danger" style="display: none;"></div>
		    <span style="font-size:12px; color:#6c6c6c;">(Ejemplo: ejemplo@quesucede.com.mx)</span>
		</div>
              
            </div><!--/ROW-->
            
            <div class="row" style="margin-top:10px;">
              
              <div class="col-md-6">
		    <label for="telefono_contacto">(*) Teléfono</label>
		    <input type="text" class="form-control type_numeric required" id="telefono_contacto" name="telefono">
		    <div id="telefono_contacto_error" class="alert alert-danger" style="display: none;"></div>
		    <span style="font-size:12px; color:#6c6c6c;">(Ejemplo: 56894155)</span><br><br><br>
		    <span style="font-size:12px; color:#6c6c6c;">Los campos con (*) son obligatorios.</span>
              </div>
              
		<div class="col-md-6">
		   <label >(*) Mensaje</label>
		   <textarea id="mensaje_contacto" name="mensaje" class="form-control type_alphanumeric required" rows="3"></textarea><br>
		   <div id="mensaje_contacto_error" class="alert alert-danger" style="display: none;"></div>
		</div>
              
            </div><!--/ROW-->
            
                <div class="row">
                  <div class="col-md-12 text-right"><br><button onclick="validar();" type="button" class="btn btn-danger btn-lg">Enviar</button><hr></div>
                </div>
        </form>
</div>

    <div class="col-md-4 f_top" style="text-align:center;">
        <img src="<?php echo $ruta_images; ?>img_4.jpg" class="img-responsive">
    </div>      

</div> <!-- /container -->