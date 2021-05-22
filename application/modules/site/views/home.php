<?php
	foreach($siteinfo as $siteinfo)
	foreach($home_page as $home_page)
	?>
	<div class="wrapper">
		<div class="trin one hidden-xs hidden-sm">
			</div>
			<div class="about">
				<div class="container">

					<div class="col-md-6 col-sm-6 col-xs-12 hidden-xs">
						<div class="pic">
						<img class="img-responsive" src="<?= DIR?>uploads/site_setting/<?=$home_page->breif_img?>">
							<div class="bg-pic">
								
							</div>
						</div>	
						
					</div>	
					<div class="col-md-6 col-sm-6 col-xs-12 hidden-md hidden-lg hidden-sm pic1 text-center">
						<img class="img-responsive" src="<?= DIR?>uploads/site_setting/<?=$home_page->breif_img?>">
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<h3 class="hed-border"><?= lang("about_page");?></h3>
						<p>
			<?php echo ($lang == 'arabic')?$home_page->breif_txt_ar:$home_page->breif_txt_eng ;?>
						</p>
						<a class="more" href="<?= DIR?>site/pages/about"><?=lang("read_more");?></a>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="servess ">
				<div class="overlay">
					<h3 class="hed-border"><?=lang("services");?></h3>
					
						<div class="clearfix"></div>
						<?php
						if(count($our_services)>0){
							foreach($our_services as $our_services){
						?>
					<div class="serves">
					
					<a href="<?=DIR?>site/services/details_services/<?= $our_services->id?>" >
					<?php
					if($our_services->img!=""){
					?>
						<img class="img-responsive" src="<?= DIR_DES_STYLE ?>products/<?= $our_services->img?>">
					<?php } else {?>
						<img class="img-responsive" src="<?= DIR_DES_STYLE ?>products/4.jpg">
					<?php }?>
						<div class="mask">
							<div class="box">
								<h5 class="hed-border"> 
								<?php 
if($lang == 'arabic'){
    if(strlen($our_services->title_ar)>60){	echo mb_substr($our_services->title_ar,0,60)."...";}
    else {echo mb_substr($our_services->title_ar,0,60);}
}
else {
if(strlen($our_services->title_eng)>60){	echo mb_substr($our_services->title_eng,0,60)."...";}
    else {echo mb_substr($our_services->title_eng,0,60);}    
}
?>
								</h5>
							</div>
						</div></a>
					</div>
					<?php } ?>
						<?php }?>

					<div class="clearfix"></div>
				</div>
				
			</div>	
			<div class="teams">
				<div class="trin hidden-xs hidden-sm ">
				</div>
				<div class="container">
						<div class="col-md-5 col-sm-12 col-xs-12 ">
							<h3 class="hed-border"><?= lang("teamwork");?></h3>
									<p>
									<?php echo ($lang == 'arabic')?$siteinfo->team_work_intro_ar:$siteinfo->team_work_intro_en ;?>
									 </p>
								
								
								
							
						</div>
						<div class="col-md-7 col-sm-12 col-xs-12 ">
							<div id="owl-example" class="owl-carousel " style="direction:ltr">
							<?php
							if(count($team_work)>0){
								foreach($team_work as $team_work){
								$jobtype_id=$team_work->jobtype_id;
							$title_name_ar=get_table_filed("job_type",array("id"=>$jobtype_id),"name_ar");
							$title_name_en=get_table_filed("job_type",array("id"=>$jobtype_id),"name_en");
							?>
								<div class="item tea ">
									<div class="team"><div>
										<h4>
<?php 
if($lang == 'arabic'){
    if(strlen($team_work->title_ar)>80){	echo mb_substr($team_work->title_ar,0,80)."...";}
    else {echo mb_substr($team_work->title_ar,0,80);}
}
else {
if(strlen($team_work->title_eng)>80){	echo mb_substr($team_work->title_eng,0,80)."...";}
    else {echo mb_substr($team_work->title_eng,0,80);}    
}
?>
										</h4>
										<h4 class="gold">
										<?php 
if($lang == 'arabic'){
    if(strlen($title_name_ar)>80){	echo mb_substr($title_name_ar,0,80)."...";}
    else {echo mb_substr($title_name_ar,0,80);}
}
else {
if(strlen($title_name_en)>80){	echo mb_substr($title_name_en,0,80)."...";}
else {echo mb_substr($title_name_en,0,80);}    
}
?>
										</h4>
										<p>
<?php 
if($lang == 'arabic'){
    if(strlen($team_work->details_ar)>250){	echo mb_substr($team_work->details_ar,0,250)."...";}
    else {echo mb_substr($team_work->details_ar,0,250);}
}
else {
if(strlen($team_work->details)>250){	echo mb_substr($team_work->details,0,250)."...";}
    else {echo mb_substr($team_work->details,0,250);}    
}
?>										
										
										
										</p>
										
									</div>
									</div>
									<button class="btn" onclick="location.href='<?=DIR?>site/teamwork'" type="button"><i class="fas fa-arrow-left fa-lg"></i></button>
									</div>
								<?php }?>
								<?php }?>
						</div>
					</div>	
			</div>
		</div></div>
		<div class="clearfix"></div>