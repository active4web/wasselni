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
$curt='team_work';
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
<title><?=lang('admins');?></title>
<?php include ("design/inc/header.php");?>
<link rel="stylesheet" href="<?=$url;?>design/lightbox2-master/dist/css/lightbox.min.css" type="text/css" media="screen" />
<script src="<?=$url;?>design/lightbox2-master/dist/js/lightbox-plus-jquery.min.js"></script>
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
							<a href="<?=$url.'admin';?>"><?=lang('admin_panel');?></a>
							<i class="fa fa-circle"></i>
						</li>
						<li>
							<span class="active"><?=lang('admins');?></span>
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
										<span class="caption-subject bold uppercase"><?=lang('admins');?></span>
									</div>
								</div>
								<div class="portlet-body">
									<div class="table-toolbar">
										<div class="row">
											<div class="col-md-6">
												<div class="btn-group">
													<button id="sample_editable_1_2_new" class="btn sbold green addbutton"> <?=lang('add');?>
														<i class="fa fa-plus"></i>
													</button>
												</div>
												<div class="btn-group">
													<button id="sample_editable_1_2_new" class="btn sbold red cancel"> <?=lang('del_group');?>
														<i class="fa fa-remove"></i>
													</button>
												</div>
											</div>
										</div>
									</div>
									<?php if(!empty($results)){?>
									<form action="<?=$url;?>admin/delete_admin" method="POST" id="form">
									<table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1_2">
										<thead>
											<tr>
												<th>
													<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
														<input id="checkAll" type="checkbox" class="group-checkable" data-set="#sample_1_2 .checkboxes" />
														<span></span>
													</label>
												</th>
												<th><?=lang('username');?></th>
												<th><?=lang('email');?></th>
												<th><?=lang('phone');?></th>
												<th><?=lang('image');?></th>
												<th><?=lang('role');?></th>
												<th><?=lang('status');?></th>
												<th><?=lang('operations');?></th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th> </th>
												<th> </th>
												<th> </th>
												<th> </th>
												<th> </th>
												<th> </th>
												<th> </th>
											</tr>
										</tfoot>
										<tbody>
                                        <?php
										 $tt=$this->db->get_where('admin')->result();
										 if(count($tt)>0){
                                            foreach($results as $data) {
												$view=$data->view;
												$mail=$data->mail;
												$phone=$data->phone;
												$type=$data->type;
												$img=$data->img;
												switch($view){
													case 0:
													  $view="<span class='label label-sm label-danger'>".lang('not_active')."</span>";
													  break;
													case 1:
													  $view="<span class='label label-sm label-success'>".lang('active')."</span>";
													  break;
													default:
													  break; 
												}

												switch($type){
													case 0:
													  $type="<span class='label label-sm label-danger'>مدير</span>";
													  break;
													case 1:
													  $type="<span class='label label-sm label-success'>مندوب</span>";
													  break;
													  case 2:
													  $type="<span class='label label-sm label-success'>Editor</span>";
													  break;
													default:
													  break; 
												}

												$image=$data->img;
												$base=base_url();
												$img=$base."uploads/site_setting/".$image; 
                                        ?>
											<tr class="odd gradeX">
												<td>
													<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
														<input type="checkbox" class="checkboxes" value="<?=$data->id;?>" name="check[]" />
														<span></span>
													</label>
												</td>
												<td><a href="<?=base_url()?>admin/teamwork/all_almustushar?id=<?= $data->id?>"><?=$data->username;?></a></td>
												<td><?=$mail;?></td>
												<td><?=$phone;?></td>
												<td><a title="view image" class="example-image-link" href="<?php echo $img;?>" data-lightbox="example-1"><?=lang('view');?></a></td>
												<td><?=$type;?></td>
												<td>
												<a  data-id="<?php echo $data->id;?>" class="btn btn-xs purple table-icon edit" title="change status" style="padding: 1px 0px;">
												<i class="fa fa-edit" title="edit status"></i>
												<span class="code_actvation-<?php echo $data->id;?>"><?php echo $view;?></span>
											</a></td> 
										
												
												<td>
													<div class="btn-group">
														<button class="btn btn-xs red dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> <?=lang('operations');?>
															<i class="fa fa-angle-down"></i>
														</button>
														<ul class="dropdown-menu pull-left" role="menu">
															<!--<li><a href="javascript:;"><i class="fa fa-eye"></i> Details </a></li>-->
															<li><a href="<?php echo base_url()?>admin/update_admin?id_type=<?php echo $data->id;?>"><i class="fa fa-pencil"></i> <?=lang('edit');?> </a></li>
															<li><a href="<?php echo base_url()?>admin/delete_admin?id_type=<?php echo $data->id;?>"><i class="fa fa-remove"></i> <?=lang('remove');?> </a></li>

														</ul>
													</div>
												</td>
											</tr>
                                            <?php }?>
										<?php } ?>
										</tbody>
									</table>
									</form>
									<?php }else{?>
									<center><span class="caption-subject font-red bold uppercase"><?=lang('no_data');?></span></center>
									<?php }?>
								</div>

								<div class="row">
                                    <div class="col-md-5 col-sm-5">
									<br>
                                        <div class="dataTables_info" id="sample_1_2_info" role="status" aria-live="polite">
                                        <ul class="nav nav-pills">
                                            <li>
                                            <a href="javascript:;"> <?=lang('total_records');?>
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
							<!-- END EXAMPLE TABLE PORTLET-->
						</div>
					</div>
					<!-- END Table Data-->
				</div>
				<!-- END CONTENT -->
			</div>
		</div>
        <!-- END CONTAINER -->
        <!-- BEGIN FOOTER -->
        <?php include ("design/inc/footer.php");?>
        <!-- END FOOTER -->

        <?php include ("design/inc/footer_js.php");?>
		<?php if(isset($_SESSION['msg']) && $_SESSION['msg']!=''){?>
<script>
$(document).ready(function(e) {
 toastr.success("<?php echo $_SESSION['msg']?>");
});
</script>
<?php }?>
	<script>
$(document).ready(function(e) {
    $(".addbutton").click(function(e) {
        window.location.assign("add_admin");
    });
});
</script>

<script>
$(document).ready(function(e) {
$(".edit").click(function(e) {
var id = $(this).data("id");
//alert(id);
var data={id:id};
			$.ajax({
				url: '<?php echo base_url("admin/check_view_teamwork") ?>',
                type: 'POST',
                data: data,				
                success: function( data ) {
                	if (data == "1") {
					// alert(data);
                		$(".code_actvation-"+id).html("<span class='label label-sm label-success'><?=lang('active');?></span>");
                	}
                	if (data == "0") {
                		$(".code_actvation-"+id).html("<span class='label label-sm label-danger'><?=lang('not_active');?></span>");
                	}
				}
         });
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
	$(".cancel").click(function(){
		if($('input[type=checkbox]:not("#checkAll"):checked').length>0){
			$('#form').unbind('submit').submit();//renable submit
		}
	    else{
			toastr.warning("<?=lang('row_one_alert');?>");
	}
	});
});
</script>

</body>
</html>
