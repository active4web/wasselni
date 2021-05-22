<?php 
	foreach($site_info as $siteinfo)
						?>
<div class="container">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-6">
							<div class="title">
								<h3><?= lang("job_page");?></h3>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<ol class="breadcrumb text-center">
							  <li><a href="<?= DIR?>site/"><?= lang("home_page");?></a></li>
							  <li class="active"><a href="#"><?= lang("job_page");?></a></li>
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
			<div class="container">
				<div class="row">
				
				
				<div class="contact">
					<div class="col-md-7 col-sm-7 col-xs-12 ">
						<h3 class="hed-border"><?=lang("Apply_job");?></h3>
                        <form method="post" action="<?= DIR?>site/jobs/contact_action"      enctype="multipart/form-data">
							 
							 <div class="col-md-6">
								 <input class="form-control input-lg" type="text" placeholder="<?=lang("name_contact");?>" name="name" required>
								 <input class="form-control input-lg" type="email" placeholder="<?=lang("mail_contact");?>" name="email" required>
								<select class="form-control" name="classroom" required>
								  <option><?=lang("classroom");?></option>
								  <option><?= lang("Primary_school");?></option>
								  <option><?= lang("Middle_school");?> </option>
								  <option><?= lang ("High_school");?></option>
                                  <option><?= lang ("Secondary_school");?></option>
                                  <option><?= lang("Bachelor_school");?></option>
                                  <option><?= lang("Master_school");?></option>
                                  <option><?=lang("PhD_school");?></option>
								</select>
							 </div>
							 <div class="col-md-6">
								 
								  <input class="form-control input-lg" type="text" placeholder="<?=lang("phone_contact");?>" name="phone" required>
								 <input class="form-control " type="text" placeholder="<?=lang("Specialty");?>" name="specialty" required>
								 <input class="form-control " type="date" name="date" required>
							 </div>
							 
							 
						 
				
					</div>
					<div class="col-md-5 col-sm-5 col-xs-12 ">
						<div class="up-load">
							<h5><?=lang("cv");?></h5>
							<div class="box">
								<div class="ui middle aligned center aligned grid container">
								  <div class="ui fluid segment">
									  <input type="file" (change)="fileEvent($event)" class="inputfile" id="embedpollfileinput"  name="cv"/>

								  <label for="embedpollfileinput" class="ui huge red right floated button">
								   <i class="fas fa-file-upload fa-4x"></i></a>
								  </label>
										  
								  </div>
								  
								</div>
						</div>
						
					</div>	</div>
					<div class="col-md-5 col-sm-5 col-xs-12 "></div>
					<div class="col-md-7 col-sm-7 col-xs-12 ">
					<button class="contact-btn"  style=""><i class="fab fa-telegram-plane"></i><?=lang("Submit_now");?></button>

</div>
				</div>
					
				</div>
					</form>
			</div>
		</div>
