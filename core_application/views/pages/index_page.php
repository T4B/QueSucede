<!--CONTENIDO GENERAL-->
<div class="container f_top_bot"><!--container -->
    <div class="row" style="margin-bottom:15px;">
        <div class="col-md-7">
        <!--CARRUSEL-->
     		<div id="myCarousel" class="carousel slide">
                  <!-- Indicators -->
                  <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                    <li data-target="#myCarousel" data-slide-to="3"></li>
                  </ol>

                  <div class="carousel-inner">


                    <div class="item active  text-center">
                      <img src="<?php echo $AWS_BUCKET;?>images/slide/img_0.jpg" alt="First slide">
                          <div class="container">
                            <div class="carousel-caption-right">

                            </div>
                          </div>
                    </div>
                    <div class="item  text-center">
                      <img src="<?php echo $AWS_BUCKET;?>images/slide/img_1.jpg" alt="Second slide">
                          <div class="container">

                          </div>
                    </div>

                    <div class="item text-center">
                       <img src="<?php echo $AWS_BUCKET;?>images/slide/img_2.jpg" alt="Third slide">
                      <div class="container">

                      </div>
                    </div>

                    <div class="item  text-center">
                      <img src="<?php echo $AWS_BUCKET;?>images/slide/img_3.jpg" alt="Four slide">
                      <div class="container">
                        <div class="carousel-caption">
                          <h1> </h1>

                          <p><a class="btn btn-large btn-primary" href="http://quesucede.com.mx/registro"><span style="font-size:30px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Aquí&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></a></p>
                        </div>
                      </div>
                    </div>

                  </div>
                  <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span style="position:absolute; top:45%; left:-5px; display:inline-block;"><img src="<?php echo $ruta_images;?>images/slide/arrow_left.jpg"></span></a>
                  <a class="right carousel-control" href="#myCarousel" data-slide="next"><span style="position:absolute; top:45%; right:-5px; display:inline-block;"><img src="<?php echo $ruta_images;?>images/slide/arrow_right.jpg"></span></a>
                </div><!-- /.carousel -->
        <!--/CARRUSEL-->
        </div><!--/col-md-7-->

           <div class="col-md-5">
                <div class="videoWrapper">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/AA8aidvNqcY" frameborder="0" allowfullscreen></iframe>
            
                </div>
            </div>
    </div><!--/ROW-->


    <div class="row" style="margin-top:20px;">
        <div class="col-md-10">
            <h1>Promociones</h1>
        </div>
    </div>
               <!-- MINIS-->
                <div class="row">
					<?php
						foreach($ultimas->result() as $promocion):
						$logo_marca = $promocion->logo_marca;
					?>
                    <!--Muestra desplegado promocion-->

					<div class="col-sm-3 col-md-3 f_muestra_promo">
					  <div class="thumbnail">
						  <h3 class="h3_m_blue"><?php echo $promocion->titulo;?></h3>
						 <div class="m_brand_mini">
							<?php if($logo_marca != "" && $logo_marca != "img_ref.jpg"): ?>
							<img src="<?php echo $ruta_images."marcas/".$logo_marca;?>">
							<?php endif;?>
						 </div>
						 <img src="<?php echo $ruta_images_promo.$promocion->foto;?>">
						<div class="caption">
						  <h5><?php echo $promocion->nombre_subcategoria;?></h5>
						 <p class="text-center">
							<a href="<?php echo $ruta_app.'promociones/detalle/'.$promocion->id_promocion;?>" class="btn btn-default">Más información</a>
						 </p>
						</div>
					  </div>
					</div>

					<!--Muestra desplegado promocion-->
					<?php endforeach; ?>
                </div><!--/ROW-->
                <!--/MINIS-->

</div> <!-- /container -->
<style type="text/css">
  <!--
  .carousel-inner > .item > img, .carousel-inner > .item > a > img {display: inline-block;}
  -->
</style>
<!--/CONTENIDO GENERAL-->
