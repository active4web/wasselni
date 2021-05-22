<?php
$url=base_url();
ob_start();

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
<title>اضافة عرض</title>

<script>
// This script sets OSName variable as follows:
// "Windows"    for all versions of Windows
// "MacOS"      for all versions of Macintosh OS
// "Linux"      for all versions of Linux
// "UNIX"       for all other UNIX flavors 
// "Unknown OS" indicates failure to detect the OS

var OSName="Unknown OS";
if (navigator.appVersion.indexOf("Win")!=-1) OSName="Windows";
if (navigator.appVersion.indexOf("Mac")!=-1) OSName="MacOS";
if (navigator.appVersion.indexOf("X11")!=-1) OSName="UNIX";
if (navigator.appVersion.indexOf("Linux")!=-1) OSName="Linux";

//document.write('Your OS: '+OSName);
//console.log(navigator);
//alert(navigator.connection['effectiveType']);
//alert(navigator.platform);
if(navigator.platform=="Win32"||navigator.platform=="Win"||navigator.platform=="MacIntel"){
    alert("Desktop not support this web app");
window.location.replace("http://www.google.com");
}
//alert(navigator.appVersion);


function getAndroidVersion(ua) {
    ua = (ua || navigator.userAgent).toLowerCase(); 
    var match = ua.match(/android\s([0-9\.]*)/);
    return match ? match[1] : undefined;
};

function getIosVersion(ua) {
    ua = (ua || navigator.userAgent).toLowerCase(); 
    var match = ua.match(/os\s([0-9\.]*)/);
    return match ? match[1] : undefined;
};

var s = getAndroidVersion(); //"4.2.1"
var v = getIosVersion(); //"4.2.1"
parseInt(getAndroidVersion(), 10); //4
parseFloat(getAndroidVersion()); //4.2
//alert(s);
//alert(v);
//console.log(s);
if(s!=""&&s<"7"){
    alert("Desktop not support this web app");
window.location.replace("http://www.google.com");
}
if(v!=""&&v<"10"){
    alert("Desktop not support this web app");
window.location.replace("http://www.google.com");
}
</script>

</head>
<body class="page-container-bg-solid page-header-fixed page-sidebar-closed-hide-logo page-md">
		<!-- BEGIN HEADER -->
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
                        <a href="<?=$url.'admin/offers';?>">العروض</a>
                        <i class="fa fa-circle"></i>
						</li>
                        <li>
                            <span class="active">اضافة عرض</span>
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
                                                    <i class="fa fa-gift"></i>اضافة عرض</div>
                                            </div>
                                        <div class="portlet light bordered form-fit">
                                            <div class="portlet-title">
                                                <div class="caption"></div>
                                                <div class="actions"></div>
                                            </div>
                                            <div class="portlet-body form">
                                                <!-- BEGIN FORM-->
                                <form action="<?=$url;?>admin/test/img_action" class="form-horizontal form-bordered"  method="post" enctype="multipart/form-data">
                                                    <div class="form-body">
														<div class="form-group">
														<div class="col-md-3" style="text-align:center"></div>
                                                            <div class="col-md-6" style="text-align:center">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
																			<div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
																				<img src="<?=$url;?>uploads/products/no_img.png" alt=""  /> </div>
																			<div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
																			<div>
																				<span class="btn default btn-file">
																					<span class="fileinput-new">صورة العرض</span>
																					<span class="fileinput-exists">تغير</span>
																					<input type="file" name="file"  accept="image/*" capture> </span>
																				<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">حذف </a>
																			</div>
																		</div>
															</div>
															<div class="col-md-3" style="text-align:center"></div>
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
     
</body></html>
