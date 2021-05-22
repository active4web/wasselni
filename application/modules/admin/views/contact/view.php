<?php
$url=base_url();
ob_start();
$dd=base_url();
if(!isset($_SESSION['admin_name'])||$_SESSION['admin_name']==""){ 
header("Location:$dd"."admin/login"); 
}

else{
$id_admin=$_SESSION['id_admin'];
$admin_name=$_SESSION['admin_name'];
$last_login=$_SESSION['last_login'];	
}
?>
<!DOCTYPE html>
<!--[if !IE]><!-->
<html class="sidebar sidebar-discover">
<!-- <![endif]-->

<head>
	<meta charset="utf-8">
	<?php include ("design/inc/head1.inc");?>
</head>

<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-md">
	<!-- Main Container Fluid -->


	<div class="container-fluid menu-hidden">
	</div>
	<div id="content">
		<?php  include("design/inc/header.inc");?>
		<!-- END HEADER -->
		<!-- BEGIN HEADER & CONTENT DIVIDER -->
		<div class="clearfix"> </div>
		<!-- END HEADER & CONTENT DIVIDER -->
		<!-- BEGIN CONTAINER -->
		<div class="page-container">
			<!-- BEGIN SIDEBAR -->
			<!-- BEGIN SIDEBAR -->
			<!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
			<!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
			<?php include ("design/inc/sidebar.inc");?>

			<!-- END SIDEBAR -->
			<!-- BEGIN CONTENT -->
			<div class="page-content-wrapper">
				<div class="page-content" style="min-height: 1261px;">
					<!-- BEGIN PAGE HEAD-->

					<!-- END PAGE HEAD-->
					<!-- BEGIN PAGE BREADCRUMB -->
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<a href="<?=$dd.'admin';?>">Home</a>
							<i class="fa fa-circle"></i>
						</li>
						<li>
							<span>Contact</span>
							<i class="fa fa-circle"></i>
						</li>
						<li>
							<a href="<?=$dd.'admin/contact/show';?>">Contact List</a>
							<i class="fa fa-circle"></i>
						</li>
						<li>
							<span class="active">Details</span>
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
												<div class="portlet box blue ">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-gift"></i>View Contacts </div>

													</div>

													<div class="portlet light bordered form-fit">
														<div class="portlet-title">
															<div class="caption">



															</div>
															<div class="actions"></div>
														</div>
														<div class="portlet-body form">
															<!-- BEGIN FORM-->
															<?php foreach($data as $res):?>
															<form action="#" class="form-horizontal form-bordered"
															 method="post">
																<div class="form-body">
																	<div class="form-group">
																		<div class="col-md-1"></div>
																		<div class="col-md-3"> Name </div>
																		<div class="col-md-8"><?=$res->name?></div>
																		<div class="col-md-1"></div>
																	</div>
																	<div class="form-group">
																		<div class="col-md-1"></div>
																		<div class="col-md-3"> Email </div>
																		<div class="col-md-8"><?=$res->email?></div>
																		<div class="col-md-1"></div>
																	</div>
																	<div class="form-group">
																		<div class="col-md-1"></div>
																		<div class="col-md-3"> Phone </div>
																		<div class="col-md-8"><?=$res->phone?></div>
																		<div class="col-md-1"></div>
																	</div>
																	<div class="form-group">
																		<div class="col-md-1"></div>
																		<div class="col-md-3"> Message </div>
																		<div class="col-md-8"><?=$res->message?></div>
																		<div class="col-md-1"></div>
																	</div>
																	<div class="form-actions">
																		<div class="row">
																			<div class="col-md-offset-3 col-md-9">
																				<button type="button" class="btn default cancelbutton">Back</button>
																			</div>
																		</div>
																	</div>
															</form>
															<?php endforeach;?>
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
							<div id="footer" class="hidden-print">
								<?php include ("design/inc/footer.inc");	?>
							</div>
						</div>
						<?php include ("design/inc/headf1.inc");?>
<script>
$(document).ready(function(e) {
    $(".cancelbutton").click(function(e) {
        window.location.assign("show");
    });
});
</script>
</body>
</html>
