<?php 
	foreach($site_info as $siteinfo)
	?>
<div class="container">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-6">
							<div class="title">
								<h3><?= lang("services");?></h3>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<ol class="breadcrumb text-center">
							  <li><a href="<?= DIR?>site/"><?= lang("home_page");?></a></li>
							  <li class="active"><a href="#"><?= lang("services");?></a></li>
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
			<div class="container ">
				<div class="row">
					
					<!--start tabs-->
					<div class="our-ser">
					<div class="tabs">
		
		<div class="col-md-4">
			<ul class="list-unstyled tab-switch ">
	
                <?php 
                $tab_id=$this->uri->segment(4);
                if($result_amount>0){
						$count=0;
						foreach($results as $prod) {
							$count++;
						?>
						<li <?php if($tab_id==$prod->id){ ?> class="selected" <?php }?> data-class=".tab-<?=$prod->id?>">
							 <?php
							 echo ( $lang == 'arabic' )?$prod->title_ar: $prod->title_eng ; 
								?> 
								<i class="fas fa-angle-left fa-lg pull-left"></i></li>
						<?php }  }?>
			</ul>
		</div>
		<div class="col-md-8">
			<div class="tabs-content lower">

			<?php if($result_amount>0){
				$count_r=0;
				
						foreach($result_amount as $service_details) {
							$count_r++;
						?>
						<div class="tab-<?=$service_details->id?> <?php if($count_r==1){?>tab-one<?php }?>" <?php if($tab_id==$service_details->id){ ?> style="display: block;" <?php } else {?>style="display: none;" <?php }?>>
						<?php
							 echo ( $lang == 'arabic' )?$service_details->details_ar: $service_details->details ; 
								?> 
						</div>
						<?php }  }?>

		
				
			</div>
		</div>
		</div>
				<div class="clearfix"></div>
				
		
				</div>
				
					
				</div>
			</div>
		</div>