<meta http-equiv="Content-type" content="text/html; charset=utf-8" />

<script src="<?php echo $ruta_js;?>highcharts.js"></script>
<script src="<?php echo $ruta_js;?>modules/data.js"></script>
<script src="<?php echo $ruta_js;?>modules/exporting.js"></script>
<script src="<?php echo $ruta_js;?>themes/cadenas.js"></script>
<script src="<?php echo $ruta_js;?>graficas.js"></script>

<script type="text/javascript">
	$(document).ready(function(){

		var titulo = 'Canales';
        var subtitulo = '';
		$("#datatablelineal").hide("fast");

		var i = 0;
        var option = '<option value="0">Todas</option>';
            //option += '<option value="00">Todas</option>';
        for(j=49;j<=52;j++){
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
        $("[id^='semana_']").html(option);


		
		grafica_lineal_tabla(titulo,subtitulo);

		$("#buscar").click(function(){

            var canal = $("#canales").find("option:selected").val();
            var semana_select_ini = $("#semana_ini").find("option:selected").val();
            var semana_select_fin = $("#semana_fin").find("option:selected").val();

            var canal_option = $("#canales :selected").text();

            var semana_ini = semana_select_ini.split('_')[0];
            var anio_ini = semana_select_ini.split('_')[1];
            var semana_fin = semana_select_fin.split('_')[0];
            var anio_fin = semana_select_fin.split('_')[1];

			var datos = {canal:canal,semana_ini:semana_ini,anio_ini:anio_ini,semana_fin:semana_fin,anio_fin:anio_fin};
			var mi_url = "<?php echo $ruta_app?>reportes/lineal_parametros";
  
            $.ajax({
                type: "POST",
                url: mi_url,
				dataType: 'json',
                cache: false,
				data: datos,
                success:function(response){
                	//alert(response.query);

                	var lineales = response.lineal;
                    //alert(lineales);
                    if(lineales == ''){
                        $("#lineal").html("<center><h1>No hay datos</h1></center>");
                        return false;
                    }
					$("#datatablelineal thead").html('');
                	$("#datatablelineal tbody").html('');

                    if(canal == '0'){
                        var tr_p = '<tr>';
                        tr_p += '<th></th>';
                        tr_p += '<th>7 Eleven</th>';
                        tr_p += '<th>Bodega Aurrera</th>';
                        tr_p += '<th>Casa Ley</th>';
                        tr_p += '<th>Chedraui</th>';
                        tr_p += '<th>Círculo K</th>';
                        tr_p += '<th>City Market</th>';
                        tr_p += '<th>Comercial Mexicana</th>';
                        tr_p += '<th>Extra</th>';
                        tr_p += '<th>Farmacia del Ahorro</th>';
                        tr_p += '<th>HEB</th>';
                        tr_p += '<th>Oxxo</th>';
                        tr_p += '<th>San Pablo</th>';
                        tr_p += '<th>Soriana</th>';
                        tr_p += '<th>Superama</th>';
                        tr_p += '<th>Walmart Supercenter</th>';
                        tr_p += '</tr>';

                        $("#datatablelineal thead").append(tr_p);

                        $.each(lineales, function(index){
                            var tr = '<tr>';
                            tr += '<td> Semana ' + lineales[index].semana + '_'+ lineales[index].anio +'</td>';
                            tr += '<td>' + lineales[index].Seven_Eleven + '</td>';
                            tr += '<td>' + lineales[index].Bodega_Aurrera + '</td>';
                            tr += '<td>' + lineales[index].Casa_Ley + '</td>';
                            tr += '<td>' + lineales[index].Chedraui + '</td>';
                            tr += '<td>' + lineales[index].Círculo_K + '</td>';
                            tr += '<td>' + lineales[index].City_Market + '</td>';
                            tr += '<td>' + lineales[index].Comercial_Mexicana + '</td>';
                            tr += '<td>' + lineales[index].Extra + '</td>';
                            tr += '<td>' + lineales[index].Farmacia_del_Ahorro + '</td>';
                            tr += '<td>' + lineales[index].HEB + '</td>';
                            tr += '<td>' + lineales[index].Oxxo + '</td>';
                            tr += '<td>' + lineales[index].San_Pablo     + '</td>';
                            tr += '<td>' + lineales[index].Soriana + '</td>';
                            tr += '<td>' + lineales[index].Superama + '</td>';
                            tr += '<td>' + lineales[index].Walmart_Supercenter + '</td>';
                            tr += '</tr>';
                            $("#datatablelineal tbody").append(tr);
                        });
                        grafica_lineal_tabla(titulo,canal_option);
                    }

                    if(canal == '1'){
                        var tr_p = '<tr>';
                        tr_p += '<th></th>';
                        tr_p += '<th>Bodega Aurrera</th>';
                        tr_p += '<th>Casa Ley</th>';
                        tr_p += '<th>Chedraui</th>';
                        tr_p += '<th>City Market</th>';
                        tr_p += '<th>Comercial Mexicana</th>';
                        tr_p += '<th>HEB</th>';
                        tr_p += '<th>Soriana</th>';
                        tr_p += '<th>Superama</th>';
                        tr_p += '<th>Walmart Supercenter</th>';
                        tr_p += '</tr>';
                        //alert(tr_p);
                        $("#datatablelineal thead").append(tr_p);

                        $.each(lineales, function(index){
                            var tr = '<tr>';
                            tr += '<td> Semana ' + lineales[index].semana + '_'+ lineales[index].anio +'</td>';                           
                            tr += '<td>' + lineales[index].Bodega_Aurrera + '</td>';
                            tr += '<td>' + lineales[index].Casa_Ley + '</td>';
                            tr += '<td>' + lineales[index].Chedraui + '</td>';
                            tr += '<td>' + lineales[index].City_Market + '</td>';
                            tr += '<td>' + lineales[index].Comercial_Mexicana + '</td>';
                            tr += '<td>' + lineales[index].HEB + '</td>';
                            tr += '<td>' + lineales[index].Soriana + '</td>';
                            tr += '<td>' + lineales[index].Superama + '</td>';
                            tr += '<td>' + lineales[index].Walmart_Supercenter + '</td>';
                            tr += '</tr>';
                            $("#datatablelineal tbody").append(tr);
                        });
                        grafica_lineal_tabla(titulo,canal_option);

                    }
                    else if(canal == 3){
                        var tr_p = '<tr>';
                        tr_p += '<th></th>';
                        tr_p += '<th>7 Eleven</th>';
                        tr_p += '<th>Círculo K</th>';
                        tr_p += '<th>Extra</th>';
                        tr_p += '<th>Oxxo</th>';
                        tr_p += '</tr>';
                        //alert(tr_p);
                        $("#datatablelineal thead").append(tr_p);

                        $.each(lineales, function(index){
                            var tr = '<tr>';
                            tr += '<td> Semana ' + lineales[index].semana + '_'+ lineales[index].anio +'</td>';                           
                            tr += '<td>' + lineales[index].Seven_Eleven + '</td>';
                            tr += '<td>' + lineales[index].Círculo_K + '</td>';
                            tr += '<td>' + lineales[index].Extra + '</td>';
                            tr += '<td>' + lineales[index].Oxxo + '</td>';
                            tr += '</tr>';
                            $("#datatablelineal tbody").append(tr);
                        });
                        grafica_lineal_tabla(titulo,canal_option);

                    }
                    else if(canal == 4){
                        var tr_p = '<tr>';
                        tr_p += '<th></th>';
                        tr_p += '<th>Farmacia del Ahorro</th>';
                        tr_p += '<th>San Pablo</th>';
                        tr_p += '</tr>';
                        //alert(tr_p);
                        $("#datatablelineal thead").append(tr_p);

                        $.each(lineales, function(index){
                            var tr = '<tr>';
                            tr += '<td> Semana ' + lineales[index].semana + '_'+ lineales[index].anio +'</td>';                           
                            tr += '<td>' + lineales[index].Farmacia_del_Ahorro + '</td>';
                            tr += '<td>' + lineales[index].San_Pablo + '</td>';
                            tr += '</tr>';
                            $("#datatablelineal tbody").append(tr);
                        });
                        grafica_lineal_tabla(titulo,canal_option);
                    }

                },
                error:function(){
					alert("error de comunicacion");
			    }
            });

            //$("")


			/*$("[id^='semana_'] , #canales").change(function(){
				//semana();
	            var canales = $("#canales").find("option:selected").val();
                var semanas = $("[id^='semana_']").find("option:selected").val();
	            //alert(semanas);
	            if(canales == '0'){
	                window.setTimeout('location.reload()', 50);
	            }
                if(semanas == '0'){
                    window.setTimeout('location.reload()', 50);
                }
			});*/

		});


	});
</script>

<div class="container f_top_bot">
<br/><br/>
<div class="row">
    <div class="col-lg-3">
        <label for="3">Canales:</label>
        <select id="canales" name="canales" class="form-control">
            <option value="0">Todas</option>
            <?php   foreach ($canales->result() as $canal): ?>
                <option value = "<?php echo $canal->id_canal;?>"><?php echo $canal->nombre_canal; ?></option>
            <?php endforeach; ?>
        </select>   
    </div>

    <div class="col-lg-3">
    	<label for="3">Semana Inicial:</label>
    	<select id="semana_ini" name="semana_ini" class="form-control">
    	</select>	
    </div>
    <div class="col-lg-3">
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
    *El reporte “línea de tiempo”  te muestra el conteo de la sumatoria de las promociones por cadena, en un lapso de tiempo. De esta manera puedes comparar semana por semana que está pasando el punto de venta.
</p>
<br/>
<br/>
<div id="lineal" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<table id="datatablelineal" style="z-index:1; display:none;">
    <thead>
        <tr>
        	<th></th>
            <th>7 Eleven</th>
            <th>Bodega Aurrera</th>
            <th>Casa Ley</th>
            <th>Chedraui</th>
            <th>Círculo K</th>
            <th>City Market</th>
            <th>Comercial Mexicana</th>
            <th>Extra</th>
            <th>Farmacia del Ahorro</th>
            <th>HEB</th>
            <th>Oxxo</th>
            <th>San Pablo</th>
            <th>Soriana</th>
            <th>Superama</th>
            <th>Walmart Supercenter</th>
        </tr>
    </thead>
    <tbody>    
    	<?php foreach ($lineales->result() as $lineal): ?>
    		<tr>
        		<td><?php echo 'Semana '.$lineal->semana.'_'.$lineal->anio ?></td>
                <td><?php echo $lineal->Seven_Eleven ?></td>
        		<td><?php echo $lineal->Bodega_Aurrera ?></td>
                <td><?php echo $lineal->Casa_Ley ?></td>
        		<td><?php echo $lineal->Chedraui ?></td>
                <td><?php echo $lineal->Círculo_K ?></td>
                <td><?php echo $lineal->City_Market ?></td>
        		<td><?php echo $lineal->Comercial_Mexicana ?></td>
                <td><?php echo $lineal->Extra ?></td>
                <td><?php echo $lineal->Farmacia_del_Ahorro ?></td>
                <td><?php echo $lineal->HEB ?></td>
                <td><?php echo $lineal->Oxxo ?></td>
                <td><?php echo $lineal->San_Pablo ?></td>
        		<td><?php echo $lineal->Soriana ?></td>
        		<td><?php echo $lineal->Superama ?></td>
        		<td><?php echo $lineal->Walmart_Supercenter ?></td>
        	</tr>
        <?php endforeach; ?>
    </tbody>
</table>
<br/><br/>
</div>
