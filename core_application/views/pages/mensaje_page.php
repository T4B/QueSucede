
<?php if($titulo == "" && $mensaje == ""){redirect('/');}?>

<div style="width:960px; margin: 0 auto; ">

	<div class="container f_top_bot" style="margin-bottom: 300px;">
	 
		<div class="row">
		  <div class="col-md-5 text-right">
			<?php if($imagen == "ok"): ?>
			<span class="glyphicon glyphicon-ok-sign icons_bigs"></span>
			<?php endif; ?>
			<?php if($imagen == "error"): ?>
			<span class="glyphicon glyphicon-remove-circle icons_bigs"></span>
			<?php endif;?>
			
			<?php if($imagen == "warning"): ?>
			<span class="glyphicon glyphicon-warning-sign icons_bigs"></span>
			<?php endif;?>
			
			<?php if($imagen == "message"): ?>
			<span class="glyphicon glyphicon-share-alt icons_bigs"></span>
			<?php endif;?>
		  </div>
		  <div class="col-md-7 mensajes_top">
		  <h1><?php echo $titulo;?></h1>
		  <h3><?php echo $mensaje; ?> </h3>
		  </div>
		</div>		
		
	</div> 
</div>    
	