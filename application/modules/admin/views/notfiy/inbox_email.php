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
$curt='emails';
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
<title>الوارد</title>
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
					<!-- BEGIN PAGE BREADCRUMB -->
					<ul class="page-breadcrumb breadcrumb">
						<li>
							<a href="<?=$url.'admin';?>"><?= lang('admin_panel'); ?></a>
							<i class="fa fa-circle"></i>
						</li>
						
						<li>
							<span class="active">الوارد</span>
						</li>
					</ul>
					<!-- END PAGE BREADCRUMB -->

					<!-- Start Table Data -->
					<div class="row">
						<div class="col-md-12">
							<!-- BEGIN EXAMPLE TABLE PORTLET-->
							<div class="portlet light bordered">
								<div class="portlet-title">
									<div class="caption font-dark">
										<i class="icon-settings font-dark"></i>
										<span class="caption-subject bold uppercase">الوارد
										<span style="margin-right:10px"><i class="icon-notebook"></i>
										
										
									</div>
								</div>
								<span class="portlet-body">
									<div class="table-toolbar">
										<div class="row">
											<div class="col-md-12">
												<?php if($result_amount>0){
													?>
													<div class="btn-group">
														<button id="sample_editable_1_2_new" class="btn sbold red delbutton"> حذف مجموعة
															<i class="fa fa-remove"></i>
														</button>
													</div>
												<?php }?>
												
													<div class="btn-group">
													<button id="sample_editable_1_2_new" class="btn sbold green addbutton">ارسال 
														<i class="fa fa-plus"></i>
													</button>
													</div>
													<div class="btn-group">
													<button id="sample_editable_1_2_new" class="btn sbold green addimport">الوارد
														<i class="fa fa-plus"></i>
													</button>
</div>
													<div class="btn-group">
													<button id="sample_editable_1_2_new" class="btn sbold green addexport">الصادر
														<i class="fa fa-plus"></i>
													</button>
													</div>
													
											</div>
										</div>
									</div>
									<?php if(!empty($results)){?>
									<form action="<?=$url?>admin/emails/delete_emial" method="POST" id="form">
									<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1_2">
										<thead>
											<tr>
												<th>
													<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
														<input id="checkAll" type="checkbox" class="group-checkable" data-set="#sample_1_2 .checkboxes" />
														<span></span>
													</label>
												</th>
												<th>المرسل</th>
												<th>الموضوع</th>
												<th> المحتوى</th>
												<th>تاريخ</th>
												<th>الحالة</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th> </th>
												<th> </th>
												<th> </th>
												<th> </th>
												<th> </th>
											</tr>
										</tfoot>
										<tbody>
										<?php
										$current_date=date("Y-m-d H:i");
                                            foreach($results as $data) {
											$from_id=$data->from_id;
											$title=$data->title;
											$content=$data->content;
											$creation_date=$data->creation_date;
											$from_name=get_table_filed("tbl_users",array("id"=>$from_id),"fname");

											$view=$data->reciver_view	;
												switch($view){
													case 0:
												$view="<span class='label label-sm label-danger' style='background-color:#e7505a !important'>غير مقرواءة</span>";
													  break;
													case 1:
													  $view="<span class='label label-sm label-success'>مقرواءة</span>";
													  break;
													  
													default:
													  break; 
												}

?>
											<tr class="odd gradeX">
												<td>
													<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
														<input name="check[]" type="checkbox" class="checkboxes" value="<?=$data->id;?>" />
														<span></span>
													</label>
												</td>
											
												<td> <?=$from_name;?> </td>
												<td><?=mb_substr($title,0,20);?></td>
												<td><a href="<?=$url?>admin/emails/view_email?id=<?=$data->id;?>"><?=mb_substr($content,0,20);?></a> </td>
												<td> <?=$creation_date;?> </td>
												<td>
				<a  data-id="<?php echo $data->id;?>" class="btn btn-xs purple table-icon edit" title="change status" style="padding: 1px 0px;">
												<i class="fa fa-edit" title="edit status"></i>
												<span class="code_actvation-<?php echo $data->id;?>"><?php echo $view;?></span>
											</a></td> 
									
											
											</tr>
											<?php }?>	
										</tbody>
									</table>
									</form>
									<?php 
											
									  } 
									  else{?>
									<center><span class="caption-subject font-red bold uppercase">عفوا لاتوجد بيانات للعرض</span></center>
									<?php }?>
								<div class="row">
                                    <div class="col-md-5 col-sm-5">
									<br>
                                        <div class="dataTables_info" id="sample_1_2_info" role="status" aria-live="polite">
                                        <ul class="nav nav-pills">
                                            <li>
                                            <a href="javascript:;"> مجموع السجلات :
                                                <span class="badge badge-success pull-right"> <?php echo $result_amount; ?> </span>
                                            </a>
                                            </li>
                                        </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-7 col-sm-7">
                                        <div style="text-align: right;" class="dataTables_paginate paging_bootstrap_full_number" id="sample_1_2_paginate">
                                            <ul class="pagination" style="visibility: visible;">
                                                <?php echo $pagination; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
								</div>
							</div>
							<!-- END EXAMPLE TABLE PORTLET-->
						</div>
					</div>
					<!-- END Table Data-->

				</div>
				<!-- END CONTENT -->
		</div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <?php include ("design/inc/footer.php");?>
        <!-- END FOOTER -->

        <?php include ("design/inc/footer_js.php");?>
		<script>
$(document).ready(function(e) {
	
    $(".addbutton").click(function(e) {
        window.location.assign("<?= DIR?>admin/emails/composed_email");
    });

	
    $(".addexport").click(function(e) {
        window.location.assign("<?= DIR?>admin/emails/export_messages");
    });
	
$(".addimport").click(function(e) {
        window.location.assign("<?= DIR?>admin/emails/inbox_email");
    });

	$(".delbutton").click(function(e) {
        window.location.assign("delete");
	});
});
</script>

<script>
$(document).ready(function(e) {
    $("#checkAll").change(function(){
		$("input[type=checkbox]").not("#checkAll").each(function() {
            this.checked=!this.checked;
        });
	});
	$(".delbutton").click(function(){
		if($('input[type=checkbox]:not("#checkAll"):checked').length>0){
			$('#form').unbind('submit').submit();//renable submit
		}
	    else{
			window.stop();
			//alert("<?=lang('row_one_alert');?>");
			toastr.warning("<?=lang('row_one_alert');?>");
	}
	});
});
</script>
<?php if(isset($_SESSION['msg']) && $_SESSION['msg']!=''){?>
<script>
$(document).ready(function(e) {
	toastr.success("<?php echo $_SESSION['msg']?>");
});
</script>
<?php }?>



<script>
$(document).ready(function(e) {
$(".edit").click(function(e) {
var id = $(this).data("id");
var data={id:id};
			$.ajax({
				url: '<?php echo base_url("admin/emails/active") ?>',
                type: 'POST',
                data: data,				
                success: function( data ) {
                	if (data == "1") {
					// alert(data);
                		$(".code_actvation-"+id).html("<span class='label label-sm label-success'> مقرواءة</span>");
                	}
                	if (data == "0") {
                		$(".code_actvation-"+id).html("<span class='label label-sm label-danger'>غير مقرواءة</span>");
                	}
				}
         });
	});
});
</script>
</body>
</html>
