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
$curt='homepage';
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" dir="rtl">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
<meta charset="utf-8">
<title>تعديل </title>
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
							<a href="<?=$url.'admin';?>">لوحة التحكم</a>
							<i class="fa fa-circle"></i>
						</li>
						
						<li>
							<span class="active">مقدمة الطاقم الطبى</span>
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
												<div class="portlet box blue ">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-gift"></i> تعديل  </div>

													</div>

													<div class="portlet light bordered form-fit">
														<div class="portlet-title">
															<div class="caption"></div>
															<div class="actions"></div>
														</div>
														<?php
															foreach($site_info as $result){
																$team_title_ar = $result->team_title_ar;
																$team_title_eng = $result->team_title_eng;
																$team_img = $result->team_img;
																$team_background = $result->team_background;
															}
														?>
														<div class="portlet-body form">
															<!-- BEGIN FORM-->
															<form action="<?php echo $url?>admin/pages/edit_doctor" class="form-horizontal form-bordered"
															 method="post" enctype="multipart/form-data">
																<div class="form-body">
																	

																<div class="form-group">
														<div class="col-md-3" style="text-align:center"></div>
                                                            <div class="col-md-6" style="text-align:center">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
																			<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
																				<img src="<?=$url;?>uploads/site_setting/<?=$team_background?>" alt="" /> </div>
																			<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
																			<div>
																				<span class="btn default btn-file">
																					<span class="fileinput-new"> (الطول :410 والعرض:1350)صورة الخلفية</span>
																					<span class="fileinput-exists">تغير</span>
																					<input type="file" name="file"></span>
																				<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">حذف </a>
																			</div>
																		</div>
															</div>
															<div class="col-md-3" style="text-align:center"></div>
                                                        </div>


														<div class="form-group">
														<div class="col-md-3" style="text-align:center"></div>
                                                            <div class="col-md-6" style="text-align:center">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
																			<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
																				<img src="<?=$url;?>uploads/site_setting/<?= $team_img;?>" alt="" /> </div>
																			<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
																			<div>
																				<span class="btn default btn-file">
																					<span class="fileinput-new"> (الطول :380 والعرض:390)صورة عامة</span>
																					<span class="fileinput-exists">تغير</span>
																					<input type="file" name="file1"></span>
																				<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">حذف </a>
																			</div>
																		</div>
															</div>
															<div class="col-md-3" style="text-align:center"></div>
                                                        </div>


																	<div class="form-group">
																		<div class="col-md-12" style="text-align:center">
																		<span class="help-block"> المحتوي </span>
																			<textarea style="width:100%;height:80px" name="about_site_ar" id="about_site_ar"><?=$team_title_ar;?></textarea>
																			<!-- <?php //echo $this->ckeditor->editor("description","description");?> -->
																			
																		</div>
																	</div>


																	<div class="form-group">
																		<div class="col-md-12" style="text-align:center">
																		<span class="help-block"> Context </span>
																			<textarea style="width:100%;height:80px"  name="about_site" id="about_site"><?=$team_title_eng;?></textarea>
																			<!-- <?php //echo $this->ckeditor->editor("description","description");?> -->
																			
																		</div>
																	</div>


																	<div class="form-actions">
																		<div class="row">
																			<div class="col-md-offset-3 col-md-9">
																				<button type="submit" class="btn green">
																					<i class="fa fa-check"></i> حفظ التعديل </button>
																				<button type="button" class="btn default cancelbutton">إلغاء</button>
																			</div>
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

        <?php include ("design/inc/footer_js.php");?>
<script>
$(document).ready(function(e) {
    $(".cancelbutton").click(function(e) {
        window.location.assign("show");
    });
});
</script>
<script type="text/javascript">
	//CKEDITOR.replace('description');
	/*var about_site = CKEDITOR.replace( 'about_site' );
	var about_site_ar = CKEDITOR.replace( 'about_site_ar' );
	CKFinder.setupCKEditor( about_site );
	CKFinder.setupCKEditor( about_sabout_site_arite );*/
</script>
</body>
</html>
