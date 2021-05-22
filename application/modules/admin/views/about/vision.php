<?php
$url=base_url();
ob_start();
if(!isset($_SESSION['admin_name'])||$_SESSION['admin_name']==""){ 
header("Location:$url"."admin/login"); 
}
else{
$id_admin=$_SESSION['id_admin'];
$admin_name=$_SESSION['admin_name'];
$last_login=$_SESSION['last_login'];
$curt='about_us';
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

<title>عن التطبيق</title>
<?php include ("design/inc/header.php");?>
</head>
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-md">
	<!-- BEGIN HEADER -->
	<?php include ("design/inc/topbar.php");?>
		<script type="text/javascript" src="<?=$url?>design/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="<?=$url?>design/ckfinder/ckfinder.js"></script>
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
							<a href="<?=$url.'admin';?>">الرئيسية</a>
							<i class="fa fa-circle"></i>
						</li>
						
						<li>
							<span class="active">عن التطبيق</span>
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
												

													<div class="portlet  form-fit">
														
														<?php
															foreach($site_info as $result){
																$about_site = $result->about_site;
																$about_site_ar= $result->about_site_ar;
																$vision_site_tr= $result->vision_site_tr;
																
															}
														?>
														<div class="portlet-body form">
															<!-- BEGIN FORM-->
															<form action="<?php echo $url?>admin/about/edit_vision" class="form-horizontal form-bordered"
															 method="post" enctype="multipart/form-data">
																<div class="form-body">
															
																	<div class="form-group">
																		<div class="col-md-12" style="text-align:center">
																		<span class="help-block"> المحتوي </span>
																			<textarea id="about_site_ar" class="form-control" name="vision_site_ar" style="padding:20px;height:150px;width:100%"><?=$about_site_ar;?></textarea>
																			<!-- <?php //echo $this->ckeditor->editor("description","description");?> -->
																			
																		</div>
																	</div>
                                                            	<div class="form-group">
																		<div class="col-md-12" style="text-align:center">
																		<span class="help-block"> Content </span>
																			<textarea  name="vision_site" class="form-control ltr" style="padding:20px;height:150px;width:100%"><?=$about_site;?></textarea>

																		</div>
																	</div>


  	                                                               <div class="form-group">
																		<div class="col-md-12" style="text-align:center">
																		<span class="help-block"> İçerik </span>
																			<textarea  name="vision_site_tr" class="form-control ltr" style="padding:20px;height:150px;width:100%"><?=$vision_site_tr;?></textarea>

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
                    <i class="fa fa-trash"></i>إلغاء الحفظ																				
                </button>
            </div>
</div>

															</form>
															<!-- END FORM-->
															</div>
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
        <?php include ("design/inc/footer.php");?>
        <!-- END FOOTER -->
<div class="footer">
 <?php include ("design/inc/footer_js.php");?>
</div>
<?php if(isset($_SESSION['msg']) && $_SESSION['msg']!=''){?>
<script  type="text/javascript">
$(document).ready(function(e) {
 toastr.success("<?php echo $_SESSION['msg']?>");
});
</script>
<?php }?>

<script type="text/javascript">
//CKEDITOR.replace('description');
//var about_site_ar = CKEDITOR.replace('about_site_ar' );
//var about_site = CKEDITOR.replace('about_site' );
//CKFinder.setupCKEditor(about_site);
//CKFinder.setupCKEditor(about_sabout_site_arite);
</script>


<script>
$(document).ready(function(e) {
    $(".cancelbutton").click(function(e) {
        window.history.back();
    });
});
</script>
</body>
</html>
