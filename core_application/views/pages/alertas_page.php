<script type="text/javascript">
    
    function borrar_alerta(alerta) {
        var mi_url = '<?php echo $ruta_app?>alertas/borrar';
		
	    $.ajax({
		type : 'POST',
		dataType : 'JSON',
		url : mi_url,
		data : {alerta:alerta},
		success:function(response){
		    if(response.codigo == 0){
			$("#mensaje_modal_mensaje").html("Alerta borrada");
			$("#modal_mensaje").modal().on('hidden.bs.modal', function(){
			    $("#div_alertas").find("input[value='"+response.alerta+"']").parent().fadeOut("slow", function(){
				$(this).remove();
			    });
			});
		    }
		},
		error:function(){
			alert("error");
		}
	    });
    }
	
    $(document).ready(function(){
	$(".modal-dialog").css("margin-top", "15%");
        $("#form_alertas_head").submit(function(event){
	    event.preventDefault();
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
	    }else{
		var mi_url = "<?php echo $ruta_app;?>alertas/guardar";
		var datos = $(this).serialize();
		
		$.ajax({
		    type:"post",
		    dataType:"json",
		    url: mi_url,
		    data: datos,
		    success: function(response){
			if (response.codigo == 0) {
			    var mensaje = "Alerta guardada correctamente";
			    $(".alerta_generica .fecha_alta_gen").html(response.alta);
			    $(".alerta_generica .criterio").html(response.titulo);
			    $(".alerta_generica").find(".input_alerta").val(response.alerta);
			    $(".alerta_generica a").attr("href", "javascript:borrar_alerta('"+response.alerta+"')");
			    var objAlerta = $(".alerta_generica").clone();
			    $(objAlerta).removeClass("alerta_generica")
			    .addClass("div_promo");
			    $("#div_alertas").prepend(objAlerta);
			    $("#mensaje_modal_mensaje").html(mensaje);
			    $("#modal_mensaje").modal().on('hidden.bs.modal', function(){
				    $(objAlerta).fadeIn("slow");
			    });	
			}else{
			    var mensaje = "Error al guardar alerta";
			    modal_mensaje(response.mensaje);
			}
			    
		    },
		    error:function(){
			    modal_mensaje("Error al guardar alerta");
		    }
		});
	    }
	    
        });
	
	$('.myTooltip').tooltip();
    });
</script>

<div class="container f_top_bot">
    <div class="row">
	    <div class="col-md-8 col-md-offset-2">
	    <h2>Buscar promociones</h2>
	    <form class="" role="form" id="form_alertas_head" method="post" action="<?php echo $ruta_app;?>alertas/guardar">
	    <div class="row">
		<div class="col-lg-3">
		  <select class="form-control" id="select_categoria_head" name="categoria">
			<option value="">-- Categoría --</option>
			<option value="TODOS"> TODOS </option>
			  <?php foreach($categorias->result() as $categoria):?>
			  <option value="<?php echo $categoria->id_categoria; ?>">
				<?php echo $categoria->nombre_categoria; ?>
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
		<button type="submit" class="btn btn-primary ">
&nbsp;&nbsp;Guardar&nbsp;&nbsp;<span class="glyphicon glyphicon-floppy-disk"></span></button>
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



<div class="container f_top_bot">
	<div class="row">
	<div class="col-md-2">
		&nbsp;
	</div>
	<div class="col-md-8" >
	    <h1>Mis Alertas</h1><br><br><br>
	    <div id="div_alertas">
	    <?php
		    foreach($alertas->result() as $alerta):
		    $id_encrypt = $this->encrypt->encode($alerta->id_alerta);
	    ?>
	    <div class="row div_promo" style="margin-bottom: 30px;">
		    <div class="col-md-2 text-right">
			<span class="glyphicon glyphicon-bell" style="font-size: 40px; color: #ed1847;"></span>
		    </div>
		    <div class="col-md-8" style="border-bottom: solid 1px #ed1847; margin-bottom: 15px; padding-bottom: 15px;">
			<div style="margin-top: 5px; color: #9c9c9c;"> <h3>Fecha de alta</h3></div>
			<div><?php echo $alerta->alta; ?></div>
			<div style="margin-top: 8px; color: #9c9c9c;"><h3>Criterio</h3></div>
			<div><?php echo $alerta->titulo; ?></div>
		    </div>
		    <div class="col-md-2 text-left">
			<div>
			    <a href="javascript:borrar_alerta('<?php echo $id_encrypt;?>');" class="btn btn-primary btn-sm myTooltip" title="Borrar"><span class="glyphicon glyphicon-trash"></span></a>
			</div>
		    </div>
		    <input type="text" style="display: none;" value="<?php echo $id_encrypt;?>">
	    </div>
	    <?php endforeach; ?>
	    </div>
		
	</div>
	<div class="col-md-2">
		&nbsp;
	</div>
	</div>
</div>


<div class="row alerta_generica" style="margin-bottom: 30px; display: none">
	<div class="col-md-2 text-right">
		<span class="glyphicon glyphicon-bell" style="font-size: 40px; color: #ed1847;"></span>
	</div>
	<div class="col-md-8" style="border-bottom: solid 1px #ed1847; margin-bottom: 15px; padding-bottom: 15px;">
		<div style="margin-top: 5px; color: #9c9c9c;"> <h3>Fecha de alta</h3></div>
		<div class="fecha_alta_gen"></div>
		<div style="margin-top: 8px; color: #9c9c9c;"><h3>Criterio</h3></div>
		<div class="criterio"></div>
	</div>
	<div class="col-md-2 text-left">
		<div>
			<a href="javascript:borrar_alerta('');" class="btn btn-primary btn-sm myTooltip" title="Borrar"><span class="glyphicon glyphicon-trash"></span></a>
		</div>
	</div>
	<input type="hidden" class="input_alerta">
	
</div>





