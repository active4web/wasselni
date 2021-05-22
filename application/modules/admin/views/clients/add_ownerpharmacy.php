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
$curt='owner_pharmacy';
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

<title>اضافة مدير صيدلية</title>
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
							<a href="<?=$url.'admin';?>"><?=lang('admin_panel');?></a>
							<i class="fa fa-circle"></i>
						</li>
						<li>
                        <a href="<?=$url.'admin/clients/owner_pharmacy';?>">مدرين الصيدليات</a>
                        <i class="fa fa-circle"></i>
						</li>
                        <li>
                            <span class="active">اضافة مدير صيدلية</span>
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
                                            
                                        <div class="portlet light bordered form-fit">
                                            <div class="portlet-title">
                                                <div class="caption"></div>
                                                <div class="actions"></div>
                                            </div>
                                            <div class="portlet-body form">
                                                <!-- BEGIN FORM-->
    <form action="<?=$url;?>admin/clients/ownerpharmacy_action" class="form-horizontal form-bordered"  method="post" enctype="multipart/form-data">
                                                    <div class="form-body">
														
<div class="form-group">
<div class="col-md-2"></div>
<div class="col-md-8">
<span class="help-block">مدير الصيدلية</span>
<input type="text" placeholder="مدير الصيدلية" class="form-control" name="name" required>
</div>
<div class="col-md-2"></div>
</div>

<div class="form-group">
<div class="col-md-2"></div>
<div class="col-md-8">
<span class="help-block">رقم التليفون </span>
<input type="text" placeholder="رقم التليفون" class="form-control" name="phone" required>
</div>
<div class="col-md-2"></div>
</div>

<div class="form-group">
<div class="col-md-2"></div>
<div class="col-md-8">
<span class="help-block">البريد الألكترونى</span>
<input type="email" placeholder="البريد الألكترونى" class="form-control" name="email" required>
</div>
<div class="col-md-2"></div>
</div>


<div class="form-group">
<div class="col-md-2"></div>
<div class="col-md-8">
    <?php
if($this->input->get("id")==""){
?>
<span class="help-block">حدد الصيدلية</label>
<?php }?>
<?php
if($this->input->get("id")!=""){
?>
<input type="hidden"  value="<?= $this->input->get("id");?>" class="form-control" name="pharamcy_type" required>

<?php } else {?>


<?php }?>
</div>
<div class="col-md-2"></div>
</div>

<div class="form-group">
<div class="col-md-2"></div>
<div class="col-md-8">
<span class="help-block">كلمة السر</span>
<input type="password" placeholder="كلمة السر" class="form-control" name="password">
</div>
<div class="col-md-2"></div>
</div>
 
<div class="form-group">
<div class="col-md-2"></div>
<div class="col-md-8">
<span class="help-block"><?=lang('role');?></label>
<select class="form-control" name="permission" required>
<option value="0">التطبيق فقط</option>
<option value="1">التطبيق والسيستم</option>
<option value="2">السيستم فقط</option>

</select>

</div>
<div class="col-md-2"></div>
</div>          
                                                  		
<div class="form-actions">
<div class="row">
<div class="col-md-offset-3 col-md-9">
<button type="submit" class="btn green">
<i class="fa fa-check"></i>اضافة</button>
<button type="reset" class="btn default">الغاء</button>
</div>
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
if(isset($_SESSION['msg1'])){
?>
<script>
$(document).ready(function(e) {
 toastr.success("<?php echo $_SESSION['msg1']?>");
});
</script>
<?php }?>
<?php 
if(isset($_SESSION['msg2'])){
?>
<script>
$(document).ready(function(e) {
 toastr.success("<?php echo $_SESSION['msg2']?>");
});
</script>
<?php }?>
<?php 
if(isset($_SESSION['msg3'])){
?>
<script>
$(document).ready(function(e) {
 toastr.success("<?php echo $_SESSION['msg3']?>");
});
</script>
<?php }?>

</body></html>
