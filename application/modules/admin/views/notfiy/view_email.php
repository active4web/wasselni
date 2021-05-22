<?php
//session_start();
ob_start();
if(!isset($_SESSION['admin_name'])||$_SESSION['admin_name']==""){ 
header("Location:".$url."admin/login"); 
}
else{
$id_admin=$_SESSION['id_admin'];
$admin_name=$_SESSION['admin_name'];
$last_login=$_SESSION['last_login'];
$curt='emails';
}
foreach($messages as $messages)

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
<title>تفاصيل الوارد</title>
<?php include ("design/inc/header.php");?>
<style>
.mt-comments .mt-comment {
    background-color: darkgoldenrod;
    height: 75px;
}
</style>
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
							<a href="<?=$url.'admin';?>"><?= lang('admin_panel'); ?></a>
							<i class="fa fa-circle"></i>
						</li>
						<li>
							<a href="<?= $url ?>admin/emails/inbox_email">الوارد</a>
							<i class="fa fa-circle"></i>
						</li>
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
												<div class="portlet box blue ">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-gift"></i>  التفاصيل</div>

													</div>

													<div class="portlet light bordered form-fit">
														<div class="portlet-title">
															<div class="caption"></div>
															<div class="actions"></div>
														</div>
														<?php
															
																$id = $messages->id;
																$title = $messages->title;
																$content = $messages->content;
																$from_id = $messages->from_id;
																$creation_date = $messages->creation_date;
																$main_data['reciver_view']='1';
																$this->db->update("tbl_discussions",$main_data,array("id"=>$id));
																$sender_name=get_this('tbl_users',['id'=>$from_id],'fname')
														?>
														<div class="portlet-body form">
															<!-- BEGIN FORM-->
													
																			<div class="portlet box yellow">
																			
																				<div class="portlet-title">
																					<div class="caption" style="font-size:13px">
																						<i class="fa fa-user"></i><?= $sender_name?>&nbsp;
	<span style="float:left;    float: left !important; direction: ltr;margin-right: 50px;">
																						<?= $creation_date?> 
																						<i class="fa fa-calendar"></i>
																						</span>
																						
																						
																						
																						</div>
																						<br>
																						<div class="caption" style="font-size:15px;text-align:right;width:100%;">
																						<i class="fa fa-note"></i><?= $title?>
																						
																						</div>
																					<div class="tools">
																						<a href="javascript:;" class="collapse"> </a>
																					</div>
																				</div>
																				<div class="portlet-body">
																					<div class="row">
																						<div class="col-md-3 col-sm-3 col-xs-3">
																							<ul class="nav nav-tabs tabs-left">
																							
																							<li>
																									<a href="#tab_6_1" data-toggle="tab">المحتوى</a>
																								</li>
																								<li>
																									<a href="#tab_6_11" data-toggle="tab">الرد</a>
																								</li>
																								
																							</ul>
																						</div>
															<div class="col-md-9 col-sm-9 col-xs-9">
																<div class="tab-content">
																	<div class="tab-pane active" id="tab_6_1">
																		<div class="portlet-body">
																			<div class="table-responsive">
																				<table class="table table-bordered">
																					<tbody>
																					<tr>
																							<td> <?=$content;?> </td>
																						</tr>
												
																					</tbody>
																				</table>


								<table class="table table-bordered">
								<tbody>
								<thead>
								<tr>
								<th> التفاصيل  </th>
								<th> المرسل  </th>
								<th> التاريخ  </th>
								</tr>
								</thead>	
								<thead>
								<?php 
								$reply_sql=$this->db->order_by("id","desc")->get_where('tbl_discussions',array('reply_id'=>$id))->result();
								if(count($reply_sql)>0){
								foreach($reply_sql as $reply_sql){
								?>
<tr>
							
								<th> <?=$reply_sql->content;?>  </th>
								<th><?php echo get_this('tbl_users',['id'=>$reply_sql->from_id],'fname');?></th>
								<th> <?=$reply_sql->creation_date;?>  </th>
																																			</tr>
								<?php } }?>
</thead>

						
								</tbody>


								</table>

								<?php #endregion
								if(count($messages_files)>0){
								foreach($messages_files as $messages_files){
								?>


								<div class="col-md-2"> <a href="<?=DIR?>uploads/emails/<?=$messages_files->file?>" target="blank" title="تحميل الملف"><img src="<?=DIR?>uploads/site_setting/download.png" style="width:32px;height:32px;"></a> </div>
								<?php }?>
								<?php }?>

																			</div>
																		</div>
																	</div>
																

																	

																


															<div class="tab-pane fade" id="tab_6_11">
																									<div class="portlet-body">
																										<div class="table-responsive">
																										<div class="portlet-body form">
															<!-- BEGIN FORM-->
															<form action="<?php echo $url ?>admin/emails/composed_action" class="form-horizontal form-bordered" method="post" enctype="multipart/form-data">
															<input type="hidden" name="replay" value="1">
															<input type="hidden" name="id_replay" value="<?=$id;?>">
															<input type="hidden" name="type" value="2">
																<div class="form-body">
										
																	<div class="form-group">
																		<div class="col-md-1"></div>
																		<div class="col-md-10">
																		<span class="help-block">البريد الالكترونى</span>
																			<input name="email"  type="text" placeholder="البريد الالكترونى" class="form-control" required readonly value="<?=$from_name=get_table_filed("tbl_users",array("id"=>$from_id),"email");?>">
																		</div>
																		<div class="col-md-1"></div>
																	</div>
																	
																
																			
																	<div class="form-group">
																		<div class="col-md-1"></div>
																		<div class="col-md-10">
																		<span class="help-block">الموضوع</span>
																			<input name="subject"  type="text" placeholder="الموضوع" class="form-control" required>
																		</div>
																		<div class="col-md-1"></div>
																	</div>
																
																	<div class="form-group">
																		<div class="col-md-1"></div>
																		<div class="col-md-10">
																		<span class="help-block">المحتوى</span>
																	<textarea name="content" style="width:100%;height:150px" class="form-control"  placeholder="الرسالة" ></textarea>
																		</div>
																		<div class="col-md-1"></div>
																	</div>

																	<div class="form-group">
																	<div class="col-md-1"></div>
																	<div class="col-md-10">
																		<div class="fileinput fileinput-new" data-provides="fileinput">
																						<div>
																							<span class="btn default btn-file">
																								<span class="fileinput-new">الملفات(gif|jpg|png|pdf|doc|xlsx)</span>
																								<span class="fileinput-exists">تغيير</span>
																								<input type="file" name="file[]"  multiple> </span>
																								<a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> حذف </a>
																						</div>
																					</div>
																		
																	</div>
																	<div class="col-md-1"></div>
																	</div>




																	<div class="form-actions">
																		<div class="row">
																			<div class="col-md-offset-3 col-md-9">
																				<button type="submit" class="btn green">
																					<i class="fa fa-check"></i> حفظ</button>
																				<button type="button" class="btn default cancelbutton">إلغاء</button>
																			</div>
																		</div>
																	</div>
																</div>
														</form>
														<!-- END FORM-->
														</div>

													</div>



																										</div>
																									</div>

																									</div>
															</div>
																								</div>




																					</div>
																				</div>
																			</div>
																		












																		
																		</div>
																		<div class="col-md-1"></div>
																	</div>
															</div>
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
