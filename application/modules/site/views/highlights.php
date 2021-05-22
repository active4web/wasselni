<?php 
	foreach($site_info as $siteinfo)
	?>
<div class="container">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-6">
							<div class="title">
								<h3><?= lang("achievements_page");?></h3>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<ol class="breadcrumb text-center">
							  <li><a href="<?= DIR?>site/"><?= lang("home_page");?></a></li>
							  <li class="active"><a href="#"><?= lang("achievements_page");?></a></li>
							</ol>	
						</div>
					</div>
				</div>		
				<div class="clearfix"></div>
			</div>
		</div>
			<div class="trin three hidden-xs hidden-sm">
			</div>			
			</div>
        </div>

        <div class="wrapper">
			<div class="container">
				<div class="row">
					<div class="performance">
						<div class="col-md-8 col-sm-12 colxs-12">
							<ul class="timeline">
<?php
if(count($achievements_text)>0){
    foreach($achievements_text as $achievements_text){
?>
<li>
<p>
<?php echo ( $lang == 'arabic' )?$achievements_text->details_ar: $achievements_text->details ; ?> 

</p>
</li>
<?php  } } ?>

							</ul>
						</div>
						<div class="col-md-4 col-sm-4 hidden-xs hidden-sm">
						<div class="formance">
						
							<div class="pic">
                                <?php
                                if($siteinfo->main_img!=""){
                                ?>
                                <img class="img-responsive" src="<?= DIR_DES_STYLE ?>site_setting/<?= $siteinfo->main_img?>">
                                <?php }?>
								<div class="perf">
								<div class="overlay">
								</div>
								</div>
							
							</div>
						</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div>