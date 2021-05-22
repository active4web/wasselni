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
							<span class="active">الأضافة</span>
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
                 <form action="<?=$url;?>admin/services/branch_service_action" class="form-horizontal form-bordered"  method="post" enctype="multipart/form-data">
                     <div class="form-body">
					<input type="hidden"  name="id_service" value="<?= $this->input->get("id")?>">								
                                                      

<div class="form-group">

<div class="col-md-4">
<span class="help-block" style="float:left">الاسم</span>
<input type="text" placeholder="الاسم" class="form-control " name="title">
</div>

<div class="col-md-4">
<span class="help-block" style="float:left">Title</span>
<input type="text"  placeholder="Title" class="form-control ltr" name="title_en">
</div>

<div class="col-md-4">
<span class="help-block" style="float:left">Başlık </span>
<input type="text"  placeholder="Başlık " class="form-control ltr" name="title_tr">
</div>





</div>

<div class="form-group">
 
 <div class="col-md-4">
<span class="help-block" >العنوان</span>
<input type="text"    placeholder="العنوان" class="form-control " name="address">
</div>

<div class="col-md-4">
<span class="help-block ltr">Address</span>
<input type="text"   placeholder="Address" class="form-control ltr" name="address_en">
</div>


<div class="col-md-4">
<span class="help-block ltr">Adres</span>
<input type="text"   placeholder="Adres" class="form-control ltr" name="address_tr">
</div>

    
</div>

<div class="form-group">


<div class="col-md-4">
<span class="help-block">الدولة </span>

<select name="country_id" class="form-control" onChange="getstate(this.value);"> 
    <option value="">من فضلك حدد الدولة</option>
    <?php foreach($country as $state_res){?>
     <option value="<?= $state_res->id?>"><?= $state_res->name?></option>
    <?php }?>
</select>
</div>

<div class="col-md-4">
<span class="help-block">المحافظه </span>

<select name="state_id" class="form-control" onChange="getcity(this.value);" id="state_id"> 
    <option value="">من فضلك حدد المحافظه</option>
   
</select>
</div>

<div class="col-md-4">
<span class="help-block">المدينه </span>

<select name="city_id" class="form-control" id="cityid">
    <option value="">من فضلك حدد المدينة</option>
</select>
</div>

</div>



<div class="form-group">
    
<div class="col-md-3">
<span class="help-block ltr" >Phone</span>
<input type="text"  placeholder="Phone" class="form-control ltr" name="phone">
</div>


<div class="col-md-3">
<span class="help-block" style="float:left">WhatsApp</span>
<input type="text"   placeholder="WhatsApp" class="form-control ltr" name="whatsapp">
</div>

<div class="col-md-3">
<span class="help-block ltr">Second Phone</span>
<input type="text"    placeholder="Second Phone" class="form-control ltr" name="phone_second">
</div>

<div class="col-md-3">
<span class="help-block ltr" >Third Phone</span>
<input type="text"   placeholder="Third Phone" class="form-control ltr " name="phone_third">
</div>





</div>







<div class="form-group">

<div class="col-md-12">
<span class="help-block" >الوصف</span>
<textarea name="description" style="width:100%;height:80px" class="form-control"  placeholder="الوصف">
   
</textarea>
</div>

</div>


<div class="form-group">

<div class="col-md-12">
<span class="help-block" style="float:left">Description</span>
<textarea name="description_en" style="width:100%;height:80px" class="form-control ltr" placeholder="Description"></textarea>
</div>

</div>


<div class="form-group">

<div class="col-md-12">
<span class="help-block" style="float:left">Açıklama</span>
<textarea name="description_tr" style="width:100%;height:80px" class="form-control ltr" placeholder="Açıklama"></textarea>
</div>

</div>

                                                     
<div class="form-group">
<div class="col-md-3" style="text-align:center"></div>
<div class="col-md-6" style="text-align:center">
<div class="fileinput fileinput-new" data-provides="fileinput">
<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
</div>
<div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px;height: 150px;"> </div>
<div>
<span class="btn default btn-file">
<span class="fileinput-new"> الصورة</span>
<span class="fileinput-exists">تغير</span>
<input type="file" name="file" required> </span>
<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">حذف </a>
</div>
</div>
</div>
<div class="col-md-3" style="text-align:center"></div>
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

<script>
function getstate(val) {
   
$.ajax({
	type: "POST",
	url: "https://wasselni.ps/admin/places/get_state",
	data:'country_id='+val,
	success: function(data){
	  //alert(data);
		$("#state_id").html(data);
	}
	});
}
</script>
