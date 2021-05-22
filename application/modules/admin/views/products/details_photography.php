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
$curt='photography_requests';
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

<title>تفاصيل الرسالة </title>
<?php include ("design/inc/header.php");?>
<style>

</style>
<?php
foreach($data as $result)
$user_name=get_table_filed("team_work",array("id"=>$result->id_service),"name");

?>
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
							<a href="<?=$url.'admin/products/photography_requests';?>">الطلبات</a>
							<i class="fa fa-circle"></i>
						</li>
						<li>
							<span class="active"> تفاصيل الرسالة</span>
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
												<div class="portlet box  ">
												

													<div class="portlet  form-fit">
													
															<!-- BEGIN FORM-->
															<form action="#" class="form-horizontal form-bordered" method="post" enctype="multipart/form-data">
																<div class="form-body">
															
														 <div class="form-group">
															<div class="col-md-12 mail-info-box ">
																 <div class="img-circle-container">
                                                                    <img src="<?= base_url()?>uploads/site_setting/admin_panel/avatar.png">
                                                                 </div>
                												<div class="name-mail-sender">
                                                                    <div class="name-email-sender"><i class="fa fa-info" style="margin-left:10px;margin-right:10px"></i><?= $result->name?></div>
                                                                    <div class="email-sender"><i class="fa fa-phone" style="margin-left:10px;margin-right:10px"></i><?= $result->phone?></div>
                                                                 </div>
										                     </div>
																	
														</div>
															<div class=" email_title " style="padding-right:50px"><i class="fa fa-whatsapp" style="margin-left:10px"> </i><?= $result->whatsapp  ?><span style="float:right;font-size: 12px;"></span></div>
														<div class=" email_title " style="padding-right:50px"><i class="fa fa-user" style="margin-left:10px"></i><?= $user_name?><span style="float:right;font-size: 12px;"></span></div>
															<div class=" email_content" style="padding-right:50px"><?= $result->about?></div>

															
															
															<!-- END FORM-->
															</div></form>
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

</body>
</html>
