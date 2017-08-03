<script type="text/javascript">
    $(document).ready(function(){
        $("input").not(".not_upper").keyup(function(){
			var valor = $(this).val();
			$(this).val(valor.toUpperCase());
		});
    });
</script>

<div class="container f_top_bot">
    <div style=" width: 650px; height: auto; margin: 0 auto;" class="f_top_bot">
        <div id="content" >
            <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                <li class="">
					<a href="<?php echo $ruta_app;?>admin#tab_promociones">Validar promociones</a>
				</li>
                <li class="">
                    <a href="<?php echo $ruta_app;?>administrador/capturar_promocion">Capturar promoción</a>
                </li>
				<li class="">
                    <a href="<?php echo $ruta_app;?>administrador/recurrentes">Promociones recurrentes</a>
                </li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						Agregar <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo $ruta_app;?>admin#tab_marca">Marca</a></li>
						<li><a href="<?php echo $ruta_app;?>admin#tab_categoria" >Categoría</a></li>
						<!--
						<li><a href="#tab_formato" data-toggle="tab">Formato</a></li>
						-->
					</ul>
				</li>
				<li>
					<a href="<?php echo $ruta_app;?>admin#tab_catalogos" >Descargar catálogos</a>
				</li>
				<li>
					<a href="<?php echo $ruta_app;?>admin#tab_folletos" >Subir folleto</a>
				</li>
				<li class="">
					<a href="<?php echo $ruta_app;?>admin#tab_promo">Modificar promo</a>
				</li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						Modificar <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo $ruta_app;?>admin#tab_modif_marca">Marca</a></li>
						<!--
						<li><a href="#tab_formato" data-toggle="tab">Formato</a></li>
						-->
					</ul>
				</li>
            </ul>
        </div>
    </div>
</div>

