	<!--end navbar-->
	<?php 
	foreach($site_info as $siteinfo)
	?>

<div class="container">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-6">
							<div class="title">
								<h3><?= lang("international_page");?></h3>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<ol class="breadcrumb text-center">
							  <li><a href="<?= DIR?>site/"><?= lang("home_page");?></a></li>
							  <li class="active"><a href="#"><?= lang("international_page");?></a></li>
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
			
		
						<div class="clearfix"></div>
						<div class="wrapper">
				<div class="international">
			<div class="container">
				<div class="col-md-6 col-sm-6 col-xs-12 ">
					<img class="img-responsive" src="<?= DIR_DES_STYLE ?>site_setting/<?= $siteinfo->International_cooperation_img?>">
				</div>
				<div class="col-md-6 col-sm-6 col-xs-12 tex ">
					<h3 class="hed-border"><?= lang("international_page");?></h3>
                    <?php echo ( $lang == 'arabic' )?$siteinfo->International_cooperation_ar: $siteinfo->International_cooperation_en ; ?>
				</div>
				<div class="clearfix"></div>
				</div>
				
		</div>
		</div>
				
				</div>
				<div class="clearfix"></div>
		