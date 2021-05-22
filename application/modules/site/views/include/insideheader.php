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

	<body style="overflow-x: hidden;"  >
		<div class="header home top abo"  style="background: url(<?= DIR_DES_STYLE?>site_setting/<?= $site_info->header_image ?>)no-repeat center;background-size: 100% 100%;">
			<div class="overlay ">
			<div class="container">
				<div class="row">
				<div class="col-md-6 col-sm-6 col-xs-12">	
						<div class="cont">
							<li><i class="fas fa-map-marker-alt"></i>
<?php echo ( $lang == 'arabic' )?$site_info->address_ar: $site_info->address_eng ; ?>
</li>
							<li><i class="fa fa-phone phone"></i><?= $site_info->header_phone?></li>
						</div>	
					</div>	
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="sochal">
						
<a href="<?= $site_info->instagram?>" target="_blank">
    <i class="fab fa-linkedin-in fa-lg"></i></i></a>
<a href="<?= $site_info->facebook?>" target="blank">
    <i class="fab fa-facebook-f fa-lg"></i></a>
<a href="<?= $site_info->twitter?>" target="_blank">
    <i class="fab fa-twitter fa-lg"></i></a>
    
					<div class="dropdown">
						  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						  <?= lang('langauge'); ?>
							<span class="caret"></span>
						  </button>
						   <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						      <?php
						      if($controller_curt=="site"){
						      ?>
							<li><a href="<?= DIR?>site/lang_site/ar/"><?= lang('arabic'); ?></a></li>
							<li><a href="<?= DIR?>site/lang_site/en/"><?= lang('english'); ?></a></li>
							<?php } else {?>
								<li><a href="<?= DIR?>site/<?= $controller_curt?>/lang_site/ar/"><?= lang('arabic'); ?></a></li>
							<li><a href="<?= DIR?>site/<?= $controller_curt?>/lang_site/en/"><?= lang('english'); ?></a></li>
							<?php }?>
						  </ul>
						</div>

						</div>
						<div class="download">
<li><a href="<?=DIR?>uploads/site_setting/<?=$site_info->pdf;?>" target="_blank"><i class="fas fa-file-download fa-lg"></i><?= lang('download_file'); ?></li></a>
						</div>
					</div>
					
				</div>
				
					
			</div>
			
			<nav class="navbar navbar-inverse "  role="navigation">
					<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
						   <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#axit-nav" aria-expanded="false">
							 <span class="sr-only">Toggle navigation</span>
							 <span class="icon-bar"></span>
							 <span class="icon-bar"></span>
							 <span class="icon-bar"></span>
						   </button>
							<a class="navbar-brand" href="<?= DIR ?>site"><img class="img-responsive center-block" src="<?= DIR_DES_STYLE?>site_setting/<?= $site_info->logo;?>"></a>
						</div>
						<div class="collapse navbar-collapse" id="axit-nav">
						   <ul class="nav navbar-nav <?= $navbar; ?>">
	
<li class="<?php if( $curt == 'site'||$curt == ""||$curt == "regulations"){ echo 'active'; } ?>">
<a href="<?= DIR ?>site/"><?php echo lang('home_page'); ?></a></li>
<li class="dropdown <?php if( $curt == 'about'||$curt == 'our_clients'){ echo 'active'; } ?>">
							  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							      <?= lang('about_quser'); ?>
							  <span class="caret"></span></a>
							  <ul class="dropdown-menu">
<li class=""><a href="<?= DIR ?>site/pages/about"><?= lang('about_page'); ?></a></li>
<li class=""><a href="<?= DIR ?>site/clients"><?= lang('clients'); ?></a></li>
							  </ul>
							</li>
<li <?php if($curt == 'our_services'||$curt == 'details_services'){?>class='active'<?php }?>><a href="<?= DIR ?>site/services"><?= lang('services'); ?></a></li>
<li <?php if($curt == 'our_team'){?>class='active'<?php }?>><a href="<?= DIR ?>site/teamwork"><?= lang('teamwork'); ?></a></li>
<li <?php if($curt == 'international'){?>class='active'<?php }?>><a href="<?= DIR ?>site/pages/international"><?= lang('international_page'); ?></a></li>
<li <?php if($curt == 'highlights'){?>class='active'<?php }?>><a href="<?= DIR ?>site/pages/highlights"><?= lang('achievements_page'); ?></a></li>
<li <?php if($curt == 'systems_regulations'){?>class='active'<?php }?>><a href="<?= DIR ?>site/system"><?= lang('system_page'); ?></a></li>
<li <?php if($curt == 'job_form'){?>class='active'<?php }?>><a href="<?= DIR ?>site/jobs"><?= lang('job_page'); ?> </a></li>
<li <?php if($curt == 'contact'){?>class='active'<?php }?>><a href="<?= DIR ?>site/pages/contact"><?= lang('contact_page'); ?> </a></li>

						   </ul>
						</div><!-- /.navbar-collapse -->
					</div><!-- /.container-fluid -->
				 </nav>
				<!--end navbar-->
