<script type="text/javascript">
    
    alert("Archivo correcto. Seleccionalo de nuevo para cargar en base de datos.");
    
    function validar_archivo() {
            var archivo = $("#datafile").val();
            if( archivo == "" ) {
                alert("Debes elegir un achivo");
            }else{
                $("#form_validar").submit();
            }
    }
</script>

<div class="container f_top_bot">
	<div style=" width: 650px; height: auto; margin: 0 auto;" class="f_top_bot">
	<div class="row">
	    <div class="col-md-6 thumbnail">
		    <label>Subir archivo</label>
		    <form method="POST" id="form_validar" action="<?php echo base_url() ?>admin/upload_promos" enctype="multipart/form-data" class="custom">
			Selecciona archivo:<br />
			<input id="datafile" type="file" name="datafile" size="40">
		    </form>
		    <br />
		    <a href="javascript:validar_archivo();" class="btn btn-primary">&nbsp;&nbsp;&nbsp;Enviar&nbsp;&nbsp;&nbsp;</a>
	    </div>
	    <div class="col-md-6 thumbnail">
		Admin
	    </div>
	</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-12 text-center ">
			<a href="<?php echo $ruta_app?>admin" class="btn btn-primary">&nbsp;&nbsp;&nbsp;Volver&nbsp;&nbsp;&nbsp;</a>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-6 ">
			&nbsp;
		</div>
	</div>
</div>