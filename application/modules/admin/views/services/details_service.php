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
$country_name=get_table_filed("countries",array("id"=>$res->country_id),"name");
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
                                      
                                      
                                           
<div class="portlet-body form">
                                                <!-- BEGIN FORM-->
 <form action="<?=$url;?>admin/services/service_edit_action" class="form-horizontal form-bordered"  method="post" enctype="multipart/form-data">
        <input type="hidden" value="<?= $res->id;?>" name="id_tab">
        <div class="form-body">
													
                                                      

<div class="form-group">

<div class="col-md-3">
<span class="help-block" style="float:left">الاسم</span>
<input type="text" value="<?= $res->name?>" placeholder="الاسم" class="form-control " name="title">
</div>

<div class="col-md-3">
<span class="help-block" style="float:left">Title</span>
<input type="text" value="<?= $res->name_en?>" placeholder="Title" class="form-control ltr" name="title_en">
</div>


<div class="col-md-3">
<span class="help-block" style="float:left">Başlık</span>
<input type="text" placeholder="Başlık" class="form-control ltr" name="title_tr"  value="<?= $res->name_tr?>">
</div>

<div class="col-md-3">
<span class="help-block ltr" >Phone</span>

<input type="text" value="<?= $res->phone?>" placeholder="Phone" class="form-control ltr" name="phone">
</div>



</div>

<div class="form-group">
    
<div class="col-md-3">
<span class="help-block" style="float:left">WhatsApp</span>
<input type="text"  value="<?= $res->whatsapp?>"  placeholder="WhatsApp" class="form-control ltr" name="whatsapp">
</div>

<div class="col-md-3">
<span class="help-block" style="float:left">Facebook</span>

<input type="text" value="<?= $res->facebook?>" placeholder="Facebook" class="form-control ltr " name="facebook">
</div>



<div class="col-md-3">
<span class="help-block" style="float:left">Instagram</span>

<input type="text" value="<?= $res->instagram?>" placeholder="Instagram" class="form-control ltr" name="instagram">
</div>

<div class="col-md-3">
<span class="help-block" style="float:left">Twitter</span>

<input type="text"  value="<?= $res->twitter?>"  placeholder="Twitter" class="form-control ltr" name="twitter">
</div>

</div>

<div class="form-group">
    
<div class="col-md-4">
<span class="help-block">الترتيب </span>
<input type="text" value="<?= $res->arrange_type?>"  placeholder="الترتيب" class="form-control" name="arrange_type">
</div>

<div class="col-md-4">
<span class="help-block">الاقسام الرئيسيه(<?= $name_cat?>)</span>
<select name="cat_id" class="form-control"  onChange="getsubcat(this.value);">
    <option value="">حدد الاقسام الرئيسيه</option>
    <?php foreach($category as $category_res){?>
     <option value="<?= $category_res->id?>"><?= $category_res->name?></option>
    <?php }?>
</select>
</div>

<div class="col-md-4">
<span class="help-block">الاقسام الفرعيه (<?= $name_dep?>)</span>
<select name="department_id" class="form-control " id="department">
    <option value="">حدد الاقسام الفرعيه</option>
</select>
</div>

</div>

<div class="form-group">
<div class="col-md-4">
<span class="help-block">الدولة (<?= $country_name;?> )</span>

<select name="country_id" class="form-control" onChange="getstate(this.value);"> 
    <option value="">من فضلك حدد الدولة</option>
    <?php foreach($country as $state_res){?>
     <option value="<?= $state_res->id?>"><?= $state_res->name?></option>
    <?php }?>
</select>
</div>

<div class="col-md-4">
<span class="help-block">المحافظه (<?= $state_name?>)</span>
<select name="state_id" class="form-control" onChange="getcity(this.value);"  id="state_id"> 
 <option value="">من فضلك حدد المحافظه</option>
</select>
</div>

<div class="col-md-4">
<span class="help-block">المدينه(<?= $city_name?>)</span>
<select name="city_id" class="form-control" id="cityid">
    <option value="">من فضلك حدد المدينه</option>
</select>
</div>

</div>


<div class="form-group">

<div class="col-md-3">
<span class="help-block" style="float:left">Email</span>
<input type="text" value="<?= $res->email?>" placeholder="Email" class="form-control ltr" name="email">
</div>


<div class="col-md-3">
<span class="help-block">الباقات(<?= $name_package?>)</span>
<select name="package_id" class="form-control" >
    <option value="">من فضلك حدد الباقة المناسبه</option>
    <?php foreach($packages as $package_res){?>
     <option value="<?= $package_res->id?>"><?= $package_res->name_package?></option>
    <?php }?>
</select>
</div>

<div class="col-md-3">
<span class="help-block">توصيل اون لاين
<?php
if($res->delivery_on==1){
?>
(بوجد خدمة توصيل)
<?php } else {?>
(لا يوجد خدمة توصيل)
<?php }?>
</span>
<select name="delivery_on" class="form-control"  >
<option value="">من فضلك حدد وجود توصيل  </option>
<option value="0">لا يوجد توصيل</option>
<option value="1">يوجد توصيل اون لاين</option>
</select>
</div>

<div class="col-md-3">
<span class="help-block">الصفحة الرئيسيه 

<?php
if($res->features==1){
?>
(تظهر فى الرئيسية)
<?php } else {?>
(لا تظهر فى الرئيسية)
<?php }?>

</span>
<select name="features" class="form-control"  >
<option value="">من فضلك حدد ظهوره فى الصفحة الرئيسية  </option>
<option value="0">لا يظهر فى الصفحة الرئيسية </option>
<option value="1">يظهر فى الصفحة الرئيسية</option>
</select>
</div>



</div>


<div class="form-group">




<div class="col-md-3">
<span class="help-block ltr">Second Phone</span>
<input type="text"  value="<?= $res->phone_second?>"  placeholder="Second Phone" class="form-control ltr" name="phone_second">
</div>

<div class="col-md-3">
<span class="help-block ltr" >Third Phone</span>
<input type="text"  value="<?= $res->phone_third?>"  placeholder="Third Phone" class="form-control ltr " name="phone_third">
</div>


<div class="col-md-3">
<span class="help-block">طريقة العرض
<?php 
if($res->slider_type==1){
?>
(يتم عرض فيديو)
<?php } else {?>
(يتم عرض معرض صور)
<?php }?>
</span>
<select name="slider_type" class="form-control"  >
<option value="">من فضلك حدد طريقة العرض</option>
<option value="1">ظهور فيديو</option>
<option value="0">ظهور معرض صور</option>
</select>
</div>


<div class="col-md-3">
<span class="help-block ltr" >Video Link</span>
<input type="text"  value="<?= $res->video_link?>"  placeholder="Video Link" class="form-control ltr" name="video_link">
</div>

</div>




<div class="form-group">



<div class="col-md-4">
<span class="help-block" >العنوان</span>
<input type="text"  value="<?= $res->address?>"  placeholder="العنوان" class="form-control " name="address">
</div>

<div class="col-md-4">
<span class="help-block ltr">Address</span>
<input type="text"  value="<?= $res->address_en?>"  placeholder="Address" class="form-control ltr" name="address_en">
</div>
<div class="col-md-4">
<span class="help-block ltr">Adres</span>
<input type="text"  value="<?= $res->address_tr?>" placeholder="Adres" class="form-control ltr" name="address_tr">
</div>


</div>
<div class="form-group">
    
<div class="col-md-4">
<span class="help-block">عنوان المنيو</span>
<input type="text"  value="<?= $res->word_title?>"  placeholder="عنوان المنيو" class="form-control " name="word_title">
</div>

<div class="col-md-4">
<span class="help-block ltr">Title of menu</span>
<input type="text"  value="<?= $res->word_title_en?>"  placeholder="Title of menu" class="form-control ltr" name="word_title_en">
</div>

<div class="col-md-4">
<span class="help-block ltr">Menü Başlığı </span>
<input type="text"  value="<?= $res->word_title_tr?>"   placeholder="Menü Başlığı" class="form-control ltr" name="word_title_tr">
</div>

</div>


<div class="form-group">
    



<div class="col-md-6">
<span class="help-block ltr">Longitude</span>
<input type="text"  value="<?= $res->lag?>"   placeholder="Longitude" class="form-control ltr" name="lag">
</div>


<div class="col-md-6">
<span class="help-block ltr">Latitude</span>
<input type="text"  value="<?= $res->lat?>"  placeholder="Latitude" class="form-control ltr" name="lat">
</div>

</div>

<div class="form-group">

<div class="col-md-12">
<span class="help-block" style="float:left">Google Map Location</span>

<input type="text"  value="<?= $res->location?>"  placeholder="Google Map Location" class="form-control ltr " name="location">
</div>

</div>

<div class="form-group">

<div class="col-md-12">
<span class="help-block" >الوصف</span>

<textarea name="description" style="width:100%;height:80px" class="form-control"  placeholder="الوصف">
    <?= $res->description?>
</textarea>
</div>

</div>


<div class="form-group">

<div class="col-md-12">
<span class="help-block" style="float:left">Description</span>

<textarea name="description_en" style="width:100%;height:80px" class="form-control ltr" laceholder="Description"><?= $res->description_en?></textarea>
</div>

</div>

<div class="form-group">

<div class="col-md-12">
<span class="help-block" style="float:left">Açıklama</span>
<textarea name="description_tr" style="width:100%;height:80px" class="form-control ltr" laceholder="Açıklama"><?= $res->description_tr?></textarea>
</div>


                                                     
<div class="form-group">
<div class="col-md-3" style="text-align:center"></div>
<div class="col-md-6" style="text-align:center">
<div class="fileinput fileinput-new" data-provides="fileinput">
<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
    <img src="<?= base_url()?>uploads/service/<?= $res->img?>">
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
		$("#state_id").html(data);
	}
	});
}
</script>

