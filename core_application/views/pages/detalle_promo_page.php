<script type="text/javascript">
    function mostrar_datos_form(id) {
	$("#span_precio").html($("#precio_formato_"+id).val());
	$("#span_ubicacion").html($("#ubicacion_formato_"+id).val());
    }
</script>

<div class="container f_top_bot"><!--container  style="margin-top:40px;-->
<div class="col-md-9 m_desplegado"><!--PANEL IZQUIERD0--->

<div id="div_formatos_detalle" style="display: none;">
<?php foreach($formatos_detalle->result() as $formato):?>
	<input id="precio_formato_<?php echo $formato->id_formato; ?>" class="precio" value="<?php echo number_format($formato->precio, 2);?>">
	<input id="ubicacion_formato_<?php echo $formato->id_formato; ?>" class="precio" value="<?php echo $formato->nombre_ubicacion; ?>">
<?php endforeach; ?>
</div>

<div class="col-md-5">
	<br />
	<h2><?php echo $promocion->nombre_marca; ?></h2>
	<h3><?php echo $promocion->nombre_tipo_promocion;?></h3>
      	<img src="<?php echo $ruta_images_promo.$promocion->foto;?>" class="img-responsive">
	<div class="row f_widget">
	    <div class="col-sm-2 col-md-2">
        <div class="gift_aviso" style="float:left;">
            <a  href="#">Camisa</a>
        </div>
	    </div>
        <div class="col-sm-6 col-md-7 ">
          <div style="border-left: solid 1px #9dcb3a; height:40px; padding-left:15px; margin-top:5px; text-align:right;">
              Semana actual: <span style="color:#9dcb3a;"><?php echo $semana;?></span>
          </div>
        </div>
	</div>
  <!--Descripción del producto--> 
  	<div class="col-md-12" style="margin-top: 30px;">
    <hr />
       <h5><b>Descripción</b></h5>
      <?php echo $promocion->descripcion;?>
      <h5><b>Producto</b></h5>
      <?php echo $promocion->producto;?>
      <h5><b>Vigencia</b></h5>
      <?php echo $promocion->vigencia;?>
      <h5><b>Mecánica</b></h5>
      <?php echo $promocion->mecanica;?>
      <h5><b>Regalo</b></h5>
      <?php echo $promocion->regalo;?>
      <h5><b>Ubicacion</b></h5>
      <span id="span_ubicacion">
	<?php echo $promocion->nombre_ubicacion;?>
      </span>
      <h5><b>Precio</b></h5>
      <span id="span_precio">
	<?php echo number_format($promocion->precio,2);?>
      </span>
      
      
      
      
      
      <input type="hidden" id="categoria" value="<?php echo $promocion->nombre_subcategoria;?>">
   </div>
  <!--Descripción del producto--> 
</div>
    
    
<div class="col-md-7 m_desplado_lateral">
    <h4><?php echo $promocion->titulo;?></h4>
    <h5>Donde:</h5>
    <hr>
    <!--PANEL DE ACORDION-->            
    <div class="panel-group" id="accordion">
	<?php
	    $contador = 1;
	    foreach($formatos_ubicaciones as $formato_ubicacion):
		    $formato = $formato_ubicacion['formato'];
		    $ubicaciones = $formato_ubicacion['ubicaciones'];
		    $anios = $formato_ubicacion['anios'];
	?>
	<div class="panel panel-default">
	    <div class="panel-heading">
		<h4 class="panel-title">
		    <a class="accordion-toggle" onclick="mostrar_datos_form('<?php echo $formato->id_formato;?>');" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo $formato->id_formato;?>">
			<h4 style="margin:0; padding-left:10px; border-left: solid 2px #ed1847;"><img src="<?php echo $ruta_images.$formato->img_formato;?>"></h4></a>
		    </a>
		</h4>
	    </div>
	    <div id="collapse_<?php echo $formato->id_formato;?>" class="panel-collapse <?php if($contador == 1){echo "in";}else{echo "collapse";}?>">
		<div class="panel-body">
		    <div class="table-responsive" style="font-size:10px;">
			<p>Semanas activa</p>
			
			<?php
			    foreach($anios as $anio_key => $value):
			?>
			<p><?php echo $anio_key;?></p>
			<table  class="table">
			    <tr>
				<?php
				    for($i = 0; $i<10; $i++){
					echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>";
				    }
				?>
			    </tr>
			    <?php
				$semanas = $value;
				$cont = 1;
				foreach($semanas as $key => $semana):
				    $res = $cont % 10;
				    $id_semana = $semana['id_semana'];
				    $num_semana = $semana['num_semana'];
				    if($cont == 1){echo '<tr>'; }
				    
				    if(in_array($id_semana, $ubicaciones)){
					echo '<td class="t_activa">';
				    }else{
					echo '<td class="t_inactiva">';
				    }
				    echo $num_semana . '</td>';
				    if($res == 0){echo '</tr><tr>'; }
				    $cont++;
				endforeach;
			    ?>
			</table>
			<?php endforeach; ?>
		    </div>       
		</div>
	    </div>
	</div>
	<?php
		$contador++;
		endforeach;
	?>
    </div><!--FIN PANEL DE ACORDION-->
    <div style="text-align: right; color: #9f9f9f;">
	<img src="<?php echo $ruta_images;?>simbolo1.jpg"> = Promoción activa &nbsp;&nbsp;
	<img src="<?php echo $ruta_images;?>simbolo2.jpg"> = Promoción inactiva
    </div>
</div><!--FIN m_desplado_lateral--->
    
  <div class="clearfix"></div>
  <!--ANTERIOR ESPACIO-->
  
  <!--ANTERIOR ESPACIO-->
  
  <!--Desplegado de más información-->
             
        
</div><!--FIN PANEL IZQUIERD0--->

    
    	<!--BARRA LATERAL-->
        <div class="col-md-3">
			<a href="javascript:window.history.back();" class="btn btn-primary btn-lg">Regresar</a>
            <hr class="red">
				<div class="well sidebar-nav">
            <ul class="nav">
              <li>
              	<h2>Lo más reciente</h2>
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
		</div>
    	<!--FIN BARRA LATERAL-->
    
    
</div><!-- /container -->