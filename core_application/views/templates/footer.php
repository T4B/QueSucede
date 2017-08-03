
<div class="cont_footer">
<div class="container"><!--container -->
	<div class="container">
        
         
            <div class="col-md-8 text-left" style="border-left:solid 1px #FFF;">
             <a href="<?php echo $ruta_app; ?>page/view/empresa">Empresa</a><br />
			 <a href="<?php echo $ruta_app; ?>page/view/que_hacemos">¿Qué hacemos?</a><br />
             <a href="<?php echo $ruta_app; ?>page/view/punto_venta">¿Por qué lo hacemos?</a><br />
			 <a href="<?php echo $ruta_app; ?>page/view/atrevete">Atrévete</a><br />
			 <a href="<?php echo $ruta_app; ?>page/view/terminos">Términos y Condiciones</a><br />
             <a href="<?php echo $ruta_app; ?>page/view/aviso_privacidad">Aviso de Privacidad</a><br />


             <a href="http://quesucede.com.mx/mostrar/categoria/ABARROTES" style="color:#000;">.</a><br />



            </div>
           
     
</div> <!-- /container -->
</div>
    
<!-- Modal -->
<div class="modal fade" id="modal_mensaje" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<br>
			<h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
		<!--CONTENIDO-->
		</div>
		</div><!-- /.modal-content -->
    </div><!-- /.modal-dialog --> 
</div><!-- /.modal -->
<!-- Modal -->


<!-- Modal -->
<div class="modal fade" id="modal_recomendacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog" style="max-width: 550px;">
      <div class="modal-content">
        <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<br>
			<!--<img src="<?php echo $ruta_images;?>logo_correo.png">-->
        </div>
        <div class="modal-body">
			<div style="padding:5px; font-size: 14px;">
				<h1 style="color: #ed1847;">Recomienda Qué Sucede.</h1>
					<form role="form">
						<div class="form-group">
						 <p>Ingresa el correo electrónico de las personas a las que quieres recomendar este sitio y en el momento en que se registren obtendrás 5 días más de cortesía en tu cuenta.</p><br />
						  
						  <!--Contenido a duplicar-->
						  <div class="row">
							<div class="col-md-8 col-xs-12 text-right" id="div_recomendaciones">
								<input type="email" class="form-control" id="text_recomendacion_1" placeholder="correo electrónico"><br />
							</div>
							
							<div class="col-md-4 col-xs-12">
								<a style="" href="javascript:agregar_recomendacion();" class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign"></span><span style="font-size: 12px;"> Agregar otro correo</span></a>
							</div>
						  </div>
						  <!--Contenido a duplicar-->
						  
						</div>
					</form>
					<button onclick="recomendacion();" class="btn btn-primary">Recomienda</button>
			</div>
		</div>
		</div><!-- /.modal-content -->
    </div><!-- /.modal-dialog --> 
</div><!-- /.modal -->
<!-- Modal -->	
</body>
</html>
<!--FOOTER-->