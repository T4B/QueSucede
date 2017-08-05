



<script type="text/javascript">
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
    var limDate = new Date();
    limDate.setDate(now.getDate() - 50);
    var limFin = new Date();
    limFin.setDate(now.getDate() - 50);
    
    var pagina_actual = <?php echo $pagina_actual; ?>;
    var total_paginas = <?php echo $total_paginas; ?>;
    var ruta_app = "<?php echo $ruta_app;?>";
    var bucket = "<?php echo $bucket;?>";
    
    function paginar(pagina) {
	var mi_ruta = ruta_app + "folletos/pag/"+pagina;
	window.location = mi_ruta;
	//$("#form_paginacion").submit();
    }
    
    function siguiente() {
	    var sig_pagina = pagina_actual + 1;
	    paginar(sig_pagina);
    }
    
    function anterior() {
	    var sig_pagina = pagina_actual - 1;
	    paginar(sig_pagina);
    }
    
    function buscar_formato(formato) {
	$("#select_formato").val(formato);
	$("#form_folletos").submit();
    }
    
    $(document).ready(function(){
        var checkin = $("#fecha_inicio").datepicker({
            format:'yyyy/mm/dd',
            onRender: function(date){
                return (date.valueOf() < limDate.valueOf() || date.valueOf() > now.valueOf() ) ? 'disabled' : '';
            }
            
        }).on('changeDate', function(ev){
            //if (ev.date.valueOf() > checkout.date.valueOf()) {
                var newDate = new Date(ev.date);
                newDate.setDate(newDate.getDate() + 1);
                limFin.setDate(newDate.getDate() - 1);
                checkout.setValue(newDate);
                $("#fecha_fin").val('');
            //}
            checkin.hide();
            //$('#fecha_fin')[0].focus();
        }).data('datepicker');
        
        
        var checkout = $("#fecha_fin").datepicker({
            format:'yyyy/mm/dd',
            onRender: function(date){
                
                return ( date.valueOf() < limFin.valueOf() || date.valueOf() > now.valueOf() ) ? 'disabled' : '';
            }
        }).on('changeDate', function(ev){
                checkout.hide();
            }
        ).data('datepicker');
        
        $("#form_folletos").submit(function(event){
            var flag_ok = true;
            var formato = $("#select_formato").val();
            
            if (formato == "") {
                alert("Elige un formato");
                flag_ok = false;
            }
            
            if (!flag_ok) {
                event.preventDefault();
            }
            
        });
	if(total_paginas > 1){
	    $(".pag_"+pagina_actual).addClass('active');
	}
    });
</script>

<div class="container f_top_bot">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<h2>Buscar folletos</h2>
			<form class="" role="form" id="form_folletos" method="post" action="<?php echo $ruta_app;?>folletos/buscar">
			<div class="row">
					<div class="col-lg-3">&nbsp;<br>
					  <select class="form-control" id="select_formato" name="formato" >
						<option value="">-- Formato --</option>
						<option value="TODOS"> TODOS </option>
						  <?php foreach($formatos->result() as $formato):?>
						  <option value="<?php echo $formato->id_formato;?>">
						  <?php echo $formato->nombre_formato; ?>
						  </option>
						  <?php endforeach; ?>
					  </select>
					</div>
					<div class="col-lg-3">
                                Fecha inicial
					   <input class="form-control" type="text" id="fecha_inicio" name="fecha_inicio">
					</div>
					<div class="col-lg-3">
                                Fecha final
					  <input class="form-control" type="text" id="fecha_fin" name="fecha_fin">
					</div>
					
					<div class="col-lg-3">&nbsp;<br>
					<button type="submit" class="btn btn-primary ">&nbsp;&nbsp;Buscar&nbsp;&nbsp;<span class="glyphicon glyphicon-search"></span></button>
					</div>
			  </div>
		  </form>
		</div>
	</div>
</div>




<div class="container f_top_bot">
    <?php if(!$es_index):?>
    <div class="row">
		    <div class="col-md-2">
			&nbsp;
		    </div>
		    <div class="col-md-6">
		       
		    </div>
		    
		    <div class="col-md-4">
			<div class="text-right">
			    <a href="javascript:window.history.back();" class="btn btn-primary" style="">
			    <span class="glyphicon glyphicon-chevron-left"></span>&nbsp;&nbsp;Regresar</a>
			</div>
		    </div>
    </div>
    <?php endif; ?>
    
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
	<?php foreach($folletos as $folleto):?>
	<div class="col-sm-3 col-md-3 f_muestra_promo">
	  <div class="thumbnail">
	    <div class="text-center" style="margin:10px 0;">
			<img src="<?php echo $AWS_BUCKET; ?>src_folletos/<?php echo $folleto['ruta'] . "/" . $folleto['img_folleto'];?>" class="img_folleto">
	    </div>
	    <img src="<?php echo $AWS_BUCKET; ?>src_folletos/<?php echo $folleto['ruta'] . "/" . $folleto['portada']; ?>">
	    <div class="caption">
	      <h5>Periodo: <br /><b><?php echo $folleto['periodo']; ?></b></h5><br>
	     <p class="text-center">
	      <a href="<?php echo $ruta_app . "folletos/detalle/" . $folleto['id_folleto']; ?>" target="" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-chevron-right "></span>&nbsp;Ver</a>
	      <a href="<?php echo $AWS_BUCKET . "src_folletos/" . $folleto['ruta'] . "/" . $folleto['pdf']; ?>" class="btn btn-primary btn-xs" target=""><span class="glyphicon glyphicon-chevron-down"></span>&nbsp;Descargar</a>
	      <?php if($es_index): ?>
		<a href="javascript:buscar_formato(<?php echo $folleto['formatos_id_formato'];?>);" class="btn btn-default btn-xs" target=""><span class="glyphicon glyphicon-chevron-left"></span>&nbsp;Historial</a>
	      <?php endif; ?>
	     </p>
	    </div>
	  </div>
	</div>
	<?php endforeach; ?>
     </div><!--/ROW-->
    <!--/MINIS-->
    
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
</div> <!-- /container -->

<!---------------------------------------------------------------------------------------------------/CONTENIDO GENERAL--->

