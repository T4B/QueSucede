<script type="text/javascript">
  function vaidar_suscripcion() {
	$("#categorias_interes_error").hide();
	var flag_ok = validar_form("form_suscripcion");
	
	if (flag_ok) {
	  if($("input[name='categorias[]']:checked").length == 0){
		$("#categorias_interes_error").show();
	  }else{
		$("#form_suscripcion").submit();
	  }
	}
  }
</script>



<!--REGISTRO DE SUSCRIPCIÓN--> 

<div style="width:960px; margin: 0 auto;">

<div class="container f_top_bot">
  <h2 class="h2_m_blue">Suscripción</h2> 
  <form role="form" id="form_suscripcion" method="post" action="<?php echo $ruta_app;?>suscripcion/guardar">
    <div class="row">
      <div class="col-md-12" style="margin-top:15px;"><h3>Datos generales</h3><hr></div>
    </div>
    
    <div class="row">
      <div class="col-md-4">
		<label for="nombre">(*) Nombre (s)</label>
        <input type="text" class="form-control type_alpha required" id="nombre" placeholder=" " name="nombre">
		<div id="nombre_error" class="alert alert-danger" style="display: none;"></div>
			<span style="font-size:12px; color:#6c6c6c;">(Ejemplo: Ana)</span>
		
      </div>
      
        <div class="col-md-4">
          <label for="a_paterno">(*) Apellido paterno</label>
          <input type="text" class="form-control type_alpha required" id="a_paterno" placeholder="" name="a_paterno">
          <div id="a_paterno_error" class="alert alert-danger" style="display: none;"></div>
          	  	<span style="font-size:12px; color:#6c6c6c;">(Ejemplo: Pérez)</span>
          
        </div>
		
        	<div class="col-md-4">
              <label for="a_materno">(*) Apellido materno</label>
              <input type="text" class="form-control type_alpha required" id="a_materno" placeholder=" " name="a_materno">
              <div id="a_materno_error" class="alert alert-danger" style="display: none;"></div>
              	<span style="font-size:12px; color:#6c6c6c;">(Ejemplo: Ruíz)</span>
              
            </div>
    
    </div><!--/ROW-->
  
    
    <div class="row" style="margin-top:10px;">
      <div class="col-md-2">
		<label for="lada">(*) LADA</label>
        <input type="text" class="form-control type_numeric required" id="lada" placeholder=" " name="lada" maxlength="4">
		<div id="lada_error" class="alert alert-danger" style="display: none;"></div>
		  	<span style="font-size:12px; color:#6c6c6c;">(Ejemplo: 0155)</span>
		
      </div>
      
	  <div class="col-md-4">
          <label for="telefono">(*) Teléfono</label>
        <input type="text" class="form-control type_numeric required" id="telefono" placeholder=" " name="telefono" maxlength="16">
		<div id="telefono_error" class="alert alert-danger" style="display: none;"></div>
			<span style="font-size:12px; color:#6c6c6c;">(Ejemplo: 56894155)</span>
		
        </div>
	  
        <div class="col-md-2">
          <label for="cp">(*) C.P.</label>
          <input type="text" class="form-control type_numeric required" id="cp" placeholder="" name="cp" maxlength="6">
          <div id="cp_error" class="alert alert-danger" style="display: none;"></div>
          		  	 <span style="font-size:12px; color:#6c6c6c;">(Ejemplo: 01234)</span>
          
        </div>
		
		<div class="col-md-3">
		  <label for="correo_susc">(*) Correo electrónico</label>
		  <input type="text" class="form-control type_mail required" id="correo_susc" placeholder=" " name="correo">
		  <div id="correo_susc_error" class="alert alert-danger" style="display: none;"></div>
		  	 <span style="font-size:12px; color:#6c6c6c;">(Ejemplo: ejemplo@tucorreo.com.mx)</span>
		  
		</div>
    
    </div><!--/ROW-->
    
    <div class="row">
      <div class="col-md-12" style="margin-top:15px;"><h3>Datos específicos</h3><hr></div>
    </div>
    
    <div class="row">
     
      <div class="col-md-4">
		<label for="compania">(*) Compañía</label>
        <input type="text" class="form-control type_alphanumeric required" id="compania" placeholder=" " name="compania">
		<div id="compania_error" class="alert alert-danger" style="display: none;"></div>
				  	 <span style="font-size:12px; color:#6c6c6c;">(Ejemplo: Mi compañía)</span>
		
		
      </div>
      
        <div class="col-md-4">
          <label for="ocupacion">(*) Ocupación</label>
          <input type="text" class="form-control type_alphanumeric required" id="ocupacion" placeholder="" name="ocupacion">
          <div id="ocupacion_error" class="alert alert-danger" style="display: none;"></div>
          		  	 <span style="font-size:12px; color:#6c6c6c;">(Ejemplo: Profesionista)</span>
          
          
        </div>
		
        	<div class="col-md-4">
              <label for="puesto">(*) Puesto o cargo</label>
              <input type="text" class="form-control type_alphanumeric required" id="puesto" placeholder="" name="puesto">
              <div id="puesto_error" class="alert alert-danger" style="display: none;"></div>
              		  	 <span style="font-size:12px; color:#6c6c6c;">(Ejemplo: Ventas)</span>
              
            </div>
    
    </div><!--/ROW-->
    
    <div class="row" style="margin-top:10px;">
     
      <div class="col-md-4">
		<label for="categorias_interes">(*) Categorías de interés</label>
            <div class="thumbnail marco_check" style="display: block; max-height: 150px;">
			  <?php foreach($categorias->result() as $categoria): ?>
			  
				<div class="checkbox">
				  <label>
					<input type="checkbox" name="categorias[]" value="<?php echo $categoria->id_categoria; ?>">
					<?php echo $categoria->nombre_categoria; ?>
				  </label>
				</div>
			  <? endforeach; ?>
				
			</div>
		<div id="categorias_interes_error" class="alert alert-danger" style="display: none;">
		  Elige al menos una opción.
		</div>
      </div>
      
        <div class="col-md-4">
          <label for="telefono_basico">(*) Rango de edad</label>
          	<select class="form-control combo" id="select_edad" name="edad">
              <option value="">Selecciona</option>
			  <?php foreach($edades->result() as $edad):?>
              <option value="<?php echo $edad->id_edad;?>" ><?php echo $edad->descripcion_edad; ?></option>
			  <?php endforeach; ?>
            </select>
          <div id="select_edad_error" class="alert alert-danger" style="display: none;"></div>
        </div>
        
     </div><!--/ROW-->
     
     <div class="row" style="margin-top:15px;">
     
 <div class="col-md-6 text-left"><span style="font-size:12px; color:#6c6c6c;">Los campos con (*) son obligatorios.</span>
 </div>
 <br />
 	 <div class="col-md-6 text-left">Para mayor información contáctanos dando clic <a href="http://quesucede.com.mx/contacto"><b>aquí</b></a></div>
     
     
		  <div class="col-md-6 text-right"><br>
		  <button type="button" onclick="javascript:vaidar_suscripcion();" class="btn btn-danger btn-lg">Suscribirme</button>
		  <hr></div>
	 </div>
	 <input type="hidden" name="paquete" value="<?php echo $paquete;?>"/>
</form>

<!--FIN DE REGISTRO DE SUSCRIPCIÓN-->    
</div>   
</div>