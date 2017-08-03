<script type="text/javascript">
  function paquete_susc(paquete) {
	$("#paquete").val(paquete);
	$("#form_paquete").submit();
  }
</script>

<form id="form_paquete" method="post" action="<?php echo $ruta_app;?>suscripcion/form" style="display: block;">
<input type="hidden" id="paquete" name="paquete" />
</form>

<!--PLANES-->

<div class="container f_top_bot" style="margin-bottom:80px;">
  
  <div class="row">
  <div class="col-md-2">&nbsp;</div>
  <div class="col-md-8"><h2 class="h2_m_yellow">Suscripción</h2></div>
  <div class="col-md-2">&nbsp;</div>
  </div> 
   
        
  <div  class="row">
   <div class="col-md-4">
      &nbsp;
    </div>
    
    
    
    <div class="col-md-4">
      
       <div class="panel panel-default">
	<div class="panel-heading text-center" style="background-color: #ec1847; color: #FFF; padding: 20px 0;"><h3 class="panel-title" style="font-size: 30px;">Suscripción<br>Corporativa</h3></div>
	<div class="panel-body">
	  <div class="text-center" style="margin-top: 20px;"><span class="glyphicon glyphicon-shopping-cart" style="font-size:90px; color: #ec1847;"></span></div>
	  
	  <div style="margin:40px 0 50px 0;">
	      <img src="<?php echo $ruta_app; ?>images/paloma.png"> Suscripción anual para 10 usuarios<br />
	      <img src="<?php echo $ruta_app; ?>images/paloma.png"> Acceso a búsqueda de promociones los 365 días<br />
	      <img src="<?php echo $ruta_app; ?>images/blank.png"> del año por categoría<br />
	      <img src="<?php echo $ruta_app; ?>images/paloma.png"> Reportes semanales por usuario<br />
	      <img src="<?php echo $ruta_app; ?>images/paloma.png"> Reportes semanales corporativos<br />
	      <img src="<?php echo $ruta_app; ?>images/paloma.png"> Alertas semanales.<br />
	      <img src="<?php echo $ruta_app; ?>images/paloma.png"> Acceso a folletos de las principales cadenas<br />
	      <img src="<?php echo $ruta_app; ?>images/paloma.png"> Precio especial por usuario adicional<br />
	  </div>
	</div>
	<div class="panel-footer text-center"><a class="btn btn-large btn-primary btn-block" href="javascript:paquete_susc('corporativo');">Contratar</a></div>
	
      </div>
      
    </div>
    
    <div class="col-md-4">
      &nbsp;
    </div>
    
    
    
  </div>
  
  <div class="row text-center">Para mayor información contáctanos dando clic <a href="<?php echo $ruta_app;?>contacto"><b>aquí.</b></a></div>
 
  
</div> <!-- /container -->

<!--PLANES-->

