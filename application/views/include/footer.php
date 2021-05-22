<footer>
<?php

foreach($site_info as $siteinfo)
?>

<footer>
		 <div class="overlay">
			<div class="container">
			<!-- Start Scroller -->
    
				<div id="elevator_item" style="display: block;"> 
					<a id="elevator" onclick="return false;" title="Back To Top"></a> 
				</div>
			
			<!-- End Scroller -->
				<div class="row">
					<div class="mailing">
					<form method="post" action="#">
						  <div class="form-group">
							<div class="col-sm-5 ">
							<h4><?=lang("Mailing_List");?></h4>
							<label  class="control-label"><?=lang("Subscribe_email");?></label>
							</div>
							<div class=" col-sm-7">
								<div class="hold">
								<input type="email"  id="email_sub" class="form-control " name="email" required placeholder="<?=lang("mail_contact");?>">
									
									  <button type="button" class="btn send_txt "><i class="fab fa-telegram-plane fa-2x"></i></button>
									</div>
								</div>	
							</div>
							</div>
						 
						 </form> 
					</div>
					<div class="col-md-3 col-sm-6 col-xs-12">
						<h4><?= lang("about_page");?></h4>
						<p>
						<p>
								<?php echo ( $lang == 'arabic' )?$siteinfo->about_footer_ar: $siteinfo->about_footer_en ; ?>
								</p>

						<a  class="f-mor" href="<?= DIR?>site/pages/about"> <?= lang("read_more");?></a></p>
					</div>
					<div class="col-md-5 col-sm-6 col-xs-12">
						
						<h4><?= lang("services");?></h4>
							<div class="qanon">
								<div class="col-md-6 col-sm-6 col-xs-6 colm-2">
									<?
								$start_service=	$this->db->limit(5)->order_by('id','desc')->get_where("our_services",array("view"=>'1'))->result();
								if(count($start_service)>0){
								foreach($start_service as $start_service){
									?>
									<li><a href="<?=DIR?>site/services/details_services/<?= $start_service->id?>"><i class="fas fa-external-link-alt"></i>
								<?php
								if($lang == 'arabic'){
									if(strlen($start_service->title_ar)>50){	echo mb_substr($start_service->title_ar,0,50)."...";}
									else {echo mb_substr($start_service->title_ar,0,50);}
								}
								else {
								if(strlen($start_service->title_eng)>50){	echo mb_substr($start_service->title_eng,0,50)."...";}
									else {echo mb_substr($start_service->title_eng,0,50);}    
								}
								?>
								
								</a></li>
								<?php  } }?>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6 colm-2">
									<?
								$last_service=	$this->db->limit(5)->order_by('id','asc')->get_where("our_services",array("view"=>'1'))->result();
								if(count($last_service)>0){
								foreach($last_service as $last_service){
									?>
									<li><a href="<?=DIR?>site/services/details_services/<?= $last_service->id?>"><i class="fas fa-external-link-alt"></i>
								<?php
								if($lang == 'arabic'){
									if(strlen($last_service->title_ar)>50){	echo mb_substr($last_service->title_ar,0,50)."...";}
									else {echo mb_substr($last_service->title_ar,0,50);}
								}
								else {
								if(strlen($last_service->title_eng)>50){	echo mb_substr($last_service->title_eng,0,50)."...";}
									else {echo mb_substr($last_service->title_eng,0,50);}    
								}
								?>
								
								
								</a></li>
								<?php  } }?>
								</div>
							</div>	
					</div>
					<div class="col-md-4 col-sm-6 col-xs-12">
						<h4><?= lang("contact_page");?></h4>
						<div class="cont">
							<li><?= lang("address_foot");?>:
							<?php echo ( $lang == 'arabic' )?$siteinfo->address_ar: $siteinfo->address_eng ; ?>

							</li>
							<li><?= lang("phone_number");?>: <?= $siteinfo->footer_phone ; ?></li> 
							<li> <?= lang("email_foot");?>: <?= $siteinfo->footer_email ; ?></li>  
							<li>
							<?php echo ($lang=='arabic')?$siteinfo->work_hrs_ar: $siteinfo->work_hrs_en ; ?>
							</li>
						
						</div>
					</div>
				</div>
				
			<div class="coppy text-center">
				<div class="container">
					<h5 class="pull-right"><?=lang("copy_right_foot");?><a href="https://wisyst.com/" target="_blank"><?=lang("copy_comp");?></a></h5>
					<div class="sochal pull-left">
				
						<a href="<?= $siteinfo->instagram?>" target="_blank"><i class="fab fa-linkedin-in fa-lg"></i></a>
						<a href="<?= $siteinfo->facebook?>" target="_blank"><i class="fab fa-facebook-f fa-lg"></i></a>
						<a href="<?= $siteinfo->twitter?>" target="_blank"><i class="fab fa-twitter fa-lg"></i></a>
				 
					</div>

				</div>
			</div>
			</div>
		</footer>


		
			
			
		<script src="<?=DIR;?>design/frontpage/js/jquery.js"></script>
		<script src="<?=DIR;?>design/frontpage/js/owl.carousel.js"></script>
		<script src="<?=DIR;?>design/frontpage/js/bootstrap.min.js"></script>
		<script src="<?=DIR;?>design/frontpage/js/plug.js"></script>
		





    <script type="text/javascript" src="<?=DIR;?>design/frontpage/toastr/toastr.min.js"></script>
    <link href="<?=DIR;?>design/frontpage/toastr/toastr.min.css" rel="stylesheet">

	<?php if(isset($_SESSION['msg']) && $_SESSION['msg']!=''){?>
<script>
$(document).ready(function(e) {
	toastr.info("<?=$_SESSION['msg'];?>",  {timeOut: 5000})
});
</script>
<?php }?>




<script>
$(document).ready(function(e) {
$(".send_txt").click(function(e) {
var email_sub = $("#email_sub").val();
var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    if (!reg.test(email_sub)) 
		{
			toastr.info("البريد الألكترونى غير صحيح",  {timeOut: 5000});
		}
 else {
var data={email:email_sub};
			$.ajax({
				url: '<?php echo base_url("site/pages/subscribe_action") ?>',
                type: 'POST',
                data: data,				
                success: function( data ) {
                	if (data == "1") {
										toastr.info("<?=lang('sendmessage_result')?>",  {timeOut: 5000});
                	}
                	if (data == "0") {
                		toastr.info("الايميل موجود سابقا",  {timeOut: 5000});
                	}
				}
         });
 }
	});
});
</script>
	</body>
</html>
