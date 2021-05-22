<?php
//session_start();
ob_start();
if(!isset($_SESSION['admin_name'])||$_SESSION['admin_name']==""){ 
header("Location:".base_url()."admin/login"); 
}
else{
$id_admin=$_SESSION['id_admin'];
$admin_name=$_SESSION['admin_name'];
$last_login=$_SESSION['last_login'];
$type=$this->input->get("type");
if($type==1){$curt='tickets';}
if($type==2){$curt='vendor_tickets';}

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

<title>التفاصيل</title>
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
							<a href="<?=$url.'admin';?>">لوحة التحكم</a>
							<i class="fa fa-circle"></i>
						</li>
						<?php 
						if($type==1){
						?>
						<li>
							<a href="<?=$url.'admin/tickets/show';?>">تذاكر المستخدم</a>
							<i class="fa fa-circle"></i>
						</li>
						<?php } else {?>
						
						<li>
							<a href="<?=$url.'admin/tickets/vendor_tickets';?>">تذاكر مقدمى الخدمة</a>
							<i class="fa fa-circle"></i>
						</li>
						
						<?php }?>
						<li>
							<span class="active">التفاصيل</span>
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
												
													<div class="portlet">
												
														<?php
															foreach($data as $result){
																$id = $result->id;
																$title = $result->title;
																$ticket_type_id = $result->ticket_type_id;
																$content = $result->content;
																$created_by = $result->created_by;
																$created_at = $result->created_at;
																$time = $result->time;
															}
														?>
														<div class="portlet-body form">
															<!-- BEGIN FORM-->
															<form action="<?php echo $url?>admin/tickets/add_action" class="form-horizontal form-bordered" method="post" enctype="multipart/form-data">
															<input type="hidden" name="id" value="<?=$id;?>">
															<input type="hidden" name="created_by" value="<?=$_SESSION['id_admin'];?>">
																<div class="form-body">
																
																	<div class="form-group">
																		<div class="col-md-2">تفاصيل التذكرة</div>
																		<div class="col-md-10">
																		<div class="portlet box yellow">
																				<div class="portlet-title">
																					<div class="caption"><i class="fa fa-cogs"></i> تفاصيل التذكرة </div>
																					<div class="tools"><a href="javascript:;" class="collapse"></a></div>
																				</div>
																			<div class="portlet-body">
																					<div class="table-responsive">
																						<table class="table table-bordered">
																							<tbody>
																								<tr>
																									<th> إسم العميل </th>
																									<td> <?php echo get_this('clients',['id'=>$created_by],'name');?> </td>
																								</tr>
																								<tr>
																									<th> وقت الإنشاء </th>
																									<td> <?=$time."-".$created_at;?> </td>
																								</tr>
																								<tr>
																									<th> نوع التذكرة </th>
																									<td> <?php echo get_this('tickets_types',['id'=>$ticket_type_id],'name');?> </td>
																								</tr>
																								<tr>
																									<th> عنوان التذكرة </th>
																									<td> <?=$title;?> </td>
																								</tr>
																								<tr>
																									<th> تفاصيل التذكرة </th>
																									<td> <?=$content;?> </td>
																								</tr>
																							</tbody>
																						</table>
																					</div>
																				</div>
																		</div>
																		</div>
																	</div>
																	<div class="form-group">
																		<div class="col-md-2"> الردود [<?=count($replies);?>]</div>
																		<div class="col-md-10">
																			<div class="mt-comments">
																			<?php 
																			foreach($replies as $replie){
																			if($replie->reply_type==1){
																				$username = get_this('clients',['id'=>$replie->created_by],'name');
																			}else{
																				$username = get_this('admin',['id'=>$replie->created_by],'username');
																			}
																			?>
																				<div class="mt-comment">
																				
																					<div class="mt-comment-body">
																						<div class="mt-comment-info">
																						    <span class="mt-comment-author">
																						        <a href="<?= base_url()?>admin/tickets/delete_reply?type=<?= $type?>&id_t=<?= $id?>&id=<?=$replie->id;?>">
																						        <i class="fa fa-trash"></i>حذف
																						        </a>
																						        </span>
																							<span class="mt-comment-author"><?=$username;?></span>
																							<span class="mt-comment-date"><?=$replie->created_at;?> - <?=$replie->time;?></span>
																						</div>
																						<div class="mt-comment-text"> <?=$replie->content;?> </div>
																					</div>
																				</div>
																			<?php }?>
																			</div>
																		</div>
																	</div>
																	<div class="form-group">
																		<div class="col-md-2"></div>
																		<div class="col-md-10">
																		    <textarea class="form-control" name="content" placeholder="الرد" style="height:100px;with:100%"> </textarea>
																		</div>
																	</div>
																																
     <div class="col-md-12" style="text-align:center">
            <div class="btn-group">    
                <button type="submit" class="btn green">
                    <i class="fa fa-save"></i> ارسال 																			
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
        <?php include ("design/inc/footer.php");?>
        <!-- END FOOTER -->

        <?php include ("design/inc/footer_js.php");?>
<script>
$(document).ready(function(e) {
    $(".cancelbutton").click(function(e) {
        window.location.assign("show");
    });
});
</script>
</body>
</html>