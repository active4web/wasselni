<?php
//session_start();
ob_start();
if(!isset($_SESSION['admin_name'])||$_SESSION['admin_name']==""){ 
header("Location:$url"."admin/login"); 
}
else{
$id_admin=$_SESSION['id_admin'];
$admin_name=$_SESSION['admin_name'];
$last_login=$_SESSION['last_login'];
$curt='home';
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

<title>الرئيسية</title>
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
                <!-- BEGIN CONTENT BODY -->
                <div class="page-content">
                    <!-- BEGIN PAGE HEAD-->
                    <div class="page-head">
                        <!-- BEGIN PAGE TITLE -->
                       
                        <!-- END PAGE TITLE -->
                    </div>
                    <!-- END PAGE HEAD-->
                    <!-- BEGIN PAGE BREADCRUMB -->
                    <!--<ul class="page-breadcrumb breadcrumb">
                        <li>
                            <a href="index.html">Home</a>
                            <i class="fa fa-circle"></i>
                        </li>
                        <li>
                            <span class="active">Dashboard</span>
                        </li>
                    </ul>-->
                    <!-- END PAGE BREADCRUMB -->
                    <!-- BEGIN PAGE BASE CONTENT -->
                    <div class="row">
                        
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="dashboard-stat2 bordered" style="background-color: #ee6f57;margin-bottom:0px;padding: 15px 15px 10px;border:0px">
							<a href="<?= DIR?>admin/agents/home">
                                <div class="display">
                                    <div class="number">
                                        <h3 class="font-green-sharp">
                                            <span data-counter="counterup" data-value="<?php
$agents=$this->db->get_where("agents")->result();
echo count($agents);?>"></span>
                                            <small class="font-green-sharp"></small>
                                        </h3>
                                        <small style="font-size:13px">المندوبين</small>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-users"></i>
                                    </div>
                                </div>
</a>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="dashboard-stat2 bordered" style="background-color: #c62a88;margin-bottom:0px;padding: 15px 15px 10px;border:0px">
							<a href="<?= DIR?>admin/products/categories">
                                <div class="display">
                                    <div class="number">
                                        <h3 class="font-red-haze">
											<span data-counter="counterup" data-value="<?php $category=$this->db->get_where("category")->result();
echo count($category);?>"></span> </h3>
                <small style="font-size:13px">الأقسام الرئيسة</small>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-cubes"></i>
                                    </div>
                                </div>
</a>
                            </div>
                        </div>
                        
                         <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="dashboard-stat2 bordered" style="background-color:#03c4a1;margin-bottom:0px;padding: 15px 15px 10px;border:0px">
							<a href="<?= DIR?>admin/services/home">
                                <div class="display">
                                    <div class="number">
                                        <h3 class="font-red-haze">
											<span data-counter="counterup" data-value="<?php $team_work=$this->db->get_where("team_work",array("admin_view"=>'0'))->result();
echo count($team_work);?>"></span> </h3>
                <small style="font-size:13px">مقدمى الخدمة</small>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-cart-arrow-down"></i>
                                    </div>
                                </div>
</a>
                            </div>
                        </div>
                        
<div class="col-md-12" style="height:20px"></div>
                        
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="dashboard-stat2 bordered"  style="background-color:#f1e189;margin-bottom:0px;padding: 15px 15px 10px;border:0px">
							<a href="<?= DIR?>admin/messages/requested_from">
                                <div class="display">
                                    <div class="number">
                                        <h3 class="font-blue-sharp">
                                            <span data-counter="counterup" data-value="<?php
$requested_from=$this->db->get_where("requested_from",array("view"=>'0'))->result();
echo count($requested_from);?>"></span>
                                        </h3>
                                        <small style="font-size:13px">رسائل طلب الأشتراك</small>
                                    </div>
                                    <div class="icon">
                                        <i class="icon-envelope"></i>
                                    </div>
                                </div>
</a>
                            </div>
                        </div>
                        
   <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="dashboard-stat2 bordered"  style="background-color:#a91f06;margin-bottom:0px;padding: 15px 15px 10px;border:0px">
							<a href="<?= DIR?>admin/products/photography_requests">
                                <div class="display">
                                    <div class="number">
                                        <h3 class="font-blue-sharp">
                                            <span data-counter="counterup" data-value="<?php
$requested_photo=$this->db->get_where("photography_requests",array("view"=>'0'))->result();
echo count($requested_photo);?>"></span>
                                        </h3>
                                        <small style="font-size:13px">طلبات التصوير</small>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-photo"></i>
                                    </div>
                                </div>
</a>
                            </div>
                        </div>
                        
                   
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="dashboard-stat2 bordered"  style="background-color:#444342;margin-bottom:0px;padding: 15px 15px 10px;border:0px">
							<a href="<?= DIR?>admin/tickets/show">
                                <div class="display">
                                    <div class="number">
                                        <h3 class="font-blue-sharp">
                                            <span data-counter="counterup" data-value="<?php
$tickets=$this->db->get_where("tickets",array("status_id"=>'0'))->result();
echo count($tickets);?>"></span>
                                        </h3>
                                        <small style="font-size:13px">التذاكر</small>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-photo"></i>
                                    </div>
                                </div>
</a>
                            </div>
                        </div>
                        
                        
  <div class="col-md-12" style="height:20px"></div>                      
                          <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="dashboard-stat2 bordered"  style="background-color:#d6d2c4;margin-bottom:0px;padding: 15px 15px 10px;border:0px">
							<a href="<?= DIR?>admin/messages/requested_photo">
                                <div class="display">
                                    <div class="number">
                                        <h3 class="font-blue-sharp">
                                            <span data-counter="counterup" data-value="<?php
$tickets=$this->db->get_where("branches",array("admin_view"=>'0'))->result();
echo count($tickets);?>"></span>
                                        </h3>
                                        <small style="font-size:13px">الفروع الجديدة</small>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-photo"></i>
                                    </div>
                                </div>
</a>
                            </div>
                        </div>
                        
                        
                         <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="dashboard-stat2 bordered"  style="background-color:#10079a;margin-bottom:0px;padding: 15px 15px 10px;border:0px">
							<a href="<?= DIR?>admin/products/offers">
                                <div class="display">
                                    <div class="number">
                                        <h3 class="font-blue-sharp">
                                            <span data-counter="counterup" data-value="<?php
$tickets=$this->db->get_where("offers",array("view"=>'0'))->result();
echo count($tickets);?>"></span>
                                        </h3>
                                        <small style="font-size:13px">العروض</small>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-photo"></i>
                                    </div>
                                </div>
</a>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                            <div class="dashboard-stat2 bordered"  style="background-color:#4ad8e4;margin-bottom:0px;padding: 15px 15px 10px;border:0px">
							<a href="<?= DIR?>admin/clients/customers">
                                <div class="display">
                                    <div class="number">
                                        <h3 class="font-blue-sharp">
                                            <span data-counter="counterup" data-value="<?php
$tickets=$this->db->get_where("clients",array("admin_view"=>'0'))->result();
echo count($tickets);?>"></span>
                                        </h3>
                                        <small style="font-size:13px">المستخدمين</small>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-photo"></i>
                                    </div>
                                </div>
</a>
                            </div>
                        </div>
                        
                        
                   
                    </div>
                    <!-- END PAGE BASE CONTENT -->
                </div>
                <!-- END CONTENT BODY -->
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <?php include ("design/inc/footer.php");?>
        <!-- END FOOTER -->

        <?php include ("design/inc/footer_js.php");?>
    </body>
</html>
