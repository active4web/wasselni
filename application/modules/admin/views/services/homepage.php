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
$curt='services';

    
}
foreach($data as $res)

$state_name=get_table_filed("state",array("id"=>$res->state),"name");
$city_name=get_table_filed("city",array("id"=>$res->city),"name");
$name_package=get_table_filed("job_type",array("id"=>$res->id_package),"name_package");
$name_cat=get_table_filed("category",array("id"=>$res->cat_id),"name");
$name_dep=get_table_filed("departments",array("id"=>$res->dep_id),"name");
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
<title>تعديل</title>
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
						
						<li>	<a href="<?=$url.'admin/services/home';?>">
							    مقدمى الخدمة</a>
							<i class="fa fa-circle"></i>
						</li>
						
							<li>
							<span class="active">تعديل</span>
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
                                      
                                        <div class="portlet ">
                                           
                                            <div class="portlet-body form">
                                                <!-- BEGIN FORM-->
                 <form action="<?=$url;?>admin/services/appearing_edit_action" class="form-horizontal form-bordered"  method="post" enctype="multipart/form-data">
                     <input type="hidden" value="<?= $res->id;?>" name="id_tab">
                                                    <div class="form-body">
													
                                                      

<div class="form-group">

<div class="col-md-3">
<span class="help-block" style="float:left">الاسم</span>
<span class="caption-subject font-red bold uppercase">
<input type="text" readonly value="<?= $res->name?>" placeholder="الاسم" class="form-control " name="title">
</div>

<div class="col-md-3">
<span class="help-block" style="float:left">Title</span>
<span class="caption-subject font-red bold uppercase">
<input type="text" readonly value="<?= $res->name_en?>" placeholder="Title" class="form-control ltr" name="title_en">
</div>

<div class="col-md-3">
<span class="help-block ltr" >Phone</span>
<span class="caption-subject font-red bold uppercase">
<input type="text" readonly value="<?= $res->phone?>" placeholder="Phone" class="form-control ltr" name="phone">
</div>

<div class="col-md-3">
<span class="help-block" style="float:left">Appearing in the Home</span>
<span class="caption-subject font-red bold uppercase">
<select name="features" class="form-control ltr">
    <option value="">Please select Appear in the Home</option>
     <option value="1">Appear in the Home</option>
    <option value="0">Not Appear in the Home</option>
</select>
</div>

</div>

<div class="col-md-12" style="text-align:center">
            <div class="btn-group">    
                <button type="submit" class="btn green">
                    
                    <i class="fa fa-save"></i> <?=lang('add');?>  																			
                </button>
            </div>
            <div class="btn-group">  
                <button type="button" class="btn default cancelbutton">
                    <i class="fa fa-trash"></i><?=lang('cancel');?>																				
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
<script>
function getsubcat(val) {
   // alert(val);
$.ajax({
	type: "POST",
	url: "<?= base_url()?>admin/services/get_departments",
	data:'cat_id='+val,
	success: function(data){
	  //alert(data);
		$("#department").html(data);
	}
	});
}
</script>

<script>
function getcity(val) {
   
$.ajax({
	type: "POST",
	url: "<?= base_url()?>admin/services/get_cities",
	data:'state_id='+val,
	success: function(data){
	  //alert(data);
		$("#cityid").html(data);
	}
	});
}
</script>

