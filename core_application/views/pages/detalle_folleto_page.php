

<div class="container f_top_bot"  style="margin-bottom:130px;">
    
    
    <div class="row">
        <div class="col-md-2">
            &nbsp;
        </div>
        <div class="col-md-4">
            <img src="<?php echo $AWS_BUCKET; ?>src_folletos/<?php echo $folleto->ruta . "/" . $folleto->img_folleto;?>">
            <br />
            <br />
            <h3>Periodo: <br />
                <?php echo $folleto->periodo; ?>
            </h3>
        </div>
        
        <div class="col-md-4">
            <div class="text-right">
                <a href="javascript:window.history.back();" class="btn btn-primary" style="">
                <span class="glyphicon glyphicon-chevron-left"></span>&nbsp;&nbsp;Regresar</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-12 text-center" style="margin-top: 20px;">
       <embed src="<?php echo $AWS_BUCKET . "src_folletos/" . $folleto->ruta . "/" .  $folleto->pdf; ?>" width="800" height="700"></embed>
       
    </div>
    
</div> <!-- /container -->