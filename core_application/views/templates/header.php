<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="title" content="Qué Sucede MX">
	<meta name="DC.Title" content="Qué Sucede">
	<meta http-equiv="title" content="Qué Sucede en la promociones">
	<meta name="DC.Creator" content="www.quesucede.com.mx">
	<meta name="keywords" content="descuentos, ventas, promociones, cadenas, autoservicio, tiendas departamentales, cupones, rifas, puntos de venta, premios, novedades, quesucede, #quesucede, PDV, marketing, estrategias, e marketing">
	<meta http-equiv="keywords" content="descuentos, ventas, promociones, cadenas, autoservicio, tiendas departamentales, cupones, rifas, puntos de venta, premios, novedades, quesucede, #quesucede, PDV, marketing, estrategias, e marketing">
	<meta name="description" content="Somos una empresa experta en el marketing promocional y digital.">
	<meta http-equiv="description" content="Somos una empresa experta en el marketing promocional y digital.">
	<meta http-equiv="DC.Description" content="Nuestra misión es proveer información a las empresas de lo que sucede en el punto de venta en todo lo relacionado a las promociones. ">
	<meta name="author" content="Qué Sucede en el pinto de venta.">
	<meta name="DC.Creator" content="Qué Sucede en el pinto de venta.">
	<meta name="vw96.objectype" content="Catalog">
	<meta name="resource-type" content="Catalog">
	<meta http-equiv="Content-Type" content="ISO-8859-1">
	<meta name="distribution" content="all">
	<meta name="robots" content="all">
	<meta name="revisit" content="15 days">   

    <title>Qué Sucede</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo $ruta_css;?>bootstrap.css" rel="stylesheet">
    <link href="<?php echo $ruta_css;?>datepicker.css" rel="stylesheet">
    <link href="<?php echo $ruta_css;?>style.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web' rel='stylesheet' type='text/css'>
    <link href="<?php echo $ruta_css;?>jquery-ui-1.10.4.custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?php //echo $ruta_js;?>html5shiv.js"></script>
      <script src="<?php //echo $ruta_js;?>respond.min.js"></script>
    <![endif]
	<script src="js/jquery-1.10.2.js"></script>-->
	
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo $ruta_js;?>jquery.js"></script>
    <script src="<?php echo $ruta_js;?>bootstrap.min.js"></script>
    <script src="<?php echo $ruta_js;?>bootstrap-datepicker.js"></script>
    <script src="<?php echo $ruta_js;?>offcanvas.js"></script>
    <script src="<?php echo $ruta_js;?>jquery.tabSlideOut.v1.3.js"></script>
    <script src="<?php echo $ruta_js;?>md5.js"></script>
    <script src="<?php echo $ruta_js;?>validators.js"></script>
    <script src="<?php echo $ruta_js;?>funciones.js"></script>
    <script src="<?php echo $ruta_js;?>jquery.tabSlideOut.v1.3.js"></script>
    <script src="<?php echo $ruta_js;?>jquery-ui-1.10.4.custom.js"></script>
    <script src="<?php echo $ruta_js;?>jquery.ui.datepicker-es.js"></script> 

    
    <script type="text/javascript" >
		function subcategorias(id_categoria, id_select) {
			var id = id_select.split("_")[2];
			if (id_categoria != "" && id_categoria != "TODOS") {
				$("#cont_izq_"+id+", #cont_der_"+id).html('');
				$("[id^='div_subcategoria_']").hide();
				var contador = 0;
				var subcategorias = $("#subcategorias_hide .categoria_"+id_categoria);
				var total_sub = subcategorias.length;
				var max_sub = Math.round((total_sub/2)+.5);
				
				var chec_todos = '<div class="checkbox"><label><input type="checkbox" checked="checked" class="check_todos" id="check_todos_'+id+'" value="">';
				chec_todos += '<b>Todos</b></label></div>';
				
				if(id_select != "select_categoria_promo"){
					$("#cont_izq_"+id).append(chec_todos);
				}
	
				
				$(subcategorias).each(function(){
					contador++;
					if (contador <= max_sub) {
					  $(this).clone().appendTo("#cont_izq_"+id);
					}else{
					  $(this).clone().appendTo("#cont_der_"+id);
					}
				});
				$("#div_subcategoria_"+id).show();
				$("#div_formatos_"+id).hide();
			}else{
				$("#div_subcategoria_"+id).hide();
			}
		}
		
		function mostrar_formatos(id_canal, id_select) {
			var id = id_select.split("_")[2];
			
			if (id_canal != "" && id_canal != "TODOS") {
				$("#cont_izq_form_"+id+", #cont_der_form_"+id).html('');
				$("[id^='div_formatos_']").hide();
				
				var contador = 0;
				var formatos = $("#formatos_hide .canales_"+id_canal);
				
				var total_sub = formatos.length;
				var max_sub = Math.round((total_sub/2)+.5);
				
				var chec_todos = '<div class="checkbox"><label><input type="checkbox" checked="checked" class="check_todos" id="check_todos_form_'+id+'" value="">';
				chec_todos += '<b>Todos</b></label></div>';
				
				$("#cont_izq_form_"+id).append(chec_todos);
				
				$(formatos).each(function(){
					contador++;
					if (contador <= max_sub) {
					  $(this).clone().appendTo("#cont_izq_form_"+id);
					}else{
					  $(this).clone().appendTo("#cont_der_form_"+id);
					}
				});
				$("#div_formatos_"+id).show();
				$("#div_subcategoria_"+id).hide();
			}else{
				$("#div_formatos_"+id).hide();
			}
			
			
		}
	  
		function cerrar_modal(id) {
		  $("#"+id).modal("hide");
		}
	  
		function modal_buscar(){
		  $("#modal_buscar").modal().on('hidden.bs.modal', function(){
			  limpia_errores();
		  });
		}
      
		function modal_mensaje(mensaje) {
			$("#mensaje_modal_mensaje").html(mensaje);
			$("#modal_mensaje").modal();
		}
	  
    function modal_recomendacion(mensaje) {
		$("#modal_recomendacion").modal().on('hidden.bs.modal', function(){
			limpiar_recomendaciones();
        });
    }
      
    function recomendacion() {
		var mi_url = "<?php echo $ruta_app?>suscripcion/recomendar";
		var correos = "";
		var llenos = 0;
		var vacios = 0;
		var correo = '';
		
		
		$("[id^='text_recomendacion_']").each(function(){
			correo = $(this).val();
			if(mail(correo)){
				llenos++;
				correos += $(this).val() + '~';
			}else{
				vacios++;
			}
		});
		
		if (vacios >= 1) {
			alert("Todos los campos se deben llenar con un correo.");
		}else{
			correos = correos.substring(0, correos.length - 1);
			$.ajax({
				type:"post",
				url:mi_url,
				dataType:"json",
				data:{correos:correos},
				success:function(response){
					if(response.codigo == 0){
						alert("Recomendaciones enviadas.");
						cerrar_modal("modal_recomendacion");
					}
				},
				error:function(){
					alert("error");
				}
			});
		}
		
    }
      
    function limpiar_recomendaciones(args) {
		$("[id^='text_recomendacion']:first").val("");
		$("[id^='text_recomendacion']").not(":first").next("br").remove();
		$("[id^='text_recomendacion']").not(":first").remove();
    }
      
    function agregar_recomendacion(){
		var max_invitaciones = 4;
		var obj_inv = $("[id^='text_recomendacion']").last().clone();
		var id = obj_inv.prop("id").split("_")[2];
		
		if ( id < max_invitaciones) {
		  id++;
		  var nuevo_id = "text_recomendacion_" + id;
		  obj_inv.prop("id", nuevo_id).val("");
		  $("#div_recomendaciones").append(obj_inv).append("<br />");
		}
    }
      
      
      var seccion_actual = '<?php echo $this->session->userdata('seccion')?>';
      var clase_seccion = '<?php echo $this->session->userdata('clase_seccion')?>';
      
      $(document).ready(function(){
        <?php if($this->session->flashdata('err_login')):?>
          modal_login();
        <?php endif; ?>
        
        $("[id^='div_subcategoria_']").delegate("[id^='check_todos_']","click", function(){
          $("[id^='div_subcategoria_']").find("[name='subcategorias[]']").prop("checked", false);
        });
        
        $("[id^='div_subcategoria_']").delegate("[name='subcategorias[]']","click", function(){
          $("[id^='div_subcategoria_']").find("[id^='check_todos_']").prop("checked", false);
        });
        
		
		$("[id^='div_formatos_']").delegate("[id^='check_todos_form']","click", function(){
          $("[id^='div_formatos_']").find("[name='formatos[]']").prop("checked", false);
        });
        
        $("[id^='div_formatos_']").delegate("[name='formatos[]']","click", function(){
          $("[id^='div_formatos_']").find("[id^='check_todos_form']").prop("checked", false);
        });
        
		$(".f_muestra_promo").find("h3,img:not('.img_folleto')").click(function(){
		  var liga = $(this).parent().find("a").prop("href");
		  window.location = liga;
		});
		
        if (seccion_actual != 0) {
          var nueva_seccion = seccion_actual-1;
          $("#ul_nav").find("li.li_menu").eq(nueva_seccion).addClass(clase_seccion);
        }
        
        $("#select_categoria_modal, #select_categoria_head, #select_categoria_promo").change(function(){
			var id_categoria = $(this).val();
            var id_select = $(this).attr("id");
			subcategorias(id_categoria, id_select);
		});
		
		$("#select_canal_modal, #select_canal_head").change(function(){
			var id_canal = $(this).val();
			var id_select = $(this).attr("id");
			mostrar_formatos(id_canal, id_select);
		});
		
		
		$("#form_buscar_modal, #form_buscar_head").submit(function(event){
            var flag_ok = false;
			var seleccionados = 0;
            var id = $(this).attr("id").split("_")[2];
            
            var categoria = $("#select_categoria_"+id).val();
			var tipo_promocion = $("#tipo_promocion_"+id).val();
            var canal = $("#select_canal_"+id).val();
            
			
            if ( categoria != "") {
				seleccionados+=1;
			}
            
            if ( tipo_promocion != "") {
				seleccionados+=1;
			}
            
			if (canal != "") {
				seleccionados++;
			}
            
            if (seleccionados < 3) {
                alert("Completa los criterios de búsqueda.");
				event.preventDefault();
			}
		});
        
      });
		$(function(){
			$('.slide-out-div').tabSlideOut({
				tabHandle: '.handle',                              //class of the element that will be your tab
				pathToTabImage: '<?php echo $ruta_images;?>contact_tab.gif',          //path to the image for the tab (optionaly can be set using css)
				imageHeight: '400px',                               //height of tab image
				imageWidth: '30px',                               //width of tab image    
				tabLocation: 'right',                               //side of screen where tab lives, top, right, bottom, or left
				speed: 300,                                        //speed of animation
				action: 'click',                                   //options: 'click' or 'hover', action to trigger animation
				topPos: '100px',                                   //position from the top
				fixedPosition: true		                           //options: true makes it stick(fixed position) on scroll
			});
		});
		$(document).ready(function(){
			$("#muestra_semana").datepicker({
		      	showWeek: true
	    	});
		});
      
    </script>
	
	  <script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	  
		ga('create', 'UA-45348864-1', 'quesucede.com.mx');
		ga('send', 'pageview');
	  </script>
    
 </head>

  <body>
<?php  
  if($this->session->userdata('login_ok')):
  ?>

<div id="subcategorias_hide" style="display: none;">
	<!--elemento checkbox-->
	<?php foreach($subcategorias->result() as $subcategoria):?>
	<div class="categoria_<?php echo $subcategoria->categorias_id_categoria; ?> checkbox">
	  <label>
		<input type="checkbox" name="subcategorias[]" value="<?php echo $subcategoria->id_subcategoria; ?>">
		<?php echo ucfirst(mb_strtolower($subcategoria->nombre_subcategoria));?>
	  </label>
	</div>
	<br />
	<?php endforeach; ?>
	<!--/elemento checkbox-->
</div>  

<div id="formatos_hide" style="display: none;">
	<!--elemento checkbox-->
	<?php foreach($formatos->result() as $formato):?>
	<div class="canales_<?php echo $formato->canales_id_canal; ?> checkbox">
	  <label>
		<input type="checkbox" name="formatos[]" value="<?php echo $formato->id_formato; ?>">
		<?php echo ucfirst(mb_strtolower($formato->nombre_formato));?>
	  </label>
	</div>
	<br />
	<?php endforeach; ?>
	<!--/elemento checkbox-->
</div>


<!--HEADER CON LOGIN-->
<!-- Fixed navbar -->
  <div class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      <a class="navbar-brand" href="<?php echo $ruta_app;?>"><img src="<?=$AWS_BUCKET;?>images/logo_header.png"></a>
      </div>
      <!--navbar-right-->
                  <div class="navbar-collapse collapse navbar-nav navbar-right" style="margin-top:15px;">
                    <ul class="nav navbar-nav">
					  <li>
						<div style="margin-top:15px;">
						  <!--BTN DE RECOMENDACION-->
                           <a class="btn btn-primary btn-xs" href="javascript:modal_recomendacion();" style="display: block;"><span class="glyphicon glyphicon-thumbs-up"></span>&nbsp;Recomienda</a>
                        </div>
					  </li>
                     
                      <li><a href="<?php echo $ruta_app;?>folletos">Folletos </a></li>
                      <li><a href="<?php echo $ruta_app;?>alertas">Mis alertas</a></li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Mis reportes <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo $ruta_app; ?>reportes">Promoción</a></li>
                            <li><a href="<?php echo $ruta_app; ?>reportes/todas_cadenas">Promoción por Cadena</a></li>
                            <li><a href="<?php echo $ruta_app; ?>reportes/lineal">Linea de tiempo</a></li>
                        </ul>
                      </li>
                      <li><div style="margin-top:15px;">
                      <a class="btn btn-primary" href="javascript:modal_buscar();" style="display: block;">&nbsp;&nbsp;Promociones&nbsp;&nbsp;<span class="glyphicon glyphicon-search"></span></a>
                      </div></li>
		      		  <li>
						<div style="margin:22px; 0 0 10px; text-align: right; color: #FFF;">&nbsp;| &nbsp; Bienvenido <?php echo $this->session->userdata('nombre_usuario');?> &nbsp;|&nbsp; 
						  <a href="<?php echo $ruta_app?>session/logout" style="color:#46c3d2;">Salir</a>
						  <?php if($this->session->userdata('tipo_suscripcion') == 'Prueba'): ?>
						  &nbsp;|&nbsp;<a href="<?php echo $ruta_app;?>suscripcion" style="color:#f8b317;"> Suscribete</a>
						</div>
					  </li>
                      <?php endif; ?>
                    </ul>
                  </div><!--/.nav-collapse -->
            </div><!--navbar-collapse collapse navbar-nav navbar-right-->
    </div>
  </div>
<!-- Fixed navbar -->
<!--HEADER CON LOGIN-->

<div class="modal fade" id="modal_mensaje" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog" style="width:500px !important;">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <br>
          <h4 class="modal-title" id="titulo_modal_mensaje"><img style="margin: 10px 0;" src="<?php echo $ruta_images;?>logo_correo.png" ></h4>
        </div>
        <div class="modal-body" style="font-size: 16px;" id="mensaje_modal_mensaje">
	  <!--CONTENIDO-->
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
</div><!-- /.modal -->





<!-- Modal -->
<div class="modal fade" id="modal_buscar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <br>
	  <h4 class="modal-title">Búsqueda de promociones</h4>
        </div>
        <div class="modal-body">
	  <!--CONTENIDO-->
      <form class="" role="form" id="form_buscar_modal" method="post" action="<?php echo $ruta_app;?>promociones/buscar">
	  <div class="row">
			  <div class="col-lg-3">
				<select class="form-control" id="select_categoria_modal" name="categoria">
				  <option value="">-- Categoría --</option>
                  <option value="TODOS"> TODOS </option>
                    <?php foreach($categorias->result() as $categoria):?>
                    <option value="<?php echo $categoria->id_categoria; ?>">
                      <?php echo ucfirst(strtolower($categoria->nombre_categoria)); ?>
                    </option>
                    <?php endforeach;?>
				  </select>
			  </div>
			  <div class="col-lg-4">
				 <select class="form-control" id="tipo_promocion_modal" name="tipo_promocion">
				  <option value="">-- Tipo de Promoción --</option>
                  <option value="TODOS"> TODOS </option>
                    <?php foreach($tipos_promocion->result() as $tipo_prom):?>
                    <option value="<?php echo $tipo_prom->id_tipo_promocion;?>">
                      <?php echo $tipo_prom->nombre_tipo_promocion;?>
                    </option>
                    <?php endforeach;?>
				  </select>
			  </div>
			  <div class="col-lg-3">
				<select class="form-control" id="select_canal_modal" name="canal">
				<option value="">-- Canales --</option>
				<option value="TODOS"> TODOS </option>
				<?php foreach($canales->result() as $canal):?>
				<option value="<?php echo $canal->id_canal;?>">
				<?php echo $canal->nombre_canal; ?>
				</option>
				<?php endforeach; ?>
				</select>
			  </div>
			  
			  <div class="col-lg-2">
			  <button type="submit" class="btn btn-primary ">&nbsp;&nbsp;Buscar&nbsp;&nbsp;<span class="glyphicon glyphicon-search"></span></button>
			  </div>
	    </div>
	    <div class="row">
			<!--Div para mostrar subcategorías-->
			<div class="thumbnail marco_check" id="div_subcategoria_modal">
				<div id="cont_izq_modal" class="col-md-6">
				 
				</div>
				<div id="cont_der_modal" class="col-md-6">
				 
				</div>
			</div>
			<!--/Div para mostrar subcategorías-->
		</div>
		
		<div class="row">
		<!--Div para mostrar formatos-->
		<div class="thumbnail marco_check" id="div_formatos_modal">
			<div id="cont_izq_form_modal" class="col-md-6">
			 
			</div>
			<div id="cont_der_form_modal" class="col-md-6">
			 
			</div>
		</div>
		<!--/Div para mostrar formatos-->
		</div>
		
		
	  <!--CONTENIDO-->
        </div>
      </form>
      
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog --> 
</div><!-- /.modal -->



<?php else:?>

<!--HEADER SIN LOGIN-->

<!-- Fixed navbar -->
    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        <a class="navbar-brand" href="<?php echo $ruta_app;?>"><img src="<?php echo $AWS_BUCKET; ?>images/logo_header.png"></a>
        </div>
        <!--navbar-right-->
        <div class="navbar-collapse collapse navbar-nav navbar-right" style="margin-top:15px;">
            
          <form class="navbar-form navbar-right" style="margin-top:15px;" id="form_login" method="POST" action="<?php echo $ruta_app;?>session/login">
          <div style="padding-right:15px; float:left; border-right:solid 1px #CCC; margin-right:15px;">
            <a href="<?php echo $ruta_app;?>registro"class="btn btn-gray">Registro trial</a>&nbsp;
            <a href="<?php echo $ruta_app;?>suscripcion"class="btn btn-gray">Suscríbete</a>
          </div> 
            <div class="form-group">
              <input type="text" placeholder="Correo" class="form-control type_mail required" id="correo" name="correo" autocomplete="off" value="">
              <div id="correo_error" class="alert alert-danger" style="display: none;"></div>
            </div>
            <div class="form-group">
              <input type="password" placeholder="Contraseña" class="form-control type_alphanumeric required" name="password" id="password" value="">
                <input type="hidden" class="form-control f_aire" id="pass">
                <div id="password_error" class="alert alert-danger" style="display: none;"></div>
            </div>
            <button type="submit" class="btn btn-primary">&nbsp;&nbsp;&nbsp;Ingresar&nbsp;&nbsp;&nbsp;</button>
			  <span style="color: #FFF;">&nbsp;&nbsp;|&nbsp;&nbsp;</span><a href="<?php echo $ruta_app; ?>registro/recuperar" style="font-size: 12px; color:#f8b317;">Recuperar contraseña</a><span style="color: #FFF;">&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</span>
			</form>
			
        </div><!--/.nav-collapse -->
      </div>
    </div>
<!--HEADER SIN LOGIN-->
<?php endif; ?>
<div class="slide-out-div" style="width:280px; z-index:1;">
		<a class="handle" href="http://link-for-non-js-users">Content</a><br/><br/>
        <div id="muestra_semana"></div>
</div>