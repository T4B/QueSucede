<script type="text/javascript">
    function alta_usuario() {
        var flag_ok = validar_form("form_admin");
        if (flag_ok) {
            //$("#form_admin").submit();
            
            var mi_url = "<?php echo $ruta_app;?>administrador/guardar_usuario";
            var data = $("#form_admin").serialize();
            
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
            <form class="form_registro text-center" id="form_admin" method="POST" action="<?php echo $ruta_app?>administrador/guardar_usuario">
                <br>
                <label>Cliente:</label><br>
                <br>
                <select id="cliente" name="cliente" class="combo">
                    <option value="">--Selecciona--</option>
                    <?php foreach($clientes->result() as $cliente):?>
                    <option value="<?php echo $cliente->id_cliente ?>"><?php echo $cliente->nombre . ' ' . $cliente->a_paterno;;?></option>
                    <?php endforeach; ?>
                </select>
                <div id="cliente_error" class="m_error" style="display: none;"></div><br><br>
                
                <br>
                <label>Nombre:</label><br>
                <br>
                <input type="text" id="nombre_admin" name="nombre" style="width:245px;" value="" class="type_alphanumeric required">
                <div id="nombre_admin_error" class="m_error" style="display: none;"></div><br><br>
                
                <br>
                <label>Apellido paterno:</label><br>
                <br>
                <input type="text" id="a_paterno" name="a_paterno" style="width:245px;" value="" class="type_generic">
                <div id="a_paterno_error" class="m_error" style="display: none;"></div><br><br>
                
                
                
                <label>Correo:</label><br>
                <br>
                <input type="text" id="correo_admin" name="correo" style="width:245px;" value="" class="type_mail required">
                <div id="correo_admin_error" class="m_error" style="display: none;"></div><br><br>
                <label>Contraseña:</label><br>
                <br>
                <input type="password" id="pass_admin" name="pass" style="width:245px;" value="" class="type_alphanumeric required"><br>
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