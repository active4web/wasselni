<?php
//session_start();
ob_start();
if(!isset($_SESSION['admin_name'])||$_SESSION['admin_name']==""){ 
header("Location:".base_url()."admin/login"); 
}
else{
$id_admin=$_SESSION['id_admin'];
$admin_name=$_SESSION['admin_name'];
$last_login=$_SESSION['last_login'];
$curt='state';
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" dir="rtl">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>تعديل</title>
<?php include ("design/inc/header.php");?>
</head>
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-md">
		<!-- BEGIN HEADER -->
		<?php include ("design/inc/topbar.php");?>
        <!-- END HEADER -->
		<!-- BEGIN HEADER & CONTENT DIVIDER -->
		<div class="clearfix"> </div>
		<!-- END HEADER & CONTENT DIVIDER -->
		<!-- BEGIN CONTAINER -->
		<div class="page-container">
			<!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- BEGIN SIDEBAR -->
                <?php include ("design/inc/sidebar.php");?>
                <!-- END SIDEBAR -->
            </div>
            <!-- END SIDEBAR -->
			<!-- BEGIN CONTENT -->
			<div class="page-content-wrapper">
				<div class="page-content" style="min-height: 1261px;">
					<!-- BEGIN PAGE HEAD-->

					<!-- END PAGE HEAD-->
					<!-- BEGIN PAGE BREADCRUMB -->
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<a href="<?=$url.'admin';?>"><?=lang('admin_panel');?></a>
							<i class="fa fa-circle"></i>
						</li>
						<li>
							<a href="<?=$url.'admin/places';?>">المحافظات</a>
							<i class="fa fa-circle"></i>
						</li>
						<li>
							<span>تعديل 
							</span>
						</li>
					</ul>
					<!-- END PAGE BREADCRUMB -->
					<!-- BEGIN PAGE BASE CONTENT -->
					<div class="row">
						<div class="col-md-12">
							<!-- BEGIN PROFILE SIDEBAR -->
							<div class="profile-sidebar">
								<!-- PORTLET MAIN -->
								<!-- END PORTLET MAIN -->
								<!-- PORTLET MAIN -->

								<!-- END PORTLET MAIN -->
							</div>
							<!-- END BEGIN PROFILE SIDEBAR -->
							<!-- BEGIN PROFILE CONTENT -->
							<div class="profile-content">
								<div class="row">
									<div class="col-md-12">
										<!--Start from-->
										<div class="tab-content">
											<div class="tab-pane active" id="tab_5">
												<div class="portlet">
													
													<?php //print_r($now);?>
													<div class="portlet  form-fit">
														<div class="portlet-body form">
															<!-- BEGIN FORM-->
															<?php foreach($data as $data)
																$country_name=get_table_filed('countries',array('id'=>$data->id_country),"name");
															?>
															<form  class="form-horizontal form-bordered"  method="post" action="<?= base_url()?>admin/places/state_edit_action" >
                                                                    <input type="hidden" id="service_type" value="2">
                                                                    <input type="hidden" id="id" name="id" value="<?= $data->id?>">
																<div class="form-body">
																	
																	<div class="form-group">
																		
																		<div class="col-md-4">
																		<span class="help-block"> العنوان  </span>
																			<input name="title" value="<?= $data->name?>" id="title"  type="text" placeholder="العنوان" class="form-control" required>
																			
																		</div>
																		
																			<div class="col-md-4">
																		<span class="help-block ltr">Title</span>
																			<input name="title_en" value="<?= $data->name_en?>" id="title_en"  type="text" placeholder="Title" class="form-control ltr" required>
																			
																		</div>
																		
																			<div class="col-md-4">
																	    	<span class="help-block ltr">Başlık</span>
																			<input name="title_tr" id="title_tr"  value="<?= $data->name_tr?>" type="text" placeholder="Başlık" class="form-control ltr" >
																		</div>
																	</div>																	
	       	                                                 <div class="form-group">
																	<div class="col-md-5">
																		<span class="help-block"> الترتيب  </span>
																			<input name="arrange_type" id="arrange_type"  value="<?= $data->arrange_type?>" type="text" placeholder="الترتيب" class="form-control" >
																			
																		</div>
																		
																		<div class="col-md-5">
                                                                    <span class="help-block">من فضلك حدد الدولة  (<?= $country_name ;?>)</span>
																		<select name="country_id" class="form-control" id="country_id"  >
																		      <option value="">من فضلك حدد الدولة</option>
																		    <?php
																		    foreach($countries as $countries){
																		    ?>
																		    <option value="<?= $countries->id ?>"><?= $countries->name ?></option>
																		    <?php }?>
																		</select>																			
																		</div>
														</div>	
																	
		<div class="col-md-12" style="text-align:center">
            <div class="btn-group">    
                <button type="submit" class="btn green">
                    
                    <i class="fa fa-save"></i> حفظ البيانات												
                </button>
            </div>
            <div class="btn-group">  
                <button type="button" class="btn default cancelbutton">
                    <i class="fa fa-trash"></i>الغاء العملية																				
                </button>
            </div>
            </div>
																</div>
														</form>
														<!-- END FORM-->
														</div>

													</div>
													<!---END FROM-->



												</div>
											</div>
											<!-- END PROFILE CONTENT -->
										</div>
									</div>
									<!-- END PAGE BASE CONTENT -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <div class="footer">
        <?php include ("design/inc/footer.php");?>
        <!-- END FOOTER -->
</div>
        <?php include ("design/inc/footer_js.php");?>
<script>
$(document).ready(function(e) {
    $(".cancelbutton").click(function(e) {
        window.history.back();
    });
});
</script>
</body>
</html>
