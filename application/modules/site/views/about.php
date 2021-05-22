	<!--end navbar-->
	<?php 
	foreach($site_info as $siteinfo)
	?>

<div class="container">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-6">
							<div class="title">
								<h3><?= lang("about_page");?></h3>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<ol class="breadcrumb text-center">
							  <li><a href="<?= DIR?>site/"><?= lang("home_page");?></a></li>
							  <li class="active"><a href="#"><?= lang("about_page");?></a></li>
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
			
			<div class="about two">
				<div class="container">
							<div class="col-md-6 col-sm-6 col-xs-12 hidden-xs">
								<div class="pic">
								<img class="img-responsive" src="<?= DIR_DES_STYLE ?>site_setting/<?= $siteinfo->about_img?>">
									<div class="bg-pic">
										
									</div>
								</div>	
								
							</div>	
							<div class="col-md-6 col-sm-6 col-xs-12 hidden-md hidden-lg hidden-sm pic1 text-center">
						<img class="img-responsive" src="<?= DIR_DES_STYLE ?>site_setting/<?= $siteinfo->about_img?>">
					</div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<h3 class="hed-border"><?php echo lang('about_page'); ?></h3>
								<p>
								<?php echo ( $lang == 'arabic' )?$siteinfo->about_site_ar: $siteinfo->about_site ; ?>
								</p>

							</div>	
						</div>
					
					</div>
						<div class="clearfix"></div>
					<div class="vision ">
						<div class="container">
								<div class="col-md-6 col-sm-7 col-xs-12 vis-text ">
								<div class="">
									<h3 class="hed-border"><?= lang("about_Vision");?></h3>
									<p>
								<?php echo ( $lang == 'arabic' )?$siteinfo->vision_site_ar: $siteinfo->vision_site ; ?>
								</p>

								</div>
								</div>
								<div class="col-md-6 col-sm-5 col-xs-12">
									<div class="<?php echo ( $lang == 'arabic' )?"left-pic":"left-pic1" ?>">
										<img class="img-responsive" src="<?= DIR_DES_STYLE ?>site_setting/<?= $siteinfo->vision_img?>">
									</div>
								</div>
						</div>	

					</div>
				
				</div>
				<div class="clearfix"></div>
		