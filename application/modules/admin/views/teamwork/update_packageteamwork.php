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
$curt='teamwork';
}
foreach($data as $data)
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
<title>تعديل مستشار </title>
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
                        <a href="<?=$url.'admin/teamwork';?>">المستشارين</a>
                        <i class="fa fa-circle"></i>
						</li>
                        <li>
                            <span class="active">تعديل مستشار</span>
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
                                                    <i class="fa fa-gift"></i>تعديل مستشار</div>
                                            </div>
                                        <div class="portlet light bordered form-fit">
                                            <div class="portlet-title">
                                                <div class="caption"></div>
                                                <div class="actions"></div>
                                            </div>
                                            <div class="portlet-body form">
                                            <input type="hidden" value="2" id="service_type">
                                                <!-- BEGIN FORM-->
     <form action="<?= base_url()?>admin/teamwork/editpackage_action"  class="form-horizontal form-bordered"  method="post">
         <input type="hidden" value="<?= $data->id?>" name="id">
                                                    <div class="form-body">
														



                                                        <div class="form-group">
														<div class="col-md-2"></div>
                                                            <div class="col-md-8">
                                                            <span class="help-block">الأسم</span>
                    <input type="text" readonly value="<?=$data->name?>" id="name" placeholder="الأسم" class="form-control" name="name">
                                                                <!--<span class="help-block"> This is inline help </span>-->
															</div>
															<div class="col-md-2"></div>
                                                        </div>

                                                       


 <div class="form-group">
<div class="col-md-2"></div>
<div class="col-md-8">
<span class="help-block" style="float:right">تاريخ الاشتراك</span>
<input name="start_time" style="direction: ltr;width: 100%;" value="<?= $data->date_packege;?>" size="18" id="start_date" type="text"  class="form_datetime form-control" >
</div>
<div class="col-md-2"></div>
</div>



<div class="form-group">
<div class="col-md-2"></div>
<div class="col-md-8">
<span class="help-block" style="float:right">الباقات</span>
<select class="form-control" name="jobtype_id"  style="padding:3px 12px">
<?php #endregion
foreach($results as $data){
?>
<option value="">حدد الباقة الجديدة</option>

<option value="<?=$data->id?>"><?=$data->name_package."(".$data->time_days." يوم )"?></option>
<?php }?>
<!--<option value="1">Admin</option>
<option value="2">Editor</option>-->
</select>
</div>
<div class="col-md-2"></div>
</div>





												

						<div class="form-actions">
                                                        <div class="row">
                                                            <div class="col-md-offset-3 col-md-9">
                                                                <button type="submit" class="  btn green">
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
if(isset($_SESSION['msg'])){
?>
<script>
$(document).ready(function(e) {
 toastr.success("<?php echo $_SESSION['msg']?>");
});
</script>
<?php }?>
<script type="text/javascript">
$(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});
</script> 



</body></html>
