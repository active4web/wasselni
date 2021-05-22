<?php

ob_start();

session_start();

include('db/opendb.inc');

$id_admin=$_SESSION['id_admin'];

	$last_login=$_SESSION['last_login'];

	if(!isset($_SESSION['admin_name'])||$_SESSION['admin_name']==""){

	//header("Location: http://".$_SERVER['SERVER_username']."/Work/nada_host/ar/index.php");

	header("Location:login.php"); 

}

?>

<!DOCTYPE html>



<!--[if !IE]><!--><html class="sidebar sidebar-discover"><!-- <![endif]-->

<head>

	<title>أعلانات شبكة مصر</title>



	<meta charset="utf-8">

   

	

	<?php 

	include ("inc/head.inc");

	?>

</head>

<body class="">

	

	<!-- Main Container Fluid -->

	<div class="container-fluid menu-hidden">

	

<?php 

include ("inc/sidebar.inc");

?>





			

		</div>

		<!-- // Sidebar Menu END -->

				

		<!-- Content -->

		<div id="content">



<?php 

include("inc/header.inc");

?>		









<div class="innerLR" align="right">



	<h2 class="margin-none" style="text-align:right; width:100%; direction:rtl">الاحصائيات &nbsp;<i class="fa fa-fw fa-pencil text-muted"></i></h2>



	<div class="separator-h"></div>

				

	<div class="row" style="border:0px solid" align="right" >

		<div class="col-md-8" style="float:right" >



			<div class="row" >

				<div class="col-md-6">

					<div class="widget innerAll text-center">
<h5 class="innerT">عدد الزيارات اليومى</h5>
<p class="innerB margin-none text-xlarge text-condensed strong text-primary"><?php echo $num_visitedday?></p>

<h5 class="innerT">عدد الزيارات الشهرى</h5>
<p class="innerB margin-none text-xlarge text-condensed strong text-primary"><?php echo $num_visitedmon?></p>



						<h3 class="innerT">عدد الزيارات </h3>
<p class="innerB margin-none text-xlarge text-condensed strong text-primary"><?php echo $num_visited ?></p>

						<div class="innerTB">
						</div>

					</div>

				</div>



				<div class="col-md-6">

				

					<div class="widget widget-tabs widget-tabs-double-2 border-bottom widget-tabs-responsive">



						<div class="widget-body">

							<div class="tab-content">

							

								<!-- Tab content -->

								<div id="tabReports" class="tab-pane active widget-body-regular innerAll inner-2x text-center"  style="direction:rtl">

									 <?php echo $num_visitor."&nbsp;"."الزائرين"?>
								</div>

								<!-- // Tab content END -->

							

								<!-- Tab content -->

								<div id="tabIncome" class="tab-pane widget-body-regular innerAll inner-2x text-center"  style="direction:rtl">
                                 <?php echo $num_car."&nbsp;"."سيارة"?>
								</div>

								<div id="tabAccounts" class="tab-pane widget-body-regular innerAll inner-2x text-center"  style="direction:rtl">
                                <?php echo $num_house."&nbsp;"."عقار"?>

								</div></div></div>
<div class="widget-head border-top-none bg-gray">
							<ul>
								<li class="active"><a class="glyphicons notes" href="#tabReports" data-toggle="tab"><i></i><span>Reports</span></a></li>
								<li><a class="glyphicons credit_card" href="#tabIncome" data-toggle="tab"><i></i><span>السيارات</span></a></li>
								<li><a class="glyphicons user" href="#tabAccounts" data-toggle="tab"><i></i><span>العقارات</span></a></li>
							</ul>
						</div>
	</div>
	</div></div>
</div>

		<div class="clearfix"></div>
<div id="footer" class="hidden-print">

			<?php

            include ("inc/footer.inc");

			?>

		

		</div>

		

		<!-- // Footer END -->

		

	</div>

	<!-- // Main Container Fluid END -->

	<?php

    include ("inc/headf.inc");

	?>
</body>
</html>