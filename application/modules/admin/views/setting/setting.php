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
$curt='setting';
}
$site_info=$this->db->get_where('site_info')->result();
$home_page=$this->db->get_where('home_page')->result();
foreach($home_page as $home_page)
foreach($site_info as $site_info)
	$logo=$site_info->logo;
	$favicon=$site_info->favicon;
	$name_site_ar=$site_info->name_site_ar;
	$face=$site_info->facebook;
	$twitter=$site_info->twitter;
    $instagram=$site_info->instagram;
    $linkedin=$site_info->linkedin;
	$support_email=$site_info->support_email;
	$support_phone=$site_info->support_phone;
    $whatsapp=$site_info->whatsapp;  
    $address_en=$site_info->address_en;
    $address=$site_info->address;
    $hotline=$site_info->hotline;
	 
	
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" dir="rtl">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<title>الاعدادات</title>
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
                            <a href="<?=$url.'admin';?>">الرئيسية</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <span class="active">الاعدادات</span>
                        </li>
                    </ul>
                    <!-- END PAGE BREADCRUMB -->
                    <!-- BEGIN PAGE BASE CONTENT -->
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN PROFILE SIDEBAR -->
                            <div class="profile-sidebar">
                                <!-- PORTLET MAIN -->                                <!-- END PORTLET MAIN -->
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
                                            
                                        <div class="portlet   form-fit">
                                            
                                            <div class="portlet-body form">
                                                <!-- BEGIN FORM-->
                                                <form action="<?=$url;?>admin/update_setting" class="form-horizontal form-bordered"  method="post" enctype="multipart/form-data">
                                                    <div class="form-body">
                                                        
<div class="form-group">
<div class="col-md-5" style="text-align:center">
<div class="fileinput fileinput-new" data-provides="fileinput">
<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
<img src="<?=$url;?>uploads/site_setting/<?php echo $logo?>" alt="" />
</div>
<div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px;height: 150px;"> 
<img src="<?=$url;?>uploads/site_setting/default-placeholder.png" alt="" />
</div>
<div>
<span class="btn default btn-file">
<span class="fileinput-new">اللوجو<?=get_img_size("logo");?></span>
<span class="fileinput-exists">تغيير</span>
<input type="file" name="file"> </span>
<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> حذف </a>
</div>
</div>
</div>

<div class="col-md-2" style="text-align:center"></div>
<div class="col-md-5" style="text-align:center">
<div class="fileinput fileinput-new" data-provides="fileinput">
<div class="fileinput-new thumbnail" style="width:32px; height:32px;">
<img src="<?=$url;?>uploads/site_setting/<?php echo $favicon?>" alt="" /> </div>
<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
<img src="<?=$url;?>uploads/site_setting/default-placeholder.png" alt="" />
</div>
<div>
<span class="btn default btn-file">
<span class="fileinput-new">ايقونة الموقع<?=get_img_size("favicon");?></span>  
<span class="fileinput-exists"> تغيير </span>
<input type="file" name="file1"> </span>
<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> حذف </a>
</div>
</div>

</div>
</div>






<div class="form-group">
<div class="col-md-3">
<span class="help-block">عنوان التطبيق</span>
<input type="text" placeholder="عنوان التطبيق" class="form-control" name="site_name_ar" value="<?php echo $name_site_ar?>">
</div>

<div class="col-md-3">
<span class="help-block ltr">ِApp Name</span>
<input type="text" placeholder="App Name" class="form-control ltr" name="site_name" value="<?= $site_info->name_site?>">
</div>

<div class="col-md-3">
<span class="help-block ltr">Hotline</span>
<input type="text" placeholder="Hotline" class="form-control ltr" name="hotline" value="<?php echo $hotline?>">
</div>

<div class="col-md-3">
<span class="help-block ltr">Whatsapp</span>
<input type="text" placeholder="Whatsapp" class="form-control ltr" name="whatsapp" value="<?php echo $whatsapp?>">
</div>


</div>


<div class="form-group">
<div class="col-md-4">
<span class="help-block ltr">Facebook Link</span>
<input type="text" placeholder="Facebook Link" class="form-control ltr" name="facebook" value="<?php echo $face?>">
<!--<span class="help-block"> This is inline help </span>-->
</div>

<div class="col-md-4">
<span class="help-block ltr">Twitter Link</span>
<input type="text" placeholder="Twitter Link" class="form-control ltr" name="twitter" value="<?php echo $twitter?>">
<!--<span class="help-block"> This is inline help </span>-->
</div>

<div class="col-md-4">
<span class="help-block ltr">Linked In</span>
<input type="text" placeholder="Linked In" class="form-control ltr" name="linkedin" value="<?php echo $linkedin?>">
<!--<span class="help-block"> This is inline help </span>-->
</div>

</div>

<div class="form-group">
<div class="col-md-4">
<span class="help-block ltr">Instagram Link  </span>
<input type="text" placeholder="Instagram Link" class="form-control ltr" name="instagram" value="<?php echo $instagram?>">
<!--<span class="help-block"> This is inline help </span>-->
</div>

<div class="col-md-4">
<span class="help-block ltr">Email</span>
<input type="text" placeholder="Email" class="form-control ltr" name="info_email" value="<?php echo $support_email?>">
<!--<span class="help-block"> This is inline help </span>-->
</div>
<div class="col-md-4">
<span class="help-block ltr">Phone</span>
<input type="text" placeholder="Phone" class="form-control ltr" name="support_phone" value="<?php echo $support_phone?>">
</div>

</div>



                                                       
<div class="form-group">
<div class="col-md-6">
<span class="help-block">العنوان</span>
<textarea class="form-control autosizeme" placeholder="العنوان" data-autosize-on="true"
style=" height:40px;" name="address"><?=$site_info->address?></textarea>
</div>

<div class="col-md-6">
<span class="help-block ltr">Address</span>
<textarea class="form-control autosizeme ltr" placeholder="Address"  style="height: 40px;" name="address_en"><?=$site_info->address_en?></textarea>
</div>


</div>



<div class="col-md-12" style="text-align:center">
            <div class="btn-group">    
                <button type="submit" class="btn green">
                    
                    <i class="fa fa-save"></i> Saved data    																			
                </button>
            </div>
            <div class="btn-group">  
                <button type="button" class="btn default cancelbutton">
                    <i class="fa fa-trash"></i>Cancel																				
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
</body></html>
