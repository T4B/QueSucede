<script type="text/javascript">
    function alta_usuario() {
        var flag_ok = validar_form("form_admin");
        if (flag_ok) {
            //$("#form_admin").submit();
            
            
            var mi_url = "<?php echo $ruta_app;?>administrador/guardar_admin";
            var data = $("#form_admin").serialize();
            
            alert(data);
            
            $.ajax({
                url:mi_url,
                type:'post',
                dataType:'json',
                data:data,
                success:function(response){
                    alert(response.mensaje);
                },
                error:function(){
                    alert("error");
                }
            });
        }
    }
</script>

<div class="container f_top_bot">
    <div style=" width: 650px; height: auto; margin: 0 auto;" class="f_top_bot">
        <div id="content" class="thumbnail">
            <form class="form_registro text-center" id="form_admin" method="POST" action="<?php echo $ruta_app?>administrador/guardar_admin">
                <br>
                <label>Nombre:</label><br>
                <br>
                <input type="text" id="nombre_admin" name="nombre" style="width:245px;" value="" class="type_alphanumeric required not_upper">
                <div id="nombre_admin_error" class="m_error" style="display: none;"></div><br><br>
                
                <label>Correo:</label><br>
                <br>
                <input type="text" id="correo_admin" name="correo" style="width:245px;" value="" class="type_mail required not_upper">
                <div id="correo_admin_error" class="m_error" style="display: none;"></div><br><br>
                <label>Contraseña:</label><br>
                <br>
                <input type="password" id="pass_admin" name="pass" style="width:245px;" value="" class="type_alphanumeric required not_upper"><br>
                <div id="pass_admin_error" class="m_error" style="display: none;"></div><br>
                <br>
                    <p>
                        <a href="javascript:alta_usuario();" class="btn btn-primary">Aceptar</a>
                    </p>
                <br>
            </form>
        </div>
    </div>
</div>