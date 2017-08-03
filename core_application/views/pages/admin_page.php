<script type="text/javascript">
	
	<?php
        $mensaje = $this->session->flashdata('mensaje');
        if($mensaje):
    ?>
    var mensaje = '<?php echo $mensaje;?>';
    alert(mensaje);
    <?php endif; ?>
	
	var url_app = "<?php echo $ruta_app;?>";
	
	function capitalize(str) {
		var capitalized = str.substr(0,1).toUpperCase()+str.substr(1);
		return capitalized;
	}
	
	function validar_archivo() {
		var archivo = $("#datafile").val();
		if( archivo == "" ) {
			alert("Debes elegir un achivo");
		}else{
			$("#form_validar").submit();
		}
    }
	
	function poner_foco(id) {
		var top = $("#"+id).offset().top-120;
		$('html, body').animate({ scrollTop: top }, 'slow');
		$("#"+id).focus();
	}
	
	function eliminar_promocion(){
		var id_promocion = $("#id_promo_m").val();
		var categoria_promo = $("#subcategoria_promo").val();
		
		if (id_promocion == "" || categoria_promo ==  "") {
			alert("Primero captura una promocion");
			poner_foco('id_promo_m');
		}else{
			$("#modal_eliminar_promo").modal();
		}
	}
	
	function borrar_promo() {
		var id_promo = $("#id_promo_m").val();
		var mi_url = "<?php echo $ruta_app;?>admin/borrar_promo";
		
		$.ajax({
			type:"post",
			url:mi_url,
			dataType:"json",
			data:{id_promo:id_promo},
			success:function(response){
				if(response.codigo != 0){
					alert("Ocurrió un error al eliminar, por favor intente de nuevo.");
				}else{
					alert("Promoción eliminada.");
					limpiar_campos_busqueda();					
				}
				limpiar_campos_promo();
				cancelar_eliminar();
			},
			error:function(){
				alert("Error de comunicación, intente más tarde.");
			}
		});
		
	}
	
	function cancelar_eliminar() {
		$("#modal_eliminar_promo").modal("hide");
	}
	
	
	function agregar_marca() {
		var marca = $("#nueva_marca").val();
		if (marca != "") {
			var mi_url = url_app + "catalogo/nueva_marca";
			
			$.ajax({
				type:"post",
				url:mi_url,
				dataType:"json",
				data:{marca:marca},
				success:function(response){
					if(response.codigo == 0){
						$("#nueva_marca").val('');
						var strOption = '';
						strOption += '<option value="'+response.id_marca;
						strOption += '">';
						strOption += response.nombre_marca;
						strOption += '</option>';
						$("#select_modif_marca, #select_marca_promo").append(strOption);
					}
					
					alert(response.mensaje);
				},
				error:function(){
					alert("Error");
				}
			});
		}else{
			alert("Captura una marca.");
		}
	}
	
	function agregar_subcategoria(){
		var categoria = $("#select_categoria").find("option:selected").val();
		if(categoria != ""){
			var subcategoria = $("#nombre_subcategoria").val();
			if(subcategoria != "") {
				var mi_url = url_app + "catalogo/nueva_subcategoria";
				$.ajax({
					type:"post",
					url:mi_url,
					dataType:"json",
					data:{categoria:categoria, subcategoria:subcategoria},
					success:function(response){
						if (response.codigo == 0) {
							$("#select_categoria").prop("selectedIndex",0);
							$("#nombre_subcategoria").val("");
						}
						alert(response.mensaje);
						
					},
					error:function(){
						alert("Error");
					}
				});
				
			}else{
				alert("Captura una subcategoría.");
				$("#nombre_subcategoria").focus();
			}
		}else{
			alert("Selecciona una categoría.");
			$("#select_categoria").focus();
		}
	}
	
	function modal_nueva_categoria() {
		$("#modal_nueva_categoria").modal();
	}
	
	function nueva_categoria() {
		var categoria = $("#nueva_categoria").val();
		if (categoria != "") {
			var mi_url = url_app + "catalogo/nueva_categoria";
			
			$.ajax({
				type:"post",
				url:mi_url,
				dataType:"json",
				data:{categoria:categoria},
				success:function(response){
					if(response.codigo == 0){
						$("#nueva_categoria").val('');
						var option = '<option selected="selected" value="';
						option += response.id_categoria+'">';
						option += categoria + '</ option>';
						$("#select_categoria option").attr('selected',false);
						$("#select_categoria").append(option);
					}
					
					alert(response.mensaje);
				},
				error:function(){
					alert("Error");
				}
			});
			
			$("#modal_nueva_categoria").modal("hide");
		}else{
			alert("Captura una categoría.");
			$("#nueva_categoria").focus();
		}
	}
	
	function modal_nuevo_canal() {
		$("#modal_nuevo_canal").modal();
	}
	
	function limpiar_campos_promo() {
		$("#select_categoria_promo").find("option:eq(0)").attr("selected",true);
		$("#div_subcategoria_promo").hide().find("#cont_izq_promo, #cont_der_promo").html('');
		$("#div_form_promo").find("input").val("");
		$('#input_foto').val('');
		$("#modal_modif_promo").modal("hide");
	}
	
	function limpiar_campos_busqueda() {
		$("#id_promo_m").val("");
		$("#titulo_promo").val("");
		$("#producto_promo").val("");
		$("#descripcion_promo").val("");
		$("#subcategoria_promo").val("");
	}
	
	function modificar_promo(){
		var mi_url = "<?php echo $ruta_app; ?>admin/actualizar_promo";
		var valor = $("#valor_campo_promo").val().toUpperCase();
		var campo = $("#nombre_campo_promo").val();
		var id_promo = $("#id_promo_m").val();
		
		if (campo == 'foto') {
			var valor = $('#input_foto').val();
			if (valor != '') {
				$('#idPromocion').val(id_promo);
				$('#formFoto').submit();
			}else{
				alert('Elige una foto');
			}
		}else{
			$.ajax({
				type:'post',
				dataType:'json',
				url:mi_url,
				data:{id_promo:id_promo,campo:campo,valor:valor},
				success:function(response){
					if(response.codigo == 0){
						alert("Datos guardados correctamente.");
						limpiar_campos_promo();
					}
				},
				error:function(){
					alert("error");
				}
			});
		}
	}
	
	function modal_modif_promo(dato) {
		
		var id_promo = $("#id_promo_m").val();
		if (id_promo != '') {
			var capitalized = capitalize(dato);
			var mensaje = 'Modificar ' + capitalized + ': ';
			
			var valor = $("#"+dato+"_id_promo").val();
			
			if (dato == 'subcategoria') {
				$("#div_foto_modal").hide();
				$("#div_marc_modal").hide()
				$("#div_campo_normal").hide();
				$("#div_sub_modal").show();
			}else if(dato == 'marca'){
				$("#div_foto_modal").hide();
				$("#div_marc_modal").show();
				$("#div_sub_modal").hide();
				$("#div_campo_normal").hide();
			}else if(dato=='foto'){
				$("#div_foto_modal").show();
				$("#div_sub_modal").hide();
				$("#div_campo_normal").hide();
			}else{
				$("#div_foto_modal").hide();
				$("#div_marc_modal").hide()
				$("#div_sub_modal").hide();
				$("#div_campo_normal").show();
			}
			
			$("#mensaje_modif_prom").html(mensaje);
			$("#span_nombre_campo").html(capitalized + ": ");
			$("#valor_campo_promo").val(valor);
			$("#nombre_campo_promo").val(dato);
			
			$("#modal_modif_promo").modal();
		}else{
			alert('Captura una promoción');
		}
	}
	
	function guardar_marca(){
		var id_marca = $("#select_marca_promo").find("option:selected").val();
		$("#valor_campo_promo").val(id_marca);
		$("#nombre_campo_promo").val('marca');
		
		modificar_promo();
		
	}
	
	function modal_promocion() {
		var id_promo = $("#id_promo_m").val();
		
		if($.isNumeric(id_promo)){
			var mi_url = "<?php echo $ruta_app;?>admin/obtener_promo";
			
			$.ajax({
				type:'post',
				dataType:'json',
				data:{id_promo:id_promo},
				url:mi_url,
				success:function(response){
					var promocion = response.promocion;
					$("#titulo_promo").val(promocion.titulo);
					$("#producto_promo").val(promocion.producto);
					$("#descripcion_promo").val(promocion.descripcion);
					$("#subcategoria_promo").val(promocion.subcategoria);
					$("#subcategoria_id_promo").val(promocion.subcategorias_id_subcategoria);
					$("#option_marca_"+promocion.marcas_id_marca).attr('selected', true);
				},
				error:function(){
					alert('error');
				}
			});
			
			$("#modal_promo").modal();
		}else{
			alert("El id de promoción debe ser numérico.");
		}
		
	}
	
	function nuevo_canal() {
		var canal = $("#nuevo_canal").val();
		if (canal != "") {
			var mi_url = url_app + "catalogo/nuevo_canal";
			
			$.ajax({
				type:"post",
				url:mi_url,
				dataType:"json",
				data:{canal:canal},
				success:function(response){
					if(response.codigo == 0){
						$("#nuevo_canal").val('');
						var option = '<option selected="selected" value="';
						option += response.id_canal+'">';
						option += canal + '</ option>';
						$("#select_canal option").attr('selected',false);
						$("#select_canal").append(option);
					}
					alert(response.mensaje);
				},
				error:function(){
					alert("Error");
				}
			});
			
			$("#modal_nuevo_canal").modal("hide");
		}else{
			alert("Captura una categoría.");
			$("#nueva_categoria").focus();
		}
	}
	
	function nuevo_formato() {
		alert("Nuevo formato");
	}
	
	function agregar_folleto(){
		var flag_ok = true;
		
		if ($("#select_formato_folleto").val() == "") {
			alert("Elige un formato");
			flag_ok = false;
			$("#select_formato_folleto").focus();
		}
		
		if (flag_ok) {
			if ($("#fecha_inicio_folleto").val() == "") {
				alert("Captura una fecha");
				flag_ok = false;
				$("#fecha_inicio_folleto").focus();
			}
		}
		
		if (flag_ok) {
			if ($("#fecha_fin_folleto").val() == "") {
				alert("Captura una fecha");
				flag_ok = false;
				$("#fecha_fin_folleto").focus();
			}
		}
		
		if (flag_ok){
			if ($("#portada_folleto").val() == "") {
				alert("Elige una portada");
				flag_ok = false;
				$("#portada_folleto").focus();
			}
		}
		
		if (flag_ok){
			if ($("#pdf_folleto").val() == "") {
				alert("Elige un pdf");
				flag_ok = false;
				$("#pdf_folleto").focus();
			}
		}
		
		if (flag_ok) {
			$("#form_folleto").submit();
		}
		
	}
	
	//Funciones para modificar marca
	function modificar_campo(campo) {
		var id_campo = $("#select_modif_"+campo).find('option:selected').val();
		var nuevo_nombre = $("#nuevo_nombre_"+campo).val();
		
		var url = "<?php echo $ruta_app;?>admin/modificar_campo";
		
		$.ajax({
			url:url,
			type:"post",
			dataType:"json",
			data:{id_campo:id_campo, nuevo_nombre:nuevo_nombre, campo:campo},
			success:function(response){
				if(response.codigo == 0){
					var funcion = 'actualizar_combos_'+campo;
					funcion += '('+id_campo+', "'+nuevo_nombre+'")';
					eval(funcion);
				}
			},
			error:function(){
				alert('error');
			}
		});
	}
	
	function actualizar_combos_marca(id, nombre){
		$("#select_modif_marca, #select_marca_promo").find('option[value='+id+']').text(nombre);
		alert("Marca modificada correctamente.");
	}
	
	$(document).ready(function(){
		
		$("#select_modif_marca").change(function(){
			var nombre = $(this).find('option:selected').text();
			nombre = $.trim(nombre);
			$("#nuevo_nombre_marca").val(nombre);
		});
		
		$("input").attr("autocomplete","off");
		$("input").not(".not_upper").keyup(function(){
			var valor = $(this).val();
			$(this).val(valor.toUpperCase());
		});
		
		$(".textarea_nolf").keyup(function(event){
            var key = event.keyCode || event.wich;
            if (key == 13) {
                event.preventDefault();
                var valor = $(this).val();
                valor = valor.replace(/\n/g, "");
                $(this).val(valor);
            }
        });
		
		
		$('#modal_modif_promo').on('hidden.bs.modal', function (e) {
			limpiar_campos_promo();
		})
		
		$('#tabs').tab();
		$('.dropdown-toggle').dropdown();
		$('#fecha_inicio_folleto, #fecha_fin_folleto').datepicker({
			dateFormat: 'yy/mm/dd'
		});
		$("#form_folleto").find(".input_big").css("width","300px");
		
		$("[id^='div_subcategoria_']").delegate("[name='subcategorias[]']","click", function(){
          $("[id^='div_subcategoria_']").find("[name='subcategorias[]']").not(this).prop("checked", false);
		  var valor = $(this).val();
		  $("#valor_campo_promo").val(valor);
        });
		
		
		<?php
			if($this->session->flashdata('nombre_log')):
				$nombre_log = $this->session->flashdata('nombre_log');
		?>
			window.location = url_app + 'admin/descargar_log/<?php echo $nombre_log; ?>';
		<?php endif; ?>
	});
</script>

<div class="container f_top_bot">
	<div style=" width: 650px; height: auto; margin: 0 auto;" class="f_top_bot">
		<div id="content">
			<ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
				<li class="active">
					<a href="#tab_promociones" data-toggle="tab">Validar promociones</a>
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
						<li><a href="#tab_marca" data-toggle="tab">Marca</a></li>
						<li><a href="#tab_categoria" data-toggle="tab">Categoría</a></li>
						<!--
						<li><a href="#tab_formato" data-toggle="tab">Formato</a></li>
						-->
					</ul>
				</li>
				<li>
					<a href="#tab_catalogos" data-toggle="tab">Descargar catálogos</a>
				</li>
				<li>
					<a href="#tab_folletos" data-toggle="tab">Subir folleto</a>
				</li>
				<li class="">
					<a href="#tab_promo" data-toggle="tab">Modificar promo</a>
				</li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						Modificar <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="#tab_modif_marca" data-toggle="tab">Marca</a></li>
						<!--
						<li><a href="#tab_formato" data-toggle="tab">Formato</a></li>
						-->
					</ul>
				</li>
			</ul>
			<div id="my-tab-content" class="tab-content ">
				<!-- Validar archivo de promociones -->
				<div class="tab-pane active" id="tab_promociones">
					<div class="row f_top_bot">
						<div class="col-md-6 thumbnail">
							<label>Validar archivo</label>
							<form id="form_validar" method="POST" action="<?php echo base_url() ?>admin/validar_archivo" enctype="multipart/form-data" class="custom">
								Selecciona archivo:<br />
								<input id="datafile" type="file" name="datafile" size="40">
							</form>
							<br />
							<a href="javascript:validar_archivo();" class="btn btn-primary">&nbsp;&nbsp;&nbsp;Enviar&nbsp;&nbsp;&nbsp;</a>
						</div>
						<div class="col-md-6 thumbnail">
							Admin
						</div>
					</div>
				</div>
				<!-- Validar archivo de promociones -->
				<div class="tab-pane" id="tab_marca">
					<h1>Agregar Marca</h1>
					<div class="row f_top_bot">
						<div class="col-md-6 thumbnail">
							Nombre:
							<input type="text" id="nueva_marca" />
							<br /><br />
							<div class="col-md-4 text-center ">
								<a href="javascript:agregar_marca();" class="btn btn-primary">
									&nbsp;&nbsp;&nbsp;Aceptar&nbsp;&nbsp;&nbsp;
								</a>
							</div>
						</div>
					</div>
				</div>
				
				<div class="tab-pane" id="tab_categoria">
					<h1>Agregar Subcategoría</h1>
					<div class="row f_top_bot thumbnail">
						<div class="col-md-12 ">
							<div class="col-md-2 text-center ">
								Categoría:
							</div>
							<div class="col-md-4 text-center ">
								<select id="select_categoria">
									<option value="">--Selecciona--</option>
									<?php foreach($categorias->result() as $categoria): ?>
										<option value="<?php echo $categoria->id_categoria;?>">
											<?php echo $categoria->nombre_categoria; ?>
										</option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="col-md-6 text-center ">
								<a href="javascript:modal_nueva_categoria();" class="btn btn-primary">
									Nueva categoría
								</a>
							</div>
							<br /><br />
						</div>
						<div class="col-md-12 ">
							<div class="col-md-2 text-center ">
								Subcategoría:
							</div>
							<div class="col-md-4 text-center ">
								<input type="text" id="nombre_subcategoria" />
							</div>
							<div class="col-md-6 text-center ">
							</div>
							<br /><br />
						</div>
						<div class="col-md-12 text-center ">
							<a href="javascript:agregar_subcategoria();" class="btn btn-primary">
								&nbsp;&nbsp;&nbsp;Aceptar&nbsp;&nbsp;&nbsp;
							</a>
						</div>
					</div>
				</div>
				
				<div class="tab-pane" id="tab_formato">
					<h1>Agregar Formato</h1>
					<div class="row f_top_bot thumbnail">
						<div class="col-md-12 text-center">
							<div class="col-md-2 text-center ">
								Canal:
							</div>
							<div class="col-md-4 text-center ">
								<select id="select_canal">
									<option vaue="">--Selecciona--</option>
									<?php foreach($canales->result() as $canal): ?>
									<option value="<?php echo $canal->id_canal; ?>"><?php echo $canal->nombre_canal; ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="col-md-6 text-center ">
								<a href="javascript:modal_nuevo_canal();" class="btn btn-primary">
									Agregar canal
								</a>
							</div>
							<br /><br />
						</div>
						<div class="col-md-12 text-center ">
							<a href="javascript:nuevo_formato();" class="btn btn-primary">
								&nbsp;&nbsp;&nbsp;Aceptar&nbsp;&nbsp;&nbsp;
							</a>
						</div>
					</div>
				</div>
				
				<div class="tab-pane" id="tab_catalogos">
					<div class="container">
					<div class="row f_top_bot">
						<div class="col-md-12 text-center ">
							<a href="<?php echo $ruta_app?>admin/catalogo" class="btn btn-primary">
								Descargar catálogos
							</a>
						</div>
					</div>
					<br /><br />
					</div>
				</div>
				<div class="tab-pane" id="tab_folletos">
					<h1>Subir folletos</h1>
					
					<form id="form_folleto" method="POST" action="<?php echo $ruta_app?>folletos/subir" enctype="multipart/form-data" class="custom">
						<div class="row f_top_bot thumbnail">
							<div class="col-md-12 ">
								<div class="col-md-3 text-center ">
									Formato:
								</div>
								<div class="col-md-4 text-center ">
									<select id="select_formato_folleto" name="formato">
										<option value="">--Selecciona--</option>
										<?php foreach($formatos->result() as $fotmato): ?>
											<option value="<?php echo $fotmato->id_formato;?>">
												<?php echo $fotmato->nombre_formato; ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-md-5 text-center ">
								</div>
								<br /><br />
							</div>
							<div class="col-md-12 ">
								<div class="col-md-3 text-center ">
									Fecha de inicio:
								</div>
								<div class="col-md-4 text-center ">
									<input type="text" id="fecha_inicio_folleto" name="fecha_inicio" />
								</div>
								<div class="col-md-5 text-center ">
								</div>
								<br /><br />
							</div>
							
							<div class="col-md-12 ">
								<div class="col-md-3 text-center ">
									Fecha de término:
								</div>
								<div class="col-md-4 text-center ">
									<input type="text" id="fecha_fin_folleto" name="fecha_fin" />
								</div>
								<div class="col-md-5 text-center ">
								</div>
								<br /><br />
							</div>
							
							<div class="col-md-12 ">
								<div class="col-md-6 text-center ">
									Portada:
									<input type="file" id="portada_folleto" name="portada">
								</div>
								<div class="col-md-6 text-center ">
									PDF:
									<input type="file" id="pdf_folleto" name="pdf">
								</div>
								<br /><br />
								<br /><br />
							</div>
						</form>
							<div class="col-md-12 text-center ">
								<a href="javascript:agregar_folleto();" class="btn btn-primary">
									&nbsp;&nbsp;&nbsp;Aceptar&nbsp;&nbsp;&nbsp;
								</a>
							</div>
						</div>
				</div>
				
				<div class="tab-pane" id="tab_promo">
					<h1>Modificar promoción</h1>
					<div class="row f_top_bot thumbnail">
						<div class="col-md-12 text-center">
							<div class="col-md-4 text-center ">
								Id de promoción:
							</div>
							<div class="col-md-4 text-center ">
								
								<input type="text" id="id_promo_m" />
							</div>
							<div class="col-md-4 text-center ">
								<a href="javascript:modal_promocion();" class="btn btn-primary">
									Aceptar
								</a>
							</div>
							<br /><br />
						</div>
					</div>
					
					
					<div id="div_form_promo" class="row f_top_bot thumbnail">
						<div class="col-md-12 text-center">
							<div class="col-md-6 text-center">
								Título:
								<input type="text" id="titulo_promo" disabled />
								<a href="javascript:modal_modif_promo('titulo');">Modificar</a>
							</div>
							<div class="col-md-6 text-center">
								Producto:
								<input type="text" id="producto_promo" disabled />
								<a href="javascript:modal_modif_promo('producto')">Modificar</a>
							</div>
						</div>
						<br /><br /><br /><br />
						<div class="col-md-12 text-center">
							<div class="col-md-7 text-center">
								Descripción:
								<input type="text" id="descripcion_promo" disabled />
								<a href="javascript:modal_modif_promo('descripcion')">Modificar</a>
							</div>
							<div class="col-md-5 text-center">
								Marca:
								<select id="select_marca_promo" name="select_marca_promo">
									<option value="">--Selecciona--</option>
									<?php foreach($marcas->result() as $marca):?>
									<option value="<?php echo $marca->id_marca;?>" id="option_marca_<?php echo $marca->id_marca;?>">
										<?php echo $marca->nombre_marca;?>
									</option>
									<?php endforeach;?>
								</select>
								<br />
								<a href="javascript:guardar_marca()">Guadrar</a>
							</div>
						</div>
						<br /><br /><br /><br />
						<div class="col-md-12 text-center">
							<div class="col-md-7 text-center">
								Categoría:
								<input type="text" id="subcategoria_promo" disabled />
								<input type="hidden" id="subcategoria_id_promo" value=""/>
								<a href="javascript:modal_modif_promo('subcategoria')">Modificar</a>
							</div>
							<div class="col-md-5 text-center">
								Foto:
								
								<a href="javascript:modal_modif_promo('foto')">Modificar</a>
								
							</div>
						</div>
						<br /><br /><br /><br />
						
						<div class="col-md-12 text-center">
							<a href="javascript:eliminar_promocion();" class="btn btn-primary">
									&nbsp;&nbsp;&nbsp;Eliminar&nbsp;&nbsp;&nbsp;
								</a>
						</div>
					</div>
					
				</div>
				
				
				<div class="tab-pane" id="tab_modif_marca">
					<h1>Modificar Marca</h1>
					<div class="row f_top_bot">
						<div class="col-md-12 thumbnail">
							Marca:
							<select id="select_modif_marca">
								<option value="">--Selecciona--</option>
								<?php foreach($marcas->result() as $marca):?>
								<option value="<?php echo $marca->id_marca;?>">
									<?php echo $marca->nombre_marca;?>
								</option>
								<?php endforeach;?>
							</select>
							Nuevo nombre:
							<input id="nuevo_nombre_marca">
							<a href="javascript:modificar_campo('marca');">Aceptar</a>
							<div class="col-md-4 text-center ">
								<br />
							</div>
						</div>
					</div>
				</div>
				
				
			</div>
		</div>
	</div>
</div>



<div class="container">
	
</div>

<div class="container">
	<div class="row">
		<div class="col-md-12 text-center ">
			<a href="<?php echo $ruta_app?>admin/logout" class="btn btn-primary">&nbsp;&nbsp;&nbsp;Salir&nbsp;&nbsp;&nbsp;</a>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-6 ">
			&nbsp;
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_nueva_categoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<br>
				<h4 class="modal-title">Agregar categoría</h4>
			</div>
			<div class="modal-body">
				<!--CONTENIDO-->
				<div class="col-md-12 text-center">
					Nombre categoría:
					<input type="text" id="nueva_categoria" />
				</div>
				<br />
				<div class="col-md-12 text-center">
					<a href="javascript:nueva_categoria();" class="btn btn-primary">
						&nbsp;&nbsp;&nbsp;Aceptar&nbsp;&nbsp;&nbsp;
					</a>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog --> 
</div><!-- /.modal -->
<!-- Modal -->

<!-- Modal -->
<div class="modal fade" id="modal_nuevo_canal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<br>
				<h4 class="modal-title">Agregar canal</h4>
			</div>
			<div class="modal-body">
				<!--CONTENIDO-->
				<div class="col-md-12 text-center">
					Nombre canal:
					<input type="text" id="nuevo_canal" />
				</div>
				<br />
				<div class="col-md-12 text-center">
					<a href="javascript:nuevo_canal();" class="btn btn-primary">
						&nbsp;&nbsp;&nbsp;Aceptar&nbsp;&nbsp;&nbsp;
					</a>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog --> 
</div><!-- /.modal -->
<!-- Modal -->

<!-- Modal -->
<div class="modal fade" id="modal_modif_promo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<br>
				<h4 class="modal-title" id="mensaje_modif_prom">Modificar </h4>
			</div>
			<div class="modal-body">
				<!--CONTENIDO-->
				
				<form id="formFoto" method="post" action="<?php echo $ruta_app;?>administrador/actualizarFoto" enctype="multipart/form-data">
					<div class="col-md-12 text-center" id="div_foto_modal">
						<span id="span_nombre_campo">Foto:</span>
						<input type="file" name="foto" id="input_foto">
					</div>
					<input type="hidden" name="idPromocion" id="idPromocion"/>
				</form>
				
				<div class="col-md-12 text-center" id="div_campo_normal">
					<span id="span_nombre_campo">Campo:</span>
					<textarea rows="4" class="textarea_nolf" id="valor_campo_promo" cols="50"></textarea>
				</div>
				<br />
				
				<div class="col-md-12 text-center" id="div_sub_modal">
					<select id="select_categoria_promo">
						<option value="">--Selecciona--</option>
						<?php foreach($categorias->result() as $categoria): ?>
							<option value="<?php echo $categoria->id_categoria;?>">
								<?php echo $categoria->nombre_categoria; ?>
							</option>
						<?php endforeach; ?>
					</select>
					<br /><br /><br />
					<div class="row">
						<!--Div para mostrar subcategorías-->
						<div class="thumbnail marco_check" id="div_subcategoria_promo">
							<div id="cont_izq_promo" class="col-md-6">
							 
							</div>
							<div id="cont_der_promo" class="col-md-6">
							 
							</div>
						</div>
						<!--/Div para mostrar subcategorías-->
					</div>
				</div>
				<div class="col-md-12 text-center">
					<a href="javascript:modificar_promo();" class="btn btn-primary">
						&nbsp;&nbsp;&nbsp;Aceptar&nbsp;&nbsp;&nbsp;
					</a>
				</div>
				<input type="hidden" id="nombre_campo_promo"/>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog --> 
</div><!-- /.modal -->
<!-- Modal -->



<!-- Modal -->
<div class="modal fade" id="modal_eliminar_promo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<br>
				<h4 class="modal-title">Eliminar promoción </h4>
			</div>
			<div class="modal-body">
				<!--CONTENIDO-->
				<div class="col-md-12 text-center">
					¿Seguro que quieres eliminar la promoción?
				</div>
				<br />
				<div class="col-md-6 text-center">
					<a href="javascript:cancelar_eliminar();" class="btn btn-primary">
						&nbsp;&nbsp;&nbsp;Cancelar&nbsp;&nbsp;&nbsp;
					</a>
				</div>
				<div class="col-md-6 text-center">
					<a href="javascript:borrar_promo();" class="btn btn-primary">
						&nbsp;&nbsp;&nbsp;Aceptar&nbsp;&nbsp;&nbsp;
					</a>
				</div>
				<div class="col-md-12 text-center">
					<br />
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog --> 
</div><!-- /.modal -->
<!-- Modal -->

