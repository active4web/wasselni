</head>
<?php

if( $lang == 'arabic'){$navbar="navbar-left";}else {$navbar="navbar-right";}
$curt = $this->uri->segment(3);
$main_curt=$this->uri->segment(1);
$controller_curt=$this->uri->segment(2);
$curt_id = $this->uri->segment(4);
$this->session->set_userdata(array('curt' => $curt));
$this->session->set_userdata(array('curt_id' => $curt_id));
  foreach($site_info as $site_info)
?>
	<body style="overflow-x: hidden;">
	<div class="header home top"   style="background: url(<?= DIR_DES_STYLE?>site_setting/<?= $site_info->header_image ?>)no-repeat center;background-size: 100% 100%;">
			<div class="overlay">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="sochal">
						<div class="dropdown">
						  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						  <?php echo lang('langauge'); ?>
							<span class="caret"></span>
						  </button>
						 <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						      <?php
						      if($controller_curt=="site"){
						      ?>
							<li><a href="<?= DIR?>site/lang_site/ar/"><?php echo lang('arabic'); ?></a></li>
							<li><a href="<?= DIR?>site/lang_site/en/"><?php echo lang('english'); ?></a></li>
							<?php } else {?>
								<li><a href="<?= DIR?>site/<?= $controller_curt?>/lang_site/ar/"><?php echo lang('arabic'); ?></a></li>
							<li><a href="<?= DIR?>site/<?= $controller_curt?>/lang_site/en/"><?php echo lang('english'); ?></a></li>
							<?php }?>
						  </ul>
						</div>
							<a href="<?= $site_info->facebook?>"  target="_blank"><i class="fa fa-facebook fa-lg"></i></a>
							<a href="<?= $site_info->instagram?>" target="_blank"><i class="fa fa-instagram fa-lg"></i></a>
							<a href="<?= $site_info->twitter?>" target="_blank"><i class="fa fa-twitter fa-lg"></i></a>

						</div>
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">	
						<div class="cont">
							
							<li><a href="tel:<?= $site_info->header_phone;?>" class="Blondie"><?= $site_info->header_phone?> <i class="fa fa-phone phonehead"></i></a></li> 
							<li><a href="mailto:<?= $site_info->header_email?>"><?= $site_info->header_email?> <i class="fa fa-envelope phonehead"></i></a></li>
						</div>	
					</div>	
				</div>
				
					
			</div>
			
			 <!--start navbar-->
				<nav class="navbar navbar-inverse "  id="nav-b" role="navigation">
					<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
						   <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#axit-nav" aria-expanded="false">
							 <span class="sr-only">Toggle navigation</span>
							 <span class="icon-bar"></span>
							 <span class="icon-bar"></span>
							 <span class="icon-bar"></span>
						   </button>
							<a class="navbar-brand" href="<?= base_url()?>site/">
							<img class="img-responsive center-block" src="<?= DIR_DES_STYLE?>site_setting/<?= $site_info->logo;?>"></a>
						</div>
						<div class="collapse navbar-collapse" id="axit-nav">
						   <ul class="nav navbar-nav <?= $navbar; ?>">
							<li class="<?php if( $curt == 'site'||$curt == ""){ echo 'active'; } ?>"><a href="<?= DIR ?>site/"><?php echo lang('home_page'); ?></a></li>
							<li class="<?php if( $curt == 'products' || $curt == 'products_details'){ echo 'active'; } ?>"><a href="<?= DIR ?>site/product/products"><?php echo lang('product_page'); ?></a></li>
							<li class="<?php if( $curt == 'team_work' || $curt == 'doctor_details'){ echo 'active'; } ?>"><a href="<?= DIR ?>site/doctors/team_work"><?php echo lang('team_page'); ?></a></li>
							<li class="<?php if( $curt == 'offers'|| $curt == 'offers_details'  ){ echo 'active'; } ?>"><a href="<?=DIR ?>site/offers/offers"><?php echo lang('offers_page'); ?></a></li>
							<li class="<?php if( $curt == 'bmi' ){ echo 'active'; } ?>"><a href="<?= DIR ?>site/pages/bmi"><?php echo lang('bmi_page'); ?></a></li>
							<li class="<?php if( $curt == 'success_stories'|| $curt == 'story_details' ){ echo 'active'; } ?>"><a href="<?= DIR ?>site/stories/success_stories"><?php echo lang('success_stories_page'); ?></a></li>
							<li class="<?php if( $curt == 'help' ){ echo 'active'; } ?>"><a href="<?= DIR ?>site/faq/help"><?php echo lang('faq_page'); ?></a></li>
							<li class="<?php if( $curt == 'contact' ){ echo 'active'; } ?>"><a href="<?= DIR ?>site/pages/contact"><?php echo lang('contact_page'); ?></a></li>





						   </ul>
						</div><!-- /.navbar-collapse -->
					</div><!-- /.container-fluid -->
				 </nav>

				<!--end navbar-->
						
					
				<!--start carousel-->
	  