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
<head>
<meta charset="utf-8">
<title>الأضافة</title>
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
                        <a href="<?=$url.'admin/products/categories';?>">الأقسام الرئيسية</a>
                        <i class="fa fa-circle"></i>
						</li>
                        <li>
                            <span class="active">اضافة </span>
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
                                        <div class="portlet ">
                                         
                                        <div class="portlet">
                                            
                                            <div class="portlet-body form">
                                                <!-- BEGIN FORM-->
                                <form  class="form-horizontal form-bordered" action="<?= base_url()?>admin/products/notification_action"  method="post" enctype="multipart/form-data" id="form">
                                                    <div class="form-body">
                                                        <input type="hidden" value="<?= $this->input->get("id_notifications");?>" name="id_notifications">
													
<div class="form-group">
<div class="col-md-12">
<span class="help-block ltr">Title</span>
<input type="text" id="title_en" placeholder="Title Of Department" class="form-control ltr" name="title" >
</div>
</div>


<div class="form-group">
<div class="col-md-12">
<span class="help-block ltr">Content</span>
<textarea name="content" style="width:100%;height:100px" class="form-control ltr" placeeholder="Content"></textarea>
</div>

</div>
                                     		
<div class="col-md-12" style="text-align:center">
            <div class="btn-group">    
                <button type="submit" class="btn green  ">
                    
                    <i class="fa fa-save"></i> ارسال 												
                </button>
            </div>
            <div class="btn-group">  
                <button type="button" class="btn default cancelbutton">
                    <i class="fa fa-trash"></i>الغاء العملية																				
                </button>
            </div>
            </div>
                                                </form>
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
        <div class="footer">
        <?php include ("design/inc/footer.php");?>
        <!-- END FOOTER -->
</div>
        <?php include ("design/inc/footer_js.php");?>
<?php 
if(isset($_SESSION['msg'])){
?>
<script>
$(document).ready(function(e) {
 toastr.success("<?php echo $_SESSION['msg']?>");
});
</script>
<?php }?>
<script>
$(document).ready(function(e) {
    $(".cancelbutton").click(function(e) {
        window.history.back();

    });
});
</script>
</body></html>
