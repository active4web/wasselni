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
$curt='regulation_service';
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
<title>مقدمة خدمة إعتماد لوائح </title>
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
							<span class="active">مقدمة خدمة إعتماد لوائح </span>
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
															<i class="fa fa-gift"></i>مقدمة خدمة إعتماد لوائح </div>

													</div>

													<div class="portlet light bordered form-fit">
														<div class="portlet-title">
															<div class="caption"></div>
															<div class="actions"></div>
														</div>
														<?php
															foreach($site_info as $result){
																$regulations_intro_en = $result->regulations_intro_en;
																$regulations_intro_ar = $result->regulations_intro_ar;
																$regulations_title_intro_ar = $result->regulations_title_intro_ar;
																$regulations_title_intro_en = $result->regulations_title_intro_en;
															}
														?>
														<div class="portlet-body form">
															<!-- BEGIN FORM-->
															<form action="<?php echo $url?>admin/regulations/intro_action" class="form-horizontal form-bordered"
															 method="post" enctype="multipart/form-data">
																<div class="form-body">
																	


																<div class="form-group">
														<div class="col-md-2"></div>
                                                            <div class="col-md-8">
                                                            <span class="help-block">العنوان</span>
                                                                <input type="text" placeholder="العنوان" value="<?= $regulations_title_intro_ar?>" class="form-control" name="title_ar">
                                                                <!--<span class="help-block"> This is inline help </span>-->
															</div>
															<div class="col-md-2"></div>
                                                        </div>
                                                        <div class="form-group">
														<div class="col-md-2"></div>
                                                            <div class="col-md-8">
                                                            <span class="help-block" style="float:left">Title</span>
                                <input type="text"  style="text-align:left" placeholder="Title" class="form-control" value="<?= $regulations_title_intro_en?>" name="title_eng">
                                                                <!--<span class="help-block"> This is inline help </span>-->
															</div>
															<div class="col-md-2"></div>
                                                        </div>


																	<div class="form-group">
																		<div class="col-md-12" style="text-align:center">
																		<span class="help-block"> المحتوي </span>
												<textarea  name="team_work_intro_ar" class="form-control autosizeme" data-autosize-on="true" style="resize: horizontal; height: 60px;"><?=$regulations_intro_ar;?></textarea>
																			<!-- <?php //echo $this->ckeditor->editor("description","description");?> -->
																			
																		</div>
																	</div>


																	<div class="form-group">
																		<div class="col-md-12" style="text-align:center">
																		<span class="help-block"> Context </span>
																			<textarea class="form-control autosizeme" name="team_work_intro_en"  data-autosize-on="true" style="resize: horizontal; height: 60px;"><?=$regulations_intro_en;?></textarea>
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
<script type="text/javascript">
	//CKEDITOR.replace('description');
	var about_site = CKEDITOR.replace( 'about_site' );
	var about_site_ar = CKEDITOR.replace( 'about_site_ar' );
	CKFinder.setupCKEditor( about_site );
	CKFinder.setupCKEditor( about_sabout_site_arite );
</script>
</body>
</html>
