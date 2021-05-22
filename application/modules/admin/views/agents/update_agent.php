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
$curt='agents';
}
foreach($data as $result)
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
<title>التعديل</title>
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
                        <a href="<?=$url.'admin/agents';?>">المندوبين</a>
                        <i class="fa fa-circle"></i>
						</li>
                        <li>
                            <span class="active">التعديل</span>
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
                                <form  class="form-horizontal form-bordered"  method="post" enctype="multipart/form-data" id="form">
                                                    <div class="form-body">
                                                        <input type="hidden" value="2" id="service_type">
                                                        <input type="hidden" value="<?= $result->id?>" id="id" name="id">
                                                        
													
<div class="form-group">
<div class="col-md-4">
<span class="help-block">الاسم</span>
<input type="text" value="<?= $result->fullname?>" id="name" placeholder="الاسم" class="form-control" name="name" required>
</div>

<div class="col-md-4">
<span class="help-block">رقم التليفون </span>
<input type="text" id="phone" value="<?= $result->phone?>" placeholder="رقم التليفون" class="form-control" name="phone" required>
</div>

<div class="col-md-4">
<span class="help-block">البريد الألكترونى</span>
<input type="email" id="email"value="<?= $result->mail?>"  placeholder="البريد الألكترونى" class="form-control" name="email" required>
</div>
</div>


<div class="form-group">
<div class="col-md-1"></div>
<div class="col-md-10">
<span class="help-block">العنوان</span>
<input type="text" value="<?= $result->address?>" placeholder="العنوان" class="form-control" name="address" required>
</div>


<div class="col-md-1"></div>
</div>
                                                  		
<div class="col-md-12" style="text-align:center">
            <div class="btn-group">    
                <button type="button" class="btn green agentbutton mainbutton">
                    
                    <i class="fa fa-save"></i> حفظ البيانات												
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
        <?php include ("design/inc/footer.php");?>
        <!-- END FOOTER -->

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
