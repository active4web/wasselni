<?php 
	foreach($site_info as $siteinfo)
	?>
<div class="container">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-6">
							<div class="title">
								<h3><?= lang("regulations_page");?></h3>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<ol class="breadcrumb text-center">
							  <li><a href="<?= DIR?>site/"><?= lang("home_page");?></a></li>
							  <li class="active"><a href="#"><?= lang("regulations_page");?></a></li>
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

		<div class="wrapper ">
			<div class="container regu">
				<div class="row">
				<div class="">
				<div class="col-md-6 col-sm-6 col-xs-12 ">

				<h3 class="hed-border"><?php echo ( $lang == 'arabic' )?$siteinfo->regulations_title_intro_ar: $siteinfo->regulations_title_intro_en ; ?></h3>
					<p><?php echo ( $lang == 'arabic' )?$siteinfo->regulations_intro_ar: $siteinfo->regulations_intro_en ; ?></p>
					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">



                    <?php
                    if(count($regulations_txt)>0){
                        $count=0;
                        foreach($regulations_txt as $regulations_txt){
                            $count++;
                    ?>
					  <div class="panel panel-default">
						<div class="panel-heading <?php if($count==1){?>active<?php }?>" role="tab" id="headingOne<?=$regulations_txt->id;?>">
						  <h4 class="panel-title">
							<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?=$regulations_txt->id;?>" aria-expanded="true" aria-controls="collapseOne">
							 <i class="far fa-eye"></i> <?php echo ( $lang == 'arabic' )?$regulations_txt->title_ar: $regulations_txt->title_eng ; ?>     
							</a>
						  </h4>
						</div>
						<div id="collapseOne<?=$regulations_txt->id;?>" class="panel-collapse collapse <?php if($count==1){?>in<?php }?>" role="tabpanel" aria-labelledby="headingOne<?=$regulations_txt->id;?>">
						  <div class="panel-body"><?php echo ( $lang == 'arabic' )?$regulations_txt->details_ar: $regulations_txt->details ; ?>				  </div>
						</div>
                      </div>
                        <?php }?>
                    <?php }?>
				
				
					</div>

				</div>
				<div class="col-md-6 col-sm-6 col-xs-12 regu main_id_in">
					<div class="model-contact">
					<h4 class="hed-border text-center">نموذج للتواصل مع المنشاة</h4>
						 <form method="post" action="<?=DIR?>site/pages/regulations_action">
						 
						 <div class="col-md-6">
							 <input class="form-control input-lg" type="text" placeholder="<?=lang("Facility_Name");?>" name="comname" required>
							 
							 <input class="form-control input-lg" type="text" placeholder="<?=lang("phone_number");?>" name="phone" required>
						 </div>
						 <div class="col-md-6">
							 <input class="form-control input-lg" type="text" placeholder="<?= lang("established_name");?>" name="name" required>
							 <input class="form-control input-lg" type="email" placeholder="<?= lang("mail_contact");?>" name="email" required>
						 </div>
						 <button class="contact-btn"><i class="fab fa-telegram-plane"></i><?= lang("established_Send");?></button>
					 </form>
				
					</div>
				</div>



				<div class="col-md-6 col-sm-6 col-xs-12 main_id_result" style="display:none">
					<div class="model-contact send text-center">
						<i class="fas fa-envelope-open-text fa-4x"></i>
						<h4>تم استلام البيانات وسوف يتم التواصل لاحقا</h4>
						<a href="">ارسل بيانات اخرى<i class="fas fa-arrow-right"></i></a>
					</div>
				</div>
					
			</div>
		</div>
		</div>
		</div>