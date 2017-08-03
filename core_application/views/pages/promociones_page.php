<script type="text/javascript">
	var pagina_actual = <?php echo $pagina_actual; ?>;
	var total_paginas = <?php echo $total_paginas; ?>;
	
	function paginar(pagina) {
		$("#num_pagina").val(pagina);
		$("#form_paginacion").submit();
	}
	
	function siguiente() {
		var sig_pagina = pagina_actual + 1;
		paginar(sig_pagina);
	}
	
	function anterior() {
		var sig_pagina = pagina_actual - 1;
		paginar(sig_pagina);
	}
	
	function guardar_alerta() {
		var mi_url = "<?php echo $ruta_app;?>alertas/guardar_alerta";
		$.ajax({
			type:"post",
			dataType:"json",
			url: mi_url,
			success: function(response){
				modal_mensaje(response.mensaje);
				$("#tooltip_alerta").hide();
			},
			error:function(){
				modal_mensaje("Error al guardar alerta");
			}
		});
	}
	
	$(document).ready(function(){
		$('#tooltip_alerta').tooltip();
		if(total_paginas > 1){
			$(".pag_"+pagina_actual).addClass('active');
		}
	});
	
</script>

<form id="form_paginacion" method="post" action="<?php echo $ruta_app;?>promociones/pag">
	<input type="hidden" id="num_pagina" name="pagina" value=""/>
</form>

<div class="container f_top_bot">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<h2>Buscar promociones</h2>
			<form class="" role="form" id="form_buscar_head" method="post" action="<?php echo $ruta_app;?>promociones/buscar">
			<div class="row">
				<div class="col-lg-3">
				  <select class="form-control" id="select_categoria_head" name="categoria">
					<option value="">-- Categoría --</option>
					<option value="TODOS"> TODOS </option>
					  <?php foreach($categorias->result() as $categoria):?>
					  <option value="<?php echo $categoria->id_categoria; ?>">
						<?php echo ucfirst(strtolower($categoria->nombre_categoria)); ?>
					  </option>
					  <?php endforeach;?>
					</select>
				</div>
				<div class="col-lg-3">
				   <select class="form-control" id="tipo_promocion_head" name="tipo_promocion">
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
				  <select class="form-control" id="select_canal_head" name="canal" >
					<option value="">-- Canales --</option>
					<option value="TODOS"> TODOS </option>
					  <?php foreach($canales->result() as $canal):?>
					  <option value="<?php echo $canal->id_canal;?>">
					  <?php echo $canal->nombre_canal; ?>
					  </option>
					  <?php endforeach; ?>
				  </select>
				</div>
				
				<div class="col-lg-3">
				<button type="submit" class="btn btn-primary ">&nbsp;&nbsp;Buscar&nbsp;&nbsp;<span class="glyphicon glyphicon-search"></span></button>
				<a class="btn btn-primary" id="tooltip_alerta" title="Agregar a mis alertas." href="javascript:guardar_alerta();"><span class="glyphicon glyphicon-bell"></span></a>
				</div>
			  </div>
				
			  <div class="row">
			   <!--Div para mostrar contenido-->
			   <div class="thumbnail marco_check" id="div_subcategoria_head">
				   <div id="cont_izq_head" class="col-md-6">
					
				   </div>
				   <div id="cont_der_head" class="col-md-6">
					
				   </div>
			   </div>
			   <!--/Div para mostrar contenido-->
			   <div class="row">
				 <!--Div para mostrar formatos-->
				 <div class="thumbnail marco_check" id="div_formatos_head">
					 <div id="cont_izq_form_head" class="col-md-6">
					  
					 </div>
					 <div id="cont_der_form_head" class="col-md-6">
					  
					 </div>
				 </div>
				 <!--/Div para mostrar subcategorías-->
				</div>
			  </div>
		  </form>
		</div>
	</div>
</div>

<div class="container "><!--container  style="margin-top:40px;-->
<div class="clearfix"></div>
    
	<div class="row">
		<br/>
	<h2>
		<?php echo $this->session->userdata('criterio_busqueda');?>
	</h2>
	</div>
	
	<?php if($error == 0): ?>
	
		<div class="row">
			
			<?php
				if($total_paginas > 1):
			?>
				<ul class="pagination">
				<?php if($pagina_actual > 1): ?>
				<li><a href="javascript:anterior();">&laquo;</a></li>
				<?php endif; ?>
				<?php
						foreach($paginacion as $pagina):
				?>
				<li class="pag_<?php echo $pagina; ?>"><a href="javascript:paginar(<?php echo $pagina;?>);"><?php echo $pagina;?></a></li>
				<?php
					endforeach;
				?>
					<?php if($pagina_actual < $total_paginas): ?>
					<li><a href="javascript:siguiente();">&raquo;</a></li>
					<?php endif; ?>
				</ul>
				<?php
				endif;
				?>
		</div>
		<div class="row">
			<?php
				foreach($tabla_promociones as $promocion):
				$logo_marca = $promocion['logo_marca'];
			?>
			<!--Muestra desplegado promocion-->
			<div class="col-sm-3 col-md-3 f_muestra_promo">
			  <div class="thumbnail">
				  <h3 class="h3_m_blue"><?php echo $promocion['titulo'];?></h3>
				 <div class="m_brand_mini">
					<?php if($logo_marca != "" && $logo_marca != "img_ref.jpg"): ?>
					<img src="<?php echo $ruta_images."marcas/".$logo_marca;?>">
					<?php endif;?>
					<?php echo $promocion['nombre_marca'];?>
				 </div>
				<img src="<?php echo $ruta_images_promo.$promocion['foto'];?>">
				<div class="caption">
				  <h5><?php echo $promocion['nombre_subcategoria'];?></h5>
				 <p class="text-center"><a href="<?php echo $ruta_app."promociones/detalle/".$promocion['id_promocion']; ?>" class="btn btn-default">Más información</a></p>
				</div>
			  </div>
			</div>
			<!--Muestra desplegado promocion-->
			<?php endforeach; ?>
		</div>
		<div class="row">
			<?php
				if($total_paginas > 1):
			?>
				<ul class="pagination">
				<li><a href="#">&laquo;</a></li>
				<?php
						foreach($paginacion as $pagina):
				?>
				<li class="pag_<?php echo $pagina; ?>"><a href="javascript:paginar(<?php echo $pagina;?>);"><?php echo $pagina;?></a></li>
				<?php
					endforeach;
				?>
					<li><a href="javascript:siguiente();">&raquo;</a></li>
				</ul>
				<?php
				endif;
				?>
		</div>
        <!-- MINIS-->
	<?php else: ?>
		<div style="width:960px; margin: 0 auto; ">

		<div class="container f_top" style="margin-bottom: 300px;">
		 
			<div class="row">
			  <div class="col-md-5 text-right">
				<?php if($imagen == "ok"): ?>
				<span class="glyphicon glyphicon-ok-sign icons_bigs"></span>
				<?php endif; ?>
				<?php if($imagen == "error"): ?>
				<span class="glyphicon glyphicon-remove-circle icons_bigs"></span>
				<?php endif;?>
				
				<?php if($imagen == "warning"): ?>
				<span class="glyphicon glyphicon-warning-sign icons_bigs"></span>
				<?php endif;?>
				
				<?php if($imagen == "message"): ?>
				<span class="glyphicon glyphicon-share-alt icons_bigs"></span>
				<?php endif;?>
			  </div>
			  <div class="col-md-7 mensajes_top">
			  <h1><?php echo $titulo;?></h1>
			  <h3><?php echo $mensaje; ?> </h3>
			  </div>
			</div>		
			
		</div> 
	</div>  
	<?php endif; ?>
            
</div><!-- /container -->