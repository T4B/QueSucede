<?php
$mensaje_time = $this->session->flashdata("mensaje_time");
if($mensaje_time):

?>

<div id="modal_timer" class="text-center" style="display: none;"><br>
	
	<?php
	$mensaje_time = "<div style='font-size:18px;'>Le recordamos que le quedan ".$mensaje_time." de la versión de prueba de <b>Qué Sucede.</b><br><br>Le recomendamos adquirir la suscripción y tener acceso a los servicios especiales.</div>";
	echo $mensaje_time;
	?>
	<br /><br />
	  <p style="text-align: center;">
		<a class="btn btn-large btn-warning" href="<?php echo $ruta_app;?>suscripcion" >Suscribirse</a>
		<a class="btn btn-large btn-primary" data-dismiss="modal" href="javascript:void(0)">Aceptar</a></p>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$(".modal-dialog").css("margin-top", "5%");
		$("#mensaje_modal_mensaje").html($("#modal_timer").html());
		$("#modal_mensaje").modal();
	});
	
</script>

<?php endif; ?>

<div class="container f_top_bot">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
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
					<div class="col-lg-4">
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
					
					<div class="col-lg-2">
					<button type="submit" class="btn btn-primary ">&nbsp;&nbsp;Buscar&nbsp;&nbsp;<span class="glyphicon glyphicon-search"></span></button>
					</div>
			  </div>
			
				<div class="row">
				 <!--Div para mostrar subcategorías-->
				 <div class="thumbnail marco_check" id="div_subcategoria_head">
					 <div id="cont_izq_head" class="col-md-6">
					  
					 </div>
					 <div id="cont_der_head" class="col-md-6">
					  
					 </div>
				 </div>
				 <!--/Div para mostrar subcategorías-->
				</div>
				
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
			  
		  </form>
		</div>
	</div>
</div>


<!---------------------------------------------------------------------------------------------CONTENIDO GENERAL--->
<div class="container f_top_bot"><!--container -->
    <div class="row row-offcanvas row-offcanvas-right">
        <div class="col-xs-12 col-sm-9">
          <p class="pull-right visible-xs">
            <button type="button" class="btn btn-primary btn-xs" data-toggle="offcanvas">Más enlaces</button>
          </p>
          
      <!--CARRUSEL-->
     		<div id="myCarousel" class="carousel slide">
                  <!-- Indicators -->
                  <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                  </ol>
                  
                  <div class="carousel-inner">
                  
                    <div class="item active">
                      <img src="<?php echo $AWS_BUCKET;?>images/slide/pro_img_1.jpg" alt="First slide">
                          <div class="container">
                            <div class="carousel-caption-right">
                              <h1>NIVEA<br /> Q10 PLUS<br /> ANTIARRUGAS</h1><br>
                                 <p>Frasco crema antiarrugas Q10.</p><br>
                                    <p><a class="btn btn-large btn-primary" href="<?php echo $ruta_app?>promociones/detalle/569">+ información</a></p>
                            </div>
                          </div>
                    </div>
                  
                    <div class="item">
                      <img src="<?php echo $AWS_BUCKET;?>images/slide/pro_img_2.jpg" alt="Second slide">
                          <div class="container">
                           <div class="carousel-caption-right">
                              <h1>NESCAFE<br /> DECAF<br /> SIN CAFEÍNA </h1><br>
                                 <p>Frasco de cafe<br /> sin cafeína 175gr</p><br>
                                    <p><a class="btn btn-large btn-primary" href="<?php echo $ruta_app?>promociones/detalle/257">+ información</a></p>
                            </div>
                          </div>
                    </div>
                    
                    <div class="item">
                       <img src="<?php echo $AWS_BUCKET;?>images/slide/pro_img_3.jpg" alt="Third slide">
                      <div class="container">
                        <div class="carousel-caption-right">
                              <h1>BONAFONT</h1><br>
                                 <p>6 Pack 300 ml c/u<br /> + 2 chupones entrenadores</p><br>
                                    <p><a class="btn btn-large btn-primary" href="<?php echo $ruta_app?>promociones/detalle/229">+ información</a></p>
                            </div>
                      </div>
                    </div>
                   
                    
                  </div>
                  <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span style="position:absolute; top:45%; left:-5px; display:inline-block;"><img src="<?php echo $AWS_BUCKET;?>slide/arrow_left.jpg"></span></a>
                  <a class="right carousel-control" href="#myCarousel" data-slide="next"><span style="position:absolute; top:45%; right:-5px; display:inline-block;"><img src="<?php echo $ruta_images;?>slide/arrow_right.jpg"></span></a>
                </div><!-- /.carousel -->
        <!--/CARRUSEL-->    
          
		  
               <!-- MINIS-->
                <div class="row" style="margin-top:20px;">
					<?php
					foreach($promociones->result() as $promocion):
					$logo_marca = $promocion->logo_marca;
					?>
                    <!--Muestra desplegado promocion-->
					<div class="col-sm-4 col-md-4 f_muestra_promo">
					  <div class="thumbnail">
						  <h3 class="h3_m_blue"><?php echo $promocion->titulo;?></h3>
						 <div class="m_brand_mini">
							<?php if($logo_marca != "" && $logo_marca != "img_ref.jpg"): ?>
							<img src="<?php echo $ruta_images."marcas/".$logo_marca;?>">
							<?php endif;?>
							<?php echo $promocion->nombre_marca;?>
						 </div>
						<img src="<?php echo $ruta_images_promo.$promocion->foto;?>">
						<div class="caption">
							<h5><?php echo $promocion->nombre_subcategoria;?></h5>
						 <p class="text-center"><a href="<?php echo $ruta_app."promociones/detalle/".$promocion->id_promocion; ?>" class="btn btn-default">Más información</a></p>
						</div>
					  </div>
					</div>
					<!--Muestra desplegado promocion-->
                        <?php endforeach; ?>
                </div><!--/ROW-->
                <!--/MINIS-->  

        </div><!--/span-->


<!-----------------------------------------------------------------------------------------------------------------BARRA LATERAL-->
        <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
          <div class="well sidebar-nav">
            <ul class="nav">
              <li>
              	<h2>Lo más reciente </h2>
              </li>
                  <?php foreach($ultimas->result() as $ultima):?>
                  <li class="active">
                        <a href="<?php echo $ruta_app."promociones/detalle/".$ultima->id_promocion;?>">
							<?php echo $ultima->nombre_marca . " - " . $ultima->nombre_tipo_promocion; ?><br>
                            <p class="mas_info"> Más información</p>
                        </a>
                  </li>
				<?php endforeach; ?>
            </ul>
            
            <ul class="nav">
              <li>
              	<h2>Destacados</h2>
              </li>
			<?php foreach($destacadas->result() as $destacada):?>
			  <li class="active">
					<a href="<?php echo $ruta_app."promociones/detalle/".$destacada->id_promocion;?>">
						<?php echo $destacada->nombre_marca . " - " . $destacada->nombre_tipo_promocion; ?><br>
						<p class="mas_info"> Más información</p>
					</a>
			  </li>
			<?php endforeach; ?>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->
        <!-----------------------------------------------------------------------------------------------------------------/BARRA LATERAL-->
      </div><!--/row-->
    
</div> <!-- /container -->

<!---------------------------------------------------------------------------------------------------/CONTENIDO GENERAL--->