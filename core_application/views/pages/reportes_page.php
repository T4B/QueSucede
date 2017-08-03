<meta http-equiv="Content-type" content="text/html; charset=utf-8" />

<script src="<?php echo $ruta_js;?>highcharts.js"></script>
<script src="<?php echo $ruta_js;?>modules/data.js"></script>
<script src="<?php echo $ruta_js;?>modules/exporting.js"></script>
<script src="<?php echo $ruta_js;?>themes/gray.js"></script>
<script src="<?php echo $ruta_js;?>graficas.js"></script>

<script type="text/javascript">
	function semana(){
		var semana_select = $("#semana").find("option:selected").val();
        var semana = semana_select.split('_')[0];
        var anio = semana_select.split('_')[1];
        var categoria = $("#categorias").find("option:selected").val();
        //alert(categoria);
		var mi_url = "<?php echo $ruta_app?>reportes/semana";

        var semana_option = $("#semana :selected").text();
        var categoria_option = $("#categorias :selected").text();
        
		$.ajax({
			  type:"post",
			  url:mi_url,
			  dataType:"json",
			  cache: false,			  
			  data:{semana:semana,anio:anio,categoria:categoria},
			  success:function(response){
                    //alert(response.query1);
			  		var promociones = response.query;
                    //alert(promociones);
                    if(promociones == ''){
                        $("#container").html("<center><h1>No hay datos</h1></center>");
                        return false;
                    }       

			  		$("#datatable tbody").html('');

			  		$.each(promociones, function(index){
			  			var tr = '<tr>';
			  			tr += '<td>' + promociones[index].formato + '</td>';
			  			//tr += '<td>' + promociones[index].Activación + '</td>';
			  			tr += '<td>' + promociones[index].Autoliquidable + '</td>';
			  			tr += '<td>' + promociones[index].Bonificación_de_Producto + '</td>';
			  			tr += '<td>' + promociones[index].Canje + '</td>';
			  			tr += '<td>' + promociones[index].Concurso + '</td>';
			  			tr += '<td>' + promociones[index].Descuento_en_Precio + '</td>';
			  			tr += '<td>' + promociones[index].Emplaye + '</td>';
			  			tr += '<td>' + promociones[index].In_On_Pack + '</td>';
			  			tr += '<td>' + promociones[index].Instant_Win + '</td>';
			  			//tr += '<td>' + promociones[index].Sampling + '</td>';

			  			tr += '</tr>';
			  			$("#datatable tbody").append(tr);

			  		});
			  		grafica_tabla(categoria_option,semana_option);
			  },
			  error:function(){
					alert("error");
			  }
		});

	}

    $(document).ready(function(){

        var titulo = 'Promociones';
        var subtitulo = 'Todas';
        var i = 0;
        var option = '<option value="0">Todas</option>';
            //option += '<option value="00">Todas</option>';
        for(j=48;j<=52;j++){
            option += '<option value="'+j+'_2014">';
            option += 'Semana'+j+'_2014';
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
        $("#semana").html(option);
    
        //grafica_barras(titulo,leyenda,categorias,series);
        grafica_tabla(titulo,subtitulo);
        $("#datatable").hide("fast");

        $("#semana").change(function(){
			//semana();
            var semanas = $("#semana").find("option:selected").val();
            //alert(semanas);
            if(semanas == '0'){
                window.setTimeout('location.reload()', 50);
            }
            else{
                semana();
            }
		});

        $("#categorias").change(function(){
            semana();   
        });
    });
</script>
<div class="container f_top_bot">
<br/><br/>
<div class="row">
    <div class="col-lg-3">
    	<label for="3">Semana:</label>
    	<select id="semana" name="semana" class="form-control">
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
</div>
<br />
<p>
    *El reporte de “promoción” te muestra un comparativo por “cadena” y  por “categoría”, de la sumatoria de promociones por “tipo de promoción”. Te permite seleccionar una semana puntual para la búsqueda.
</p>
<br/>
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<table id="datatable" style="z-index:1; display:none;">
    <thead>
        <tr>
            <th>Promocion</th>
            <!--<th>Activación</th>-->
            <th>Autoliquidable</th>
            <th>Bonificación de Producto</th>
            <th>Canje</th>
            <th>Concurso</th>
            <th>Descuento_en_Precio</th>
            <th>Emplaye</th>
            <th>In / On Pack</th>
            <th>Instant Win</th>
            <!--<th>Sampling</th>-->
        </tr>
    </thead>
    <tbody>    
    	<?php foreach ($promociones->result() as $promocion): ?>
    		<tr>
        		<td><?php echo $promocion->formato ?></td>
        		<!--<td><?php //echo $promocion->Activación ?></td>-->
        		<td><?php echo $promocion->Autoliquidable ?></td>
        		<td><?php echo $promocion->Bonificación_de_Producto ?></td>
        		<td><?php echo $promocion->Canje ?></td>
        		<td><?php echo $promocion->Concurso ?></td>
        		<td><?php echo $promocion->Descuento_en_Precio ?></td>
        		<td><?php echo $promocion->Emplaye ?></td>
        		<td><?php echo $promocion->In_On_Pack ?></td>
        		<td><?php echo $promocion->Instant_Win ?></td>
        		<!--<td><?php //echo $promocion->Sampling ?></td>-->
        	</tr>
        <?php endforeach; ?>
    </tbody>
</table>
<br/><br/>

</div>