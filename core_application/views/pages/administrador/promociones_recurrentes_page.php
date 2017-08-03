<script type="text/javascript">
    
    function limpiar_campos_recurrente() {
        $('#formato_recurrente, #ubicacion_recurrente, #estado_recurrente, #semana_recurrente, #activa_recurrente, #anio_recurrente')
        .find('option').attr('selected', false);
        $('#precio_recurrente').val('');
        $('#form_recurrente').find('div[id$="_error"]').hide().html('');
    }
    
    function editar_recurrente(id) {
        $('#id_promocion_recurrente').val(id);
        $('#modal_recurrente').modal();
    }
    
    function agregar_recurrente(){
        var flag_ok = false;
        
        flag_ok = validar_form('form_recurrente');
        
        if(flag_ok){
            var url = '<?php echo $ruta_app;?>administrador/guardar_recurrente';
            var datos = $('#form_recurrente').serialize();
            
            $.ajax({
                url:url,
                type:'post',
                dataType:'json',
                data:datos,
                success:function(response){
                    alert(response.codigo);
                },
                error:function(){
                    alert('Error');
                }
            });
            //$('#form_recurrente').submit();
        }
    }
    
    function filtrar_todos(){
        var criterio = $.trim($("#criterio").val());
        var url = '<?php echo $ruta_app;?>administrador/obtener_promociones';
        
        $.ajax({
            url:url,
            type:'post',
            dataType:'json',
            data:{criterio:criterio},
            success:function(response){
                $('#tabla_promo tbody tr').remove();
                var tbody = $('#tabla_promo tbody');
                if (response.codigo == 0) {
                    var promociones = response.promociones;
                    $.each(promociones, function(index){
                        var promocion = promociones[index];
                        var tr = $('<tr>');
                        var td_id = $('<td>');
                        td_id.html(promocion.id_promocion);
                        tr.append(td_id);
                        var td_descripcion = $('<td>');
                        td_descripcion.html(promocion.descripcion);
                        tr.append(td_descripcion);
                        
                        var string_liga = '<a href="javascript:editar_recurrente('+promocion.id_promocion+');">Editar</a>';
                        var td_liga = $('<td>');
                        td_liga.html(string_liga);
                        tr.append(td_liga);
                        
                        tbody.append(tr);
                    });
                }else{
                    alert('No se encontraron coincidencias');
                }
            },
            error:function(){
                alert('Errorrrrrr');
            }
        });
        
        /*
        $("#tabla_promo tbody tr").show();
        
        if (criterio != '') {
            $("#tabla_promo tbody tr").each(function(){
                var tr = $(this);
                if (tr.is(':visible')) {
                    var criterio_ok = false;
                    var contenido = tr.html().toUpperCase();
                    if (contenido.indexOf(criterio) >= 0){
                        criterio_ok = true;
                    }
                    
                    if (!criterio_ok) {
                        tr.hide();
                    }
                }
                
            });
        }
        */
    }
    
    $(document).ready(function(){
        $('#criterio').keyup(function(event){
            var keycode = event.keyCode ? event.keyCode : event.which;
            
            if (keycode == 13) {
                filtrar_todos();
            }
        });
        
        $('#modal_recurrente').on('hidden.bs.modal', function (e) {
            limpiar_campos_recurrente();
        })
    });
</script>

<div class="container f_top_bot">
    <div style=" width: 900px; height: auto; margin: 0 auto;" class="f_top_bot">
        <div id="content" class="thumbnail">
            <div class="form-group">
            <label for="formato">Filtrar:</label>
            <div style="width:500px;">
                <input type="text" id="criterio" placeholder="Descripción" class="form-control">
            </div>
            
            </div>
            <table id="tabla_promo">
                <thead>
                    <th>
                        ID
                    </th>
                    <th>
                        Descripción
                    </th>
                </thead>
                <tbody>
                <?php foreach($promociones->result() as $promocion):?>
                <tr>
                    <td>
                        <?php echo $promocion->id_promocion;?>
                    </td>
                    <td>
                        <?php echo $promocion->descripcion;?>
                    </td>
                    <td>
                        <a href="javascript:editar_recurrente(<?php echo $promocion->id_promocion;?>);">Editar</a>
                    </td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>
            
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal_recurrente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="form_recurrente" method="post" action="<?php echo $ruta_app;?>administrador/guardar_recurrente">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <br>
                <h4 class="modal-title">Agregar recurrente</h4>
            </div>
            <input type="hidden" id="id_promocion_recurrente" name="id_promocion_recurrente"/>
            <div class="modal-body">
                <!--CONTENIDO-->
                <div class="col-md-6 text-center">
                    Formato:
                    <select id="formato_recurrente" name="formato_recurrente" class="combo">
                        <option value="">--Selecciona--</option>
                        <?php foreach($formatos->result() as $formato):?>
                        <option value="<?php echo $formato->id_formato;?>"><?php echo $formato->nombre_formato;?></option>
                        <?php endforeach;?>
                    </select>
                    <div id="formato_recurrente_error" class="m_error" style="display: none;"></div><br>
                </div>
                <div class="col-md-6 text-center">
                    Ubicación:
                    <select id="ubicacion_recurrente" name="ubicacion_recurrente" class="combo">
                        <option value="">--Selecciona--</option>
                        <?php foreach($ubicaciones->result() as $ubicacion):?>
                        <option value="<?php echo $ubicacion->id_ubicacion;?>"><?php echo $ubicacion->nombre_ubicacion;?></option>
                        <?php endforeach;?>
                    </select>
                    <div id="ubicacion_recurrente_error" class="m_error" style="display: none;"></div><br>
                </div>
                <div class="clear"></div>
                <br /><br />
                <div class="col-md-6 text-center">
                    Estado:
                    <select id="estado_recurrente" name="estado_recurrente" class="combo">
                        <option value="">--Selecciona--</option>
                        <?php foreach($estados->result() as $estado):?>
                        <option value="<?php echo $estado->id_estado;?>"><?php echo $estado->nombre_estado;?></option>
                        <?php endforeach;?>
                    </select>
                    <div id="estado_recurrente_error" class="m_error" style="display: none;"></div><br>
                </div>
                <div class="col-md-6 text-center">
                    Semana:
                    <select id="semana_recurrente" name="semana_recurrente" class="combo">
                        <option value="">--Selecciona--</option>
                        <?php for($i = 1; $i <= 52; $i++):?>
                        <option value="<?php echo $i;?>"><?php echo $i;?></option>
                        <?php endfor;?>
                    </select>
                    <div id="semana_recurrente_error" class="m_error" style="display: none;"></div><br>
                </div>
                <div class="clear"></div>
                <br /><br />
                <div class="col-md-6 text-center">
                    Activa:
                    <select id="activa_recurrente" name="activa_recurrente" class="combo">
                        <option value="">--Selecciona--</option>
                        <option value="1">SI</option>
                        <option value="0">NO</option>
                    </select>
                    <div id="activa_recurrente_error" class="m_error" style="display: none;"></div><br>
                </div>
                <div class="col-md-6 text-center">
                    Precio:
                    <input type="text" id="precio_recurrente" name="precio_recurrente" class="type_decimal required" />
                    <div id="precio_recurrente_error" class="m_error" style="display: none;"></div><br>
                </div>
                <div class="clear"></div>
                <br /><br />
                <div class="col-md-6 text-center">
                    Año:
                    <select id="anio_recurrente" name="anio_recurrente" class="combo">
                        <option value="">--Selecciona--</option>
                        <option value="<?php echo $anio;?>"><?php echo $anio;?></option>
                        <option value="<?php echo $anio_anterior;?>"><?php echo $anio_anterior;?></option>
                    </select>
                    <div id="anio_recurrente_error" class="m_error" style="display: none;"></div><br>
                </div>
                <div class="col-md-6 text-center">
                    <br/>&nbsp;<br />
                </div>
                <div class="clear"><br /></div>
                
                <br /><br /><br />
                <div class="col-md-12 text-center">
                    <a href="javascript:agregar_recurrente();" class="btn btn-primary">
                        &nbsp;&nbsp;&nbsp;Aceptar&nbsp;&nbsp;&nbsp;
                    </a>
                </div>
            </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog --> 
</div><!-- /.modal -->
<!-- Modal -->