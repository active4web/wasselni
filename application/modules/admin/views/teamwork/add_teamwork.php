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
<title>اضافة مستشار </title>
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
                            <span class="active">اضافة مستشار</span>
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
                                                    <i class="fa fa-gift"></i>اضافة مستشار</div>
                                            </div>
                                        <div class="portlet light bordered form-fit">
                                            <div class="portlet-title">
                                                <div class="caption"></div>
                                                <div class="actions"></div>
                                            </div>
                                            <div class="portlet-body form">
                                            <input type="hidden" value="1" id="service_type">
                                                <!-- BEGIN FORM-->
     <form id="myForm"  class="form-horizontal form-bordered"  method="post" enctype="multipart/form-data">
                                                    <div class="form-body">
														
<div class="form-group">
<div class="col-md-3" style="text-align:center"></div>
<div class="col-md-6" style="text-align:center">
<div class="fileinput fileinput-new" data-provides="fileinput">
<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
<img src="<?=$url;?>uploads/products/no_img.png" alt="" /> </div>
<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
<div>
<span class="btn default btn-file">
<span class="fileinput-new">صورة المستشار<?=get_img_size("mainclient");?></span>
<span class="fileinput-exists">تغير</span>
<input type="file" name="file"> </span>
<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">حذف </a>
</div>
</div>
</div>
<div class="col-md-3" style="text-align:center"></div>
</div>


                                                        <div class="form-group">
														<div class="col-md-2"></div>
                                                            <div class="col-md-8">
                                                            <span class="help-block">الأسم</span>
                                                                <input type="text" id="name" placeholder="الأسم" class="form-control" name="name">
                                                                <!--<span class="help-block"> This is inline help </span>-->
															</div>
															<div class="col-md-2"></div>
                                                        </div>

                                                        <div class="form-group">
														<div class="col-md-2"></div>
                                                            <div class="col-md-8">
                                                            <span class="help-block"  style="float:left">Name</span>
                    <input type="text" id="name_en" placeholder="Name" class="form-control" name="name_en" style="direction:ltr;text-align:left;">
															</div>
															<div class="col-md-2"></div>
                                                        </div>


                                                        <div class="form-group">
														<div class="col-md-2"></div>
                                                            <div class="col-md-8">
                                                            <span class="help-block" style="float:right">التليفون</span>
                                <input type="text" id="phone"  placeholder="التليفون" class="form-control" name="phone">
															</div>
															<div class="col-md-2"></div>
                                                        </div>
                                                        <div class="form-group">
														<div class="col-md-2"></div>
                                                            <div class="col-md-8">
                                                            <span class="help-block" style="float:right">رقم الوتس</span>
                                <input type="text" id="whatsapp"  placeholder="رقم الوتس" class="form-control" name="whatsapp">
															</div>
															<div class="col-md-2"></div>
                                                        </div>
                                                        <div class="form-group">
														<div class="col-md-2"></div>
                                                            <div class="col-md-8">
                                                            <span class="help-block" style="float:right">رابط الفيس بوك</span>
                                <input type="text" id="facebook"  placeholder="رابط الفيس بوك" class="form-control" name="facebook">
															</div>
															<div class="col-md-2"></div>
                                                        </div>
                                                        <div class="form-group">
														<div class="col-md-2"></div>
                                                            <div class="col-md-8">
                                                            <span class="help-block" style="float:right">البريد الالكترونى</span>
                                <input type="email" id="email"  placeholder="البريد الالكترونى" class="form-control" name="email">
															</div>
															<div class="col-md-2"></div>
                                                        </div>
                                                        <div class="form-group">
														<div class="col-md-2"></div>
                                                            <div class="col-md-8">
                                                            <span class="help-block" style="float:right">الولاية</span>
                                <input type="text" id="state"  placeholder="الولاية" class="form-control" name="state">
															</div>
															<div class="col-md-2"></div>
                                                        </div>




                                                        <div class="form-group">
														<div class="col-md-2"></div>
                                                            <div class="col-md-8">
                                                            <span class="help-block"  style="float:left">State</span>
                    <input type="text" id="state_en" placeholder="State" class="form-control" name="state_en" style="direction:ltr;text-align:left;">
															</div>
															<div class="col-md-2"></div>
                                                        </div>



                                                        <div class="form-group">
														<div class="col-md-2"></div>
                                                            <div class="col-md-8">
                                                            <span class="help-block" style="float:right">المدينة</span>
                                <input type="text" id="city"  placeholder="المدينة" class="form-control" name="city">
															</div>
															<div class="col-md-2"></div>
                                                        </div>


                                                        <div class="form-group">
														<div class="col-md-2"></div>
                                                            <div class="col-md-8">
                                                            <span class="help-block"  style="float:left">City</span>
                    <input type="text" id="city_en" placeholder="City" class="form-control" name="city_en" style="direction:ltr;text-align:left;">
															</div>
															<div class="col-md-2"></div>
                                                        </div>


                                                        <div class="form-group">
														<div class="col-md-2"></div>
                                                            <div class="col-md-8">
                                                            <span class="help-block" style="float:right">المنطقة</span>
                                <input type="text" id="place"  placeholder="المنطقة" class="form-control" name="place">
															</div>
															<div class="col-md-2"></div>
                                                        </div>


                                                        <div class="form-group">
														<div class="col-md-2"></div>
                                                            <div class="col-md-8">
                                                            <span class="help-block"  style="float:left">Place</span>
                    <input type="text" id="place_en" placeholder="Place" class="form-control" name="place_en" style="direction:ltr;text-align:left;">
															</div>
															<div class="col-md-2"></div>
                                                        </div>



                                                        <div class="form-group">
														<div class="col-md-2"></div>
                                                            <div class="col-md-8">
                                                            <span class="help-block" style="float:right">العنوان</span>
                                <input type="text" id="place"  placeholder="العنوان" class="form-control" name="address">
															</div>
															<div class="col-md-2"></div>
                                                        </div>


                                                        
                                                        <div class="form-group">
														<div class="col-md-2"></div>
                                                            <div class="col-md-8">
                                                            <span class="help-block"  style="float:left">Addres</span>
                    <input type="text" id="address_en" placeholder="Addres" class="form-control" name="addres_en" style="direction:ltr;text-align:left;">
															</div>
															<div class="col-md-2"></div>
                                                        </div>



<div class="form-group">

<div class="col-md-2"></div>
<div class="col-md-8">
<span class="help-block" style="float:right">تاريخ الاشتراك</span>
<input name="start_time" style="direction: ltr;width: 100%;" size="18" id="start_date" type="text"  class="form_datetime form-control" >
</div>
<div class="col-md-2"></div>
</div>




<div class="form-group">
<div class="col-md-2"></div>
<div class="col-md-8">
<span class="help-block" style="float:right">العنوان على الخريطة</span>


<div class="form-group ">
<input type="text" value="" class="form-control span6" id="us2-address" required/>
</div>
<div class="span12" style="margin-top:30px">
<div class="form-group">
<div id="us2" style="width: 100%;height: 300px;"></div>
<div class="clearfix">&nbsp;</div>
</div>
</div>
    
<input type="hidden" name="lat" class="form-control" style="width: 150px" id="let" />
<input type="hidden" name="lag" class="form-control" style="width: 150px" id="lag" /> 

</div>
<div class="col-md-2"></div>
</div>



														<div class="form-group">
														<div class="col-md-2"></div>
                                                            <div class="col-md-8">
                                                            <span class="help-block" style="float:right">الباقات</span>
                                                            <select class="form-control" name="jobtype_id" required style="padding:3px 12px">
                                                            <?php #endregion
                                                            foreach($results as $data){
                                                            ?>
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
                                                                <button type="button" class="mainbutton projectkbutton btn green">
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

        
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyDLQm_ttVZOC_AGj0_e5tq7HxjHz_w5BlE"></script>
<script src="<?=DIR?>design/assets/map/locationpicker.jquery.js"></script>

<script>
$('#us2').locationpicker({
location: {
latitude: "15.501977736613599",
longitude: "32.561272691015574"
},
zoom: 10,
radius: 300,
inputBinding: {
latitudeInput: $('#let'),
longitudeInput: $('#lag'),
radiusInput: $('#us2-radius'),
locationNameInput: $('#us2-address')
},
enableAutocomplete: true
});
</script>


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
