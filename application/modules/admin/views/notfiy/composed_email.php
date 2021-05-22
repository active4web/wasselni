<?php
//session_start();
ob_start();
if (!isset($_SESSION['admin_name']) || $_SESSION['admin_name'] == "") {
	header("Location:" . base_url() . "admin/login");
} else {
	$id_admin = $_SESSION['id_admin'];
	$admin_name = $_SESSION['admin_name'];
	$last_login = $_SESSION['last_login'];
	$curt = 'emails';
}
$id_project=$this->input->get('id_project');
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
<title>ارسال رسالة</title>
<?php include("design/inc/header.php"); ?>
</head>
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-md">
		<!-- BEGIN HEADER -->
		<?php include("design/inc/topbar.php"); ?>
		<script type="text/javascript" src="<?= $url ?>design/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="<?= $url ?>design/ckfinder/ckfinder.js"></script>
        <!-- END HEADER -->
		<!-- BEGIN HEADER & CONTENT DIVIDER -->
		<div class="clearfix"> </div>
		<!-- END HEADER & CONTENT DIVIDER -->
		<!-- BEGIN CONTAINER -->
		<div class="page-container">
			<!-- BEGIN SIDEBAR -->
            <div class="page-sidebar-wrapper">
                <!-- BEGIN SIDEBAR -->
                <?php include("design/inc/sidebar.php"); ?>
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
							<a href="<?= $url . 'admin'; ?>"><?= lang('admin_panel'); ?></a>
							<i class="fa fa-circle"></i>
						</li>
						<li>
							<a href="<?= $url ?>admin/emails/inbox_email">الوارد</a>
							<i class="fa fa-circle"></i>
						</li>
						<li>
							<span>المرسلة</span>
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
															<i class="fa fa-gift"></i>المرسلة</div>
													</div>

													<div class="portlet light bordered form-fit">
														<div class="portlet-title">
															<div class="caption"></div>
															<div class="actions"></div>
														</div>
														<div class="portlet-body form">
															<!-- BEGIN FORM-->
															<form action="<?php echo $url ?>admin/emails/composed_action" class="form-horizontal form-bordered" method="post" enctype="multipart/form-data">
																<div class="form-body">
										
																	<div class="form-group">
																		<div class="col-md-1"></div>
																		<div class="col-md-10">
																		<span class="help-block">البريد الالكترونى</span>
																			<input name="email"  type="text" placeholder="البريد الالكترونى" class="form-control" required>
																		</div>
																		<div class="col-md-1"></div>
																	</div>
																	
																
																			
																	<div class="form-group">
																		<div class="col-md-1"></div>
																		<div class="col-md-10">
																		<span class="help-block">الموضوع</span>
																			<input name="subject"  type="text" placeholder="الموضوع" class="form-control" required>
																		</div>
																		<div class="col-md-1"></div>
																	</div>
																
																	<div class="form-group">
																		<div class="col-md-1"></div>
																		<div class="col-md-10">
																		<span class="help-block">المحتوى</span>
																	<textarea name="content" style="width:100%;height:150px" class="form-control"  placeholder="الرسالة" ></textarea>
																		</div>
																		<div class="col-md-1"></div>
																	</div>

																	<div class="form-group">
																	<div class="col-md-1"></div>
																	<div class="col-md-10">
																		<div class="fileinput fileinput-new" data-provides="fileinput">
																						<div>
																							<span class="btn default btn-file">
																								<span class="fileinput-new">الملفات(gif|jpg|png|pdf|doc|xlsx)</span>
																								<span class="fileinput-exists">تغيير</span>
																								<input type="file" name="file[]"  multiple> </span>
																								<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> حذف </a>
																						</div>
																					</div>
																		
																	</div>
																	<div class="col-md-1"></div>
																	</div>




																	<div class="form-actions">
																		<div class="row">
																			<div class="col-md-offset-3 col-md-9">
																				<button type="submit" class="btn green">
																					<i class="fa fa-check"></i> حفظ</button>
																				<button type="button" class="btn default cancelbutton">إلغاء</button>
																			</div>
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
        <?php include("design/inc/footer.php"); ?>
        <!-- END FOOTER -->

        <?php include("design/inc/footer_js.php"); ?>
<script>
$(document).ready(function(e) {
$(".cancelbutton").click(function(e) {
window.history.back();
});
});
</script>
<script>
	//this script for select if time of start project selected or no as :
	 //if value==2 mean select start date or value =1 mean not selected date
	
$(document).ready(function(e) {
	$("input[type='radio']").click(function(){
		var radioValue = $("input[name='select_date']:checked").val();
            if(radioValue==2){
               $("#start_date").show();
            }
			else {
				$("#start_date").hide();	
			}

var radioValue = $("input[name='select_enddate']:checked").val();
if(radioValue==2){
$("#enddate").show();
}
else {
$("#enddate").hide();	
}

        });
});
</script>
<script type="text/javascript">
    $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});
</script>  
<?php if(isset($_SESSION['msg']) && $_SESSION['msg']!=''){?>
<script>
$(document).ready(function(e) {
	toastr.success("<?php echo $_SESSION['msg']?>");
});
</script>
<?php }?>
</body>
</html>
