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
                 <form action="<?=$url;?>admin/services/edit_branch_action" class="form-horizontal form-bordered"  method="post" enctype="multipart/form-data">
                     <div class="form-body">
                         <?php
                         foreach($data as $data)
                         
                         $country_id=get_table_filed("state",array("id"=>$data->state),"id_country");
                         $state_name=get_table_filed("state",array("id"=>$data->state),"name");
                         $country_name=get_table_filed("countries",array("id"=>$country_id),"name");
                         $city_name=get_table_filed("city",array("id"=>$data->city),"name");
                        ?>
					<input type="hidden"  name="id_service" value="<?= $this->input->get("id_tab")?>">								
                           <input type="hidden"  name="id" value="<?= $data->id?>">	                           

<div class="form-group">

<div class="col-md-4">
<span class="help-block">الاسم</span>

<input type="text" value="<?= $data->name?>" placeholder="الاسم" class="form-control " name="title">
</div>

<div class="col-md-4">
<span class="help-block" style="float:left">Title</span>

<input type="text" value="<?= $data->name_en?>"  placeholder="Title" class="form-control ltr" name="title_en">
</div>


<div class="col-md-4">
<span class="help-block" style="float:left">Başlık</span>
<input type="text" value="<?= $data->name_tr?>"  placeholder="Başlık" class="form-control ltr" name="title_tr">
</div>


</div>

<div class="form-group">
    
 <div class="col-md-4">
<span class="help-block" >العنوان</span>
<input type="text"  value="<?= $data->address?>"   placeholder="العنوان" class="form-control " name="address">
</div>
   
<div class="col-md-4">
<span class="help-block" >Address</span>
<input type="text"  value="<?= $data->address_en?>"   placeholder="Address" class="form-control " name="address_en">
</div>    

<div class="col-md-4">
<span class="help-block" style="float:left">Adres</span>
<input type="text" value="<?= $data->address_tr?>"  placeholder="Adres" class="form-control ltr" name="address_tr">
</div>


</div?

<div class="form-group">

<div class="col-md-4">
<span class="help-block">الدولة (<?= $country_name  ?> )</span>
<select name="country_id" class="form-control" onChange="getstate(this.value);"> 
    <option value="">من فضلك حدد الدولة</option>
    <?php foreach($countries as $state_res){?>
     <option value="<?= $state_res->id?>"><?= $state_res->name?></option>
    <?php }?>
</select>
</div>

<div class="col-md-4">
<span class="help-block">المحافظه (<?= $state_name?>)</span>
<select name="state_id" class="form-control" onChange="getcity(this.value);" id="state_id"> 
    <option value="">حدد المحافظه </option>
    
</select>
</div>

<div class="col-md-4">
<span class="help-block">المدينه (<?= $city_name?>)</span>
<select name="city_id" class="form-control" id="cityid">
    <option value="">حدد المدينه</option>
</select>
</div>


</div>

<div class="form-group">

<div class="col-md-3">
<span class="help-block ltr" >Phone</span>
<input type="text"  value="<?= $data->phone?>" placeholder="Phone" class="form-control ltr" name="phone">
</div>

<div class="col-md-3">
<span class="help-block" style="float:left">WhatsApp</span>
<input type="text" value="<?= $data->whatsapp?>"   placeholder="WhatsApp" class="form-control ltr" name="whatsapp">
</div>

<div class="col-md-3">
<span class="help-block ltr">Second Phone</span>
<input type="text"  value="<?= $data->phone_second?>"  placeholder="Second Phone" class="form-control ltr" name="phone_second">
</div>

<div class="col-md-3">
<span class="help-block ltr" >Third Phone</span>
<input type="text"  value="<?= $data->phone_third?>"  placeholder="Third Phone" class="form-control ltr " name="phone_third">
</div>





</div>









<div class="form-group">

<div class="col-md-12">
<span class="help-block" >الوصف</span>

<textarea name="description" style="width:100%;height:80px" class="form-control"  placeholder="الوصف">
 <?= $data->description?>  
</textarea>
</div>

</div>


<div class="form-group">

<div class="col-md-12">
<span class="help-block" style="float:left">Description</span>

<textarea name="description_en" style="width:100%;height:80px" class="form-control ltr" placeholder="Description">
    <?= $data->description_en?> 
</textarea>
</div>

</div>


<div class="form-group">

<div class="col-md-12">
<span class="help-block" style="float:left">Description</span>
<textarea name="description_tr" style="width:100%;height:80px" class="form-control ltr" placeholder="Description">
    <?= $data->description_tr?> 
</textarea>
</div>

</div>

                                                     
<div class="form-group">
<div class="col-md-3" style="text-align:center"></div>
<div class="col-md-6" style="text-align:center">
<div class="fileinput fileinput-new" data-provides="fileinput">
<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
    <img src="<?= base_url()?>uploads/service/branches/<?= $data->img?>">
</div>
<div class="fileinput-preview fileinput-exists thumbnail" style="width: 200px;height: 150px;"> </div>
<div>
<span class="btn default btn-file">
<span class="fileinput-new"> الصورة</span>
<span class="fileinput-exists">تغير</span>
<input type="file" name="file"> </span>
<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">حذف </a>
</div>
</div>
</div>
<div class="col-md-3" style="text-align:center"></div>
</div>




<div class="col-md-12" style="text-align:center">
            <div class="btn-group">    
                <button type="submit" class="btn green">
                    
                    <i class="fa fa-save"></i>حفظ التغيرات																		
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
