
		<?php 
	foreach($site_info as $siteinfo)
foreach($contact_info as $contact_info)
						?>
<div class="container">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-6">
							<div class="title">
								<h3><?= lang("contact_page");?></h3>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-6">
							<ol class="breadcrumb text-center">
							  <li><a href="<?= DIR?>site/"><?= lang("home_page");?></a></li>
							  <li class="active"><a href="#"><?= lang("contact_page");?></a></li>
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
		
		
		<div class="wrapper no-padding">
			<div class="container">
				<div class="row">
				
				
				<div class="contact">
					<div class="col-md-6 col-sm-6 col-xs-12 ">
						<h3 class="hed-border"><?= lang("contact_page");?></h3>
				
							
							 <form method="post" action="<?= DIR?>site/pages/contact_action">
							 
							 <div class="col-md-6">
								 <input class="form-control input-lg" type="text" placeholder="<?php echo lang('name_contact'); ?>" name="name" required>
								 
								 <input class="form-control input-lg" type="text" placeholder="<?php echo lang('phone_contact'); ?>" name="phone" required>
							 </div>
							 <div class="col-md-6">
								 
								 <input class="form-control input-lg" type="email" placeholder="<?php echo lang('mail_contact'); ?>" name="email" required>
								 <input class="form-control input-lg" type="text" placeholder="<?php echo lang('subject_contact'); ?>" name="subject" required>
							 </div>
							 <div class="col-md-12">
								<textarea class="form-control input-lg" placeholder="<?php echo lang('message_contact'); ?>" name="message"required></textarea>
							 </div>
							 <div class="col-md-12">
							 <button class="contact-btn"><i class="fab fa-telegram-plane"></i><?php echo lang('send_contact'); ?> </button>
							 </div>
							 
						 </form>
				
					</div>
					<div class="col-md-6 col-sm-6 col-xs-12 ">
						<div class="info">
							
						<li><div><i class="fas fa-map-marker-alt fa-lg"></i></div><p>
							<?php echo ( $lang == 'arabic' )?$contact_info->address_ar: $contact_info->address_eng ; ?></p> </li>
						<li><div><i class="fa fa-phone phone fa-lg"></i></div><p><?php echo $contact_info->phone_sales?></p></li>
						<li><div><i class="fas fa-envelope fa-lg"></i></div><p><?php echo $contact_info->email_sales?></p></li>
						
						</div>
						
					</div>
				</div>
					
			</div>
		</div>
		<?php echo $contact_info->map?>

		</div>

	
