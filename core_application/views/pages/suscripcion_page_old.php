<script type="text/javascript">
  function paquete_susc(paquete) {
	$("#paquete").val(paquete);
	$("#form_paquete").submit();
  }
</script>

<form id="form_paquete" method="post" action="<?php echo $ruta_app;?>suscripcion/form" style="display: block;">
<input type="text" id="paquete" name="paquete" />
</form>

<!--PLANES-->

<div class="container" style="margin-bottom:80px;">
  
  <div class="row f_top">
  <div class="col-md-2">&nbsp;</div>
  <div class="col-md-8"><h2 class="h2_m_yellow">Suscripción</h2></div>
  <div class="col-md-2">&nbsp;</div>
  </div> 
   
        
  <div  class="row">
   <div class="col-md-2">
      &nbsp;
    </div>
    
    <div class="col-md-4">
      
      <div class="panel panel-default">
	<div class="panel-heading text-center" style="background-color: #f8b317; color: #FFF; padding: 20px 0;"><h3 class="panel-title" style="font-size: 30px;">Suscripción<br>Individual</h3></div>
	<div class="panel-body">
	  <div class="text-center" style="margin-top: 20px;"><span class="glyphicon glyphicon-shopping-cart" style="font-size:90px; color: #f8b317;"></span></div>
	  
	  <ul style="margin:40px 0 50px 0;">
	    <li>Suscripción anual para un usuario.</li>
	    <li>Acceso a búsqueda de promociones los 365 días del año por categoría.</li>
	    <li>Reportes semanales.</li>
	    <li>Alarmas semanales.</li>
	    <li>Acceso a folletos de las principales cadenas.</li>
	  </ul>
	</div>
	<div class="panel-footer text-center"><a class="btn btn-large btn-warning btn-block" href="javascript:paquete_susc('individual');">Contratar</a></div>
      </div>
      
    </div>
    
    <div class="col-md-4">
      
       <div class="panel panel-default">
	<div class="panel-heading text-center" style="background-color: #ec1847; color: #FFF; padding: 20px 0;"><h3 class="panel-title" style="font-size: 30px;">Suscripción<br>Corporativo</h3></div>
	<div class="panel-body">
	  <div class="text-center" style="margin-top: 20px;"><span class="glyphicon glyphicon-shopping-cart" style="font-size:90px; color: #ec1847;"></span></div>
	  
	  <ul style="margin-top: 40px;">
	      <li>Suscripción anual para 10 usuarios.</li>
	      <li>Acceso a búsqueda de promociones los 365 días del año por categoría.</li>
	      <li>Reportes semanales por usuario.</li>
	      <li>Reportes semanales corporativos.</li>
	      <li>Alarmas semanales.</li>
	      <li>Acceso a folletos de las principales cadenas.</li>
	      <li>Precio especial por usuario adicional.</li>
	  </ul>
	</div>
	<div class="panel-footer text-center"><a class="btn btn-large btn-primary btn-block" href="javascript:paquete_susc('corporativo');">Contratar</a></div>
	
      </div>
      
    </div>
    
    <div class="col-md-2">
      &nbsp;
    </div>
    
    
    
  </div>
  
            <div class="row text-center">Para mayor información contáctanos vía mail <a href="mailto:info@quesucede.mx"><b>info@quesucede.mx</b></a> </div>
  
</div> <!-- /container -->

<!--PLANES-->

