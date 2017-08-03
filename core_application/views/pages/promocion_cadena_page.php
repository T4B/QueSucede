<meta http-equiv="Content-type" content="text/html; charset=utf-8" />

<script src="<?php echo $ruta_js;?>highcharts.js"></script>
<script src="<?php echo $ruta_js;?>modules/data.js"></script>
<script src="<?php echo $ruta_js;?>modules/exporting.js"></script>
<script src="<?php echo $ruta_js;?>themes/gray.js"></script>
<script src="<?php echo $ruta_js;?>graficas.js"></script>

<?php

	$array_general = array();
	$array_color = array();
		
	foreach ($promociones_general->result() as $promocion)
	{
		array_push($array_general, array($promocion->promocion,$promocion->total));
		array_push($array_color, array($promocion->color));
	}
?>	

<script type="text/javascript">
function cadena(){

	var cadena = $("#cadena").find("option:selected").val();
    var categoria = $("#categorias").find("option:selected").val();

    var cadena_option = $("#cadena :selected").text();
    var categoria_option = $("#categorias :selected").text();
    var titulo = "Total promociones por cadenas";
    var leyenda = "";
	var emergente = " Total Registros: ";

 	var semana_select_ini = $("#semana_ini").find("option:selected").val();
    var semana_select_fin = $("#semana_fin").find("option:selected").val();

    var semana_ini = semana_select_ini.split('_')[0];
    var anio_ini = semana_select_ini.split('_')[1];
    var semana_fin = semana_select_fin.split('_')[0];
    var anio_fin = semana_select_fin.split('_')[1];

	var datos = {cadena:cadena,categoria:categoria,semana_ini:semana_ini,anio_ini:anio_ini,semana_fin:semana_fin,anio_fin:anio_fin};

        //alert(categoria);
	var mi_url = "<?php echo $ruta_app?>reportes/cadena";

	//alert(cadena);

	$.ajax({
		type:"post",
		url:mi_url,
		dataType:"json",
		cache: false,			  
		data:datos,
		success:function(response){
				if (response.cadenas == ''){
					$("#pastel_1").html("<center><h1>No hay datos</h1></center>");
					$("#pastel_2").html("");
                    return false;
				}

				var datos = response.general;
				var color1 = response.general_color;

				if(categoria_option == 'Todas'){
					//alert("todas");
					grafico_pastel("_1",titulo,leyenda,emergente,datos,color1);
				}
				else{
					grafico_pastel("_1",titulo,categoria_option,emergente,datos,color1);
				}
				/*grafica 2*/
				var datos_cadena = response.cadenas;
				var color2 = response.color;
				if(cadena_option == 'Todas'){
					var datos_general = <?php echo json_encode($array_general,JSON_NUMERIC_CHECK);?>;
					grafico_pastel("_2",cadena_option,categoria_option,emergente,datos_cadena,color2);
					grafico_pastel("_1",titulo,leyenda,emergente,datos_general,color1);
					//$("#pastel_1").html('');

				}
				if(categoria_option == 'Todas'){
					grafico_pastel("_2",cadena_option,leyenda,emergente,datos_cadena,color2);
				}
				else{
					grafico_pastel("_2",cadena_option,categoria_option,emergente,datos_cadena,color2);
				}

				if(datos_cadena == ''){
                    $("#pastel_2").html('');
                    return false;
                }  
				

		},
		error:function(){
				alert("error");
	  	}
	});


}

$(document).ready(function(){

	var datos = <?php echo json_encode($array_general,JSON_NUMERIC_CHECK);?>;
	var color = <?php echo json_encode($array_color,JSON_NUMERIC_CHECK);?>;
	var titulo = "Total promociones por cadenas";
	var leyenda = "";
	var emergente = " Total Registros: ";
	var id_div = "_1";
	//alert(color);

	grafico_pastel(id_div,titulo,leyenda,emergente,datos,color);

	$("#cadena").change(function(){
		var cadenas = $("#cadena").find("option:selected").val();
        if(cadenas == '0'){
            window.setTimeout('location.reload()', 50);
        }
        else{
            cadena();
        }
	});

	$("#categorias").change(function(){
        cadena();   
    });

    var i = 0;
    var option = '<option value="0">Todas</option>';
        //option += '<option value="00">Todas</option>';
    for(j=49;j<=52;j++){
        option += '<option value="'+j+'_2013">';
        option += 'Semana'+j+'_2013';
    }
    for(i=1;i<=52;i++){
        option += '<option value="'+i+'_2014">';
        option += 'Semana'+i+'_2014';
        
    }
	for(i=1;i<=52;i++){
		option += '<option value="'+i+'_2015">';
		option += 'Semana'+i+'_2015';
		
	}
	for(i=1;i<=52;i++){
		option += '<option value="'+i+'_2016">';
		option += 'Semana'+i+'_2016';
		
	}
    option += '</option>'
    $("[id^='semana_']").html(option);

    $("#buscar").click(function(){

            var cadena = $("#cadena").find("option:selected").val();
            var categoria = $("#categorias").find("option:selected").val();
            var semana_select_ini = $("#semana_ini").find("option:selected").val();
            var semana_select_fin = $("#semana_fin").find("option:selected").val();

            var semana_ini = semana_select_ini.split('_')[0];
            var anio_ini = semana_select_ini.split('_')[1];
            var semana_fin = semana_select_fin.split('_')[0];
            var anio_fin = semana_select_fin.split('_')[1];

			var datos = {cadena:cadena,categoria:categoria,semana_ini:semana_ini,anio_ini:anio_ini,semana_fin:semana_fin,anio_fin:anio_fin};
			var mi_url = "<?php echo $ruta_app?>reportes/cadena";

			$.ajax({
				type:'POST',
				url: mi_url,
				dataType:'Json',
				cache:false,
				data: datos,
				success:function(response){
					var datos = response.general;
					var color1 = response.general_color;
					//alert(response.query);
					if (datos == ''){
						$("#pastel_2").html("<center><h1>No hay datos</h1></center>");
	                    return false;
					}
					grafico_pastel("_2",titulo,'Semana'+semana_select_ini+' - Semana'+semana_select_fin,emergente,datos,color1);
					/*grafica 2*/
					var datos_cadena = response.cadenas;
					var color2 = response.color;
					if (datos_cadena == ''){
						$("#pastel_2").html("<center><h1>No hay datos</h1></center>");
	                    return false;
					}
					grafico_pastel("_2",titulo,'Semana'+semana_select_ini+' - Semana'+semana_select_fin,emergente,datos_cadena,color2);

				},
				error:function(){
					alert('Error de Comunicacion');
				}
			});
	});


});
</script>

<div class="container f_top_bot">
<br/><br/>
<div class="row">
    <div class="col-lg-2">
    	<label for="3">Cadena:</label>
    	<select id="cadena" name="cadena" class="form-control">
    		<option value="0">Todas</option>
            <?php   foreach ($formatos->result() as $formato): ?>
                <option value = "<?php echo $formato->id_formato;?>"><?php echo $formato->nombre_formato; ?></option>
            <?php endforeach; ?>
    	</select>	
    </div>
    <div class="col-lg-3">
    	<label for="3">Categorias:</label>
    	<select id="categorias" name="categorias" class="form-control">
            <option value="0">Todas</option>
            <?php   foreach ($categorias->result() as $categoria): ?>
                <option value = "<?php echo $categoria->id_categoria;?>"><?php echo $categoria->nombre_categoria; ?></option>
            <?php endforeach; ?>
    	</select>	
    </div>
    <div class="col-lg-2">
    	<label for="3">Semana Inicial:</label>
    	<select id="semana_ini" name="semana_ini" class="form-control">
    	</select>	
    </div>
    <div class="col-lg-2">
    	<label for="3">Semana Final:</label>
    	<select id="semana_fin" name="semana_fin" class="form-control">
    	</select>	
    </div>
    <div class="col-lg-1" style="margin-top:4px;">
    <br/>
    <input type="button" name="buscar" id="buscar" class="btn btn-primary" value="Buscar" />
    </div>
</div>
<br />
<p>
	*El reporte de “promoción por cadena” te permite comparar la sumatoria de promociones por “tipo de promoción”,  “cadena” y “categoría”. Puedes además comparar el total de las cadenas, con la cadena seleccionada.
</p>
<br/>
<br/>
<div class="row">
	<div id="pastel_1" style="min-width: 310px; height: 400px; margin: 0 auto" class="col-lg-6"></div>
	<div id="pastel_2" style="min-width: 310px; height: 400px; margin: 0 auto" class="col-lg-6"></div>
</div>
<br/><br/>
</div>