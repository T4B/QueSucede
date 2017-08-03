<script type="text/javascript">
    function validar_promocion() {
        var flag_ok = false;
        flag_ok = validar_form('form_promocion');
        if (flag_ok) {
            $("#form_promocion").submit();
        }
    }
    
    <?php
        $mensaje = $this->session->flashdata('mensaje');
        if($mensaje):
    ?>
    var mensaje = '<?php echo $mensaje;?>';
    alert(mensaje);
    <?php endif; ?>
    $(document).ready(function(){
        $('.date').datepicker({
            dateFormat: 'yy/mm/dd'
        });
        
        $("input[name='vigencia']").click(function(){
            var valor = $(this).val();
            $('.div_SI, .div_NO').hide();
            $('.div_'+valor).show();
        });
    });
</script>

<div class="container f_top_bot">
    <div style=" width: 650px; height: auto; margin: 0 auto;" class="f_top_bot">
        <div id="content" class="thumbnail">
            <form class="formee" role="form" id="form_promocion" action="<?php echo $ruta_app;?>administrador/guardar_promocion" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="formato">Formato:</label>
                    <select id="formato" name="formato" class="form-control combo">
                        <option value="">--Selecciona--</option>
                        <?php foreach($formatos->result() as $formato):?>
                        <option value="<?php echo $formato->id_formato;?>">
                            <?php echo $formato->nombre_formato;?>
                        </option>
                        <?php endforeach;?>
                    </select>
                    <div id="formato_error" class="m_error" style="display: none;"></div><br>
                </div>
                
                
                <div class="form-group">
                    <label for="formato">Estado:</label>
                    <select id="estado" name="estado" class="form-control combo">
                        <option value="">--Selecciona--</option>
                        <?php foreach($estados->result() as $estado):?>
                        <option value="<?php echo $estado->id_estado;?>">
                            <?php echo $estado->nombre_estado;?>
                        </option>
                        <?php endforeach;?>
                    </select>
                    <div id="estado_error" class="m_error" style="display: none;"></div><br>
                </div>
                
                
                <div class="form-group">
                    <label for="subcategoria">Subcategoría:</label>
                    <select id="subcategoria" name="subcategoria" class="form-control combo">
                        <option value="">--Selecciona--</option>
                        <?php foreach($subcategorias->result() as $subcategoria):?>
                        <option value="<?php echo $subcategoria->id_subcategoria;?>">
                            <?php echo $subcategoria->nombre_subcategoria;?>
                        </option>
                        <?php endforeach;?>
                    </select>
                    <div id="subcategoria_error" class="m_error" style="display: none;"></div><br>
                </div>
                <div class="form-group">
                    <label for="marca">Marca:</label>
                    <select id="marca" name="marca" class="form-control combo">
                        <option value="">--Selecciona--</option>
                        <?php foreach($marcas->result() as $marca):?>
                        <option value="<?php echo $marca->id_marca;?>">
                            <?php echo $marca->nombre_marca;?>
                        </option>
                        <?php endforeach;?>
                    </select>
                    <div id="marca_error" class="m_error" style="display: none;"></div><br>
                </div>
                <div class="form-group">
                  <label for="precio">Precio:</label>
                  <input type="text" name="precio" id="precio" placeholder="Precio" class="form-control type_decimal required">
                    <div id="precio_error" class="m_error" style="display: none;"></div><br>
                </div>
                
                <div class="form-group">
                    <label for="ubicacion">Ubicación:</label>
                    <select id="ubicacion" name="ubicacion" class="form-control combo">
                        <option value="">--Selecciona--</option>
                        <?php foreach($ubicaciones->result() as $ubicacion):?>
                        <option value="<?php echo $ubicacion->id_ubicacion;?>">
                            <?php echo $ubicacion->nombre_ubicacion;?>
                        </option>
                        <?php endforeach;?>
                    </select>
                    <div id="ubicacion_error" class="m_error" style="display: none;"></div><br>
                </div>
                
                <div class="form-group">
                    <label for="titulo">Producto</label>
                    <input type="text" class="form-control type_generic required" name="producto" id="producto"
                           placeholder="Producto">
                    <div id="producto_error" class="m_error" style="display: none;"></div><br>
                </div>
                
                <div class="form-group">
                    <label for="titulo">Título</label>
                    <input type="text" class="form-control type_generic required" name="titulo" id="titulo"
                           placeholder="Título">
                    <div id="titulo_error" class="m_error" style="display: none;"></div><br>
                </div>
                
                <div class="form-group">
                    <label for="tipo_promocion">Tipo de promoción:</label>
                    <select id="tipo_promocion" name="tipo_promocion" class="form-control combo">
                        <option value="">--Selecciona--</option>
                        <?php foreach($tipos_promocion->result() as $tipo_promocion):?>
                        <option value="<?php echo $tipo_promocion->id_tipo_promocion;?>">
                            <?php echo $tipo_promocion->nombre_tipo_promocion;?>
                        </option>
                        <?php endforeach;?>
                    </select>
                    <div id="tipo_promocion_error" class="m_error" style="display: none;"></div><br>
                </div>
                
                
                <div class="form-group">
                    <label for="">¿Tiene vigencia?</label>
                </div>
                
                <div class="radio">
                    <label>
                      <input type="radio" name="vigencia" id="vigencia_no" value="NO" checked>
                      No
                    </label>
                </div>
                
                <div class="form-group div_NO">
                    <label for="desc_vigencia">Vigencia:</label>
                    <input type="text" class="form-control type_generic required" name="desc_vigencia" id="desc_vigencia"
                           placeholder="Vigencia">
                    <div id="desc_vigencia_error" class="m_error" style="display: none;"></div><br>
                </div>
                
                <div class="radio">
                    <label>
                        <input type="radio" name="vigencia" id="vigencia_si" value="SI" >
                        Sí
                    </label>
                </div>
                
                <div class="form-group div_SI" style="display: none;">
                    <label for="titulo">Fecha inicio:</label>
                    <input type="text" class="form-control type_generic required date" name="fecha_inicio" id="fecha_inicio">
                    <div id="fecha_inicio_error" class="m_error" style="display: none;"></div><br>
                </div>
                
                <div class="form-group div_SI" style="display: none;">
                    <label for="fecha_fin">Fecha fin:</label>
                    <input type="text" class="form-control type_generic required date" name="fecha_fin" id="fecha_fin">
                    <div id="fecha_fin_error" class="m_error" style="display: none;"></div><br>
                </div>
                
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <input type="text" class="form-control type_generic required" name="descripcion" id="descripcion"
                           placeholder="Descipción">
                    <div id="descripcion_error" class="m_error" style="display: none;"></div><br>
                </div>
                
                <div class="form-group">
                    <label for="mecanica">Mecánica</label>
                    <input type="text" class="form-control type_generic required" name="mecanica" id="mecanica"
                           placeholder="Mecánica">
                    <div id="mecanica_error" class="m_error" style="display: none;"></div><br>
                </div>
                
                <div class="form-group">
                    <label for="regalo">Regalo</label>
                    <input type="text" class="form-control type_generic required" name="regalo" id="regalo"
                           placeholder="Regalo">
                    <div id="regalo_error" class="m_error" style="display: none;"></div><br>
                </div>
                
                <div class="form-group">
                    <label for="foto">Foto</label>
                    <input type="file" id="foto" name="foto" class="form-control type_file required">
                    <div id="foto_error" class="m_error" style="display: none;"></div><br>
                </div>
                
                <a href="javascript:validar_promocion();" class="btn btn-primary">Aceptar</a>
            </form>
        </div>
    </div>
</div>