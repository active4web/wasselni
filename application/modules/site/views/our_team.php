<?php 
	foreach($site_info as $siteinfo)
	?>
<div class="container">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-6">
							<div class="title">
								<h3><?= lang("teamwork");?></h3>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<ol class="breadcrumb text-center">
							  <li><a href="<?= DIR?>site/"><?= lang("home_page");?></a></li>
							  <li class="active"><a href="#"><?= lang("teamwork");?></a></li>
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
		<div class="setups">
			<div class="container ">
				<div class="row">
					<div class="col-md-5 col-sm-12 col-xs-12">
						
						<div class="setup">
						
							<h3 class="hed-border"><?= lang("txt_founders");?></h3>
							<p><?php echo ( $lang == 'arabic' )?$siteinfo->team_work_intro_ar: $siteinfo->team_work_intro_en ; ?> </p>
							<ul>	
						</div>
					</div>
					<div class="col-md-7 col-sm-12 col-xs-12 teamss">
                        <?php 
                        if(count($main_team)){
                        foreach($main_team as $mainteam){
                     $jobtype_id=$mainteam->jobtype_id;
                     $user_name_ar=get_table_filed("job_type",array("id"=>$jobtype_id),"name_ar"); 
                     $user_name_en=get_table_filed("job_type",array("id"=>$jobtype_id),"name_en");                           
                        ?>
						<div class="col-md-6 col-sm-6 col-xs-6 tea">
							<div class="team">
								<div>
								<h4><?php echo ( $lang == 'arabic' )?$mainteam->title_ar: $mainteam->title_eng ; ?> </h4>
								<h4 class="gold"><?php echo ( $lang == 'arabic' )?$user_name_ar: $user_name_en; ?> </h4>
								<p style="font-size:14px;padding: 0px 5px 0px 5px;">
<?php 
if($lang == 'arabic'){
if(strlen($mainteam->details_ar)>150){	echo mb_substr($mainteam->details_ar,0,150)."...";}
else {echo mb_substr($mainteam->details_ar,0,150);}
}
else {
if(strlen($mainteam->details)>150){	echo mb_substr($mainteam->details,0,150)."...";}
else {echo mb_substr($mainteam->details,0,150);}    
}
?>	    
                            </p>
								
								
							</div>
							</div>
							<button type="button" class="btn " data-toggle="modal" data-target="#myModal<?=$mainteam->id?>">
							 <i class="fas fa-arrow-left fa-lg"></i>
							</button>

							<!-- Modal -->
							<div class="modal fade" id="myModal<?=$mainteam->id?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							  <div class="modal-dialog" role="document">
								<div class="modal-content">
								  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel<?=$mainteam->id?>">
                                    <?php echo ( $lang == 'arabic' )?$mainteam->title_ar: $mainteam->title_eng ; ?>
                                    </h4>
								<h4 class="gold"><?php echo ( $lang == 'arabic' )?$user_name_ar: $user_name_en; ?></h4>
								  </div>
								  <div class="modal-body">
									<p style="font-size:14px;padding: 0px 5px 0px 5px;">
                                    <?php echo ( $lang == 'arabic' )?$mainteam->details_ar: $mainteam->details ; ?> 
                                </p>

								  </div>
								  
								</div>
							  </div>
							</div>
                        </div>
                        <?php  } }?>
						
						</div>
						<div class="clearfix"></div>
					</div>
					</div>
					</div>
						<div class="clearfix"></div>
					<div class="teamss all-team">
					<div class="container">
						<div class="row">
                        <h3 class="hed-border text-center"><?=lang("teamwork");?></h3>
                        
                        <?php 
                        
                        if(count($result_amount)){$count=0;
                        foreach($results as $data){
                            $count++;
                     $jobtype_id=$data->jobtype_id;
                     $user_name_ar_title=get_table_filed("job_type",array("id"=>$jobtype_id),"name_ar"); 
                     $user_name_en_title=get_table_filed("job_type",array("id"=>$jobtype_id),"name_en");                           
                        ?>
							<div class="col-md-3 col-sm-4 col-xs-6 tea <?php if(count($result_amount)==7&&$count>4&&$lang == 'arabic'){?>col-md-pull-2 <?php } else if(count($result_amount)==7&&$count>4&&$lang == 'english') {?>col-md-push-2<?php }?>">
							<div class="team">
							<div>
								<h4><?php echo ( $lang == 'arabic' )?$data->title_ar: $data->title_eng ; ?> </h4>
								<h4 class="gold"><?php echo ( $lang == 'arabic' )?$user_name_ar_title: $user_name_en_title; ?> </h4>
								<p style="font-size:14px;">
<?php 
if($lang == 'arabic'){
if(strlen($data->details_ar)>150){	echo mb_substr($data->details_ar,0,150)."...";}
else {echo mb_substr($data->details_ar,0,150);}
}
else {
if(strlen($data->details)>150){	echo mb_substr($data->details,0,150)."...";}
else {echo mb_substr($data->details,0,150);}    
}
?>	    
                            </p>
								
								
							</div>
							</div>
							<button type="button" class="btn " data-toggle="modal" data-target="#myModal<?=$data->id;?>">
							 <i class="fas fa-arrow-left fa-lg"></i>
							</button>

							<!-- Modal -->
							<div class="modal fade" id="myModal<?=$data->id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							  <div class="modal-dialog" role="document">
                              <div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel<?=$data->id?>">
                                    <?php echo ( $lang == 'arabic' )?$data->title_ar: $data->title_eng ; ?>
                                    </h4>
                                    <h4 class="gold"><?php echo ( $lang == 'arabic' )?$user_name_ar_title: $user_name_en_title; ?> </h4>
								  </div>
								  <div class="modal-body">
									<p>
                                    <?php echo ( $lang == 'arabic' )?$data->details_ar: $data->details ; ?> 
                                </p>

								  </div>
								  
								</div>
							  </div>
							</div>
                        </div>
                        <?php } }?>
					
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			</div>